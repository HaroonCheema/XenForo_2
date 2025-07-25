<?php

namespace FS\SendMailFromTable\Api\Controller;

use XF\Api\Controller\AbstractController;
use XF\Mvc\Entity\Entity;
use XF\Mvc\ParameterBag;

/**
 * @api-group Threads
 */
class InsertEmails extends AbstractController
{
    protected function preDispatchController($action, ParameterBag $params) {}

    public function actionPost(ParameterBag $params)
    {
        $inputRaw = $this->request()->getInputRaw();

        $json = json_decode($inputRaw, true);

        if (!is_array($json) || !isset($json['emails'])) {
            return $this->apiError(
                \XF::phrase('Required input missing.'),
                'required_input_missing'
            );
        }

        $emails = $json['emails'];

        foreach ($emails as $emailData) {
            $newEmail = $this->em()->create('FS\SendMailFromTable:MidNightEmails');
            $newEmail->email = $emailData['email'] ?? '';
            $newEmail->date = $emailData['date'] ?? \XF::$time;
            $newEmail->save();
        }

        return $this->apiSuccess([
            'emails' => "Emails inserted successfully."
        ]);
    }
}
