<?php

namespace AVForums\TagEssentials\XF\Entity;

/**
 * Class User
 *
 * Extends \XF\Entity\User
 *
 * @package AVForums\TagEssentials\XF\Entity
 */
class User extends XFCP_User
{
    /**
     * @param null $error
     *
     * @return bool
     */
    public function canEditTagWiki(/** @noinspection PhpUnusedParameterInspection */&$error = null)
    {
        if (!$this->user_id)
        {
            return false;
        }

        return $this->hasPermission('general', 'tagess_edit_wiki');
    }

    /**
     * @param null $error
     *
     * @return bool
     */
    public function canViewTagUsers(/** @noinspection PhpUnusedParameterInspection */&$error = null)
    {
        if (!$this->user_id)
        {
            return false;
        }

        return $this->hasPermission('general', 'tagessCanViewTagUsers');
    }

    /**
     * @param null $error
     *
     * @return bool
     */
    public function canEditTagCategory(/** @noinspection PhpUnusedParameterInspection */&$error = null)
    {
        if (!$this->user_id)
        {
            return false;
        }

        if (!$this->app()->options()->tagess_categoriesEnabled)
        {
            return false;
        }

        return $this->hasPermission('general', 'tagess_edit_category');
    }

    /**
     * @param null $error
     *
     * @return bool
     */
    public function canWatchTag(/** @noinspection PhpUnusedParameterInspection */&$error = null)
    {
        if (!$this->user_id)
        {
            return false;
        }

        if (!\XF::options()->tagess_navWatchTags)
        {
            return false;
        }

        return $this->hasPermission('general', 'tagess_watch_tag');
    }

    /**
     * @param null $error
     *
     * @return bool
     */
    public function canViewTagWikiHistory(/** @noinspection PhpUnusedParameterInspection */&$error = null)
    {
        if (!$this->user_id)
        {
            return false;
        }

        if (!$this->app()->options()->editHistory['enabled'])
        {
            return false;
        }

        return true;
    }
}