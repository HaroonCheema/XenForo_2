<?php

namespace FS\ThreadDeleteEdit\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Thread extends XFCP_Thread
{

    public function actionDeleteEdit(ParameterBag $params)
    {
        $visitor = \XF::visitor();

        if (!($visitor->is_admin && $visitor->is_moderator)) {
            return $this->noPermission();
        }

        $this->assertNotEmbeddedImageRequest();

        $thread = $this->assertViewableThread($params->thread_id);

        if ($this->isPost()) {

            $input = $this->filter([
                'users' => 'str',
            ]);

            if ($input['users'] == '') {
                throw $this->exception($this->error(\XF::phraseDeferred('please_complete_required_fields')));
            }

            $thread->fastUpdate("users", $input['users']);

            return $this->redirect($this->getDynamicRedirect());
        } else {

            $viewParams = [
                'thread' => $thread,
            ];

            return $this->view('FS\ThreadDeleteEdit:Thread', 'fs_thread_delete_edit_add', $viewParams);
        }
    }
}
