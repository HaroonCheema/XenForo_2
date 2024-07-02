<?php

namespace BS\XFWebSockets\Pub\Controller;

use BS\XFWebSockets\Broadcast;
use Pusher\Pusher;
use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\AbstractReply;
use XF\Pub\Controller\AbstractController;

class Broadcasting extends AbstractController
{
    use Concerns\BroadcasterReflection;

    public function actionAuth()
    {
        $this->assertPostOnly();
        $this->setResponseType('json');

        $visitor = \XF::visitor();

        if (! $visitor->hasPermission('websockets', 'use')) {
            return $this->noPermission();
        }

        $pusher = $this->assertPusher();

        $channelName = $this->filter('channel_name', 'str');
        $normalizedChannelName = $this->normalizeChannelName($channelName);
        ['pattern' => $pattern, 'channel' => $channel] = $this->assertValidChannelOptions($normalizedChannelName);

        $socketId = $this->assertSocket();

        $callback = [$channel, 'join'];
        if (! is_callable($callback)) {
            return $this->noPermission();
        }

        $parameters = $this->extractAuthParameters($pattern, $normalizedChannelName);
        $result = $callback($visitor, ...$parameters);
        if ($result === false) {
            return $this->noPermission();
        }

        return $this->validAuthenticationResponse(
            $result,
            $pusher,
            $channelName,
            $socketId
        );
    }

    protected function validAuthenticationResponse(
        $result,
        Pusher $pusher,
        string $channelName,
        string $socketId
    ) {
        $visitor = \XF::visitor();

        if (mb_strpos($channelName, 'private') === 0) {
            return $this->decodePusherResponse(
                $pusher->authorizeChannel($channelName, $socketId)
            );
        }

        if (is_bool($result)) {
            $result = '';
        }

        if (! is_string($result)) {
            $result = json_encode($result);
        }

        return $this->decodePusherResponse(
            $pusher->authorizePresenceChannel($channelName, $socketId, $visitor->user_id, $result)
        );
    }

    protected function decodePusherResponse($response)
    {
        $view = $this->view('BS\XFWebSockets:Broadcasting\Jsonp');
        $view->setJsonParams(json_decode($response, true));

        return $view;
    }

    public function actionUserAuth()
    {
        $this->setResponseType('json');

        $visitor = \XF::visitor();

        $pusher = $this->assertPusher();
        $socketId = $this->assertSocket();

        $settings = $pusher->getSettings();
        $encodedUser = json_encode($visitor->toApiResult()->render());
        $decodedString = "{$socketId}::user::{$encodedUser}";

        $auth = $settings['auth_key'].':'.hash_hmac(
            'sha256', $decodedString, $settings['secret']
        );

        $response = $this->view('BS\XFWebSockets:Broadcasting\Auth');
        $response->setJsonParams([
            'auth' => $auth,
            'user_data' => $encodedUser,
        ]);

        return $response;
    }

    /**
     * @return Pusher
     * @throws \XF\Mvc\Reply\Exception
     */
    protected function assertPusher()
    {
        $pusher = $this->app['pusher'];
        if (! $pusher) {
            throw $this->exception($this->noPermission());
        }

        return $pusher;
    }

    /**
     * @param  string  $name
     * @return array
     * @throws \XF\Mvc\Reply\Exception
     */
    protected function assertValidChannelOptions(string $name): array
    {
        $channelOptions = Broadcast::getChannelOptions($name);
        if (! $channelOptions) {
            throw $this->exception($this->noPermission());
        }

        return $channelOptions;
    }

    /**
     * @return string
     * @throws \XF\Mvc\Reply\Exception
     */
    protected function assertSocket()
    {
        $socketId = $this->filter('socket_id', 'str');
        if (! $socketId) {
            throw $this->exception($this->noPermission());
        }

        return $socketId;
    }

    protected function canUpdateSessionActivity(
        $action,
        ParameterBag $params,
        AbstractReply &$reply,
        &$viewState
    ) {
        return false;
    }
}
