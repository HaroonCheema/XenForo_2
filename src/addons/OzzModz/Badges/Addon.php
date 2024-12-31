<?php
/**
 * Badges xF2 addon by CMTV
 * Enjoy!
 */

namespace OzzModz\Badges;

class Addon
{
	const ID = 'OzzModz/Badges';
	const NAMESPACE = 'OzzModz\Badges';
	const PREFIX = 'ozzmodz_badges';
	const PHRASE_PREFIX = self::PREFIX . '_';
	const TEMPLATE_PREFIX = self::PREFIX . '_';
	const PERMISSION_GROUP = self::PREFIX;

	public static function phrase($phrase, array $params = [], $allowHtml = true)
	{
		return \XF::phrase(self::PHRASE_PREFIX . $phrase, $params, $allowHtml);
	}

	public static function phraseDeferred($name, array $params = [])
	{
		return \XF::phraseDeferred(self::PHRASE_PREFIX . $name, $params);
	}

	public static function prefix(string $content = ''): string
	{
		return self::PREFIX . (empty($content) ? '' : '_') . strtolower($content);
	}

	public static function shortName(string $content = ''): string
	{
		return self::NAMESPACE . ':' . $content;
	}

	public static function table(string $content = ''): string
	{
		return strtolower('xf_' . self::prefix($content));
	}

	public static function column(string $content): string
	{
		return strtolower(self::prefix($content));
	}
}