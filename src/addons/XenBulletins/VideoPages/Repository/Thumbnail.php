<?php
namespace XenBulletins\VideoPages\Repository;
use XF\Mvc\Entity\Finder;
use XF\Mvc\Entity\Repository;
use XF\PrintableException;

class Thumbnail extends \XF\Mvc\Entity\Repository{
    
    
    public function createEmbedDataHandler($bbCodeMediaSiteId) {
        $handlers = $this->getEmbedDataHandlers();

        if (isset($handlers[$bbCodeMediaSiteId])) {
            $handlerClass = $handlers[$bbCodeMediaSiteId];
        } else {
            $handlerClass = 'XenBulletins\VideoPages';
        }

        if (strpos($handlerClass, ':') === false && strpos($handlerClass, '\\') === false) {
            $handlerClass = "XenBulletins\VideoPages:$handlerClass";
        }
        $handlerClass = \XF::stringToClass($handlerClass, '\%s\EmbedData\%s');
        $handlerClass = \XF::extendClass($handlerClass);

        return new $handlerClass($this->app());
    }
    
    protected function getEmbedDataHandlers()
	{
		$handlers = [
			'imgur' => 'XFMG:Imgur',
			'vimeo' => 'XFMG:Vimeo',
			'youtube' => 'XFMG:YouTube'
		];

		$this->app()->fire('xfmg_embed_data_handler_prepare', [&$handlers]);

		return $handlers;
	}
    
}


