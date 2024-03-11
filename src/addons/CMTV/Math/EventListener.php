<?php
<<<<<<< HEAD

=======
>>>>>>> ec84cb00a69fdecad2b7ec284b83c9f007c870e0
/**
 * Math xF2 addon by CMTV
 * Enjoy!
 */

namespace CMTV\Math;

use XF\Data\Editor;
use XF\Mvc\Controller;

class EventListener
{
    public static function editorButtonData(array &$buttons, Editor $editorData)
    {
        $buttons['CMTV_Math'] = [
            'fa' => 'fa-function',
            'title' => \XF::phrase('CMTV_Math_insert_math')
        ];
    }

    public static function editorDialog(array &$data, Controller $controller)
    {
<<<<<<< HEAD
        $data['template'] = 'CMTV_Math_insert_math_jax_dialog';
=======
        $data['template'] = 'CMTV_Math_insert_math_dialog';
>>>>>>> ec84cb00a69fdecad2b7ec284b83c9f007c870e0
    }

    public static function bbCodeProcessorActionMap(array &$processorActionMap)
    {
        $processorActionMap['CMTV_Math'] = 'CMTV\Math:MathDelimiters';
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> ec84cb00a69fdecad2b7ec284b83c9f007c870e0
