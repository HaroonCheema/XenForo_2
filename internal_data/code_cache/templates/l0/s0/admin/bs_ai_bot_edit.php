<?php
// FROM HASH: 72a67d4a134fc5e7580895f9dd04e491
return array(
'macros' => array('general' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'bot' => '!',
		'userGroups' => '!',
		'handlers' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if (!$__vars['bot']['user_id']) {
		$__finalCompiled .= '
		' . $__templater->formTextBoxRow(array(
			'name' => 'username',
			'ac' => 'single',
		), array(
			'label' => 'User',
		)) . '
	';
	}
	$__finalCompiled .= '

	' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'is_active',
		'selected' => $__vars['bot']['is_active'],
		'label' => 'Active',
		'hint' => 'Use this to disable bot.',
		'_type' => 'option',
	)), array(
	)) . '
	
	';
	$__compilerTemp1 = $__templater->mergeChoiceOptions(array(), $__vars['handlers']);
	$__finalCompiled .= $__templater->formSelectRow(array(
		'name' => 'bot_class',
		'data-xf-init' => 'aib-handler-tabs-loader',
		'data-link' => $__templater->func('link', array('ai-bots/tabs', $__vars['bot'], ), false),
		'data-first-load' => ($__templater->method($__vars['bot'], 'isInsert', array()) ? 'true' : 'false'),
		'value' => $__vars['bot']['bot_class'],
	), $__compilerTemp1, array(
		'label' => 'Handler',
	)) . '

	';
	$__compilerTemp2 = $__templater->mergeChoiceOptions(array(), $__vars['userGroups']);
	$__finalCompiled .= $__templater->formCheckBoxRow(array(
		'name' => 'extra_user_group_ids',
		'value' => $__vars['bot']['extra_user_group_ids'],
		'listclass' => 'listColumns',
	), $__compilerTemp2, array(
		'label' => 'Add user to user groups',
		'hint' => '<br />
			' . $__templater->formCheckBox(array(
		'standalone' => 'true',
	), array(array(
		'check-all' => '< .formRow',
		'label' => 'Select all',
		'_type' => 'option',
	))) . '
		',
	)) . '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->method($__vars['bot'], 'isInsert', array())) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Add bot');
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit bot' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['bot']['username']));
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['bot'], 'isUpdate', array())) {
		$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('', array(
			'href' => $__templater->func('link', array('ai-bots/delete', $__vars['bot'], ), false),
			'icon' => 'delete',
			'overlay' => 'true',
		), '', array(
		)) . '
');
	}
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['bot'], 'isInsert', array())) {
		$__finalCompiled .= '
	<div class="blockMessage blockMessage--warning blockMessage--iconic">
		' . 'For the bot to work, you need to select the necessary nodes and user groups for which it will work. This can be done in the "Restrictions" tab.' . '
	</div>
';
	}
	$__finalCompiled .= '

';
	$__templater->includeJs(array(
		'src' => 'bs/ai_bots/bot_edit.js',
		'min' => '1',
	));
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__templater->isTraversable($__vars['bot']['tabs'])) {
		foreach ($__vars['bot']['tabs'] AS $__vars['tabIndex'] => $__vars['tab']) {
			$__compilerTemp1 .= '
					<a class="tabs-tab" 
					   role="tab" 
					   tabindex="' . ($__vars['tabIndex'] + 1) . '" 
					   aria-controls="' . $__templater->escape($__vars['tab']['id']) . '">
						' . $__templater->escape($__vars['tab']['title']) . '
					</a>
				';
		}
	}
	$__compilerTemp2 = '';
	if ($__templater->method($__vars['bot'], 'isUpdate', array())) {
		$__compilerTemp2 .= '
				' . $__templater->filter($__templater->method($__vars['bot']['Handler'], 'renderTabPanes', array()), array(array('raw', array()),), true) . '
			';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<h2 class="block-tabHeader tabs hScroller js-aibTabs" data-xf-init="tabs h-scroller" role="tablist">
			<span class="hScroller-scroll">
				<a class="tabs-tab is-active" 
				   role="tab" 
				   tabindex="0" 
				   aria-controls="general"
				   data-protected="true">
					' . 'General' . '
				</a>
				' . $__compilerTemp1 . '
			</span>
		</h2>

		<ul class="tabPanes block-body js-aibTabPanes">
			<li class="is-active" role="tabpanel" id="general" data-protected="true">
				' . $__templater->callMacro(null, 'general', array(
		'bot' => $__vars['bot'],
		'userGroups' => $__vars['userGroups'],
		'handlers' => $__vars['handlers'],
	), $__vars) . '
			</li>
			' . $__compilerTemp2 . '
		</ul>
		
		' . $__templater->formSubmitRow(array(
		'sticky' => 'true',
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('ai-bots/save', $__vars['bot'], ), false),
		'class' => 'block',
		'ajax' => 'true',
	)) . '

';
	return $__finalCompiled;
}
);