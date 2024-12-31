<?php
// FROM HASH: dc9f96f9a92b52fc2b0ad8a0f430f323
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Sort badges');
	$__finalCompiled .= '

' . $__templater->callMacro('public:nestable_macros', 'setup', array(), $__vars) . '

';
	$__compilerTemp1 = '';
	if ($__templater->isTraversable($__vars['badgeData']['badgeCategories'])) {
		foreach ($__vars['badgeData']['badgeCategories'] AS $__vars['catId'] => $__vars['category']) {
			$__compilerTemp1 .= '
			';
			if (($__vars['catId'] > 0)) {
				$__compilerTemp1 .= '
				<h4 class="block-minorHeader">' . $__templater->escape($__vars['category']['title']) . '</h4>
			';
			} else {
				$__compilerTemp1 .= '
				<h4 class="block-minorHeader">' . 'Uncategorized' . '</h4>
			';
			}
			$__compilerTemp1 .= '
			<div class="block-body">
				<div class="nestable-container" data-xf-init="nestable" data-parent-id="' . $__templater->escape($__vars['catId']) . '" data-max-depth="1" data-value-target=".js-badgeData">
					';
			$__compilerTemp2 = '';
			$__compilerTemp2 .= '
							';
			$__vars['i'] = 0;
			if ($__templater->isTraversable($__vars['badgeData']['badges'][$__vars['catId']])) {
				foreach ($__vars['badgeData']['badges'][$__vars['catId']] AS $__vars['badgeId'] => $__vars['badge']) {
					$__vars['i']++;
					$__compilerTemp2 .= '
								<li class="nestable-item" data-id="' . $__templater->escape($__vars['badgeId']) . '">
									<div class="nestable-handle nestable-handle--full" aria-label="' . $__templater->filter('Drag handle', array(array('for_attr', array()),), true) . '">' . $__templater->fontAwesome('fa-bars', array(
					)) . '</div>
									<div class="nestable-content">' . $__templater->escape($__vars['badge']['title']) . '</div>
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
					' . $__templater->formHiddenVal('badges[]', '', array(
				'class' => 'js-badgeData',
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
		'action' => $__templater->func('link', array('ozzmodz-badges/sort', ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);