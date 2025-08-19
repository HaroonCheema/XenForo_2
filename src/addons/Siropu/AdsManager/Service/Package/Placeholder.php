<?php

namespace Siropu\AdsManager\Service\Package;

class Placeholder extends \XF\Service\AbstractService
{
	protected $package;
	protected $placeholder;

	public function __construct(\XF\App $app, \Siropu\AdsManager\Entity\Package $package)
	{
		parent::__construct($app);

		$this->package = $package;

		if ($package->Placeholder)
		{
			$this->placeholder = $this->package->Placeholder;
		}
		else
		{
			$this->placeholder = $this->em()->create('Siropu\AdsManager:Ad');
		}
	}
	public function generate()
	{
		$useBackupAd = $this->package->settings['use_backup_ad'];

		if (empty($useBackupAd))
		{
			$title       = \XF::phrase('siropu_ads_manager_your_ad_here_title');
			$description = \XF::phrase('siropu_ads_manager_your_ad_here_description', [
				'costAmount' => $this->app->data('XF:Currency')
					->languageFormat($this->package->cost_amount, $this->package->cost_currency),
				'costPer'    => $this->package->getCostPerPhrase()
			]);

			$targetUrl    = $this->app->router('public')->buildLink('full:ads-manager/packages/create-ad', $this->package);
			$allowedSizes = $this->package->settings['ad_allowed_sizes'];
			$adSize       = current($allowedSizes);
			$bgColor      = $this->rgbToHex(\XF::options()->siropuAdsManagerPlaceholderBgColor);
			$textColor    = $this->rgbToHex(\XF::options()->siropuAdsManagerPlaceholderTextColor);

			$code = $adSize ? '<a href="' . $targetUrl . '"><img src="https://via.placeholder.com/' . $adSize . '/' . $bgColor . '/' . $textColor . '/?text=' . urlencode($description) . '" class="samPlaceholder"></a>' : '<a href="' . $targetUrl . '">' . $description . '</a>';

			switch ($this->package->type)
			{
				case 'code':
					$this->placeholder->content_1 = $code;
					break;
				case 'banner':
					$this->placeholder->content_2 = $code;
				case 'text':
				case 'link':
					$this->placeholder->title = $title;

					if ($this->package->type == 'text')
					{
						$this->placeholder->content_1 = $description;
					}
					break;
				default:
					return;
					break;
			}

			$this->placeholder->target_url = $targetUrl;
		}

		$this->placeholder->name = \XF::phrase('siropu_ads_manager_placeholder_title');
		$this->placeholder->type = $this->package->type;
		$this->placeholder->package_id = $this->package->package_id;
		$this->placeholder->inherit_package = true;
		$this->placeholder->inheritPackage();
          $this->placeholder->updateExtraData(['is_placeholder' => $useBackupAd ? 2 : 1]);
		$this->placeholder->saveIfChanged();

		$this->package->placeholder_id = $this->placeholder->ad_id;
		$this->package->saveIfChanged();
	}
	protected function rgbToHex($rgb)
	{
		preg_match_all('/\d+/', $rgb, $matches);
		return \XF\Util\Color::rgbToHex($matches[0]);
	}
}
