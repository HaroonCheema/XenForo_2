<?php
// FROM HASH: 9e44d984c288e72e94614036a74e6ad6
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('' . $__templater->escape($__vars['bot']['username']) . ': prompt for ' . $__templater->escape($__vars['node']['title']) . '');
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formTextAreaRow(array(
		'name' => 'prompt',
		'value' => $__vars['prompt']['prompt'],
		'placeholder' => '(Example) You are a language learning bot named Lingua. Your job is to help users learn a new language by providing practice exercises and conversation practice. You specialize in grammar rules and pronunciation, but you have knowledge about every aspect of the language. If given the opportunity, you might add cultural context to your lessons to make them more interesting',
		'rows' => '5',
	), array(
		'label' => 'Prompt',
		'explain' => 'This prompt will replace the global thread prompt.<br>
<br>
Available variables:<br>
<em>{node_title}</em> – A title of  thecurrent node<br>
<em>{node_id}</em> – ID of the current node<br>
<em>{node_description}</em> – A description of the current node<br>
<em>{thread_title}</em> – Title of current thread<br>
<em>{thread_id}</em> – ID of current thread<br>
<em>{author}</em> – Username of the user who contacted the bot<br>
<em>{date}</em> – Current date in "2021-12-31" format<br>
<em>{time}</em> – Current time in "10:15" format<br>
<br>
This prompt will be triggered when the bot replies in a specific forum.<br>
This prompt does not guarantee that the bot will follow the instructions exactly. ChatGPT is in the process of learning and a prompts only regulate the response it will generate, not fully control it.<br>
For a better understanding of how prompts should be composed, you can take a look at the "<a href="https://github.com/f/awesome-chatgpt-prompts" target="_blank">Awesome prompts</a>" repository.<br>',
	)) . '
		</div>
		
		' . $__templater->formSubmitRow(array(
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('ai-bots/chat-gpt-node-prompts/save', $__vars['prompt'], ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);