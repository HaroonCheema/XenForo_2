<?php

namespace JUM\ConnectedAccounts\ConnectedAccount\ProviderData;

use XF\ConnectedAccount\ProviderData\AbstractProviderData;

class Vimeo extends AbstractProviderData
{
	/**
	 * @return string
	 */
	public function getDefaultEndpoint()
	{
		return 'me';
	}

	/**
	 * @return mixed|null
	 */
	public function getProviderKey()
	{
		return $this->requestFromEndpoint('uri');
	}

	/**
	 * @return mixed|null
	 */
	public function getUsername()
	{
		return $this->requestFromEndpoint('name');
	}

	/**
	 * @return mixed|null
	 */
	public function getProfileLink()
	{
		return $this->requestFromEndpoint('link');
	}

	/**
	 * @return mixed|null
	 */
	public function getLocation()
	{
		return $this->requestFromEndpoint('location');
	}

	/**
	 * @return mixed
	 */
	public function getAvatarUrl()
	{
		return $this->requestFromEndpoint('pictures')['sizes']['8']['link'];
	}
}