<?php

namespace FS\BatchProfile\Admin\Controller;

class Batch extends XFCP_Batch
{
    protected function filterInputs()
    {
        $input = $this->filter([
            'title' => 'str',
            'desc' => 'str',
            'img_path' => 'str',
            'type_repeat' => 'int',
            'mini_post' => 'int',
            'usergroup_ids' => 'array',
            'allow_thread' => 'bool',
            'allow_profile' => 'bool',
        ]);

        if ($input['title'] == '' || $input['img_path'] == '' || count($input['usergroup_ids']) <= 0) {
            throw $this->exception($this->error(\XF::phraseDeferred('please_complete_required_fields')));
        }

        return $input;
    }
}
