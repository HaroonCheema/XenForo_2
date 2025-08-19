<?php

namespace Siropu\AdsManager\Service\Ad;

use XF\Service\AbstractXmlImport;

class Import extends AbstractXmlImport
{
	public function import(\SimpleXMLElement $xml)
	{
		$this->importAds($xml);
	}
	public function importAds(\SimpleXMLElement $xml)
	{
		$existing = $this->finder('Siropu\AdsManager:Ad')
			->where('ad_id', $this->getAdIds($xml->ads))
			->fetch();

		$duplicated  = [];
		$onDuplicate = $this->app->request->filter('on_duplicate', 'str');

		foreach ($xml->ads->ad AS $xmlAd)
		{
			$data = $this->getAdDataFromXml($xmlAd);
			$adId = $data['ad_id'];

			unset($data['ad_id']);

			if (isset($existing[$adId]))
			{
				if ($onDuplicate == 'update')
				{
					$ad = $this->em()->find('Siropu\AdsManager:Ad', $adId);
				}
				else
				{
					$ad = $this->em()->create('Siropu\AdsManager:Ad');
				}
			}
			else
			{
				$ad = $this->em()->create('Siropu\AdsManager:Ad');
				$ad->set('ad_id', $adId, ['forceSet' => true]);
			}

			$ad->bulkSet($data);

			if ($ad->package_id && !$ad->Package)
			{
				$ad->package_id = 0;
			}

			$ad->save(false);

			if (isset($existing[$adId]))
			{
				$duplicated[$adId] = $ad->get('ad_id');
			}

               if ($ad->canUseXfSyntax())
               {
                    $content = $ad->applyLinkAttributes($ad->content_1 ?: $ad->content_2);

                    if ($ad->hasXfSyntax($content))
                    {
                         if ($ad->isPopup())
                         {
                              $content = json_encode(nl2br($content));
                         }

                         $template = $ad->getMasterTemplate();

                         if ($template->set('template', $content))
          			{
                              $template->save(false);
          			}
                    }
               }
		}

		$xmlExtras = $xml->ads_extras;

          if ($xmlExtras->extra)
          {
               foreach ($xmlExtras->extra AS $xmlAdExtra)
     		{
     			$data = $this->getAdExtraDataFromXml($xmlAdExtra);
     			$adId = $data['ad_id'];

     			if (isset($existing[$adId]))
     			{
     				if ($onDuplicate == 'update')
     				{
     					$adExtra = $this->em()->find('Siropu\AdsManager:AdExtra', $adId);
     				}
     				else
     				{
     					$adExtra = $this->em()->create('Siropu\AdsManager:AdExtra');
     					$data['ad_id'] = $duplicated[$adId];
     				}
     			}
     			else
     			{
     				$adExtra = $this->em()->create('Siropu\AdsManager:AdExtra');
     			}
     			$adExtra->bulkSet($data, ['forceSet' => true]);
     			$adExtra->save(false);
     		}
          }
	}
	protected function getAdIds(\SimpleXMLElement $xmlAds)
	{
		$adIds = [];

		foreach ($xmlAds->ad AS $ad)
		{
			$adIds[] = intval((string) $ad->ad_id);
		}

		return $adIds;
	}
	protected function getAdDataFromXml(\SimpleXMLElement $xmlAd)
	{
		$adData = [];

		foreach ($this->getAdRepo()->getColumns() AS $key => $val)
		{
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
					$value = \XF\Util\Xml::processSimpleXmlCdata((string) $xmlAd->{$key});
					break;
				default:
					$value = (string) $xmlAd->{$key};
					break;
			}

               if ($val['type'] == 65552)
               {
                    $value = (array) (@unserialize($value) ?: @json_decode($value, true));
               }

               $adData[$key] = $value;
		}

		return $adData;
	}
	protected function getAdExtraDataFromXml(\SimpleXMLElement $xmlAdExtra)
	{
		$adExtraData = [];

		foreach ($this->getAdExtraRepo()->getColumns() AS $key => $val)
		{
			switch ($key)
			{
				case 'notes':
				case 'reject_reason':
                    case 'pending_changes':
					$value = \XF\Util\Xml::processSimpleXmlCdata((string) $xmlAdExtra->{$key});
					break;
				default:
					$value = (string) $xmlAdExtra->{$key};
					break;
			}

               if ($val['type'] == 65552)
               {
                    $value = (array) (@unserialize($value) ?: @json_decode($value, true));
               }

               $adExtraData[$key] = $value;
		}

		return $adExtraData;
	}
	public function getAdRepo()
	{
		return $this->app->repository('Siropu\AdsManager:Ad');
	}
	public function getAdExtraRepo()
	{
		return $this->app->repository('Siropu\AdsManager:AdExtra');
	}
}
