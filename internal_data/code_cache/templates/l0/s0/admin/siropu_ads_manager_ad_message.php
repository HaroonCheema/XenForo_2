<?php
// FROM HASH: c5ff08a74ada93d4dcb49fac54049df8
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Send message to ' . $__templater->escape($__vars['ad']['username']) . '');
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__vars['type'] == 'email') {
		$__compilerTemp1 .= '
						<div class="inputGroup">
							' . $__templater->formTextBox(array(
			'name' => 'subject',
			'placeholder' => 'Subject',
			'required' => 'required',
		)) . '
						</div>
					';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formRow('
				<div class="block-tabHeader tabs tabs--standalone hScroller" data-xf-init="tabs h-scroller" role="tablist">
					<a href="' . $__templater->func('link', array('ads-manager/ads/message', $__vars['ad'], ), true) . '" class="tabs-tab' . (($__vars['type'] == 'alert') ? ' is-active' : '') . '">' . 'Alert' . '</a>
					<a href="' . $__templater->func('link', array('ads-manager/ads/message', $__vars['ad'], array('type' => 'email', ), ), true) . '" class="tabs-tab' . (($__vars['type'] == 'email') ? ' is-active' : '') . '">' . 'Email' . '</a>
					<a href="' . $__templater->func('link_type', array('public', 'conversations/add', null, array('to' => $__vars['ad']['username'], ), ), true) . '" class="tabs-tab" data-xf-click="overlay">' . 'Start conversation' . '</a>
				</div>
				<div class="inputGroup-container">
					' . $__compilerTemp1 . '
					<div class="inputGroup">
						' . $__templater->formTextArea(array(
		'name' => 'message',
		'placeholder' => 'Message',
		'rows' => '3',
		'required' => 'required',
	)) . '
					</div>
				</div>
				' . $__templater->formHiddenVal('type', $__vars['type'], array(
	)) . '
			', array(
		'label' => 'Message type',
	)) . '
		</div>

		' . $__templater->formSubmitRow(array(
		'submit' => 'Send',
		'fa' => 'fa-paper-plane',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('ads-manager/ads/message', $__vars['ad'], ), false),
		'ajax' => 'true',
		'data-force-flash-message' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);