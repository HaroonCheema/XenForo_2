<?php
// FROM HASH: 138cc79beb9d2cff64ff72a13c674189
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Ratting');
	$__finalCompiled .= '

';
	$__compilerTemp1 = array(array(
		'value' => '0',
		'label' => 'None',
		'_type' => 'option',
	));
	if ($__templater->isTraversable($__vars['userUpgrades'])) {
		foreach ($__vars['userUpgrades'] AS $__vars['key'] => $__vars['upgrade']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['upgrade']['user_upgrade_id'],
				'selected' => ($__vars['upgradeUserGroup']['current_userGroup'] == $__vars['key']),
				'label' => $__templater->escape($__vars['upgrade']['title']),
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">

			' . $__templater->formSelectRow(array(
		'name' => 'userUpId',
		'required' => 'required',
	), $__compilerTemp1, array(
		'label' => 'Select Package',
		'hint' => 'Required',
	)) . '

			' . $__templater->callMacro('rating_macros', 'rating', array(), $__vars) . '

			' . $__templater->formTextAreaRow(array(
		'name' => 'message',
		'rows' => '2',
		'autosize' => 'true',
		'data-xf-init' => 'min-length',
		'data-allow-empty' => 'false',
		'data-toggle-target' => '#js-resourceReviewLength',
	), array(
		'label' => 'Review',
		'explain' => '
					' . 'Explain why you\'re giving this rating.' . '
				',
		'hint' => 'Required',
	)) . '

			' . $__templater->formUploadRow(array(
		'name' => 'image',
		'accept' => '.gif,.jpeg,.jpg,.jpe,.png',
		'data-required' => 'true',
	), array(
		'label' => 'Upload Image',
		'hint' => 'Required',
		'explain' => 'Upload any image...!',
	)) . '

		</div>
		' . $__templater->formSubmitRow(array(
		'submit' => 'Submit rating',
		'icon' => 'rate',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('package-rating/add', ), false),
		'class' => 'block',
		'ajax' => 'true',
		'novalidate' => 'false',
	));
	return $__finalCompiled;
}
);