<?php

namespace PF\EditorSymbols;


use XF\Data\Editor;
use XF\Mvc\Controller;

class Listener
{
    public static function editorButtonData(array &$buttons, \XF\Data\Editor $editorData)
    {
        $buttons['pfEsAddSymbol'] = [
            'fa' => 'fa-university',
            'title' => \XF::phrase('pf_es_add_symbol'),
            'type' => 'dropdown'
        ];
    }

    public static function editorDialog(array &$data, Controller $controller)
    {
        if (isset($data['dialog']) && ($data['dialog'] == 'pfEditorSymbols')) {
            $data['template'] = 'pf_es_editor_symbols';
            $data['params']['symbols'] = preg_split('/\r\n|[\r\n]/', \XF::options()->pf_es_symbols);
        }
    }
}
