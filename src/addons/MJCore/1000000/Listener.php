<?php
namespace MJCore;

use XF\Container;
use XF\Template\Templater;

class Listener
{
	protected static $addedCopyright = false;
	public static function templaterSetup(Container $container, Templater &$templater)
	{
		$templater->addFunction('copyright', function(Templater $templater, &$escape){
			$copyrightHtml = $templater->fnCopyright($templater, $escape);
			return self::addCopyrightIfRequired($copyrightHtml);
		});
	}

	protected static function addCopyrightIfRequired($defaultCopyright = '')
	{
		if(!self::requiredCopyright())
		{
			return $defaultCopyright;
		}
		self::$addedCopyright = true;
		return $defaultCopyright.self::getCopyrightHtml();
	}

	protected static function getCopyrightHtml()
	{
		return (string) '<div id="BRCopyright" class="concealed muted" style="float:left;margin-left: 10px;"><style>@media (max-width:480px){.Responsive #BRCopyright span{display: none;}}</style><div class="muted"><a href="http://brivium.com/" class="concealed" title="Brivium Limited"><span>XenForo </span>Add-ons by Brivium<span> &trade;  &copy; 2012-'.date("Y").' Brivium LLC.</span></a></div></div>';
	}

	protected static function requiredCopyright()
	{
		return !self::$addedCopyright && self::addOnsRequired() && !self::bypassCopyright();
	}

	protected static function addOnsRequired()
	{
		$prefixes = ['brivium', 'mj'];
		$addOns = \XF::app()->registry()->get('addOns');

		$pattern = sprintf('/^(?|'.implode('|', $prefixes).')\//i');
		foreach($addOns as $addOnId => $versionId)
		{
			if(preg_match($pattern, $addOnId, $match))
			{
				return true;
			}
		}
		return false;
	}

	protected static function bypassCopyright()
	{
		return \XF::app()->options()->brBypassCopyright || \XF::app()->config('brBypassCopyright');
	}
}