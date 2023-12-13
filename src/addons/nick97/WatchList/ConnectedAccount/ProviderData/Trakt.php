<?php

namespace nick97\WatchList\ConnectedAccount\ProviderData;

use \XF\ConnectedAccount\ProviderData\AbstractProviderData;

class Trakt extends AbstractProviderData
{
    /**
     * @return string
     */
    public function getDefaultEndpoint()
    {
        return 'users/me';
    }

    /**
     * @return mixed
     */
    public function getProviderKey()
    {

        // var_dump($this->requestFromEndpoint('name'));exit;

        return $this->requestFromEndpoint('name');

        // return "NAME";
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->requestFromEndpoint('username');
    }
}
