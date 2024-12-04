<?php

namespace FS\ExtendThreadCredits\Admin\Controller;
use FS\ExtendThreadCredits\Entity\UserSpecialCreditLog as EntityUserSpecialCreditLog;
use XF\Admin\Controller\AbstractController;
use XF\ControllerPlugin\Delete;
use XF\Mvc\FormAction;
use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\View;
use XF\Repository\User;
class UserSpecialCredit extends AbstractController
{
    public function actionList(ParameterBag $params)
    {
        // Get the current logged-in user
        $visitor = \XF::visitor();
    
        // Create the finder for UserSpecialCreditLog with pagination parameters
        $page = $this->filterPage($params->page);
        $perPage = 15;
        
        // Create the finder for UserSpecialCreditLog
        $specialCreditsFinder = $this->finder('FS\ExtendThreadCredits:UserSpecialCreditLog')->with('User');
    
        // Check if the user is a moderator but not an admin
        if ($visitor->is_moderator && !$visitor->is_admin)
        {
            // Filter to show only the logs assigned by this moderator
            $specialCreditsFinder->where('moderator_id', $visitor->user_id);
        }
    
        // Calculate total records and apply pagination
        $total = $specialCreditsFinder->total();
        $specialCreditsFinder->limitByPage($page, $perPage);
        $specialCredits = $specialCreditsFinder->fetch();
    
        // Pass pagination information to the view
        $viewParams = [
            'specialCredits' => $specialCredits,
            'page' => $page,
            'perPage' => $perPage,
            'total' => $total,
            'pageNavParams' => [] // Add any additional query parameters here if needed
        ];
    
        return $this->view('FS\ExtendThreadCredits:UserSpecialCredit\List', 'special_credit_list', $viewParams);
    }
    
    
    
    public function actionAdd()
    {
        $specialCredits = $this->em()->create('FS\ExtendThreadCredits:UserSpecialCreditLog');

        return $this->specialCreditAddEdit($specialCredits);
    }



    public function actionEdit(ParameterBag $params)
    {
            $specialCredits = $this->assertSpecialCreditExists($params->user_special_credit_id);
            return $this->specialCreditAddEdit($specialCredits);
       
    }
    protected function specialCreditAddEdit(EntityUserSpecialCreditLog $specialCredits)
    {
        $viewParams = [
            'specialCredits' => $specialCredits
        ];
        return $this->view('FS\ExtendThreadCredits:UserSpecialCredit\Edit', 'special_credit_add_edit', $viewParams);
    }

    protected function assertSpecialCreditExists($id, $with = null, $phraseKey = null)
    {
        return $this->assertRecordExists('FS\ExtendThreadCredits:UserSpecialCreditLog', $id, $with, $phraseKey);
    }
    public function actionSave(ParameterBag $params)
    {
        // Check if we're updating an existing entry or creating a new one
        if ($params->user_special_credit_id) {
            $specialCredits = $this->assertSpecialCreditExists($params->user_special_credit_id);
        } else {
            $specialCredits = $this->em()->create('FS\ExtendThreadCredits:UserSpecialCreditLog');
        }
    
        // Validate the username input
        $username = $this->filter('username', 'str');
        $user = $this->em()->findOne('XF:User', ['username' => $username]);
        
        // If user is not found, return an error response
        if (!$user) {
            return $this->error(\XF::phrase('requested_user_not_found'));
        }
    
        // Run the save process if the user exists
        $form = $this->specialCreditSaveProcess($specialCredits, $user);
        $form->run();
    
        // Redirect to the list view after saving
        return $this->redirect($this->buildLink("user-special-credit/list"));
    }
    

    protected function specialCreditSaveProcess(EntityUserSpecialCreditLog $specialCredits,$user)
        {
        $form = $this->formAction();
        $visitorId = \XF::visitor()->user_id;
      
        $credit = $this->filter('special_credit', 'int');
        // Filter the input values
        $input = $this->filter([
            'reason' => 'str',
        ]);
        
        // Assign values to the User entity
        $user->special_credit = $credit;
        $user->save();  // Save the updated credit value to the user entity
        $input['user_id'] = $user->user_id;
        $input['moderator_id'] = $visitorId;
        $input['given_at'] = \XF::$time;
    
        // Save data to the UserSpecialCreditLog entity
        $form->basicEntitySave($specialCredits, $input);
    
        return $form;
    }
    public function actionDelete(ParameterBag $params)
    {
        // Retrieve the UserSpecialCreditLog entity
        $specialCredits = $this->assertSpecialCreditExists($params->user_special_credit_id);
        
        // Retrieve the associated user entity and set their special_credit to 0
        $user = $specialCredits->User;
        if ($user) {
            $user->special_credit = 0;
            $user->save(); // Save the updated user record
        }
    
        // Proceed with deleting the UserSpecialCreditLog entry
        $plugin = $this->plugin('XF:Delete');
        return $plugin->actionDelete(
            $specialCredits,
            $this->buildLink('user-special-credit/delete', $specialCredits),
            $this->buildLink('user-special-credit/edit', $specialCredits),
            $this->buildLink('user-special-credit/list'),
            $specialCredits->User->username
        );
    }
    
}