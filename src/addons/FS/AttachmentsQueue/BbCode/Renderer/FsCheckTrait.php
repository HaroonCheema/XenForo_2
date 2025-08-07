<?php

namespace FS\AttachmentsQueue\BbCode\Renderer;

use XF\Entity\Post;

trait FsCheckTrait
{
    /** @var \ArrayObject */
    protected $xcOptions;

    /** @var \XF\App */
    protected $xcApp;

    /** @var \XF\Entity\User */
    protected $xcVisitor;

    // CUSTOM PARAMS

    protected $isGuest;
    protected $isWaitingEmailConfirm;
    protected $boardUrl;
    protected $parsedBoardUrl;

    //  TAG COUNT

    protected $attachCount = [];
    protected $mediaCount = [];
    protected $urlCount = [];
    protected $imageCount = [];

    // CAN USE CHECKER (cache)

    protected $canUseAttachChecker = null;
    protected $canUseMediaChecker  = null;
    protected $canUseImageChecker  = null;
    protected $canUseUrlChecker    = null;

    // ATTACH

    protected $attachErrorLimitDisplay = null;

    // Media

    protected $mediaErrorLimitDisplay = null;

    // Image

    protected $imageWebsiteExcluded = [];
    protected $imageErrorLimitDisplay = null;

    // Link
    protected $linkWebsiteExcluded = [];
    protected $linkErrorLimitDisplay = null;
    protected $linkAnonymUrl;

    protected $attachParams = [
        'errorTemplate' => null,
        'errorLimitDisplay' => null,
    ];

    protected $attachError = null;

    // MEDIA

    protected $mediaParams = [
        'errorTemplate' => null,
        'errorLimitDisplay' => null,
    ];

    protected $mediaError = null;

    // IMAGE

    protected $imgParams = [
        'errorTemplate' => null,
        'errorLimitDisplay' => null,
        'allowInternalImages' => null,
        'websiteExcluded' => null
    ];

    protected $imgError = null;

    // URL

    protected $urlParams = [
        'errorTemplate' => null,
        'errorLimitDisplay' => null,
        'allowInternalLinks' => null,
        'anonymUrl' => null,
        'websiteExcluded' => null,
    ];

    protected $webSitesExcluded = null;

    protected $urlError = null;

    public function checkConstruct()
    {
        $this->xcOptions = \XF::options();
        $this->xcApp = \XF::app();
        $this->xcVisitor = \XF::visitor();

        $this->isGuest = $this->xcVisitor->user_id === 0;
        $this->isWaitingEmailConfirm = $this->xcVisitor->user_state === 'email_confirm';

        $this->boardUrl = $this->xcOptions->boardUrl;
        $this->parsedBoardUrl = $this->xcParseUrl($this->boardUrl);

        $this->attachErrorLimitDisplay = intval($this->xcOptions->xc_hide_links_from_guests_limit_insert_attach);
        $this->mediaErrorLimitDisplay  = intval($this->xcOptions->xc_hide_links_from_guests_limit_insert_media);
        $this->imageErrorLimitDisplay  = intval($this->xcOptions->xc_hide_links_from_guests_limit_insert_image);
        $this->linkErrorLimitDisplay   = intval($this->xcOptions->xc_hide_links_from_guests_limit_insert_links);

        $this->insertWebsiteExcluded('linkWebsiteExcluded', $this->xcOptions->xc_hide_links_from_guests_websites_excluded);
        $this->insertWebsiteExcluded('imageWebsiteExcluded', $this->xcOptions->xc_hide_links_from_guests_img_websites_excluded);

        $this->linkAnonymUrl = $this->xcOptions->xc_hide_links_from_guests_anonym_url;
    }

    protected function insertWebsiteExcluded($name, $websites)
    {
        $websites = preg_split('/\s+/', trim($websites), -1, PREG_SPLIT_NO_EMPTY);

        $newWebSites = [];
        foreach ($websites as $website) {
            $newWebSites[] = $this->xcParseUrl($this->getValidUrl($website));
        }

        $this->{$name} = $newWebSites;
    }

    // ATTACH FUNCTIONS

    public function canUseAttachChecker($entity)
    {
        if ($this->canUseAttachChecker != null) {
            return $this->canUseAttachChecker;
        }

        if (!$this->isGuest && !$this->isWaitingEmailConfirm) {
            $this->canUseAttachChecker = false;
            return false;
        }

        if (!$this->xcOptions->xc_hide_links_from_guests_enable_hide_attach) {
            $this->canUseMediaChecker = false;
            return false;
        }

        if ($this->isWaitingEmailConfirm && !$this->xcOptions->xc_hide_links_from_guests_atta_no_validated_email) {
            $this->canUseAttachChecker = false;
            return false;
        }

        if (!$this->checkAllowedNode($entity, $this->xcOptions->xc_hide_link_from_guests_attach_allowed_nodes)) {
            return false;
        }

        $this->canUseAttachChecker = true;
        return true;
    }

    public function canDisplayErrorAttach(Post $post)
    {
        $postId = $post->post_id;
        if (!isset($this->attachCount[$postId])) {
            $this->attachCount[$postId] = 0;
        }
        $this->attachCount[$postId]++;

        if ($this->attachErrorLimitDisplay === 0) {
            return true;
        }

        if ($this->attachCount[$postId] <= $this->attachErrorLimitDisplay) {
            return true;
        }

        return false;
    }

    // MEDIA FUNCTIONS

    public function canUseMediaChecker($entity)
    {
        if ($this->canUseMediaChecker != null) {
            return $this->canUseMediaChecker;
        }

        if (!$this->isGuest && !$this->isWaitingEmailConfirm) {
            $this->canUseMediaChecker = false;
            return false;
        }

        if (!$this->xcOptions->xc_hide_links_from_guests_enable_hide_media) {
            $this->canUseMediaChecker = false;
            return false;
        }

        if ($this->isWaitingEmailConfirm && !$this->xcOptions->xc_hide_links_from_guests_media_no_validated_email) {
            $this->canUseMediaChecker = false;
            return false;
        }

        if (!$this->checkAllowedNode($entity, $this->xcOptions->xc_hide_link_from_guests_media_allowed_nodes)) {
            return false;
        }
        $this->canUseMediaChecker = true;
        return true;
    }

    public function canDisplayErrorMedia(Post $post)
    {
        $postId = $post->post_id;
        if (!isset($this->mediaCount[$postId])) {
            $this->mediaCount[$postId] = 0;
        }
        $this->mediaCount[$postId]++;

        if ($this->mediaErrorLimitDisplay === 0) {
            return true;
        }

        if ($this->mediaCount[$postId] <= $this->mediaErrorLimitDisplay) {
            return true;
        }

        return false;
    }

    // MEDIA FUNCTIONS

    public function canUseImageChecker($entity)
    {
        if ($this->canUseImageChecker != null) {
            return $this->canUseImageChecker;
        }

        if (!$this->isGuest && !$this->isWaitingEmailConfirm) {
            $this->canUseImageChecker = false;
            return false;
        }

        if (!$this->xcOptions->xc_hide_links_from_guests_enable_hide_image) {
            $this->canUseImageChecker = false;
            return false;
        }

        if ($this->isWaitingEmailConfirm && !$this->xcOptions->xc_hide_links_from_guests_image_no_validated_email) {
            $this->canUseImageChecker = false;
            return false;
        }

        if (!$this->checkAllowedNode($entity, $this->xcOptions->xc_hide_link_from_guests_image_allowed_nodes)) {
            return false;
        }

        $this->canUseImageChecker = true;
        return true;
    }

    public function canDisplayErrorImage(Post $post)
    {
        $postId = $post->post_id;
        if (!isset($this->imageCount[$postId])) {
            $this->imageCount[$postId] = 0;
        }
        $this->imageCount[$postId]++;

        if ($this->imageErrorLimitDisplay === 0) {
            return true;
        }

        if ($this->imageCount[$postId] <= $this->imageErrorLimitDisplay) {
            return true;
        }

        return false;
    }

    // URL FUNCTIONS

    public function canUseUrlChecker($entity)
    {
        if ($this->canUseUrlChecker != null) {
            return $this->canUseUrlChecker;
        }

        if (!$this->isGuest && !$this->isWaitingEmailConfirm) {
            $this->canUseUrlChecker = false;
            return false;
        }

        if (!$this->xcOptions->xc_hide_links_from_guests_enable_hide_link) {
            $this->canUseUrlChecker = false;
            return false;
        }

        if ($this->isWaitingEmailConfirm && !$this->xcOptions->xc_hide_links_from_guests_no_validated_email) {
            $this->canUseUrlChecker = false;
            return false;
        }

        if (!$this->checkAllowedNode($entity, $this->xcOptions->xc_hide_link_from_guests_allowed_nodes)) {
            return false;
        }

        $this->canUseUrlChecker = true;
        return true;
    }

    public function canDisplayErrorUrl(Post $post)
    {
        $postId = $post->post_id;
        if (!isset($this->urlCount[$postId])) {
            $this->urlCount[$postId] = 0;
        }

        $this->urlCount[$postId]++;

        if ($this->linkErrorLimitDisplay === 0) {
            return true;
        }

        if ($this->urlCount[$postId] <= $this->linkErrorLimitDisplay) {
            return true;
        }

        return false;
    }

    // OTHER FUNCTIONS

    public function checkAllowedNode($entity, $optionValue)
    {
        if (!$entity instanceof Post) {
            return false;
        }

        if (in_array($entity->Thread->node_id, $optionValue)) {
            return false;
        }

        return true;
    }

    protected function xcParseUrl($url)
    {
        return str_replace('www.', '', parse_url($url, PHP_URL_HOST));
    }

    protected function xcPrepareRenderUrl(array $children, $option, array $tag, array $options)
    {
        if ($option !== null && !is_array($option)) {
            $url = $option;
            $text = $this->renderSubTree($children, $options);

            if ($text === '') {
                $text = $url;
            }
        } else if (
            is_array($option)
            && isset($option['unfurl'])
            && $option['unfurl'] === 'true'
        ) {
            $url = $this->renderSubTreePlain($children);
            $text = '';
            $unfurl = true;
        } else {
            $url = $this->renderSubTreePlain($children);
            $text = $this->prepareTextFromUrlExtended($url, []);
        }

        $url = $this->getValidUrl($url);
        if (!$url) {
            return $text;
        }

        $url = $this->formatter->censorText($url);

        $url = parse_url($url, PHP_URL_HOST);
        $url = str_replace('www.', '', $url);

        return $url;
    }

    protected function isWebsiteExcluded($url, $websites)
    {
        if (!in_array($url, $websites)) {
            return false;
        }

        return true;
    }
}
