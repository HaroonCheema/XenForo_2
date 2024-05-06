<?php

namespace FS\IPSearchResult\XF\Repository;

class Ip extends XFCP_Ip
{
        public function getJustUsersByIp($baseIp)
	{
		$ip = \XF\Util\Ip::convertIpStringToBinary($baseIp);
		if ($ip === false)
		{
			$baseIp = preg_replace('/[^\x20-\x7F]/', '?', $baseIp);
			throw new \InvalidArgumentException("Cannot convert IP '$baseIp' to binary");
		}

		$ips = $this->db()->fetchAllKeyed("
			SELECT user_id, ip
			FROM xf_ip
			WHERE ip = ?
			GROUP BY user_id
		", 'user_id', $ip);
		if (!$ips)
		{
			return [];
		}

		$userIds = array_column($ips, 'user_id');
		$userIds = array_unique($userIds);

		$userFinder = $this->finder('XF:User')
			->where('user_id', $userIds)
			->order('username');

		$users = $userFinder->fetch();
                
                return $users;
        }

}
