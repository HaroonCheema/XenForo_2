<?php

namespace BS\XFWebSockets\Cli\Command;

use BS\XFWebSockets\Broadcast;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use XF\Util\Random;

class CreateSoketiConfig extends Command
{
    protected function configure()
    {
        $this->setName('xf-websockets:create-soketi-config');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $configPath = Broadcast::soketiConfigPath();

        if (file_exists($configPath)) {
            $output->writeln('Soketi config file already exists at ' . $configPath);
            return;
        }

        $template = $this->getStubTemplate();

        $appId = Random::getRandomString(8);
        $appKey = Random::getRandomString(32);
        $appSecret = Random::getRandomString(64);

        $find = ['{APP_ID}', '{APP_KEY}', '{APP_SECRET}'];
        $replace = [$appId, $appKey, $appSecret];
        $template = str_replace($find, $replace, $template);

        file_put_contents($configPath, $template);

        $output->writeln('Soketi config file created at ' . $configPath);

        \XF::repository('XF:Option')->updateOptions([
            'bsXFWebSocketsPusherAppID'  => $appId,
            'bsXFWebSocketsPusherKey'    => $appKey,
            'bsXFWebSocketsPusherSecret' => $appSecret,
        ]);

        $output->writeln('Pusher key updated in XF options');
    }

    protected function getStubTemplate(): string
    {
        return file_get_contents(__DIR__ . '/stubs/soketi.config.stub');
    }
}