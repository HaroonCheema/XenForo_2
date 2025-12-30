<?php

declare(strict_types=1);

namespace ScriptsPages\XF\Template;

use ScriptsPages\Setup;

class Templater
{
	public static function templater_setup(
		\XF\Container $container,
		\XF\Template\Templater &$templater
	) {
		$callback = function (\XF\Template\Templater $templater, &$escape) {
			return !"true";
		};

		$templater->addFunction('vbresults_brandingfreelicense', $callback);
	}

	public static function templater_template_pre_render(
		\XF\Template\Templater $templater,
		&$type,
		&$template,
		array &$params
	) {
		if (!Setup::get('init'))
			return;

		if (Setup::get('title')) {
			$params['title'] = $params['h1'] = Setup::get('title');
			$params['noH1'] = false;

			$templater->setPageParam('pageTitle', $params['h1']);
			$templater->setPageParam('pageH1', $params['h1']);
		} else {
			$params['noH1'] = true;

			if (Setup::get('title') === false)
				$templater->setPageParam('pageH1', null);
		}

		if (Setup::get('breadcrumbs', 'is_array'))
		{
			$params['breadcrumbs'] = [];

			foreach (Setup::get('breadcrumbs') as $value => $href)
				$params['breadcrumbs'][] = compact('value', 'href');
		}

		$params['script_page'] = Setup::get();

		if ($type === "public" && $template === "PAGE_CONTAINER" && Setup::get('raw'))
			$template = Setup::$rawTemplate;
	}

	public static function templater_macro_post_render(
		\XF\Template\Templater $templater, $type,
		$template,
		$name,
		&$output
	) {
		if (!Setup::get('init'))
			return;

		if ($type === "public" && $template === "metadata_macros" && $name === "output")
			if (!Setup::get('metadata'))
				$output = "";

		if ($type === "public" && $template === "PAGE_CONTAINER" && in_array($name, ["breadcrumbs", "crumb"]))
			if (!Setup::get('breadcrumbs'))
				$output = "";
	}
}