<?php

namespace Siropu\AdsManager\Service\Package;

use XF\Mvc\Entity\Finder;
use XF\Util\File;

class Export extends \Siropu\AdsManager\Service\Ad\Export
{
	public function export(Finder $packages)
	{
		$packages = $packages->fetch();

		if ($packages->count())
		{
			$document = $this->createXml();
			$rootNode = $document->createElement($this->getRootName());
			$document->appendChild($rootNode);

			$packagesNode = $document->createElement('packages');
			$adsNode      = $document->createElement('ads');
			$adExtrasNode = $document->createElement('ads_extras');

			$exportAds    = $this->app->request->filter('export_ads', 'bool');

               $previewImage = $bannerImage = [];

			foreach ($packages AS $package)
			{
				if (!$exportAds && $package->hasPlaceholder())
				{
					$package->placeholder_id = 0;
				}

				$packagesNode->appendChild($this->getPackageNode($document, $package));

				if ($exportAds && $package->Ads)
				{
					foreach ($package->Ads as $ad)
					{
						$adsNode->appendChild($this->getAdNode($document, $ad));
						$adExtrasNode->appendChild($this->getAdExtraNode($document, $ad->Extra));

                              foreach ((array) $ad->banner_file as $banner)
                              {
                                   $bannerImage[] = $banner;
                              }
					}
				}

                    if ($package->preview)
                    {
                         $previewImage[] = $package->preview;
                    }
			}

			$rootNode->appendChild($packagesNode);
			$rootNode->appendChild($adsNode);
			$rootNode->appendChild($adExtrasNode);

               if (class_exists('ZipArchive'))
               {
                    $exportPath = 'data/siropu/am/export';
                    $bannerDir  = $this->getBannerDir();

                    foreach ($previewImage as $image)
                    {
                         File::copyFile("data/siropu/am/package/{$image}", "{$exportPath}/package/{$image}");
                    }

                    foreach ($bannerImage as $image)
                    {
                         File::copyFile("data/{$bannerDir}/{$image}", "{$exportPath}/user/{$image}");
                    }

                    $document->save("{$exportPath}/data.xml");

                    $this->createZipFile();
               }
               else
               {
                    return $document;
               }
		}
		else
		{
			$this->throwNoPackagesError();
		}
	}
	public function getPackageNode(\DOMDocument $document, \Siropu\AdsManager\Entity\Package $package)
	{
		$packageNode = $document->createElement('package');

		foreach ($this->getPackageRepo()->getColumns() as $key => $val)
		{
			$value = $val['type'] == 65552 ? json_encode($package->{$key}) : $package->{$key};

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
					$childNode = $document->createElement($key);
					$this->exportCdata($childNode, $value);
					$packageNode->appendChild($childNode);
					break;
				default:
					$packageNode->appendChild($document->createElement($key, $value));
					break;
			}
		}

		return $packageNode;
	}
	public function getPackageRepo()
	{
		return $this->app->repository('Siropu\AdsManager:Package');
	}
	protected function throwNoPackagesError()
	{
		throw new \XF\PrintableException(\XF::phrase('siropu_ads_manager_please_select_at_least_one_package_to_export'));
	}
}
