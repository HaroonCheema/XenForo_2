<?php

namespace XenBulletins\VideoPages;

use XF\Util\Arr;

class Listener {

    public static function templaterSetup(\XF\Container $container, \XF\Template\Templater &$templater) {
        /** @var \RecordBook\Template\TemplaterSetup $templaterSetup */
        $class = \XF::extendClass('XenBulletins\VideoPages\Template\TemplaterSetup');
        $templaterSetup = new $class();

        $templater->addFunction('get_vpthumbnail', [$templaterSetup, 'fnGetVpthumbnail']);
        $templater->addFunction('iframurl', [$templaterSetup, 'fnIframUrl']);

    }

   

}
