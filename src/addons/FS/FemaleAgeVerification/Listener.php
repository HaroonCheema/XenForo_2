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
    public static function controllerPreDispatch(\XF\Mvc\Controller $controller, $action, \XF\Mvc\ParameterBag $params)
    {
        if ($controller instanceof \XF\Pub\Controller\AbstractController) {

            $visitor = \XF::visitor();
            $options = \XF::options();
            $femaleGroup = $options->fsFemaleAgeVerificationGroup;

            if ($visitor->user_id && $visitor->gender == 'female' && $femaleGroup != 0 && $visitor->isMemberOf($femaleGroup)) {

                throw $controller->exception($controller->error(\XF::phrase('fs_female_age_verfication_age_confirmation')));
            }
        }
    }
}
