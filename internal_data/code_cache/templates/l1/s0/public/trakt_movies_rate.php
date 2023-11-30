<?php
// FROM HASH: e7e888ea90936cad0f6f8cf60075b927
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped($__templater->escape($__vars['movie']['trakt_title']));
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
		'rowExplain' => 'trakt_movies_already_rated',
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
		'action' => $__templater->func('link', array('movies/rate', $__vars['movie'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);