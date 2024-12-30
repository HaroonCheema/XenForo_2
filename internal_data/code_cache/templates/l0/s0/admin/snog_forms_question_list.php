<?php
// FROM HASH: faaef3e53a120e2e706a7225b81889f1
return array(
'macros' => array('question' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'question' => $__vars['question'],
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	$__compilerTemp1 = array();
	if ($__vars['question']['type'] == 9) {
		$__compilerTemp1[] = array(
			'class' => 'dataList-cell dataList-cell--min',
			'_type' => 'cell',
			'html' => $__templater->escape($__vars['question']['display']),
		);
		$__compilerTemp1[] = array(
			'href' => $__templater->func('link', array('form-questions/edit', $__vars['question'], ), false),
			'label' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . 'Agreement Text',
			'_type' => 'main',
			'html' => '',
		);
		$__compilerTemp1[] = array(
			'class' => 'dataList-cell dataList-cell--min',
			'_type' => 'cell',
			'html' => '',
		);
	} else {
		if ($__vars['question']['type'] == 6) {
			$__compilerTemp1[] = array(
				'class' => 'dataList-cell dataList-cell--min',
				'_type' => 'cell',
				'html' => $__templater->escape($__vars['question']['display']),
			);
		} else {
			$__compilerTemp2 = '';
			if (($__templater->method($__vars['question'], 'canUsedForReportTitle', array()) AND $__vars['question']['error'])) {
				$__compilerTemp2 .= '
						<span style="color:red;font-weight:bold;">' . $__templater->escape($__vars['question']['display']) . '</span>
					';
			} else {
				$__compilerTemp2 .= '
						' . $__templater->escape($__vars['question']['display']) . '
					';
			}
			$__compilerTemp1[] = array(
				'class' => 'dataList-cell dataList-cell--min',
				'_type' => 'cell',
				'html' => '
					' . $__compilerTemp2 . '
				',
			);
		}
		if ($__templater->method($__vars['question'], 'hasUrl', array())) {
			if ($__vars['question']['conditional']) {
				$__compilerTemp1[] = array(
					'href' => $__templater->func('link', array('form-questions/conedit', $__vars['question'], ), false),
					'label' => $__templater->callMacro(null, 'row_label_wrapper', array(
					'question' => $__vars['question'],
					'contents' => $__vars['question']['text'],
				), $__vars),
					'_type' => 'main',
					'html' => '',
				);
				$__compilerTemp1[] = array(
					'class' => 'dataList-cell dataList-cell--min',
					'_type' => 'cell',
					'html' => '
						' . ($__vars['question']['hasconditional'] ? ((('QID' . $__vars['xf']['language']['label_separator'] . ' ') . $__templater->escape($__vars['question']['questionid'])) . ' & ') : '') . '
						<span style="color:green;font-weight:bold;">' . 'Conditional on QID' . ' ' . $__templater->escape($__vars['question']['conditional']) . '</span>
					',
				);
			} else {
				$__compilerTemp1[] = array(
					'href' => $__templater->func('link', array('form-questions/edit', $__vars['question'], ), false),
					'label' => $__templater->callMacro(null, 'row_label_wrapper', array(
					'question' => $__vars['question'],
					'contents' => $__vars['question']['text'],
				), $__vars),
					'_type' => 'main',
					'html' => '',
				);
				$__compilerTemp1[] = array(
					'class' => 'dataList-cell dataList-cell--min',
					'_type' => 'cell',
					'html' => ($__vars['question']['hasconditional'] ? (('QID' . $__vars['xf']['language']['label_separator'] . ' ') . $__templater->escape($__vars['question']['questionid'])) : ''),
				);
			}
		} else {
			if ($__vars['question']['conditional']) {
				$__compilerTemp1[] = array(
					'href' => $__templater->func('link', array('form-questions/conedit', $__vars['question'], ), false),
					'label' => $__templater->callMacro(null, 'row_label_wrapper', array(
					'question' => $__vars['question'],
					'contents' => $__templater->filter($__templater->func('bb_code', array($__vars['question']['text'], '', '', ), false), array(array('raw', array()),), false),
					'raw' => true,
				), $__vars),
					'_type' => 'main',
					'html' => '',
				);
				$__compilerTemp1[] = array(
					'class' => 'dataList-cell dataList-cell--min',
					'_type' => 'cell',
					'html' => '
						' . ($__vars['question']['hasconditional'] ? ((('QID' . $__vars['xf']['language']['label_separator'] . ' ') . $__templater->escape($__vars['question']['questionid'])) . ' & ') : '') . '
						<span style="color:green;font-weight:bold;">
							' . 'Conditional on QID' . ' ' . $__templater->escape($__vars['question']['conditional']) . '
						</span>
					',
				);
			} else {
				$__compilerTemp1[] = array(
					'href' => $__templater->func('link', array('form-questions/edit', $__vars['question'], ), false),
					'label' => '
							' . $__templater->callMacro(null, 'row_label_wrapper', array(
					'question' => $__vars['question'],
					'contents' => $__templater->filter($__templater->func('bb_code', array($__vars['question']['text'], '', '', ), false), array(array('raw', array()),), false),
					'raw' => true,
				), $__vars) . '
						',
					'_type' => 'main',
					'html' => '',
				);
				$__compilerTemp1[] = array(
					'class' => 'dataList-cell dataList-cell--min',
					'_type' => 'cell',
					'html' => ($__vars['question']['hasconditional'] ? (('QID' . $__vars['xf']['language']['label_separator'] . ' ') . $__templater->escape($__vars['question']['questionid'])) : ''),
				);
			}
		}
	}
	$__compilerTemp1[] = array(
		'href' => $__templater->func('link', array('form-questions/delete', $__vars['question'], ), false),
		'_type' => 'delete',
		'html' => '',
	);
	$__finalCompiled .= $__templater->dataRow(array(
		'class' => 'dataList-row',
	), $__compilerTemp1) . '

';
	return $__finalCompiled;
}
),
'row_label_wrapper' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'question' => '!',
		'contents' => '!',
		'raw' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if ($__vars['question']['type'] == 6) {
		$__finalCompiled .= '
		<div style=\'width=100%;text-align:center;\'>';
		if ($__vars['raw']) {
			$__finalCompiled .= '
			' . $__templater->filter($__vars['contents'], array(array('raw', array()),), true) . '
		';
		} else {
			$__finalCompiled .= '
			' . $__templater->escape($__vars['contents']) . '
		';
		}
		$__finalCompiled .= '</div>
	';
	} else {
		$__finalCompiled .= '
		';
		if ($__vars['raw']) {
			$__finalCompiled .= '
			' . $__templater->filter($__vars['contents'], array(array('raw', array()),), true) . '
		';
		} else {
			$__finalCompiled .= '
			' . $__templater->escape($__vars['contents']) . '
		';
		}
		$__finalCompiled .= '
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped(($__vars['form']['posid'] ? $__templater->escape($__vars['form']['position']) : 'Default') . ' ' . 'Questions');
	$__finalCompiled .= '

';
	$__templater->setPageParam('section', ($__vars['form']['posid'] ? 'snogForms' : 'snogQuestions'));
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__vars['conditionalPermitted']) {
		$__compilerTemp1 .= '
			' . $__templater->button('Add conditional question', array(
			'href' => $__templater->func('link', array('form-editquestions/addcon', $__vars['form'], ), false),
			'icon' => 'add',
		), '', array(
		)) . '
		';
	}
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	<div class="buttonGroup">
		' . $__templater->button('Add new question', array(
		'href' => $__templater->func('link', array('form-editquestions/add', $__vars['form'], ), false),
		'icon' => 'add',
	), '', array(
	)) . '
		' . $__compilerTemp1 . '
		' . $__templater->button('Order', array(
		'href' => $__templater->func('link', array('form-editquestions/sort', $__vars['form'], ), false),
		'icon' => 'sort',
		'overlay' => 'true',
	), '', array(
	)) . '
	</div>
	
	' . $__templater->button('Edit Form', array(
		'href' => $__templater->func('link', array('form-forms/edit', $__vars['form'], ), false),
		'icon' => 'edit',
	), '', array(
	)) . '
');
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['questions'], 'empty', array())) {
		$__finalCompiled .= '
	<div class="block-container">
		<div class="block-body">
			';
		$__compilerTemp2 = '';
		$__compilerTemp3 = $__templater->method($__vars['questions'], 'getFlattened', array(0, ));
		if ($__templater->isTraversable($__compilerTemp3)) {
			foreach ($__compilerTemp3 AS $__vars['question']) {
				$__compilerTemp2 .= '
					' . $__templater->callMacro(null, 'question', array(
					'question' => $__vars['question']['record'],
				), $__vars) . '
				';
			}
		}
		$__finalCompiled .= $__templater->dataList('
				' . $__compilerTemp2 . '
			', array(
			'class' => 'dataList',
		)) . '
		</div>
	</div>
';
	} else {
		$__finalCompiled .= '
	<div class="blockMessage">' . 'There is nothing to display.' . '</div>
';
	}
	$__finalCompiled .= '

' . 'Question numbers in <span style="color:red;font-weight:bold;">RED</span> may be used in report title creation.<br />Conditional questions ALWAYS appear immediately after the question that triggers them no matter where they are in the sort order shown here.<br /><span style="color:blue;font-weight:bold;">NOTE: </span>If using a question in the report title, you MUST arrange the questions so any conditional questions appear immediately after the question that triggers the conditional question. This ensures the question/answer numbering is correct.' . '
';
	if ($__vars['form']['posid']) {
		$__finalCompiled .= '
	<div class="p-title" style="margin-top:15px;">
		<div class="p-title-pageAction">
			<div class="buttonGroup">
				' . $__templater->button('Insert Default Questions', array(
			'href' => $__templater->func('link', array('form-editquestions/adddefault', $__vars['form'], ), false),
			'icon' => 'add',
		), '', array(
		)) . '
			</div>
		</div>
	</div>
';
	}
	$__finalCompiled .= '

' . '

';
	return $__finalCompiled;
}
);