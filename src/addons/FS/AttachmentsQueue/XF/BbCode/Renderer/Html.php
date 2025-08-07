<?php

namespace FS\AttachmentsQueue\XF\BbCode\Renderer;

use FS\AttachmentsQueue\BbCode\Renderer\FsCheckTrait;
use XF;
use XF\Str\Formatter;
use XF\Template\Templater;

class Html extends XFCP_Html
{
    use FsCheckTrait;

    public function __construct(Formatter $formatter, Templater $templater)
    {
        parent::__construct($formatter, $templater);
        $this->checkConstruct();
    }

    public function renderTagAttach(array $children, $option, array $tag, array $options)
    {
        $response = parent::renderTagAttach($children, $option, $tag, $options);

        if (!isset($options['entity'])) {
            return $response;
        }

        if (!$this->canUseAttachChecker($options['entity'])) {
            return $response;
        }

        if (!$this->canDisplayErrorAttach($options['entity'])) {
            return '';
        }

        return $this->renderError('attach');
    }

    public function renderTagImage(array $children, $option, array $tag, array $options)
    {
        $response = parent::renderTagImage($children, $option, $tag, $options);

        if (!isset($options['entity'])) {
            return $response;
        }

        if (!$this->canUseImageChecker($options['entity'])) {
            return $response;
        }

        if (!$this->canUseImageChecker($options['entity'])) {
            return $response;
        }

        $url = $this->xcPrepareRenderUrl($children, $option, $tag, $options);

        if ($this->xcOptions->xc_hide_links_from_guests_allow_internal_img && preg_match("#{$this->parsedBoardUrl}#", $url)) {
            return $response;
        }

        if (!empty($this->imageWebsiteExcluded) && $this->isWebsiteExcluded($url, $this->imageWebsiteExcluded)) {
            return $response;
        }

        if (!$this->canDisplayErrorImage($options['entity'])) {
            return '';
        }

        return $this->renderError('image');
    }

    public function renderTagMedia(array $children, $option, array $tag, array $options)
    {
        $response = parent::renderTagMedia($children, $option, $tag, $options);

        if (!isset($options['entity'])) {
            return $response;
        }

        if (!$this->canUseMediaChecker($options['entity'])) {
            return $response;
        }

        if (!$this->canDisplayErrorMedia($options['entity'])) {
            return '';
        }

        return $this->renderError('media');
    }

    public function renderTagUrl(array $children, $option, array $tag, array $options)
    {
        $response = parent::renderTagUrl($children, $option, $tag, $options);

        if (!isset($options['entity'])) {
            return $response;
        }

        $url = $this->xcPrepareRenderUrl($children, $option, $tag, $options);

        $isInternalLink = (preg_match("#{$this->parsedBoardUrl}#", $url));

        if (!$this->canUseUrlChecker($options['entity'])) {
            return $isInternalLink ? $response : $this->renderAnonymUrl($response);
        }

        if ($this->xcOptions->xc_hide_links_from_guests_allow_internal_links && $isInternalLink) {
            return $response;
        }

        if (!empty($this->linkWebsiteExcluded) && $this->isWebsiteExcluded($url, $this->linkWebsiteExcluded)) {
            return $response;
        }

        if (!$this->canDisplayErrorUrl($options['entity'])) {
            return '';
        }

        return $this->renderError('link');
    }

    public function renderAnonymUrl($response)
    {
        if (empty($this->linkAnonymUrl)) {
            return $response;
        }

        $regex = '|<a.*\s+href=[\"\']([^\'\"]*)[\'\"].*>(.*)</a>|Uims';
        preg_match($regex, $response, $urlData);
        if (!isset($urlData[0]) && !isset($urlData[1])) {
            return $response;
        }

        $url = $this->linkAnonymUrl . $urlData[1];

        $response = preg_replace_callback($regex, function ($matches) use ($url) {
            $newUrl = 'href="' . $url . '"';
            return str_replace('href="' . $matches[1] . '"', $newUrl, $matches[0]);
        }, $response);

        return $response;
    }

    protected function renderError($tag)
    {
        if ($this->isGuest) {
            $errorPhrase = 'fs_hide_links_from_guests_guests_error_hide_' . $tag;
        } else {
            $errorPhrase = 'fs_hide_links_from_guests_user_error_hide_' . $tag;
        }

        $viewParams = [
            'tag'  => $tag,
            'errorPhrase' => \XF::phrase($errorPhrase)
        ];
        return $this->templater->renderTemplate('public:fs_hide_links_medias_to_guests_bb_code_hide_error', $viewParams);
    }
}
