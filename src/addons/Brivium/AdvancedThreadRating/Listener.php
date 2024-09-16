<?php
namespace Brivium\AdvancedThreadRating;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Manager;
use XF\Mvc\Entity\Structure;
use XF\Template\Templater;
use XF\App;
use XF\Pub\App as PubApp;
use XF\NoticeList;

class Listener
{

	public static function appSetup(App $app)
	{
		$options = $app->options();

		$fontAwesome = false;
		if($options->BRATR_iconRating == 'style-rating')
		{
			$styleRatingRepo = $app->repository('Brivium\AdvancedThreadRating:StyleRating');
			$styleRatingCss = $styleRatingRepo->getStyleRatingCss();
			if($styleRatingCss)
			{
				$options->offsetSet('BRATR_styleRating', $styleRatingCss);
				$fontAwesome = false;
			}
		}elseif($options->BRATR_iconRating != 'font-awesome"')
		{
			$fontAwesome = false;
		}
		if($fontAwesome)
		{
			$options->offsetSet('fontAwesomeSource', 'bootstrap');
		}
	}

	public static function noticesSetup(PubApp $app, NoticeList $noticeList, array $pageParams)
	{
		$confirmEmail = $app->session()->get('bratr_confirmEmail');
		if(!empty($confirmEmail))
		{
			$message = \XF::phrase('BRATR_you_must_confirm_by_email_to_rated_this_thread', ['email' => $confirmEmail]);
			$noticeList->addNotice('email_confirm', 'block', $message);
		}
	}

	public static function postEntityStructure(Manager $em, Structure &$structure)
	{
		$structure->columns += [
			'bratr_star' => ['type' => Entity::UINT, 'default' => 0],
			'thread_rating_id' => ['type' => Entity::UINT, 'default' => 0],
		];
	}

	public static function templaterMacroPostRender(Templater $templater, $type, $template, $name, &$output)
	{
		if($type == 'public' && $template == 'rating_macros')
		{
			switch($name)
			{
				case 'setup':
					$templater->includeJs([
						'src' => 'brivium/AdvancedThreadRating/rating.js',
						'min' => true,
					]);
				case 'stars':
					$templater->includeCss('BRATR_rating_stars.less');
					$options = \XF::app()->options();
					if(!empty($options->BRATR_styleRating))
					{
						$templater->includeCss('public:BRATR_style_rating_stars.less');
					}elseif($options->BRATR_iconRating == 'font-awesome')
					{
						$templater->includeCss('public:BRATR_font_awesome_stars.less');
					}elseif($options->BRATR_iconRating)
					{
						$templater->includeCss('public:BRATR_option_style_rating_stars.less');
					}
					break;
			}
		}
	}

	public static function userEntityStructure(Manager $em, Structure &$structure)
	{
		$structure->columns += [
			'bratr_receive_ratings' => ['type' => Entity::UINT, 'default' => 0, 'changeLog' => false],
			'bratr_receive_rating_count' => ['type' => Entity::UINT, 'default' => 0, 'changeLog' => false],
			'bratr_be_donated_ratings' => ['type' => Entity::UINT, 'default' => 0, 'changeLog' => false],
			'bratr_ratings' => ['type' => Entity::UINT, 'default' => 0, 'changeLog' => false],
		];
	}
}