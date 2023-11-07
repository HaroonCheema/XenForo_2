<?php

namespace FS\HideUsernames\XF\NewsFeed;

use XF\Entity\NewsFeed;
use XF\Mvc\Entity\Entity;

class ProfilePost extends XFCP_ProfilePost
{
	public function render(NewsFeed $newsFeed, Entity $content = null)
	{


		if (!$content) {
			$content = $newsFeed->Content;
			if (!$content) {
				return '';
			}
		}

		$action = $newsFeed->action;

		$app = \xf::app();
		$serviceHide = $app->service('FS\HideUsernames:HideUserNames');

		if ($content instanceof \XF\Entity\Thread) {
			$content->FirstPost->message = $serviceHide->replaceUserNames($content->FirstPost->message);
		}

		if ($content instanceof \XF\Entity\Post) {
			$content->message = $serviceHide->replaceUserNames($content->message);
		}

		$template = $this->getTemplateName($action);
		$data = $this->getTemplateData($action, $newsFeed, $content);

		return \XF::app()->templater()->renderTemplate($template, $data);
	}
}
