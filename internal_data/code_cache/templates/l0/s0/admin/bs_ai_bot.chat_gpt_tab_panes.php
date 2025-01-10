<?php
// FROM HASH: f462a9fe78290db7086db819d98ebba0
return array(
'macros' => array('tuning' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'bot' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<!-- TUNING: START -->
	
	' . $__templater->formSelectRow(array(
		'name' => 'general[chat_model]',
		'value' => $__templater->method($__vars['bot'], 'getSafest', array('general', 'chat_model', 'gpt-3.5-turbo', )),
	), array(array(
		'value' => 'gpt-3.5-turbo',
		'label' => 'gpt-3.5-turbo',
		'_type' => 'option',
	),
	array(
		'value' => 'gpt-4',
		'label' => 'gpt-4',
		'_type' => 'option',
	),
	array(
		'value' => 'gpt-4-32k',
		'label' => 'gpt-4-32k',
		'_type' => 'option',
	)), array(
		'label' => 'Chat model',
		'explain' => 'GPT 4 understands context better, and can process more information.<br>
GPT 3.5 is significantly faster and cheaper.<br>
More details about the difference in models can be found at <a href="https://platform.openai.com/docs/models/overview" target="_blank">this link</a>.',
	)) . '
	
	<!-- TUNING: AFTER CHAT MODEL -->
	
	<h3 class="block-formSectionHeader">
		<span class="collapseTrigger collapseTrigger--block" data-xf-click="toggle" data-target="< :up:next">
			' . 'Threads' . '
		</span>
	</h3>
	<div class="block-body block-body--collapsible">
		' . $__templater->formTextAreaRow(array(
		'name' => 'general[thread_prompt]',
		'value' => $__vars['bot']['general']['thread_prompt'],
		'placeholder' => '(Example) You are a language learning bot named Lingua. Your job is to help users learn a new language by providing practice exercises and conversation practice. You specialize in grammar rules and pronunciation, but you have knowledge about every aspect of the language. If given the opportunity, you might add cultural context to your lessons to make them more interesting',
		'rows' => '5',
	), array(
		'label' => 'Prompt',
		'explain' => 'Available variables:<br>
<em>{thread_title}</em> – Title of current thread<br>
<em>{thread_id}</em> – ID of current thread<br>
<em>{author}</em> – Username of the user who contacted the bot<br>
<em>{forum_title}</em> – Title of thread forum<br>
<em>{date}</em> – Current date in "2021-12-31" format<br>
<em>{time}</em> – Current time in "10:15" format<br>
<br>
This prompt will describe the behavior of the bot when compiling a response for thread message.<br>
You can also <a href="' . $__templater->func('link', array('ai-bots/chat-gpt-node-prompts', ), true) . '" target="_blank">set up prompts individually for each forum.</a><br>
This prompt does not guarantee that the bot will follow the instructions exactly. ChatGPT is in the process of learning and a prompts only regulate the response it will generate, not fully control it.<br>
For a better understanding of how prompts should be composed, you can take a look at the "<a href="https://github.com/f/awesome-chatgpt-prompts" target="_blank">Awesome prompts</a>" repository.<br>',
	)) . '

		' . $__templater->formNumberBoxRow(array(
		'name' => 'general[thread_context_limit]',
		'min' => '0',
		'value' => $__vars['bot']['general']['thread_context_limit'],
	), array(
		'label' => 'Context limit',
		'explain' => 'The number of messages that will be loaded from the thread into the bot.<br>
Set to 0 to have the bot only reply to the message that triggered.',
	)) . '

		' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'general[thread_smart_ignore]',
		'label' => 'Smart ignore',
		'checked' => $__vars['bot']['general']['thread_smart_ignore'],
		'_type' => 'option',
	)), array(
		'explain' => 'Enabling this option instructs the bot to ignore messages that are not intended for it. For instance, if the bot is set up to respond to all messages in a forum, but users can also communicate with each other, the bot will ignore messages from users that don\'t refer to it, despite mentions or other triggers.
<br><br>
Please note that this feature is experimental and cannot guarantee 100% results. However, reducing the context of the bot can significantly improve its performance. Also, for more correct operation of this function, it is recommended to tell the bot its username in the prompt.
<br><br>
By activating this option, 50 tokens will be added to each request. However, it can save tokens on the output for messages that don\'t require a response and makes the bot much smarter.',
	)) . '
		
		<hr class="formRowSep" />
	</div>
	
	<!-- TUNING: AFTER THREADS -->
	
	<h3 class="block-formSectionHeader">
		<span class="collapseTrigger collapseTrigger--block" data-xf-click="toggle" data-target="< :up:next">
			' . 'Conversations' . '
		</span>
	</h3>
	<div class="block-body block-body--collapsible">
		' . $__templater->formTextAreaRow(array(
		'name' => 'general[conversation_prompt]',
		'value' => $__vars['bot']['general']['conversation_prompt'],
		'placeholder' => '(Example) You are a language learning bot named Lingua. Your job is to help users learn a new language by providing practice exercises and conversation practice. You specialize in grammar rules and pronunciation, but you have knowledge about every aspect of the language. If given the opportunity, you might add cultural context to your lessons to make them more interesting',
		'rows' => '5',
	), array(
		'label' => 'Prompt',
		'explain' => 'Available variables:<br>
<em>{conversation_title}</em> – Title of current conversation<br>
<em>{conversation_id}</em> – ID of current conversation<br>
<em>{author}</em> – Username of the user who contacted the bot<br>
<em>{recipients}</em> – List of recipient usernames of current conversation<br>
<em>{date}</em> – Current date in "2021-12-31" format<br>
<em>{time}</em> – Current time in "10:15" format<br>
<br>
This prompt will describe the behavior of the bot when compiling a response for conversation message.<br>
This prompt does not guarantee that the bot will follow the instructions exactly. ChatGPT is in the process of learning and a prompts only regulate the response it will generate, not fully control it.<br>
For a better understanding of how prompts should be composed, you can take a look at the "<a href="https://github.com/f/awesome-chatgpt-prompts" target="_blank">Awesome prompts</a>" repository.',
	)) . '

		' . $__templater->formNumberBoxRow(array(
		'name' => 'general[conversation_context_limit]',
		'min' => '0',
		'value' => $__vars['bot']['general']['conversation_context_limit'],
	), array(
		'label' => 'Context limit',
		'explain' => 'The number of messages that will be loaded from the conversation into the bot.<br>
Set to 0 to have the bot only reply to the message that triggered.',
	)) . '

		' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'general[conversation_smart_ignore]',
		'label' => 'Smart ignore',
		'checked' => $__vars['bot']['general']['conversation_smart_ignore'],
		'_type' => 'option',
	)), array(
		'explain' => 'Enabling this option instructs the bot to ignore messages that are not intended for it.
<br><br>
Please note that this feature is experimental and cannot guarantee 100% results. However, reducing the context of the bot can significantly improve its performance. Also, for more correct operation of this function, it is recommended to tell the bot its username in the prompt.
<br><br>
By activating this option, 50 tokens will be added to each request. However, it can save tokens on the output for messages that don\'t require a response and makes the bot much smarter.',
	)) . '

		<hr class="formRowSep" />
	</div>
	
	<!-- TUNING: AFTER CONVERSATIONS -->
	
	<h3 class="block-formSectionHeader">
		<span class="collapseTrigger collapseTrigger--block" data-xf-click="toggle" data-target="< :up:next">
			' . 'Bot profile' . '
		</span>
	</h3>
	<div class="block-body block-body--collapsible">
		' . $__templater->formTextAreaRow(array(
		'name' => 'general[bot_profile_prompt]',
		'value' => $__templater->method($__vars['bot'], 'getSafest', array('general', 'bot_profile_prompt', )),
		'placeholder' => '(Example) You are a language learning bot named Lingua. Your job is to help users learn a new language by providing practice exercises and conversation practice. You specialize in grammar rules and pronunciation, but you have knowledge about every aspect of the language. If given the opportunity, you might add cultural context to your lessons to make them more interesting',
		'rows' => '5',
	), array(
		'label' => 'Prompt',
		'explain' => 'Available variables:<br>
<em>{author}</em> – Username of the user who contacted the bot<br>
<em>{date}</em> – Current date in "2021-12-31" format<br>
<em>{time}</em> – Current time in "10:15" format<br>
<br>
This prompt will describe the behavior of the bot when compiling a response for profile comment.<br>
This prompt does not guarantee that the bot will follow the instructions exactly. ChatGPT is in the process of learning and a prompts only regulate the response it will generate, not fully control it.<br>
For a better understanding of how prompts should be composed, you can take a look at the "<a href="https://github.com/f/awesome-chatgpt-prompts" target="_blank">Awesome prompts</a>" repository.',
	)) . '

		' . $__templater->formNumberBoxRow(array(
		'name' => 'general[bot_profile_context_limit]',
		'min' => '0',
		'value' => $__templater->method($__vars['bot'], 'getSafest', array('general', 'bot_profile_context_limit', )),
	), array(
		'label' => 'Context limit',
		'explain' => 'The number of comments that will be loaded into the bot.<br>
Set to 0 to have the bot only reply to the comment that triggered.',
	)) . '

		<hr class="formRowSep" />
	</div>
	
	<!-- TUNING: AFTER BOT PROFILE -->
	
	' . $__templater->formNumberBoxRow(array(
		'name' => 'general[temperature]',
		'max' => '1',
		'min' => '0.1',
		'step' => '0.1',
		'value' => $__vars['bot']['general']['temperature'],
	), array(
		'label' => 'Temperature',
		'explain' => 'See the <a href="https://platform.openai.com/docs/guides/chat/instructing-chat-models">OpenAI API documentation</a> for details.',
	)) . '
	<!-- TUNING: END -->
';
	return $__finalCompiled;
}
),
'restrictions' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'bot' => '!',
		'userGroups' => '!',
		'nodeTree' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<!-- RESTRICTIONS: START  -->
	';
	$__compilerTemp1 = array(array(
		'value' => '-1',
		'label' => 'All',
		'_type' => 'option',
	));
	$__compilerTemp1 = $__templater->mergeChoiceOptions($__compilerTemp1, $__vars['userGroups']);
	$__finalCompiled .= $__templater->formSelectRow(array(
		'name' => 'restrictions[active_for_user_group_ids]',
		'multiple' => 'true',
		'value' => $__vars['bot']['restrictions']['active_for_user_group_ids'],
		'listclass' => 'listColumns',
	), $__compilerTemp1, array(
		'label' => 'Active for user groups',
		'explain' => 'Only users who are members of the selected groups will be able to use the bot.',
	)) . '

	<hr class="formRowSep" />
	
	<!-- RESTRICTIONS: AFTER ACTIVE USER GROUPS -->

	' . $__templater->formRow('
		' . $__templater->callMacro('forum_selection_macros', 'select_forums', array(
		'selectName' => 'restrictions[active_node_ids]',
		'nodeIds' => $__vars['bot']['restrictions']['active_node_ids'],
		'nodeTree' => $__vars['nodeTree'],
		'withRow' => false,
	), $__vars) . '
	', array(
		'rowtype' => 'input',
		'label' => 'Applicable forums',
		'explain' => 'Bot wil reply only in the selected forums.',
	)) . '

	' . $__templater->formNumberBoxRow(array(
		'name' => 'restrictions[max_replies_per_thread]',
		'value' => $__vars['bot']['restrictions']['max_replies_per_thread'],
	), array(
		'label' => 'Max replies per thread',
		'explain' => 'If the number of bot posts in a thread reaches this value, it will not respond.<br>
Set to "0" to remove this limitation.',
	)) . '

	<hr class="formRowSep" />
	
	<!-- RESTRICTIONS: AFTER THREADS -->
	
	' . $__templater->formNumberBoxRow(array(
		'name' => 'restrictions[max_replies_per_conversation]',
		'value' => $__vars['bot']['restrictions']['max_replies_per_conversation'],
	), array(
		'label' => 'Max replies per conversation',
		'explain' => 'If the number of bot messages in a conversation reaches this value, it will not respond.<br>
Set to "0" to remove this limitation.',
	)) . '

	<hr class="formRowSep" />
	
	<!-- RESTRICTIONS: AFTER CONVERSATIONS -->
	' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'restrictions[spam_check]',
		'label' => 'Spam check',
		'checked' => $__vars['bot']['restrictions']['spam_check'],
		'_type' => 'option',
	)), array(
		'explain' => 'If the option is enabled, the bot\'s messages will be checked for spam, just like regular users.',
	)) . '
	<!-- RESTRICTIONS: END -->
';
	return $__finalCompiled;
}
),
'triggers' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'bot' => '!',
		'nodeTree' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<!-- TRIGGERS: START -->
	' . $__templater->formSelectRow(array(
		'name' => 'triggers[active_in_context]',
		'multiple' => 'true',
		'value' => $__vars['bot']['triggers']['active_in_context'],
	), array(array(
		'value' => 'thread',
		'label' => 'Thread',
		'_type' => 'option',
	),
	array(
		'value' => 'conversation',
		'label' => 'Conversation',
		'_type' => 'option',
	),
	array(
		'value' => 'bot_profile',
		'label' => 'Bot profile',
		'_type' => 'option',
	)), array(
		'label' => 'Context',
		'explain' => 'Places where the bot will be available.',
	)) . '

	<hr class="formRowSep" />
	
	<!-- TRIGGERS: AFTER CONTEXT -->

	' . $__templater->formCheckBoxRow(array(
		'name' => 'triggers[post]',
		'value' => $__vars['bot']['triggers']['post'],
	), array(array(
		'value' => 'mention',
		'label' => 'Mention',
		'checked' => $__templater->func('in_array', array('mention', $__vars['bot']['triggers']['post'], ), false),
		'_type' => 'option',
	),
	array(
		'value' => 'quote',
		'label' => 'Quote',
		'checked' => $__templater->func('in_array', array('quote', $__vars['bot']['triggers']['post'], ), false),
		'_type' => 'option',
	)), array(
		'label' => 'Post triggers',
	)) . '
	
	' . $__templater->formRow('
		' . $__templater->callMacro('forum_selection_macros', 'select_forums', array(
		'selectName' => 'triggers[posted_in_node_ids]',
		'nodeIds' => $__vars['bot']['triggers']['posted_in_node_ids'],
		'nodeTree' => $__vars['nodeTree'],
		'withRow' => false,
	), $__vars) . '
	', array(
		'rowtype' => 'input',
		'label' => 'Posted in',
		'explain' => 'The bot will respond to all messages posted in selected forums, except for those messages that match ignore regexes.',
	)) . '
	
	<!-- TRIGGERS: AFTER POSTS -->

	<hr class="formRowSep" />

	' . $__templater->formCheckBoxRow(array(
		'name' => 'triggers[conversation]',
		'value' => $__vars['bot']['triggers']['conversation'],
	), array(array(
		'value' => 'private_appeal',
		'label' => 'Private appeal',
		'checked' => $__templater->func('in_array', array('private_appeal', $__vars['bot']['triggers']['conversation'], ), false),
		'hint' => 'Reply in a conversation where only the bot and the user are recipients.',
		'_type' => 'option',
	),
	array(
		'value' => 'mention',
		'label' => 'Mention',
		'checked' => $__templater->func('in_array', array('mention', $__vars['bot']['triggers']['conversation'], ), false),
		'_type' => 'option',
	),
	array(
		'value' => 'quote',
		'label' => 'Quote',
		'checked' => $__templater->func('in_array', array('quote', $__vars['bot']['triggers']['conversation'], ), false),
		'_type' => 'option',
	)), array(
		'label' => 'Conversation triggers',
	)) . '

	<hr class="formRowSep" />
	
	<!-- TRIGGERS: AFTER CONVERSATION -->

	';
	$__compilerTemp1 = '';
	if ($__templater->isTraversable($__vars['bot']['triggers']['regexes'])) {
		foreach ($__vars['bot']['triggers']['regexes'] AS $__vars['counter'] => $__vars['regex']) {
			$__compilerTemp1 .= '
				<li class="inputGroup">
					' . $__templater->formTextBox(array(
				'name' => 'triggers[regexes][' . $__vars['counter'] . ']',
				'value' => $__vars['regex'],
				'placeholder' => 'Regular expression',
			)) . '
				</li>
			';
		}
	}
	$__finalCompiled .= $__templater->formRow('
		<ul class="listPlain inputGroup-container">
			' . $__compilerTemp1 . '

			<li class="inputGroup" data-xf-init="field-adder" data-increment-format="triggers[regexes][{counter}]">
				' . $__templater->formTextBox(array(
		'name' => 'triggers[regexes][' . $__vars['nextCounter'] . ']',
		'placeholder' => 'Regular expression',
	)) . '
			</li>
		</ul>
	', array(
		'rowtype' => 'input',
		'label' => 'Regexes',
		'explain' => 'If a message is matched with one of these regular expressions, the bot will fire.',
	)) . '

	';
	$__compilerTemp2 = '';
	if ($__templater->isTraversable($__vars['bot']['triggers']['ignore_regexes'])) {
		foreach ($__vars['bot']['triggers']['ignore_regexes'] AS $__vars['counter'] => $__vars['regex']) {
			$__compilerTemp2 .= '
				<li class="inputGroup">
					' . $__templater->formTextBox(array(
				'name' => 'triggers[ignore_regexes][' . $__vars['counter'] . ']',
				'value' => $__vars['regex'],
				'placeholder' => 'Regular expression',
			)) . '
				</li>
			';
		}
	}
	$__finalCompiled .= $__templater->formRow('
		<ul class="listPlain inputGroup-container">
			' . $__compilerTemp2 . '

			<li class="inputGroup" data-xf-init="field-adder" data-increment-format="triggers[ignore_regexes][{counter}]">
				' . $__templater->formTextBox(array(
		'name' => 'triggers[ignore_regexes][' . $__vars['nextCounter'] . ']',
		'placeholder' => 'Regular expression',
	)) . '
			</li>
		</ul>
	', array(
		'rowtype' => 'input',
		'label' => 'Ignore regexes',
		'explain' => 'Bot will not respond on post if text matching one of these regexes. ',
	)) . '
	<!-- TRIGGERS: END -->
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<li role="tabpanel" id="tuning">
	' . $__templater->callMacro(null, 'tuning', array(
		'bot' => $__vars['bot'],
	), $__vars) . '
</li>
<li role="tabpanel" id="restrictions">
	' . $__templater->callMacro(null, 'restrictions', array(
		'bot' => $__vars['bot'],
		'userGroups' => $__vars['userGroups'],
		'nodeTree' => $__vars['nodeTree'],
	), $__vars) . '
</li>
<li role="tabpanel" id="triggers">
	' . $__templater->callMacro(null, 'triggers', array(
		'bot' => $__vars['bot'],
		'nodeTree' => $__vars['nodeTree'],
	), $__vars) . '
</li>

' . '

' . '

';
	return $__finalCompiled;
}
);