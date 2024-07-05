<?php

namespace Andy\StartConversation\XF\Pub\Controller;

class Conversation extends XFCP_Conversation
{
	public function actionStartConversation()
	{    
		// get visitor
		$visitor = \XF::visitor();
				
		// get permission
		if (!$visitor->hasPermission('conversation', 'start'))
		{
			return $this->noPermission();
		}
        
        // get options
        $options = \XF::options();

        // get options from Admin CP -> Options -> Start conversation -> Quote message
        $quoteMessage = $options->startConversationQuoteMessage;
        
        // get options from Admin CP -> Options -> Start conversation -> New conversation maximum
        $newConversationMaximum = $options->startConversationNewConversationMaximum;
        
        // get options from Admin CP -> Options -> Start conversation -> Exclude usernames
        $excludeUsernames = $options->startConversationExcludeUsernames;

        // get options from Admin CP -> Options -> Start conversation -> Exclude user groups
        $excludeUserGroups = $options->startConversationExcludeUserGroups;
        
        // get options from Admin CP -> Options -> Basic board information -> Board Url
        $boardUrl = $options->boardUrl;

        // get visitor
        $visitor = \XF::visitor();

        // get userId
        $userId = $visitor['user_id'];

        // define variable
        $bypass = '';

        //########################################
        // excludeUsernames
        //########################################

        // check condition
        if (!empty($excludeUsernames))
        {
            // forech condition
            foreach ($excludeUsernames as $value) 
            {
                if ($value == $userId)
                {
                    $bypass = 'yes';
                }
            }
        }

        //########################################
        // excludeUserGroups
        //########################################

        // get result
        $finder = \XF::finder('XF:User');
        $result = $finder
            ->where('user_id', $userId)
            ->fetchOne();

        // get secondaryUserGroups
        $secondaryUserGroups = $result['secondary_group_ids'];

        // check condition
        if (!empty($secondaryUserGroups))
        {
            // array intersect
            $match = array_intersect($secondaryUserGroups, $excludeUserGroups);				

            // check condition
            if ($match)
            {
                $bypass = 'yes';
            }
        }

        // check condition
        if ($bypass != 'yes')
        {
            // get timestamp
            $timestamp = time() - 86400;

            // get results
            $finder = \XF::finder('XF:ConversationMaster');
            $results = $finder
                ->where('user_id', $userId)
                ->where('start_date', '>', $timestamp)
                ->fetch();

            // get newConversationCount
            $newConversationCount = count($results);

            // check condition
            if ($newConversationCount >= $newConversationMaximum)
            {
                return $this->error(\XF::phrase('startconversation_conversation_limit'));
            }
        }
        
        // check condition
		if ($this->isPost())
		{
			$creator = $this->setupConversationCreate();
			if (!$creator->validate($errors))
			{
				return $this->error($errors);
			}
			$this->assertNotFlooding('conversation', $this->app->options()->floodCheckLengthDiscussion ?: null);
			$conversation = $creator->save();

			$this->finalizeConversationCreate($creator);

			return $this->redirect($this->buildLink('conversations', $conversation));
		}
		else
		{
			$to = $this->filter('to', 'str');
			$title = $this->filter('title', 'str');
			$message = $this->filter('message', 'str');
            $postId = $this->filter('post_id', 'uint');
			
			// get post
			$finder = \XF::finder('XF:Post');
			$post = $finder
				->where('post_id', $postId)
				->fetchOne();

			// check condition
			if (!$post->canView($error))
			{
				throw $this->exception($this->noPermission($error));
			}
            
            // check condition
            if (!$quoteMessage)
            {
                // get message
                $message = $message = '[QUOTE]' . \XF::phrase('startconversation_in_regards_to_post:') . ' [URL]' . $boardUrl . '/posts/' . $postId . '/[/URL][/QUOTE]';
            }
            
            // check condition
            if ($quoteMessage)
            {
                // get post
                $finder = \XF::finder('XF:Post');
                $post = $finder
                    ->where('post_id', $postId)
                    ->fetchOne();
				
				// check condition
				if (empty($post))
				{
					return $this->noPermission(\XF::phrase('error'));
				}

                // get postMessage
                $postMessage = $post['message'];
                
                // get startQuote
                $startQuote = '[QUOTE="' . $post['username'] . ', post: ' . $postId . ', member: ' . $post['user_id'] . '"]';

                // get message
                $message = $startQuote . $postMessage . '[/QUOTE]';
            }
            
			if ($to !== '' && strpos($to, ',') === false)
			{
				/** @var \XF\Entity\User $toUser */
				$toUser = $this->em()->findOne('XF:User', ['username' => $to]);
				if (!$toUser)
				{
					return $this->notFound(\XF::phrase('requested_user_not_found'));
				}

				if ($visitor->user_id == $toUser->user_id)
				{
					return $this->noPermission(\XF::phrase('you_may_not_start_conversation_with_yourself'));
				}

				if (!$visitor->canStartConversationWith($toUser))
				{
					return $this->noPermission(\XF::phrase('you_may_not_start_conversation_with_x_because_of_their_privacy_settings', ['name' => $toUser->username]));
				}
			}

			/** @var \XF\Entity\ConversationMaster $conversation */
			$conversation = $this->em()->create('XF:ConversationMaster');

			$draft = \XF\Draft::createFromKey('conversation');

			if ($conversation->canUploadAndManageAttachments())
			{
				/** @var \XF\Repository\Attachment $attachmentRepo */
				$attachmentRepo = $this->repository('XF:Attachment');
				$attachmentData = $attachmentRepo->getEditorData('conversation_message', null, $draft->attachment_hash);
			}
			else
			{
				$attachmentData = null;
			}

			$viewParams = [
				'to' => $to ?: $draft->recipients,
				'title' => $title ?: $draft->title,
				'message' => $message ?: $draft->message,

				'conversation' => $conversation,
				'draft' => $draft,

				'attachmentData' => $attachmentData
			];
			return $this->view('XF:Conversation\Add', 'conversation_add', $viewParams);
		}
	}
}