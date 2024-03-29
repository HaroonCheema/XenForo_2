<?php
// FROM HASH: 4076eaa234db4558e5ac09cfebef206b
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Confirm action');
	$__finalCompiled .= '

';
	$__compilerTemp1 = array();
	if ($__templater->isTraversable($__vars['discussions'])) {
		foreach ($__vars['discussions'] AS $__vars['threadId'] => $__vars['thread']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['threadId'],
				'checked' => 'checked',
				'label' => '<span class="">' . $__templater->escape($__vars['thread']['title']) . '</span>',
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->form('

	<div class="block-container">
		<div class="block-body">
			' . $__templater->formInfoRow('
					' . 'Please confirm that you want to Remove (unlink) the following selected discussions from <strong> ' . $__templater->escape($__vars['item']['item_title']) . ' </strong>' . '
			', array(
		'rowtype' => 'confirm',
	)) . '
		</div>
		
			' . $__templater->formCheckBoxRow(array(
		'name' => 'thread_ids',
		'listclass' => 'inputChoices--inline',
	), $__compilerTemp1, array(
		'label' => 'These discussions will be Removed',
		'explain' => 'you can deselect from these if you don\'t want to Remove them',
	)) . '


		' . $__templater->formSubmitRow(array(
		'icon' => 'remove',
	), array(
		'rowtype' => 'simple',
	)) . '
	</div>

', array(
		'action' => $__templater->func('link', array('bh-item/quick-delete', $__vars['item'], ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);