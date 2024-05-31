<?php
// FROM HASH: f17c26471f0fb348709b53984fb8651e
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Rating');
	$__finalCompiled .= '

';
	$__compilerTemp1 = array(array(
		'value' => '0',
		'label' => 'None',
		'_type' => 'option',
	));
	if ($__templater->isTraversable($__vars['games'])) {
		foreach ($__vars['games'] AS $__vars['key'] => $__vars['game']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['game']['game_id'],
				'label' => $__templater->escape($__vars['game']['title']),
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">

			' . $__templater->formSelectRow(array(
		'name' => 'game_id',
		'required' => 'required',
	), $__compilerTemp1, array(
		'label' => 'Select Game',
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
		'action' => $__templater->func('link', array('game-rating/add', ), false),
		'class' => 'block',
		'ajax' => 'true',
		'novalidate' => 'false',
	));
	return $__finalCompiled;
}
);