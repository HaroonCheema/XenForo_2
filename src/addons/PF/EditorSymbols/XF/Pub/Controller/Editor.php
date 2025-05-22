<?php

namespace PF\EditorSymbols\XF\Pub\Controller;

class Editor extends XFCP_Editor
{
    public function actionPfEsSymbols()
    {
        $viewParams = [
            'symbols' => preg_split('/\r\n|[\r\n]/', \XF::options()->pf_es_symbols)
        ];

        return $this->view('', 'pf_es_editor_symbols', $viewParams);
    }
}