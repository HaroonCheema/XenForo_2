<?php
// FROM HASH: aa99457c1839a753b3eb534494db8eca
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped($__templater->escape($__vars['tvshow']['tv_title']));
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
			<div class="block-body">
				' . $__templater->callMacro('rating_macros', 'rating', array(
		'row' => true,
		'name' => 'rating',
		'currentRating' => $__vars['userRating']['rating'],
		'rowLabel' => 'Rating',
		'rowHint' => '',
		'rowExplain' => 'trakt_tv_already_rated',
	), $__vars) . '
		</div>

		<div class="formRow formSubmitRow">
			<div class="formSubmitRow-main">
				<div class="formSubmitRow-bar"></div>
				<div class="formSubmitRow-controls" style="padding: 5px 0 5px 0; !important;">
					<div style="text-align:center;margin-left:auto;margin-right:auto;">
						' . $__templater->button('Submit rating', array(
		'type' => 'submit',
		'accesskey' => 's',
		'class' => 'button button--icon button--icon--save',
	), '', array(
	)) . '
					</div>
				</div>
			</div>
		</div>
	</div>
', array(
		'action' => $__templater->func('link', array('tv/rate', $__vars['tvshow'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);