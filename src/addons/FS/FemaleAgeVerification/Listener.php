<?php

namespace FS\FemaleAgeVerification;

use XF\Mvc\Entity\Entity;

class Listener
{
    /**
     * Called at the end of the postDispatch() method of the main Controller object.
     *
     * Event hint: Fully qualified name of the root class that was called.
     *
     * @param \XF\Mvc\Controller $controller Main controller object.
     * @param mixed $action Current controller action.
     * @param \XF\Mvc\ParameterBag $params ParameterBag object containing router
     *                                                related params.
     * @param \XF\Mvc\Reply\AbstractReply $reply Reply object.
     */
    // public static function controllerPreDispatch(\XF\Mvc\Controller $controller, $action, \XF\Mvc\ParameterBag $params)
    // {
    //     if ($controller instanceof \XF\Pub\Controller\AbstractController) {

    //         // echo "Controller";
    //         // exit;

    //         $visitor = \XF::visitor();
    //         $options = \XF::options();
    //         $femaleGroup = $options->fsFemaleAgeVerificationGroup;

    //         if ($visitor->user_id && $visitor->gender == 'female' && $femaleGroup != 0 && $visitor->isMemberOf($femaleGroup)) {

    //             // throw new InvalidArgumentException('Listener is not registered.');

    //             // throw new Exception\NotFound('dispute with id " " not found');

    //             // throw $this->exception($this->notFound());

    //             // throw \XF::app()->exception(\XF::app()->message(new \XF\PreEscaped($options->boardInactiveMessage), \XF::app()->config('serviceUnavailableCode')));

    //             // echo "Hello Visitor babel first verify your age please!";
    //             // exit;

    //             // if (!(($controller instanceof \XF\Pub\Controller\Account && ($action == 'Upgrades' || $action == 'VisitorMenu' || $action == 'AlertsPopup'))
    //             //     || $controller instanceof \XF\Pub\Controller\Purchase
    //             //     || $controller instanceof \XF\Pub\Controller\Logout
    //             //     || ($controller instanceof \XF\Pub\Controller\Conversation && $action == 'Popup')
    //             // )) {

    //             //     header('Location: ' . $controller->buildLink('account/upgrades'));
    //             //     exit;
    //             // }
    //         }
    //     }
    // }
}
