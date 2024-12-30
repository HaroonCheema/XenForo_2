<?php
// FROM HASH: e416a9b3f476b3988bd4517deca6e6ea
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Types');
	$__finalCompiled .= '

';
	$__templater->setPageParam('section', 'snogTypes');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	<div class="buttonGroup">
		' . $__templater->button('Add Form Type', array(
		'href' => $__templater->func('link', array('form-types/add', ), false),
		'icon' => 'add',
	), '', array(
	)) . '
		' . $__templater->button('Order', array(
		'href' => $__templater->func('link', array('form-types/sort', ), false),
		'icon' => 'sort',
		'overlay' => 'true',
	), '', array(
	)) . '
	</div>
');
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['types'], 'empty', array())) {
		$__finalCompiled .= '
	<div class="block-container">
		<div class="block-body">
			';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['types'])) {
			foreach ($__vars['types'] AS $__vars['type']) {
				$__compilerTemp1 .= '
					' . $__templater->dataRow(array(
				), array(array(
					'href' => $__templater->func('link', array('form-types/edit', $__vars['type'], ), false),
					'label' => $__templater->escape($__vars['type']['type']),
					'_type' => 'main',
					'html' => '',
				),
				array(
					'class' => 'dataList-cell--min',
					'_type' => 'cell',
					'html' => '
							' . $__templater->button('<i class="fa fa-files-o" aria-hidden="true"> ' . 'Copy' . '</i>', array(
					'href' => $__templater->func('link', array('form-types/copy', $__vars['type'], ), false),
				), '', array(
				)) . '
						',
				),
				array(
					'href' => $__templater->func('link', array('form-types/delete', $__vars['type'], ), false),
					'_type' => 'delete',
					'html' => '',
				))) . '
				';
			}
		}
		$__finalCompiled .= $__templater->dataList('
				' . $__compilerTemp1 . '
			', array(
		)) . '
		</div>
	</div>
';
	} else {
		$__finalCompiled .= '
	<div class="blockMessage">' . 'There is nothing to display.' . '</div>
';
	}
	return $__finalCompiled;
}
);