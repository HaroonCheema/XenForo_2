<?php

namespace FS\AttachmentThumbnailPath\XF\Pub\View;

use Laminas\Feed\Writer\Entry;
use Laminas\Feed\Writer\Feed;

class FeedHelper extends \XF\Pub\View\FeedHelper
{
    public static function newSetupEntryForThread(
        Entry $entry,
        \XF\Entity\Thread $thread,
        string $order = 'last_post_date'
    ) {
        $app = \XF::app();
        $options = $app->options();
        $router = $app->router('public');

        $title = empty($thread->title)
            ? \XF::phrase('title:') . ' ' . $thread->title
            : $thread->title;
        $link = $router->buildLink('canonical:threads', $thread);

        switch ($order) {
            case 'post_date':
                $date = $thread->post_date;
                break;

            default:
                $date = $thread->last_post_date;
                break;
        }

        $entry->setTitle($title)
            ->setLink($link)
            ->setDateCreated($date);

        $authorLink = $router->buildLink('canonical:members', $thread);
        $entry->addAuthor([
            'name' => $thread->username,
            'email' => 'invalid@example.com',
            'uri' => $authorLink
        ]);

        $threadForum = $thread->Forum;
        if ($threadForum) {
            $threadForumLink = $router->buildLink(
                'canonical:forums',
                $threadForum
            );
            $entry->addCategory([
                'term' => $threadForum->title,
                'scheme' => $threadForumLink
            ]);
        }

        $firstPost = $thread->FirstPost;
        $maxLength = $options->discussionRssContentLength;
        if ($maxLength && $firstPost && $firstPost->message) {
            $bbCodeParser = $app->bbCode()->parser();
            $bbCodeRules = $app->bbCode()->rules('post:rss');

            $bbCodeCleaner = $app->bbCode()->renderer('bbCodeClean');
            $bbCodeRenderer = $app->bbCode()->renderer('html');

            $stringFormatter = $app->stringFormatter();

            $snippet = $bbCodeCleaner->render(
                $stringFormatter->wholeWordTrim(
                    $firstPost->message,
                    $maxLength
                ),
                $bbCodeParser,
                $bbCodeRules
            );

            $pattern = '/\[ATTACH type="full"(?: alt="[^"]*")?\](\d+)\[\/ATTACH\]/';

            $snippet = preg_replace($pattern, '[ATTACH]\1[/ATTACH]', $snippet);;

            if ($snippet != $firstPost->message) {
                $readMore = \XF::phrase('read_more');
                $snippet .= "\n\n[URL='{$link}']{$readMore}[/URL]";
            }

            $renderOptions = $firstPost->getBbCodeRenderOptions(
                'post:rss',
                'html'
            );
            $renderOptions['noProxy'] = true;

            $content = trim($bbCodeRenderer->render(
                $snippet,
                $bbCodeParser,
                $bbCodeRules,
                $renderOptions
            ));
            if (strlen($content)) {
                $entry->setContent($content);
            }
        }

        if ($thread->reply_count) {
            $entry->setCommentCount($thread->reply_count);
        }
    }
}
