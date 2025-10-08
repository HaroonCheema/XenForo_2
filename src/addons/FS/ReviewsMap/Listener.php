<?php

namespace FS\ReviewsMap;

/**
 * Class Listener
 *
 * @package FS\ReviewsMap
 */
class Listener
{
	/**
	 * Called after the global \XF\App object has been setup. This will fire regardless of the
	 * application type.
	 *
	 * @param \XF\App $app Global App object.
	 * @throws \XF\Db\Exception
	 */
	public static function appSetup(\XF\App $app)
	{
		$container = $app->container();

		$container->set('reviewmap.builder', function (\XF\Container $c) {
			$class = 'FS\ReviewsMap\Sitemap\Builder';
			$class = \XF::extendClass($class);
			$app = \XF::app();

			$user = $c['em']->getRepository('XF:User')->getGuestUser();
			$types = $c['em']->getRepository('FS\ReviewsMap:ReviewmapLog')->getSitemapContentTypes();

			return new $class($app, $user, $types);
		}, false);

		$container->set('reviewmap.renderer', function (\XF\Container $c) {
			$sitemapRepo = \XF::repository('FS\ReviewsMap:ReviewmapLog');
			$app = \XF::app();

			$class = \XF::extendClass('FS\ReviewsMap\Sitemap\Renderer');
			return new $class($app, $sitemapRepo->getActiveSitemap());
		}, false);
	}
}
