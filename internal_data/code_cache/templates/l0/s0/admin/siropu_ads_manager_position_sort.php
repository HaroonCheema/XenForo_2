<?php
// FROM HASH: 8a2e924a9f7ff266ca4ed5a6c9bf638b
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Sort positions');
	$__finalCompiled .= '

' . $__templater->callMacro('public:nestable_macros', 'setup', array(), $__vars) . '

';
	$__compilerTemp1 = '';
	if ($__templater->isTraversable($__vars['positionData']['positionCategories'])) {
		foreach ($__vars['positionData']['positionCategories'] AS $__vars['positionCategoryId'] => $__vars['positionCategory']) {
			$__compilerTemp1 .= '
			';
			if (($__vars['positionCategoryId'] > 0)) {
				$__compilerTemp1 .= '
				<h4 class="block-minorHeader">' . $__templater->escape($__vars['positionCategory']['title']) . '</h4>
			';
			} else {
				$__compilerTemp1 .= '
				<h4 class="block-minorHeader">' . 'Uncategorized positions' . '</h4>
			';
			}
			$__compilerTemp1 .= '
			<div class="block-body">
				<div class="nestable-container" data-xf-init="nestable" data-parent-id="' . $__templater->escape($__vars['positionCategoryId']) . '" data-max-depth="1" data-value-target=".js-positionData">
					';
			$__compilerTemp2 = '';
			$__compilerTemp2 .= '
							';
			$__vars['i'] = 0;
			if ($__templater->isTraversable($__vars['positionData']['positions'][$__vars['positionCategoryId']])) {
				foreach ($__vars['positionData']['positions'][$__vars['positionCategoryId']] AS $__vars['positionId'] => $__vars['position']) {
					$__vars['i']++;
					$__compilerTemp2 .= '
								<li class="nestable-item" data-id="' . $__templater->escape($__vars['positionId']) . '">
									<div class="nestable-handle nestable-handle--full" aria-label="' . 'Drag handle' . '"><i class="fa fa-bars" aria-hidden="true"></i></div>
									<div class="nestable-content">' . $__templater->escape($__vars['position']['title']) . '</div>
								</li>
							';
				}
			}
			$__compilerTemp2 .= '
							';
			if (strlen(trim($__compilerTemp2)) > 0) {
				$__compilerTemp1 .= '
						<ol class="nestable-list">
							' . $__compilerTemp2 . '
						</ol>
					';
			}
			$__compilerTemp1 .= '
					' . $__templater->formHiddenVal('positions[]', '', array(
				'class' => 'js-positionData',
			)) . '
				</div>
			</div>
		';
		}
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		' . $__compilerTemp1 . '
		' . $__templater->formSubmitRow(array(
		'icon' => 'save',
	), array(
		'rowtype' => 'simple',
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('ads-manager/positions/sort', ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);