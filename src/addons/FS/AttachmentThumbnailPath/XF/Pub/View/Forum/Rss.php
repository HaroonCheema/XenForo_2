<?php

namespace FS\AttachmentThumbnailPath\XF\Pub\View\Forum;


class Rss extends XFCP_Rss
{
    public function renderRss()
    {
        /** @var \XF\Entity\Forum $forum */
        $forum = $this->params['forum'];
        $order = $this->params['order'];
        $threads = $this->params['threads'];

        $feed = new \Laminas\Feed\Writer\Feed();

        $options = \XF::options();
        $router = \XF::app()->router('public');
        if ($forum) {
            $title = $forum->title;
            $description = $forum->description;
            $feedLink = $router->buildLink('canonical:forums/index.rss', $forum);
        } else {
            $title = $options->boardTitle;
            $description = $options->boardDescription;
            $feedLink = $router->buildLink('canonical:forums/index.rss', '-');
        }

        \XF\Pub\View\FeedHelper::setupFeed(
            $feed,
            $title,
            $description,
            $feedLink
        );

        foreach ($threads as $thread) {
            $entry = $feed->createEntry();
            \FS\AttachmentThumbnailPath\XF\Pub\View\FeedHelper::newSetupEntryForThread(
                $entry,
                $thread,
                $order
            );
            $feed->addEntry($entry);
        }

        return $feed->orderByDate()->export('rss', true);
    }
}
