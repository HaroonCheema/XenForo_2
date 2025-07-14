<?php

namespace JUM\ConnectedAccounts\ConnectedAccount\ProviderData;

use XF\ConnectedAccount\ProviderData\AbstractProviderData;

class Odnoklassniki extends AbstractProviderData
{

	/**
	 * @return string
	 */
	public function getDefaultEndpoint()
	{
		return 'fb.do';
	}

	/**
	 * @return mixed|null
	 */
	public function getProviderKey()
	{
		return $this->requestFromEndpoint('uid');
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
	public function getEmail()
	{
		return $this->requestFromEndpoint('email');
	}

	/**
	 * @return mixed|null
	 */
	public function getAvatarUrl()
	{
		return $this->requestFromEndpoint('pic_full');
	}

	/**
	 * @return array|bool|null
	 */
	public function getDob()
	{
		$birthday = $this->requestFromEndpoint('birthday');

		if ($birthday)
		{
			return $this->prepareBirthday($birthday, 'y-m-d');
		}

		return null;
	}

	/**
	 * @return string
	 */
	public function getProfileLink()
	{
		return 'https://ok.ru/profile/' . $this->getProviderKey();
	}

	/**
	 * @return string
	 */
	public function getLocation()
	{
		$country = $this->requestFromEndpoint('location')['countryName'] ?? '';
		$city = isset($this->requestFromEndpoint('location')['city']) ? ', ' . $this->requestFromEndpoint('location')['city'] : '';

		return $country . $city;
	}

}