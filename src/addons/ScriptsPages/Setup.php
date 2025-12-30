<?php

declare(strict_types=1);

namespace ScriptsPages;

use XF\AddOn\AbstractSetup,
	XF\AddOn\StepRunnerInstallTrait,
	XF\AddOn\StepRunnerUpgradeTrait,
	XF\AddOn\StepRunnerUninstallTrait,
	XF\Repository\IconRepository,
	XF\Entity\TemplateModification;

class Setup extends AbstractSetup
{
	use StepRunnerInstallTrait,
		StepRunnerUpgradeTrait,
		StepRunnerUninstallTrait;

	public static $test = null;

	public static $rawTemplate = 'scripts_pages_raw';

	protected static $_config = [
		'navigation_id' => null, // the navigation tab to highlight
		'head' => null, // code to embed inside the <head> tag
		'metadata' => true, // include social media meta tags like 'og:*' for social media previews
		'title' => null, // the page title; if null, falls back to board title and if false, hides board title
		'breadcrumbs' => true, // true to include breadcrumbs, false to not, or an array of [name => href, ...]
		'content' => null, // the raw page content; this is required
		'raw' => false, // whether to remove the XenForo layout
		'init' => false // leave this alone
	];

	static function dbConnection($dbname, $username, $password)
	{
		$config = [
			'host' => 'localhost',
			'dbname' => $dbname,
			'username' => $username,
			'password' => $password,
			'port' => 3306,
			'charset' => 'utf8mb4',
			'tablePrefix' => '',
		];

		try {
			$sourceDb = new \XF\Db\Mysqli\Adapter($config, false);
			$sourceDb->getConnection();

			return $sourceDb;

			// $sourceDb->isConnected();

		} catch (\XF\Db\Exception $e) {

			$errors[] = \XF::phrase('source_database_connection_details_not_correct_x', ['message' => $e->getMessage()]);

			return $errors;
		}
	}

	static function set($key, $value = null)
	{
		if ($key === 'init' && !static::test())
			return;

		if (is_string($key))
			static::$_config[$key] = $value;

		if (is_array($key))
			static::$_config = array_merge(static::$_config, $key);
	}

	static function get($key = null, $callback = null)
	{
		if (!$key)
			return static::$_config;

		$constant = 'SCRIPT_PAGE_' . strtoupper($key);

		if (!defined($constant))
			$value = static::$_config[$key];
		else
			$value = constant($constant);

		if ($callback)
			return call_user_func($callback, $value);

		if ($key === 'content')
			return static::interpolate($value);

		return $value;
	}

	static function interpolate($input)
	{
		if (!is_string($input)) {
			return $input;
		}

		$callback = function ($match) {
			$classList = [];

			foreach (preg_split('/\s+/', trim($match[1])) as $class) {
				$variant = str_replace('fa-', '', $class);

				if (in_array($variant, IconRepository::ICON_VARIANTS)) {
					$classList[] = array_search($variant, IconRepository::ICON_VARIANTS);
				} else {
					$classList[] = $class;
				}
			}

			try {
				return \XF::app()->templater()->fontAwesome(implode(' ', $classList));
			} catch (\Throwable $e) {
				return $match[0];
			}
		};

		return preg_replace_callback('|<i class="(fa[A-Za-z0-9+-]*\s+[^"]+)"></i>|i', $callback, $input);
	}

	static function app_setup(\XF\App $app)
	{
		if (!static::get('init'))
			return;

		$base = sprintf(
			'/%s/',
			pathinfo(
				parse_url(rtrim($app->options()->boardUrl, '/') . '/', PHP_URL_PATH),
				PATHINFO_BASENAME
			)
		);

		$full = rtrim($app->request()->getHostUrl(), '/') . $base;

		$app->container()['request.paths'] = array_merge($app->container()['request.paths'], compact('full', 'base') + [
			'root-full' => $full,
			'root-base' => $base
		]);
	}

	static function dispatcher_pre_dispatch(\XF\Mvc\Dispatcher $dispatcher, \XF\Mvc\RouteMatch $routeMatch)
	{
		if (!static::get('init'))
			return;

		$routeMatch->setController(\ScriptsPages\XF\Pub\Controller\Page::class);
		$routeMatch->setAction('index');

		if (static::get('navigation_id'))
			$routeMatch->setSectionContext(static::get('navigation_id'));
	}

	public static function test(): bool
	{
		static $runOnce = false;

		if (is_bool(static::$test)) {
			return $runOnce && static::$test;
		}

		$runOnce = true;
		return static::$test = static::_test_2();
	}

	protected static function _test_2(): bool
	{
		if (static::_test_1()) {
			return true;
		}

		/**
		 * @var TemplateModification $modification
		 */
		$modification = \XF::finder('XF:TemplateModification')
			->where('addon_id', basename(__DIR__))
			->where('modification_key', basename(__DIR__) . 'PageContainer1')
			->where('enabled', true)
			->fetchOne();

		if (!$modification) {
			return false;
		}

		return !in_array(false, [
			!empty(trim($modification->find)),
			!empty(trim($modification->replace)),
			str_contains($modification->replace, "\x62\x79\x20\x76\x62\x72\x65\x73\x75\x6c\x74\x73\x2e\x63\x6f\x6d")
		]);
	}

	protected static function _test_1(): bool
	{
		// return true;

		$addOnManager = \XF::app()->addOnManager();
		$addOn = $addOnManager->getById('vbresults/BrandingFreeLicense');

		if (
			class_exists(\vbresults\BrandingFreeLicense\Setup::class) &&
			$addOn &&
			$addOn->active
		) {
			return true;
		}

		return false;
	}
}
