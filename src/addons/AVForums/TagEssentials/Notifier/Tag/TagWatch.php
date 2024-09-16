<?php

namespace AVForums\TagEssentials\Notifier\Tag;

use XF\Notifier\AbstractNotifier;

/**
 * Class TagWatch
 *
 * @package AVForums\TagEssentials\Notifier\TagWatch
 */
class TagWatch extends AbstractNotifier
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
     * @var \AVForums\TagEssentials\Entity\TagWatch
     */
    protected $tagWatch;

    /**
     * @var \AVForums\TagEssentials\XF\Entity\TagContent
     */
    protected $tagContent;

    /**
     * @var null|string
     */
    protected $dependsOnAddOnId;

    /**
     * TagWatch constructor.
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
     * @param \XF\Entity\User $user
     *
     * @return bool
     */
    public function canNotify(\XF\Entity\User $user)
    {
        $this->tagWatch = $this->app->finder('AVForums\TagEssentials:TagWatch')
            ->where('user_id', $user->user_id)
            ->where('tag_id', $this->tag->tag_id)
            ->fetchOne();

        if (!$this->tagWatch)
        {
            return false;
        }

        return ($this->tagWatch->user_id !== $this->tagContent->add_user_id);
    }

    /**
     * @param \XF\Entity\User $user
     *
     * @return bool
     */
    public function sendAlert(\XF\Entity\User $user)
    {
        $tagContent = $this->tagContent;

        if ($this->dependsOnAddOnId)
        {
            $extraData['depends_on_addon_id'] = $this->dependsOnAddOnId;
        }

        return $this->basicAlert($user,
            $tagContent->AddUser->user_id,
            $tagContent->AddUser->username,
            $tagContent->content_type,
            $tagContent->content_id,
            'new_tagged_content',
            ['tag' => $this->tag->tag]
        );
    }

    /**
     * @return string
     */
    protected function getEmailTemplate()
    {
        return 'avForumsTagEss_watched_tag_' . $this->content->getEntityContentType();
    }

    /**
     * @param \XF\Entity\User $user
     *
     * @return bool
     */
    public function sendEmail(\XF\Entity\User $user)
    {
        if (!$user->email || $user->user_state !== 'valid')
        {
            return false;
        }

        $emailTemplate = $this->getEmailTemplate();
        $emailTemplateEntity = $this->app->finder('XF:Template')
            ->where('type', 'email')
            ->where('title', $emailTemplate)
            ->where('style_id', $user->style_id)
            ->fetchOne();

        if (!$emailTemplateEntity)
        {
            return false;
        }

        $params = [
            'tag' => $this->tag,
            'tagContent' => $this->tagContent,
            'content' => $this->content,
            'receiver' => $user
        ];

        $this->app()->mailer()->newMail()
            ->setToUser($user)
            ->setTemplate($emailTemplate, $params)
            ->queue();

        return true;
    }
}