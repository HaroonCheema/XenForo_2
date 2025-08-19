<?php
// FROM HASH: 622c6a4853ff6046727713fe209f754a
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
				' . 'Please confirm that you want to delete the following' . $__vars['xf']['language']['label_separator'] . '
				<strong><a href="' . $__templater->func('link', array('ads-manager/position-categories/edit', $__vars['positionCategory'], ), true) . '">' . $__templater->escape($__vars['positionCategory']['title']) . '</a></strong>
				<div class="blockMessage blockMessage--important blockMessage--iconic">
					' . 'Any positions belonging to this category will be uncategorized following the deletion.' . '
				</div>
			', array(
		'rowtype' => 'confirm',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'delete',
	), array(
		'rowtype' => 'simple',
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('ads-manager/position-categories/delete', $__vars['positionCategory'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);