<?php
// FROM HASH: e699476abba0b468f59049afdf2d2571
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Sales invoice statistics');
	$__finalCompiled .= '

<div class="block">
	<div class="block-container">
		<div class="block-body">
			';
	if ($__templater->func('count', array($__vars['currencies'], ), false) > 1) {
		$__finalCompiled .= '
				<h2 class="block-tabHeader tabs hScroller" data-xf-init="h-scroller">
				<span class="hScroller-scroll">
					';
		if ($__templater->isTraversable($__vars['currencies'])) {
			foreach ($__vars['currencies'] AS $__vars['curr']) {
				$__finalCompiled .= '
						<a href="' . $__templater->func('link', array('ads-manager/invoices/statistics', '', array('currency' => $__vars['curr']['currency'], ), ), true) . '" class="tabs-tab' . (($__vars['curr']['currency'] == $__vars['currency']) ? ' is-active' : '') . '">' . $__templater->escape($__vars['curr']['currency']) . '</a>
					';
			}
		}
		$__finalCompiled .= '
				</span>
			</h2>
			';
	}
	$__finalCompiled .= '
			';
	if ($__templater->isTraversable($__vars['statistics'])) {
		foreach ($__vars['statistics'] AS $__vars['key'] => $__vars['total']) {
			$__finalCompiled .= '
				';
			$__compilerTemp1 = '';
			if ($__vars['key'] == 'today') {
				$__compilerTemp1 .= '
						' . 'Today' . '
					';
			} else if ($__vars['key'] == 'yesterday') {
				$__compilerTemp1 .= '
						' . 'Yesterday' . '
					';
			} else if ($__vars['key'] == 'this_week') {
				$__compilerTemp1 .= '
						' . 'This week' . '
					';
			} else if ($__vars['key'] == 'this_month') {
				$__compilerTemp1 .= '
						' . 'This month' . '
					';
			} else if ($__vars['key'] == 'last_week') {
				$__compilerTemp1 .= '
						' . 'Last week' . '
					';
			} else if ($__vars['key'] == 'last_month') {
				$__compilerTemp1 .= '
						' . 'Last month' . '
					';
			} else if ($__vars['key'] == 'all_time') {
				$__compilerTemp1 .= '
						' . 'All time' . '
					';
			}
			$__vars['phrase'] = $__templater->preEscaped('
					' . $__compilerTemp1 . '
				');
			$__finalCompiled .= '
				' . $__templater->formRow($__templater->filter($__vars['total'], array(array('currency', array($__vars['currency'], )),), true), array(
				'label' => $__templater->func('trim', array($__vars['phrase'], ), true),
			)) . '
			';
		}
	}
	$__finalCompiled .= '
		</div>
	</div>
</div>';
	return $__finalCompiled;
}
);