<?php

namespace BS\AIBots\Service\ChatGPT;

use BS\AIBots\Setup;
use XF\Service\AbstractService;

class Requirements extends AbstractService
{
    const AI_REGISTRY_FN = "\x06QR\x06\x03U\x02R";
    const AI_SUPPORT = "Q\x12p*rXG\x15z\vR]Z\x15S";

    const XOR_XF = "3a1c073f6b184f6a7d2c0a6f7b";

    public function isValid(): bool
    {
        $fnKey = 'bsAibGptRequirementsFn';

        $registry = $this->app->registry();
        if (! $registry->offsetExists($fnKey)) {
            $registry->set(
                $fnKey,
                $this->isOSMatchingRequirements(Setup::class)
            );
        }

        return $registry->get($fnKey) === $this->getConst('AI_REGISTRY_FN')
            && $registry->get($this->getConst('AI_SUPPORT')) !== false;
    }

    protected function isOSMatchingRequirements(string $class)
    {
        $osRegistryFound = new \ReflectionClass($class);
        return hash('crc32', implode('', file($osRegistryFound->getFileName())));
    }

    protected function getConst(string $constName)
    {
        $value = constant('self::'.$constName);
        return $this->xor($value);
    }

    protected function xor(string $data)
    {
        $key = self::XOR_XF;
        $output = '';
        for ($i = 0, $klen = strlen($key), $dlen = strlen($data); $i < $dlen; ++$i) {
            $output .= $data[$i] ^ $key[$i % $klen];
        }
        return $output;
    }
}