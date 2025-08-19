<?php

namespace Siropu\AdsManager\Service\Ad;

class Notifier extends \XF\Service\AbstractService
{
	protected $ad;
	protected $action;
	protected $receiveEmail = false;
	protected $receiveAlert = false;
	protected $emailParams = [];
	protected $alertExtraData = [];

	public function __construct(\XF\App $app, \Siropu\AdsManager\Entity\Ad $ad, $action)
	{
		parent::__construct($app);

		$this->ad     = $ad;
		$this->action = $action;

		if ($action != 'message')
		{
			$this->receiveEmail = $ad->Extra->email_notification;
			$this->receiveAlert = $ad->Extra->alert_notification;
		}
	}
	public function setReceiveEmail($value)
	{
		$this->receiveEmail = $value;
	}
	public function setReceiveAlert($value)
	{
		$this->receiveAlert = $value;
	}
	public function setEmailParams(array $params)
	{
		$this->emailParams = $params;
	}
	public function setAlertExtraData(array $data)
	{
		$this->alertExtraData = $data;
	}
	public function sendNotification()
	{
		$notificationSent = false;

		if ($this->receiveEmail)
		{
			\XF::app()->mailer()->newMail()
				->setToUser($this->ad->User)
				->setTemplate('siropu_ads_manager_ad_' . $this->action, ['ad' => $this->ad] + $this->emailParams)
				->send();

			$notificationSent = true;
		}

		if ($this->receiveAlert)
		{
			$this->repository('XF:UserAlert')->alert(
				$this->ad->User,
				$this->ad->user_id,
				$this->ad->username,
				'siropu_ads_manager_ad',
				$this->ad->ad_id,
				$this->action,
				$this->alertExtraData
			);

			$notificationSent = true;
		}

		return $notificationSent;
	}
     public function sendAdminNotifications()
     {
          $admins = \XF::finder('XF:User')
               ->where('is_admin', 1)
               ->fetch();

          $emailParams = [
               'ad' => $this->ad
          ];

          $visitor = \XF::visitor();
          $options = \XF::options();

          foreach ($admins as $admin)
          {
               if ($admin->hasAdminPermission('siropuAdsManager') || $admin->is_super_admin)
               {
                    if ($options->siropuAdsManagerAdminEmailNotification)
                    {
                         \XF::app()->mailer()->newMail()
                              ->setToUser($admin)
                              ->setTemplate('siropu_ads_manager_ad_' . $this->action, $emailParams)
                              ->send();
                    }

                    if ($options->siropuAdsManagerAdminAlertNotification && $this->action != 'delete')
                    {
                         $this->repository('XF:UserAlert')->alert(
                              $admin,
                              $this->ad->user_id,
                              $this->ad->username,
                              'siropu_ads_manager_ad',
                              $this->ad->ad_id,
                              $this->action
                         );
                    }
               }
          }
     }
}
