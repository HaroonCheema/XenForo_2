<?php

namespace AL\Core;

/**
 * Class Extension
 * @package AL\Core
 *
 * The class wraps the default extension object available in the container
 * as it was the only way to manipulate the method @resolveExtendedClassToRoot
 */
class Extension extends \XF\Extension
{
    /**
     * @var \XF\Extension
     */
    protected $original_extension;

    public function resolveExtendedClassToRoot($class)
    {
        if (
            \XF::options()->offsetExists('al_core_legacy_extension')
            && !\XF::options()->al_core_legacy_extension
        )
        {
            return $this->original_extension->resolveExtendedClassToRoot($class);
        }

        if (is_object($class))
        {
            $class = get_class($class);
        }

        // Class extensions are rare, so do the check first
        if (substr($class, 0, 3) === 'AL\\' && preg_match('#XF\d+#', $class))
        {
            // Just to simplify the regexp below
            $class = str_replace('\\', '/', $class);
            $class = preg_replace('#/XF\d+/(\w+)$#', '/$1', $class);
            $class = preg_replace('#^AL.*?/XF/#', 'XF/', $class);
            $class = str_replace('/', '\\', $class);
        }

        return $this->original_extension->resolveExtendedClassToRoot($class);
    }

    /**
     * @param \XF\Extension $original_extension
     */
    public function setOriginalExtension(\XF\Extension $original_extension)
    {
        $this->original_extension = $original_extension;
        $this->listeners = $original_extension->listeners;
        $this->classExtensions = $original_extension->classExtensions;
        $this->extensionMap = $original_extension->extensionMap;
    }
}