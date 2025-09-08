<?php
namespace XenGenTr\XGTCoreLibrary\Listener;

use XF\Container;
use XF\Entity\StyleProperty;
use XF\Entity\StylePropertyGroup;
use XF\Template\Templater;
use XF\Util\Arr;
/**
 * Class TemplaterSetup
 */

class TemplaterSetup
{
    /**
     * @var array
     */
    protected static $_js = [];

    /**
     * @param Container $container
     * @param Templater $templater
     */
    public static function templaterSetup(Container $container, Templater &$templater)
    {
        $templater->addFunction(
            'xgt_style_property_prefix',
            ['\XenGenTr\XGTCoreLibrary\Listener\TemplaterSetup', 'fnStylePropertyPrefix']
        );
    }
    /**
     * @param Templater $templater
     * @param $escape
     * @param $entity
     * @return string
     */
    public static function fnStylePropertyPrefix(Templater $templater, &$escape, $entity)
    {
        $key = '';
        if ($entity instanceof StylePropertyGroup) {
            $key = $entity->group_name;
        }
        if ($entity instanceof StyleProperty) {
            $key = $entity->property_name;
        }

        if (strpos($key, 'xgt_') === 0) {
            $escape = false;
            return $templater->renderTemplate('admin:xgt_style_property_prefix');
        }

        return null;
    }

}