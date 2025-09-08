<?php

namespace XenGenTr\XGTForumistatistik\XF\Entity;

use XF\Mvc\Entity\Structure;

/**
 * Class User
 * @package XenGenTr\XGTForumistatistik\XF\Entity
 */
class User extends XFCP_User
{
	public function canIstatistikleriGor(&$error = null)
	{
		return $this->hasPermission('XGT_istatistik_izin_grubu', 'XGT_istatistik_gor');
	}

	public function canKullaniciIstatistikGor(&$error = null)
	{
		return $this->hasPermission('XGT_istatistik_izin_grubu', 'XGT_istatistik_kullanici');
	}
}