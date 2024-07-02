<?php
// FROM HASH: 7fe37bbe9a6e3cf841578a2f61d496c9
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<h3 class="block-formSectionHeader">
	<span class="collapseTrigger collapseTrigger--block" data-xf-click="toggle" data-target="< :up:next">
		' . 'Chat' . '
	</span>
</h3>
<div class="block-body block-body--collapsible">
	' . $__templater->formTextAreaRow(array(
		'name' => 'general[rtc_prompt]',
		'value' => $__vars['bot']['general']['rtc_prompt'],
		'placeholder' => 'bs_aib_prompt_placeholder',
		'rows' => '5',
	), array(
		'label' => 'bs_aib_prompt',
		'explain' => 'Available variables:<br>
<em>{author}</em> – Username of the user who contacted the bot<br>
<em>{date}</em> – Current date in "2021-12-31" format<br>
<em>{time}</em> – Current time in "10:15" format<br>
<br>
This prompt will describe the behavior of the bot when compiling a response for chat message.<br>
This prompt does not guarantee that the bot will follow the instructions exactly. ChatGPT is in the process of learning and a prompts only regulate the response it will generate, not fully control it.<br>
For a better understanding of how prompts should be composed, you can take a look at the "<a href="https://github.com/f/awesome-chatgpt-prompts" target="_blank">Awesome prompts</a>" repository.',
	)) . '

	' . $__templater->formNumberBoxRow(array(
		'name' => 'general[rtc_context_limit]',
		'min' => '0',
		'value' => $__vars['bot']['general']['rtc_context_limit'],
	), array(
		'label' => 'bs_aib_context_limit',
		'explain' => 'The number of messages that will be loaded from the chat into the bot.<br>
Set to 0 to have the bot only reply to the message that triggered.',
	)) . '

	' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'general[rtc_smart_ignore]',
		'label' => 'bs_aib_smart_ignore',
		'checked' => $__vars['bot']['general']['rtc_smart_ignore'],
		'_type' => 'option',
	)), array(
		'explain' => 'bs_aib_smart_ignore_explain',
	)) . '

	' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'general[rtc_streaming_mode]',
		'label' => 'Streaming mode',
		'checked' => $__templater->method($__vars['bot'], 'getSafest', array('general', 'rtc_streaming_mode', )),
		'_type' => 'option',
	)), array(
		'explain' => 'bs_aib_stream_mode_explain',
	)) . '
	
	' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'general[rtc_respond_in_pm_only]',
		'label' => 'Respond in PM only',
		'checked' => $__templater->method($__vars['bot'], 'getSafest', array('general', 'rtc_respond_in_pm_only', )),
		'_type' => 'option',
	)), array(
		'explain' => 'If this option is enabled, bot messages will be visible only to the author of the trigger message.',
	)) . '

	<hr class="formRowSep" />
</div>';
	return $__finalCompiled;
}
);