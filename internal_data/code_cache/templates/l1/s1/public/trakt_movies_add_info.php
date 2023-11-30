<?php
// FROM HASH: 7a72f71a11ee63facd4087115a49937b
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('trakt_movies_add_info');
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formTextBoxRow(array(
		'name' => 'trakt',
		'value' => '',
	), array(
		'label' => 'trakt_movies_link_id',
	)) . '
			
			' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'changetitle',
		'value' => '1',
		'selected' => $__vars['group']['postview'],
		'label' => 'trakt_movies_change_title',
		'_type' => 'option',
	)), array(
	)) . '
		</div>
		
		<div class="formRow formSubmitRow">
			<div class="formSubmitRow-main">
				<div class="formSubmitRow-bar"></div>
				<div class="formSubmitRow-controls" style="padding: 5px 0 5px 0; !important;">
					<div style="text-align:center;margin-left:auto;margin-right:auto;">
						' . $__templater->button('trakt_movies_add_info', array(
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
		'action' => $__templater->func('link', array('movies/addinfo', $__vars['thread'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);