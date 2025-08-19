<?php

namespace Siropu\AdsManager\Service\Package;

use XF\Service\AbstractXmlImport;

class Import extends \Siropu\AdsManager\Service\Ad\Import
{
	public function import(\SimpleXMLElement $xml)
	{
		$xmlPackages = $xml->packages;

		$existing = $this->finder('Siropu\AdsManager:Package')
			->where('package_id', $this->getPackageIds($xmlPackages))
			->fetch();

		$onDuplicate = $this->app->request->filter('on_duplicate', 'str');

		foreach ($xmlPackages->package AS $xmlPackage)
		{
			$data = $this->getPackageDataFromXml($xmlPackage);
			$packageId = $data['package_id'];

			unset($data['package_id']);

			if (isset($existing[$packageId]))
			{
				if ($onDuplicate == 'update')
				{
					$package = $this->em()->find('Siropu\AdsManager:Package', $packageId);
				}
				else
				{
					$package = $this->em()->create('Siropu\AdsManager:Package');
				}
			}
			else
			{
				$package = $this->em()->create('Siropu\AdsManager:Package');
				$package->set('package_id', $packageId, ['forceSet' => true]);
			}

               $package->bulkSet($data);
               $package->set('ad_count', 0);
               $package->set('empty_slot_count', 0);
			$package->save(false);
		}

		if ($xml->ads->ad)
		{
			$this->importAds($xml);
		}
	}
	protected function getPackageIds(\SimpleXMLElement $xmlPackages)
	{
		$packagesIds = [];

		foreach ($xmlPackages->package AS $package)
		{
			$packagesIds[] = intval((string) $package->package_id);
		}

		return $packagesIds;
	}
	protected function getPackageDataFromXml(\SimpleXMLElement $xmlPackage)
	{
		$packageData = [];

		foreach ($this->getPackageRepo()->getColumns() AS $key => $val)
		{
			switch ($key)
			{
				case 'title':
				case 'description':
				case 'guidelines':
                    case 'content':
                    case 'position':
                    case 'cost_custom':
                    case 'discount':
                    case 'settings':
				case 'position_criteria':
				case 'user_criteria':
				case 'page_criteria':
                    case 'device_criteria':
				case 'geo_criteria':
                    case 'advertiser_criteria':
					$value = \XF\Util\Xml::processSimpleXmlCdata((string) $xmlPackage->{$key});
					break;
				default:
					$value = (string) $xmlPackage->{$key};
					break;
			}

               if ($val['type'] == 65552)
               {
                    $value = (array) (@unserialize($value) ?: @json_decode($value, true));
               }

			$packageData[$key] = $value;
		}

		return $packageData;
	}
	public function getPackageRepo()
	{
		return $this->app->repository('Siropu\AdsManager:Package');
	}
}
