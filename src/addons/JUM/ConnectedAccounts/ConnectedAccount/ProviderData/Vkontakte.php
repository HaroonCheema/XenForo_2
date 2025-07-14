<?php

namespace JUM\ConnectedAccounts\ConnectedAccount\ProviderData;

use XF\ConnectedAccount\ProviderData\AbstractProviderData;

class Vkontakte extends AbstractProviderData
{
	/**
	 * @return string
	 */
	public function getDefaultEndpoint()
	{
		return 'users.get?fields=first_name,last_name,screen_name,bdate,photo_max_orig,photo_50,country,city&v=5.92';
	}

	/**
	 * @return mixed
	 */
	public function getDataResponse()
	{
		return $this->requestFromEndpoint('response')[0];
	}

	/**
	 * @return mixed
	 */
	public function getProviderKey()
	{
		return $this->getDataResponse()['id'];
	}

	/**
	 * @return string
	 */
	public function getUsername()
	{
		$firstName = $this->getDataResponse()['first_name'];
		$lastName = $this->getDataResponse()['last_name'];

		return $firstName .' '.  $lastName;
	}

	/**
	 * @return mixed
	 */
	public function getScreenName()
	{
		return $this->getDataResponse()['screen_name'] ?? 'id' . $this->getProviderKey();
	}

	/**
	 * @return string
	 */
	public function getLocation()
	{

		$country = $this->getDataResponse()['country']['title'] ?? '';
		$city = isset($this->getDataResponse()['city']['title']) ? ', ' . $this->getDataResponse()['city']['title'] : '';

		return $country . $city;
	}

	/**
	 * @return string
	 */
	public function getEmail()
	{
		return $this->storageState->getProviderToken()->getExtraParams('response')['email'] ?? '';
	}

	/**
	 * @return array|bool|null
	 */
	public function getDob()
	{
		$birthday = $this->getDataResponse()['bdate'] ?? null;

		if ($birthday)
		{
			return $this->prepareBirthday($birthday, 'd.m.y');
		}

		return null;
	}

	/**
	 * @return string
	 */
	public function getProfileLink()
	{
		return 'https://vk.com/' . $this->getScreenName();
	}

	/**
	 * @return mixed
	 */
	public function getAvatarUrl()
	{
		return $this->getDataResponse()['photo_max_orig'];
	}
}