<?php

namespace Siropu\AdsManager\Criteria;

class Device extends \XF\Criteria\AbstractCriteria
{
     protected $params;
     protected $mobileDetect;
     protected $deviceType;
     protected $deviceOptions = [];
     protected $osMatch = [];
     protected $browserMatch;

     public function __construct(\XF\App $app, array $criteria)
     {
          parent::__construct($app, $criteria);

          if (phpversion() >= 7.4)
          {
               $this->mobileDetect = new \Detection\MobileDetect();
          }
          else
          {
               $this->mobileDetect = new \Mobile_Detect();
          }

          $this->setDeviceType();

          foreach ($this->getCriteria() as $criteria)
          {
               $this->deviceOptions[] = $criteria['rule'];

               switch ($criteria['rule'])
               {
                    case 'ios':
                         $this->osMatch[] = 'IOS|iPhone|iPad';
                         break;
                    case 'android':
                         $this->osMatch[] = 'Android';
                         break;
                    case 'windows':
                         $this->osMatch[] = 'windows';
                         break;
                    case 'macos':
                         $this->osMatch[] = 'Mac OS X';
                         break;
                    case 'linux':
                         $this->osMatch[] = 'Linux';
                         break;
                    case 'chrome':
                         $this->browserMatch[] = 'Chrome|CriOS';
                         break;
                    case 'firefox':
                         $this->browserMatch[] = 'Firefox';
                         break;
                    case 'safari':
                         $this->browserMatch[] = 'Safari';
                         break;
                    case 'opera':
                         $this->browserMatch[] = 'Opera';
                         break;
                    case 'edge':
                         $this->browserMatch[] = 'Edge';
                         break;
                    case 'ie':
                         $this->browserMatch[] = 'MSIE';
                         break;
                    case 'vivaldi':
                         $this->browserMatch[] = 'Vivaldi';
                         break;
               }
          }
     }
     public function _matchDesktop(array $data, \XF\Entity\User $user)
     {
          if (in_array($this->deviceType, $this->deviceOptions))
          {
               return true;
          }
     }
     public function _matchTablet(array $data, \XF\Entity\User $user)
     {
          if (in_array($this->deviceType, $this->deviceOptions))
          {
               if ($this->deviceType == 'tablet' && !empty($data['brand']))
               {
                    $matchBrand = false;

                    foreach ((array) $data['brand'] as $brand)
                    {
                         $tabletBrand = $brand . (!in_array($brand, ['iPad', 'Kindle', 'Hudl', 'GenericTablet']) ? 'Tablet' : '');

                         if ($this->mobileDetect->is($tabletBrand))
                         {
                              $matchBrand = true;
                              break;
                         }
                    }

                    return $matchBrand;
               }

               return true;
          }
     }
     public function _matchMobile(array $data, \XF\Entity\User $user)
     {
          if (in_array($this->deviceType, $this->deviceOptions))
          {
               if ($this->deviceType == 'mobile' && !empty($data['brand']))
               {
                    $matchBrand = false;

                    foreach ((array) $data['brand'] as $brand)
                    {
                         if ($this->mobileDetect->is($brand))
                         {
                              $matchBrand = true;
                              break;
                         }
                    }

                    return $matchBrand;
               }

               return true;
          }
     }
     public function _matchIos(array $data, \XF\Entity\User $user)
     {
          return $this->matchOS();
     }
     public function _matchAndroid(array $data, \XF\Entity\User $user)
     {
          return $this->matchOS();
     }
     public function _matchWindows(array $data, \XF\Entity\User $user)
     {
          return $this->matchOS();
     }
     public function _matchMacos(array $data, \XF\Entity\User $user)
     {
          return $this->matchOS();
     }
     public function _matchLinux(array $data, \XF\Entity\User $user)
     {
          return $this->matchOS();
     }
     public function _matchChrome(array $data, \XF\Entity\User $user)
     {
          return $this->matchBrowser();
     }
     public function _matchFirefox(array $data, \XF\Entity\User $user)
     {
          return $this->matchBrowser();
     }
     public function _matchSafari(array $data, \XF\Entity\User $user)
     {
          return $this->matchBrowser();
     }
     public function _matchOpera(array $data, \XF\Entity\User $user)
     {
          return $this->matchBrowser();
     }
     public function _matchEdge(array $data, \XF\Entity\User $user)
     {
          return $this->matchBrowser();
     }
     public function _matchIe(array $data, \XF\Entity\User $user)
     {
          return $this->matchBrowser();
     }
     public function _matchVivaldi(array $data, \XF\Entity\User $user)
     {
          return $this->matchBrowser();
     }
     public function setDeviceType()
	{
		$this->deviceType = $this->mobileDetect->isMobile() ? ($this->mobileDetect->isTablet() ? 'tablet' : 'mobile') : 'desktop';
	}
     public function isDesktop()
	{
          return $this->deviceType == 'desktop';
     }
     public function isTablet()
	{
          return $this->deviceType == 'tablet';
     }
     public function isMobile()
	{
          return $this->deviceType == 'mobile';
     }
     public function getDeviceType()
     {
          return $this->deviceType;
     }
     public function getDeviceBrandList()
	{
		return [
			'tablet' => [
				'iPad',
				'Samsung',
                    'Xiaomi',
				'Sony',
				'Lenovo',
				'AMPE',
				'Acer',
				'Advan',
				'Ainol',
				'AllFine',
				'AllView',
				'Archos',
				'Arnova',
				'Asus',
				'AudioSonic',
				'BlackBerry',
				'Blaupunkt',
				'Broncho',
				'Captiva',
				'Celkon',
				'ChangJia',
				'Coby',
				'Concorde',
				'Cresta',
				'Cube',
				'DPS',
				'Danew',
				'DanyTech',
				'Dell',
				'Digma',
				'ECS',
				'Eboda',
				'EssentielB',
				'Evolio',
				'FX2',
				'Fly',
				'Fujitsu',
				'GU',
				'Galapad',
				'GoClever',
				'HCL',
				'HP',
				'HTC',
				'Huawei',
				'Hudl',
				'IRU',
				'Iconbit',
				'Intenso',
				'JXD',
				'Jaytech',
				'Karbonn',
				'Kindle',
				'Kobo',
				'Kocaso',
				'LG',
				'Lava',
				'Leader',
				'MID',
				'MSI',
				'Mediatek',
				'Medion',
				'Megafon',
				'Mi',
				'Micromax',
				'Modecom',
				'Motorola',
				'Mpman',
				'Nabi',
				'Nec',
				'Nexo',
				'Nexus',
				'Nibiru',
				'Nook',
				'Odys',
				'Onda',
				'Overmax',
				'PROSCAN',
				'Pantech',
				'Philips',
				'Playstation',
				'PocketBook',
				'PointOfView',
				'Positivo',
				'Prestigio',
				'PyleAudio',
				'RockChip',
				'RossMoor',
				'SMiT',
				'Skk',
				'Storex',
				'Surface',
				'Teclast',
				'Tecno',
				'Texet',
				'Tolino',
				'Toshiba',
				'Trekstor',
				'Ubislate',
				'Versus',
				'Viewsonic',
				'Visture',
				'Vodafone',
				'Vonino',
				'Wolder',
				'Xoro',
				'YONES',
				'Yarvik',
				'Zync',
				'bq',
				'iJoy',
				'iMobile',
				'GenericTablet'
			],
			'mobile' => [
				'iPhone',
				'Samsung',
                    'Xiaomi',
				'Alcatel',
				'Amoi',
				'Asus',
				'BlackBerry',
				'Dell',
				'Fly',
				'HTC',
				'INQ',
				'LG',
				'Micromax',
				'Motorola',
				'Nexus',
				'Nintendo',
				'Palm',
				'Pantech',
				'SimValley',
				'Sony',
				'Vertu',
				'Wiko',
				'Wolfgang',
				'iMobile',
				'GenericPhone'
			]
		];
	}
     public function getExtraTemplateData()
     {
          $templateData = [
			'deviceBrandList' => $this->getDeviceBrandList()
		];

          return $templateData;
     }
     protected function matchOS()
     {
          return $this->mobileDetect->match(implode('|', $this->osMatch));
     }
     protected function matchBrowser()
     {
          return $this->mobileDetect->match(implode('|', $this->browserMatch));
     }
}
