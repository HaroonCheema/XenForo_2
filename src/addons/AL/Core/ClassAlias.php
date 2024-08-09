<?php

namespace AL\Core;

/**
 * Class alias fixing loading of different classes for different versions of XF.
 * The solution is inspired by @Xon library at https://github.com/Xon/XenForo2-StandardLib/blob/7040b59d2b4e826fe3abe7e5071ed3796b5d304b/upload/src/addons/SV/StandardLib/Repository/Helper.php#L196
 */
class ClassAlias
{
    public static function registerVersionAlias($defaultClass)
    {
        $className = 'XF21';
        if (\XF::$versionId >= 2020000)
        {
            $className = 'XF22';
        }

        $versionClass = explode('\\', $defaultClass);
        $lastComponent = array_pop($versionClass);
        $versionClass[] = $className;
        $versionClass[] = $lastComponent;

        $versionClass = implode('\\', $versionClass);

        self::register($versionClass, $defaultClass);
    }

    public static function register($versionClass, $defaultClass)
    {
        class_alias($versionClass, $defaultClass);

        // Register an alias for the XFCP_ prefixed version to the default class
        class_alias(self::getProxyName($defaultClass), self::getProxyName($versionClass), false);
    }

    public static function getProxyName($class)
    {
        $classComponents = explode('\\', $class);
        $lastComponent = array_pop($classComponents);
        $classComponents[] = 'XFCP_' . $lastComponent;
        return implode('\\', $classComponents);
    }
}