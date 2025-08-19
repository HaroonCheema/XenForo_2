<?php
// FROM HASH: d7c3c61b5a9885c8a054775588c5a0c0
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Change ad owner');
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['errors'], 'empty', array())) {
		$__finalCompiled .= '
	';
		if ($__templater->isTraversable($__vars['errors'])) {
			foreach ($__vars['errors'] AS $__vars['error']) {
				$__finalCompiled .= '
		<div class="blockMessage blockMessage--important blockMessage--iconic">' . $__templater->escape($__vars['error']) . '</div>
	';
			}
		}
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['success'], 'empty', array())) {
		$__finalCompiled .= '
	<div class="blockMessage blockMessage--success blockMessage--iconic">
		' . 'Ad ownership successfully changed.' . '
	</div>
	 ' . $__templater->button('<i class="fa fa-arrow-left" aria-hidden="true"></i> ' . 'Go back', array(
			'href' => $__templater->func('link', array('ads-manager/tools/change-ad-owner', ), false),
		), '', array(
		)) . '
';
	} else if (!$__templater->test($__vars['users'], 'empty', array())) {
		$__finalCompiled .= '
	';
		$__compilerTemp1 = $__templater->mergeChoiceOptions(array(), $__vars['users']);
		$__compilerTemp2 = '';
		if ($__vars['ads']) {
			$__compilerTemp2 .= '
					';
			$__compilerTemp3 = $__templater->mergeChoiceOptions(array(), $__vars['ads']);
			$__compilerTemp2 .= $__templater->formSelectRow(array(
				'name' => 'ad_id[]',
				'value' => $__vars['input']['ad_id'],
				'multiple' => 'true',
			), $__compilerTemp3, array(
				'label' => 'Select ads',
			)) . '

					' . $__templater->formTextBoxRow(array(
				'name' => 'username',
				'value' => $__vars['input']['username'],
				'data-xf-init' => 'auto-complete',
				'data-single' => 'true',
			), array(
				'label' => 'New owner',
			)) . '

					<hr class="formRowSep" />

					' . $__templater->formCheckBoxRow(array(
			), array(array(
				'name' => 'invoices',
				'value' => '1',
				'selected' => $__vars['input']['invoices'],
				'label' => 'Include invoices',
				'_type' => 'option',
			),
			array(
				'name' => 'add_to_group',
				'value' => '1',
				'selected' => $__vars['input']['add_to_group'],
				'label' => 'Add new owner to advertiser user groups',
				'_type' => 'option',
			)), array(
			)) . '

					' . $__templater->formHiddenVal('complete', '1', array(
			)) . '
				';
		}
		$__compilerTemp4 = '';
		if ($__vars['input']['user_id']) {
			$__compilerTemp4 .= '
				' . $__templater->formSubmitRow(array(
				'icon' => 'save',
				'submit' => 'Change',
			), array(
			)) . '
			';
		} else {
			$__compilerTemp4 .= '
				' . $__templater->formSubmitRow(array(
				'icon' => 'next',
				'submit' => 'Next',
			), array(
			)) . '
			';
		}
		$__finalCompiled .= $__templater->form('
		<div class="block-container">
			<div class="block-body">
				' . $__templater->formSelectRow(array(
			'name' => 'user_id',
			'value' => $__vars['input']['user_id'],
		), $__compilerTemp1, array(
			'label' => 'Select current owner',
		)) . '

				' . $__compilerTemp2 . '
			</div>
			' . $__compilerTemp4 . '
		</div>
	', array(
			'action' => $__templater->func('link', array('ads-manager/tools/change-ad-owner', ), false),
			'class' => 'block',
		)) . '
';
	} else {
		$__finalCompiled .= '
	<div class="blockMessage">' . 'There are no advertisers.' . '</div>
';
	}
	return $__finalCompiled;
}
);