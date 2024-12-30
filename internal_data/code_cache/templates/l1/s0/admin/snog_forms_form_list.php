<?php
// FROM HASH: 8cb8dcb21abe3c75ac6eeb341c4dcbac
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Forms');
	$__finalCompiled .= '

';
	$__templater->setPageParam('section', 'snogForms');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	<div class="buttonGroup">
		' . $__templater->button('Add New Form', array(
		'href' => $__templater->func('link', array('form-forms/add', ), false),
		'icon' => 'add',
	), '', array(
	)) . '
		' . $__templater->button('Order', array(
		'href' => $__templater->func('link', array('form-forms/sort', ), false),
		'icon' => 'sort',
		'overlay' => 'true',
	), '', array(
	)) . '
	</div>
');
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['forms'], 'empty', array())) {
		$__finalCompiled .= '
	<div class="block-container">
		<div class="block-body">
			';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['forms'])) {
			foreach ($__vars['forms'] AS $__vars['form']) {
				$__compilerTemp1 .= '
					';
				$__compilerTemp2 = '';
				if ($__vars['form']['formlimit']) {
					$__compilerTemp2 .= '
								' . $__templater->button('Reset', array(
						'href' => $__templater->func('link', array('form-forms/reset', $__vars['form'], ), false),
						'icon' => 'refresh',
						'overlay' => 'true',
					), '', array(
					)) . '
								' . $__templater->button('Reset' . ' 1', array(
						'href' => $__templater->func('link', array('form-forms/resetone', $__vars['form'], ), false),
						'icon' => 'refresh',
						'overlay' => 'true',
					), '', array(
					)) . '
							';
				}
				$__compilerTemp1 .= $__templater->dataRow(array(
				), array(array(
					'href' => $__templater->func('link', array('form-forms/edit', $__vars['form'], ), false),
					'label' => $__templater->escape($__vars['form']['position']),
					'explain' => $__templater->func('link_type', array('public', 'canonical:form/select', $__vars['form'], ), true),
					'hint' => 'Submit count' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->filter($__vars['form']['submit_count'], array(array('number', array()),), true),
					'_type' => 'main',
					'html' => '',
				),
				array(
					'class' => 'dataList-cell--min',
					'_type' => 'cell',
					'html' => '
							' . $__compilerTemp2 . '
						',
				),
				array(
					'class' => 'dataList-cell--min',
					'_type' => 'cell',
					'html' => '
							' . $__templater->button('Questions', array(
					'href' => $__templater->func('link', array('form-editquestions/formquestions', $__vars['form'], ), false),
					'fa' => 'fa-question-circle',
				), '', array(
				)) . '
							' . $__templater->button('Copy', array(
					'href' => $__templater->func('link', array('form-forms/copy', $__vars['form'], ), false),
					'fa' => 'fa-copy',
				), '', array(
				)) . '
						',
				),
				array(
					'href' => $__templater->func('link', array('form-forms/delete', $__vars['form'], ), false),
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