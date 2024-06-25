<?php
// FROM HASH: 488d1a1dec522a699d22acec0fb75cdc
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Communications');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('
		' . 'Add communication' . '
	', array(
		'href' => $__templater->func('link', array('thmonetize-communications/add', ), false),
		'icon' => 'add',
	), '', array(
	)) . '
');
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['communications'], 'empty', array())) {
		$__finalCompiled .= '
	';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['communications'])) {
			foreach ($__vars['communications'] AS $__vars['communication']) {
				$__compilerTemp1 .= '
						';
				$__compilerTemp2 = '';
				if ($__vars['communication']['active']) {
					$__compilerTemp2 .= '
									' . (('Next send' . ': ') . $__templater->func('date_time', array($__vars['communication']['next_send'], ), true)) . '
								';
				}
				$__compilerTemp1 .= $__templater->dataRow(array(
					'label' => $__templater->escape($__vars['communication']['title']),
					'hint' => $__templater->escape($__vars['communication']['type_phrase']),
					'href' => $__templater->func('link', array('thmonetize-communications/edit', $__vars['communication'], ), false),
					'delete' => $__templater->func('link', array('thmonetize-communications/delete', $__vars['communication'], ), false),
					'explain' => '
								' . $__compilerTemp2 . '
							',
				), array(array(
					'name' => 'active[' . $__vars['communication']['communication_id'] . ']',
					'selected' => $__vars['communication']['active'],
					'class' => 'dataList-cell--separated',
					'submit' => 'true',
					'tooltip' => 'Enable / disable \'' . $__vars['communication']['title'] . '\'',
					'_type' => 'toggle',
					'html' => '',
				),
				array(
					'href' => $__templater->func('link', array('thmonetize-communications/send', $__vars['communication'], ), false),
					'overlay' => 'true',
					'data-xf-init' => 'tooltip',
					'title' => 'Send now',
					'class' => 'dataList-cell--iconic',
					'_type' => 'action',
					'html' => '
								' . $__templater->fontAwesome('fa-envelope', array(
				)) . '
							',
				))) . '
					';
			}
		}
		$__finalCompiled .= $__templater->form('
		<div class="block-outer">
			' . $__templater->callMacro('filter_macros', 'quick_filter', array(
			'key' => 'thmonetize-communications',
			'class' => 'block-outer-opposite',
		), $__vars) . '
		</div>
		<div class="block-container">
			<div class="block-body">
				' . $__templater->dataList('
					' . $__compilerTemp1 . '
				', array(
		)) . '
				<div class="block-footer">
					<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['total'], ), true) . '</span>
				</div>
			</div>
		</div>
	', array(
			'action' => $__templater->func('link', array('thmonetize-communications/toggle', ), false),
			'class' => 'block',
			'ajax' => 'true',
		)) . '
';
	} else {
		$__finalCompiled .= '
	<div class="blockMessage">' . 'No items have been created yet.' . '</div>
';
	}
	return $__finalCompiled;
}
);