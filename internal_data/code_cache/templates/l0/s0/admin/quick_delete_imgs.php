<?php
// FROM HASH: 9897b637e1fb77112c3ba6a9c91a46e0
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Confirm action');
	$__finalCompiled .= '

' . $__templater->form('

	<div class="block-container">
		
				<div class="block-body">
					' . $__templater->formInfoRow('
							' . 'Are you sure to want delete this items (' . $__templater->func('count', array($__vars['images'], ), true) . ')' . '
					', array(
		'rowtype' => 'confirm',
	)) . '
				</div>
		        
		       <input type="hidden" value="' . $__templater->escape($__vars['img_ids']) . '" name="avatar_ids">

		' . $__templater->formSubmitRow(array(
		'icon' => 'delete',
	), array(
		'rowtype' => 'simple',
	)) . '
	</div>

', array(
		'action' => $__templater->func('link', array('ag/quick-delete', ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);