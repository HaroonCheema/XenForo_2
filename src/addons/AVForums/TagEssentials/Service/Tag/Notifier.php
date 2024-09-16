<?php

namespace AVForums\TagEssentials\Service\Tag;

use XF\Service\AbstractNotifier;

/**
 * Class Notifier
 *
 * @package AVForums\TagEssentials\Service\Tag
 */
class Notifier extends AbstractNotifier
{
    /**
     * @var \AVForums\TagEssentials\XF\Entity\Tag
     */
    protected $tag;

    /**
     * @var \XF\Tag\AbstractHandler
     */
    protected $handler;

    /**
     * @var \XF\Mvc\Entity\Entity
     */
    protected $content;

    /**
     * @var \AVForums\TagEssentials\XF\Entity\TagContent
     */
    protected $tagContent;

    /**
     * @var null|string
     */
    protected $dependsOnAddOnId;

    /**
     * Notifier constructor.
     *
     * @param \XF\App                 $app
     * @param \XF\Entity\Tag          $tag
     * @param \XF\Tag\AbstractHandler $handler
     * @param \XF\Mvc\Entity\Entity   $content
     * @param \XF\Entity\TagContent   $tagContent
     * @param null|string             $dependsOnAddOnId
     */
    public function __construct(\XF\App $app, \XF\Entity\Tag $tag, \XF\Tag\AbstractHandler $handler, \XF\Mvc\Entity\Entity $content, \XF\Entity\TagContent $tagContent, $dependsOnAddOnId = null)
    {
        parent::__construct($app);

        $this->tag = $tag;
        $this->handler = $handler;
        $this->content = $content;
        $this->tagContent = $tagContent;
        $this->dependsOnAddOnId = $dependsOnAddOnId;
    }

    /**
     * @return array
     */
    protected function loadNotifiers()
    {
        return [
            'tagWatch' => $this->app->notifier('AVForums\TagEssentials:Tag\TagWatch', $this->tag, $this->handler, $this->content, $this->tagContent, $this->dependsOnAddOnId)
        ];
    }

    /**
     * @param \XF\Entity\User $user
     *
     * @return bool
     */
    protected function canUserViewContent(\XF\Entity\User $user)
    {
        return $this->handler->canViewContent($this->content);
    }

    public static function createForJob(array $extraData)
    {
        if (empty($extraData['tagContentId']) || empty($extraData['dependsOnAddOnId']))
        {
            return null;
        }

        $tagContentId = $extraData['tagContentId'];
        $dependsOnAddOnId = $extraData['dependsOnAddOnId'];

        /** @var \XF\Entity\TagContent $tagContent */
        $tagContent = \XF::finder('XF:TagContent')
                         ->where('tag_content_id', $tagContentId)
                         ->with(['Tag', 'AddUser'], true)
                         ->fetchOne();

        if (!$tagContent)
        {
            return null;
        }

        return \XF::app()->service('AVForums\TagEssentials:Tag\Notifier', $tagContent->Tag, $tagContent->getHandler(), $tagContent->getContent(), $tagContent, $dependsOnAddOnId);
    }

    protected function getExtraJobData()
    {
        return [
            'tagContentId' => $this->tagContent->tag_content_id,
            'dependsOnAddOnId' => $this->dependsOnAddOnId
        ];
    }

    /**
     * @param array $users
     */
    protected function loadExtraUserData(array $users)
    {
    }
}