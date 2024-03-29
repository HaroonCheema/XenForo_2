<?php
// FROM HASH: 43b44fe909c837669437567d07921809
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Rate this Item');
	$__finalCompiled .= '

';
	$__templater->breadcrumbs($__templater->method($__vars['item'], 'getBreadcrumbs', array()));
	$__finalCompiled .= '

';
	$__templater->includeJs(array(
		'src' => 'xf/thread.js',
		'min' => '1',
	));
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__vars['existingRating']) {
		$__compilerTemp1 .= '
				' . $__templater->formInfoRow('
					' . 'You have already rated this Item. Re-rating it will remove your existing rating or review.' . '
				', array(
			'rowtype' => 'confirm',
		)) . '
			';
	}
	$__compilerTemp2 = '';
	if ($__vars['xf']['options']['bh_ReviewRequired']) {
		$__compilerTemp2 .= '
						' . 'Review is required' . '
					';
	}
	$__compilerTemp3 = '';
	if ($__vars['xf']['options']['bh_MinimumReviewLength']) {
		$__compilerTemp3 .= '
						<span id="js-resourceReviewLength">' . 'Your review must be at least ' . $__templater->escape($__vars['xf']['options']['bh_MinimumReviewLength']) . ' characters.' . '</span>
					';
	}
	$__finalCompiled .= $__templater->form('
	
	<div class="block-container">
		<div class="block-body">
			' . $__compilerTemp1 . '
			
			' . $__templater->callMacro('rating_macros', 'rating', array(
		'currentRating' => $__vars['existingRating']['rating'],
	), $__vars) . '
			
		
				' . $__templater->formEditorRow(array(
		'name' => 'message',
		'value' => $__vars['existingRating']['message'],
		'data-min-height' => '100',
		'data-xf-init' => 'min-length',
		'data-min-length' => $__vars['xf']['options']['bh_MinimumReviewLength'],
		'data-allow-empty' => ($__vars['xf']['options']['bh_ReviewRequired'] ? 'false' : 'true'),
		'data-toggle-target' => '#js-resourceReviewLength',
		'maxlength' => $__vars['xf']['options']['messageMaxLength'],
	), array(
		'label' => 'Review',
		'hint' => ($__vars['xf']['options']['bh_ReviewRequired'] ? 'Required' : ''),
		'explain' => '
					' . 'Explain why you\'re giving this rating. Reviews which are not constructive may be removed without notice.' . '
					' . $__compilerTemp2 . '
					' . $__compilerTemp3 . '
				',
	)) . '
			
			' . $__templater->formRow('
				' . $__templater->callMacro('helper_attach_upload', 'upload_block', array(
		'attachmentData' => $__vars['attachmentData'],
	), $__vars) . '
			', array(
	)) . '

		</div>
		' . $__templater->formSubmitRow(array(
		'submit' => 'Submit rating',
		'icon' => 'rate',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('bh-item/rate', $__vars['item'], ), false),
		'class' => 'block',
		'ajax' => 'true',
		'data-xf-init' => 'attachment-manager thread-edit-form',
		'data-item-selector' => '.js-itemReview-' . $__vars['item']['item_id'] . ($__vars['existingRating'] ? ('-' . $__vars['existingRating']->{'item_rating_id'}) : ('-' . $__vars['xf']['visitor']['user_id'])),
	));
	return $__finalCompiled;
}
);