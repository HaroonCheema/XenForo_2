<?php
namespace Brivium\AdvancedThreadRating\NewsFeed\Thread;

use XF\Entity\NewsFeed;
use XF\Mvc\Entity\Entity;

class Rating extends \XF\NewsFeed\AbstractHandler
{

	public function getTemplateData($action, NewsFeed $newsFeed, Entity $content = null)
	{
		$data = parent::getTemplateData($action, $newsFeed, $content);
		if(empty($data['content']) || empty($data['user']) || !$data['content'] instanceof \Brivium\AdvancedThreadRating\Entity\Rating)
		{
			return $data;
		}

		$rating = $data['content'];
		if(!$rating->is_anonymous)
		{
			return $data;
		}

		if($rating->canViewAnonymous())
		{
			$data['user']->username = \XF::phrase('anonymous')->render() . ' ('.$data['user']->username.')';
		}else
		{
			$data['user'] = [
				'username' => \XF::phrase('anonymous')->render()
			];
		}

		return $data;
	}

	public function isPublishable(Entity $entity, $action)
	{
		return true;
	}

	public function getEntityWith()
	{
		$visitor = \XF::visitor();

		return ['User', 'Thread', 'Thread.Forum', 'Thread.Forum.Node.Permissions|' . $visitor->permission_combination_id];
	}
}