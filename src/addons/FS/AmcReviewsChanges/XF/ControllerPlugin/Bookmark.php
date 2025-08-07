<?php

namespace FS\AmcReviewsChanges\XF\ControllerPlugin;

use XF\Mvc\ParameterBag;
use XF\Mvc\Entity\Entity;

class Bookmark extends XFCP_Bookmark
{
    public function actionSaveBookmark(Entity $content, $confirmUrl)
    {
        $isBookmarked = $content->isBookmarked();

        if (!$isBookmarked && !$content->canBookmark($error)) {
            throw $this->exception($this->noPermission($error));
        }

        $contentType = $content->getEntityContentType();
        if (!$contentType) {
            throw new \InvalidArgumentException("Provided entity must define a content type in its structure");
        }

        if ($isBookmarked) {
            $bookmark = $content->getBookmark();

            if ($this->request->exists('delete')) {
                $bookmark->delete();
                $bookmark = null;

                $switchKey = 'bookmarkremoved';
            } else {
                $editor = $this->setupBookmarkEditor($bookmark);
                $editor->save();

                $this->finalizeBookmarkEditor($editor);

                $switchKey = 'bookmarked';
            }
        } else {
            $creator = $this->setupBookmarkCreator($content);
            if (!$creator->validate($errors)) {
                throw $this->exception($this->error($errors));
            }
            $creator->save();
            $bookmark = $creator->getBookmark();

            $this->finalizeBookmarkCreator($creator);

            $switchKey = 'bookmarked';

            if ($content->Thread->canWatch() && !$content->Thread->isWatched()) {
                /** @var \XF\Repository\ThreadWatch $threadWatchRepo */
                $threadWatchRepo = $this->repository('XF:ThreadWatch');

                $state = 'watch_email';
                $threadWatchRepo->setWatchState($content->Thread, \XF::visitor(), $state);
            }
        }

        if ($this->filter('_xfWithData', 'bool')) {
            $message = $switchKey == 'bookmarked'
                ? \XF::phrase('fs_amc_item_saved_successfully')
                : \XF::phrase('fs_amc_item_deleted_successfully');

            if ($switchKey == 'bookmarked' && $this->filter('tooltip', 'bool')) {
                $reply = $this->getBookmarkEditReply($content, $confirmUrl, ['tooltip' => true, 'added' => true], $bookmark);
                $reply->setJsonParam('message', $message);
            } else {
                $reply = $this->redirect($this->getDynamicRedirect(), $message);
            }

            $reply->setJsonParam('switchKey', $switchKey);
            return $reply;
        } else {
            throw $this->exception($this->redirect($this->getDynamicRedirect()));
        }
    }
}
