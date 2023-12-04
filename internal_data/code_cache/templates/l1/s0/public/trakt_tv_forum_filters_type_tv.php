<?php
// FROM HASH: 9f50cb72610e5049fd8401d48a0e4bf2
return array(
'extends' => function($__templater, array $__vars) { return 'forum_filters'; },
'extensions' => array('before_date_limit' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
	<div class="menu-row menu-row--separated">
		' . 'Genre' . $__vars['xf']['language']['label_separator'] . '
		<div class="u-inputSpacer">
			' . $__templater->formTextBox(array(
		'name' => 'genre',
		'value' => ($__vars['filters']['genre'] ? $__vars['filters']['genre'] : ''),
		'maxlength' => '50',
	)) . '
		</div>
	</div>

	<div class="menu-row menu-row--separated">
		' . 'Director' . $__vars['xf']['language']['label_separator'] . '
		<div class="u-inputSpacer">
			' . $__templater->formTextBox(array(
		'name' => 'director',
		'value' => ($__vars['filters']['director'] ? $__vars['filters']['director'] : ''),
		'maxlength' => '50',
	)) . '
		</div>
	</div>

	<div class="menu-row menu-row--separated">
		' . 'Cast' . $__vars['xf']['language']['label_separator'] . '
		<div class="u-inputSpacer">
			' . $__templater->formTextBox(array(
		'name' => 'cast',
		'value' => ($__vars['filters']['cast'] ? $__vars['filters']['cast'] : ''),
		'maxlength' => '50',
	)) . '
		</div>
	</div>

	<div class="menu-row menu-row--separated">
		' . 'trakt_tv_title:' . '
		<div class="u-inputSpacer">
			' . $__templater->formTextBox(array(
		'name' => 'tv_title',
		'value' => ($__vars['filters']['tv_title'] ? $__vars['filters']['tv_title'] : ''),
		'maxlength' => '50',
	)) . '
		</div>
	</div>

	<div class="menu-row menu-row--separated">
		' . 'Show status' . $__vars['xf']['language']['label_separator'] . '
		<div class="u-inputSpacer">
			' . $__templater->formSelect(array(
		'name' => 'tv_status',
	), array(array(
		'value' => '',
		'label' => 'Any',
		'_type' => 'option',
	),
	array(
		'value' => 'Returning Series',
		'label' => 'trakt_tv_status_returning_series',
		'_type' => 'option',
	),
	array(
		'value' => 'Ended',
		'label' => 'trakt_tv_status_ended',
		'_type' => 'option',
	),
	array(
		'value' => 'Canceled',
		'label' => 'trakt_tv_status_cancelled',
		'_type' => 'option',
	))) . '
		</div>
	</div>
';
	return $__finalCompiled;
}),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

' . $__templater->renderExtension('before_date_limit', $__vars, $__extensions);
	return $__finalCompiled;
}
);