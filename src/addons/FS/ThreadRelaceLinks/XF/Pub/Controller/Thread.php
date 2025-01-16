<?php

namespace FS\ThreadRelaceLinks\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Thread extends XFCP_Thread
{
    public function actionReplaceLinks(ParameterBag $params)
    {
        $visitor = \XF::visitor();

        if (!$visitor->hasPermission('fs_thread_replace_links', 'can_replace_link')) {
            return $this->noPermission();
        }

        $thread = $this->assertViewableThread($params->thread_id);

        if (!$thread->thread_id) {
            return $this->noPermission();
        }

        if ($this->isPost()) {

            $inputs = $this->filterInputs();

            $postRepo = $this->getPostRepo();

            $postList = $postRepo->findPostsForThreadView($thread);

            if ($postList->total()) {
                $posts = $postList->fetch();

                foreach ($posts as $key => $post) {
                    $this->replaceOldLinkToNew($post, $inputs);
                }
            }

            return $this->redirect($this->buildLink('threads', $thread));
        } else {
            $viewParams = [
                'thread' => $thread,
            ];

            return $this->view('XF:Thread\ReplaceLinks', 'fs_thread_post_replace_links', $viewParams);
        }
    }


    protected function filterInputs()
    {
        $input = \xf::app()->request()->filter([
            'old_link' => 'str',
            'new_link' => 'str',
        ]);

        // $regex = '/^(https?:\/\/)?([a-zA-Z0-9.-]+\.[a-zA-Z]{2,})(:\d+)?(\/.*)?$/';

        $regex = '/^(https?:\/\/)?((localhost|[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}))(\/.*)?$/';

        $oldLink = preg_match($regex, $input['old_link']) === 1;
        $newLink = preg_match($regex, $input['new_link']) === 1;


        if (empty($input['old_link']) || empty($input['new_link'])) {

            throw new \XF\PrintableException(\XF::phrase('please_complete_required_fields'));
        } elseif (!$oldLink || !$newLink) {

            throw new \XF\PrintableException(\XF::phrase('fs_thread_replace_link_enter_valid_url', ['url' => $oldLink ? $input['new_link'] : $input['old_link']]));
        }

        return $input;
    }


    protected function replaceOldLinkToNew(\XF\Entity\Post $post, $inputs)
    {

        $oldLink = $inputs['old_link'];
        $newLink = $inputs['new_link'];

        $newMessage = $post->message;

        if (strpos($newMessage, $oldLink) !== false) {
            $newMessage = preg_replace_callback(
                '/\[URL unfurl="true"\](.*?)\[\/URL\]/',
                function ($matches) use ($oldLink, $newLink) {
                    return $matches[1] === $oldLink
                        ? "[URL unfurl=\"true\"]{$newLink}[/URL]"
                        : $matches[0];
                },
                $newMessage
            );

            $newMessage = preg_replace_callback(
                '/\[URL=\'(.*?)\'\](.*?)\[\/URL\]/',
                function ($matches) use ($oldLink, $newLink) {
                    return $matches[1] === $oldLink
                        ? "[URL='{$newLink}']" . $matches[2] . "[/URL]"
                        : $matches[0];
                },
                $newMessage
            );

            $newMessage = preg_replace_callback(
                '/\[URL\](.*?)\[\/URL\]/',
                function ($matches) use ($oldLink, $newLink) {
                    return $matches[1] === $oldLink
                        ? "[URL]{$newLink}[/URL]"
                        : $matches[0];
                },
                $newMessage
            );

            // $newMessage = preg_replace(
            //     '/\b' . preg_quote($oldLink, '/') . '\b/',
            //     $newLink,
            //     $newMessage
            // );

            // $newMessage = preg_replace_callback(
            //     '/\bhttps?:\/\/[^\s]+/',
            //     function ($matches) use ($oldLink, $newLink) {
            //         return $matches[0] === $oldLink ? $newLink : $matches[0];
            //     },
            //     $newMessage
            // );
        }

        $post->bulkSet([
            'message' => $newMessage
        ]);

        $post->save();
    }
}
