<?php

namespace AVForums\TagEssentials\Repository;

use XF\Mvc\Entity\Repository;

/**
 * Class TagWatch
 *
 * @package AVForums\TagEssentials\Repository
 */
class TagWatch extends Repository
{
    /**
     * @param \AVForums\TagEssentials\Entity\TagWatch $tagWatch
     * @param                                         $state
     *
     * @throws \XF\PrintableException
     */
    public function setWatchState(\AVForums\TagEssentials\Entity\TagWatch $tagWatch, $state)
    {
        switch ($state)
        {
            case 'watch_email':
            case 'watch_no_email':
            case 'no_email':
                $tagWatch->send_email = ($state === 'watch_email');
                $tagWatch->save();
                break;

            case 'watch_alert':
            case 'watch_no_alert':
                $tagWatch->send_alert = ($state === 'watch_alert');
                $tagWatch->save();
                break;

            case 'delete':
            case 'stop':
            case '':
                if ($tagWatch)
                {
                    $tagWatch->delete();
                }
                break;

            default:
                throw new \InvalidArgumentException("Unknown state '$state'");
        }
    }

    /**
     * @param \XF\Entity\User $user
     * @param                 $state
     *
     * @return int
     */
    public function setWatchStateForAll(\XF\Entity\User $user, $state)
    {
        if (!$user->user_id)
        {
            throw new \InvalidArgumentException('Invalid user');
        }

        $db = $this->db();

        switch ($state)
        {
            case 'watch_email':
                return $db->update('xf_tagess_tag_watch', ['send_email' => 1], 'user_id = ?', $user->user_id);

            case 'watch_alert':
                return $db->update('xf_tagess_tag_watch', ['send_alert' => 1], 'user_id = ?', $user->user_id);

            case 'watch_no_email':
            case 'no_email':
                return $db->update('xf_tagess_tag_watch', ['send_email' => 0], 'user_id = ?', $user->user_id);

            case 'watch_no_alert':
            case 'no_alert':
                return $db->update('xf_tagess_tag_watch', ['send_alert' => 0], 'user_id = ?', $user->user_id);

            case 'delete':
            case 'stop':
            case '':
                return $db->delete('xf_tagess_tag_watch', 'user_id = ?', $user->user_id);

            default:
                throw new \InvalidArgumentException("Unknown state '$state'");
        }
    }

    /**
     * @param $state
     *
     * @return bool
     */
    public function isValidWatchState($state)
    {
        switch ($state)
        {
            case 'watch_email':
            case 'watch_alert':
            case 'watch_no_email':
            case 'watch_no_alert':
            case 'no_email':
            case 'no_alert':
            case 'delete':
            case 'stop':
            case '':
                return true;

            default:
                return false;
        }
    }
}