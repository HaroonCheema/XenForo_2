<?php

namespace Siropu\AdsManager\Service\Ad;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Finder;
use XF\Service\AbstractXmlExport;
use XF\Util\File;

class Export extends AbstractXmlExport
{
	public function getRootName()
	{
		return 'ads_manager';
	}
	public function export(Finder $ads)
	{
		$ads = $ads->fetch();

		if ($ads->count())
		{
               $images = [];

			$document = $this->createXml();
			$rootNode = $document->createElement($this->getRootName());
			$document->appendChild($rootNode);

			$adsNode      = $document->createElement('ads');
			$adExtrasNode = $document->createElement('ads_extras');

			foreach ($ads AS $ad)
			{
				$adsNode->appendChild($this->getAdNode($document, $ad));
				$adExtrasNode->appendChild($this->getAdExtraNode($document, $ad->Extra));

                    foreach ((array) $ad->banner_file as $banner)
                    {
                         $images[] = $banner;
                    }
			}

               $rootNode->appendChild($document->createElement('packages'));
			$rootNode->appendChild($adsNode);
			$rootNode->appendChild($adExtrasNode);

               if (class_exists('ZipArchive'))
               {
                    $exportPath = 'data/siropu/am/export';
                    $bannerDir  = $this->getBannerDir();

                    foreach ($images as $image)
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
			$this->throwNoAdsError();
		}
	}
	public function getAdNode(\DOMDocument $document, \Siropu\AdsManager\Entity\Ad $ad)
	{
		$adNode = $document->createElement('ad');

		foreach ($this->getAdRepo()->getColumns() as $key => $val)
		{
			$value = $val['type'] == 65552 ? json_encode($ad->{$key}) : $ad->{$key};

			switch ($key)
			{
                    case 'name':
				case 'content_1':
				case 'content_2':
				case 'content_3':
                    case 'content_4':
                    case 'title':
                    case 'position':
                    case 'item_array':
                    case 'banner_url':
                    case 'banner_file':
                    case 'target_url':
				case 'position_criteria':
				case 'user_criteria':
				case 'page_criteria':
                    case 'device_criteria':
				case 'geo_criteria':
					$childNode = $document->createElement($key);
					$this->exportCdata($childNode, $value);
					$adNode->appendChild($childNode);
					break;
				default:
					$adNode->appendChild($document->createElement($key, $value));
					break;
			}
		}

		return $adNode;
	}
	public function getAdExtraNode(\DOMDocument $document, \Siropu\AdsManager\Entity\AdExtra $adExtra)
	{
		$adExtraNode = $document->createElement('extra');

		foreach ($this->getAdExtraRepo()->getColumns() as $key => $val)
		{
               $value = $val['type'] == 65552 ? json_encode($adExtra->{$key}) : $adExtra->{$key};

			switch ($key)
			{
				case 'notes':
				case 'reject_reason':
                    case 'pending_changes':
                    case 'custom_fields':
					$childNode = $document->createElement($key);
					$this->exportCdata($childNode, $value);
					$adExtraNode->appendChild($childNode);
					break;
				default:
					$adExtraNode->appendChild($document->createElement($key, $value));
					break;
			}
		}

		return $adExtraNode;
	}
     public function createZipFile()
     {
          $exportPath = 'data/siropu/am/export';

          $zip = new \ZipArchive();
          $zip->open("{$exportPath}/ads_manager_export.zip", \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

          $files = new \RecursiveIteratorIterator(
               new \RecursiveDirectoryIterator($exportPath), \RecursiveIteratorIterator::LEAVES_ONLY);

          foreach ($files as $file)
          {
               if (!$file->isDir() && !preg_match('/\.(zip|html)/', $file->getFilename()))
               {
                    $zip->addFile((string) $file, substr((string) $file, strlen($exportPath) + 1));
               }
          }

          $zip->close();

          foreach ($files as $file)
          {
               if (!$file->isDir() && !preg_match('/\.(zip|html)/', $file->getFilename()))
               {
                    unlink($file);
               }
          }
     }
     public function getBannerDir()
     {
          return \XF::options()->siropuAdsManagerBannerDirName ?: 'siropu/am/user';
     }
	public function getAdRepo()
	{
		return $this->app->repository('Siropu\AdsManager:Ad');
	}
	public function getAdExtraRepo()
	{
		return $this->app->repository('Siropu\AdsManager:AdExtra');
	}
	protected function throwNoAdsError()
	{
		throw new \XF\PrintableException(\XF::phrase('siropu_ads_manager_please_select_at_least_one_ad_to_export'));
	}
}
