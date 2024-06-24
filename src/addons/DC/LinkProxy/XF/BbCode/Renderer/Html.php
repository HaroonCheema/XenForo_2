<?php

namespace DC\LinkProxy\XF\BbCode\Renderer;

class Html extends XFCP_Html
{
    protected function getRenderedLink($text, $url, array $options)
    {
        
		$linkInfo = $this->formatter->getLinkClassTarget($url);
		$rels = [];

		$classAttr = $linkInfo['class'] ? " class=\"$linkInfo[class]\"" : '';
		$targetAttr = $linkInfo['target'] ? " target=\"$linkInfo[target]\"" : '';

		if (!$linkInfo['trusted'] && !empty($options['noFollowUrl']))
		{
			$rels[] = 'nofollow';
		}

		if ($linkInfo['target'])
		{
			$rels[] = 'noopener';
		}

		$proxyAttr = '';
		if (empty($options['noProxy']))
		{
			$proxyUrl = $this->formatter->getProxiedUrlIfActive('link', $url);
			if ($proxyUrl)
			{
				$proxyAttr = ' data-proxy-href="' . htmlspecialchars($proxyUrl) . '"';
			}
		}

		if ($rels)
		{
			$relAttr = ' rel="' . implode(' ', $rels) . '"';
		}
		else
		{
			$relAttr = '';
        }
        
        $link = $this->formatter->getLinkClassTarget($url);

        if ($link['type'] != 'internal')
        {
            
            if(!$this->assertWhiteListDomain($url))  // if url not in whiteListed domains then encode url and alter the title of url
            {   
                    $options = \XF::options();

                    $boardUrl = $options->boardUrl;
                        
                    if ($options->useFriendlyUrls)
                    {
                        $urlEncoded = $boardUrl . '/redirect?to=' . base64_encode(htmlspecialchars($url));
                    }
                    else
                    {
                        $urlEncoded = $boardUrl . '?redirect&to=' . base64_encode(htmlspecialchars($url));
                    }

                    $url = $urlEncoded;
                    $text = $this->getAlternateTitleForLinks();
            }
            
        } 
        else 
        {   
            $url = htmlspecialchars($url);
        }

        return $this->wrapHtml(
                '<a href="' . $url . '"' . $targetAttr . $classAttr . $proxyAttr . $relAttr . '>',
                $text,
                '</a>'
        );
    }
        
        
//        protected function getRenderedUnfurl($url, array $options)
//	{
//		$result = $this->getUnfurlResultFromUrl($url, $options);
//                
////                $result->title = 'test';
//               // echo '<pre>';                var_dump($result->title);exit;
//                
// 
//
//		if (!$result)
//		{
//			$text = $this->prepareTextFromUrlExtended($url, $options);
//			return '<div>' . $this->getRenderedLink($text, $url, $options) . '</div>';
//		}
//
//		return $this->templater->renderUnfurl($result, $options);
//	}
        
        protected function getUnfurlResultFromUrl($url, array $options)
	{
            $result = parent::getUnfurlResultFromUrl($url, $options);
                        
            if(!$this->assertWhiteListDomain($url))
            {
                $result->title = $this->getAlternateTitleForLinks();        // if not a whiteList domain url then alternate title will be display for links
            }
                        
            return $result;
	}
        
       
        protected function prepareTextFromUrlExtended($url, array $options)
	{
                if(!$this->assertWhiteListDomain($url))
                {
                    return $this->getAlternateTitleForLinks();
                }
                
                return parent::prepareTextFromUrlExtended($url, $options);
	}
        
                
        protected function assertWhiteListDomain($url)
        {
            $options = \XF::options();
            
            /** Check white listed domains */
            $whiteListedDomains = $options->DC_LinkProxy_DomainWhiteList;
            $domainWhiteListedArray = explode("\n", $whiteListedDomains);
            $domain = parse_url($url, PHP_URL_HOST);

            foreach ($domainWhiteListedArray as $whiteListedDomain) 
            {
                if ( $domain == $whiteListedDomain )
                {
                    return true;    // if whiteList domain url then return true
                }
            }
            
            
            return false;
        }
        
        protected function getAlternateTitleForLinks()
        {
                return \XF::options()->DC_LinkProxy_link_replace_text;
        }
}