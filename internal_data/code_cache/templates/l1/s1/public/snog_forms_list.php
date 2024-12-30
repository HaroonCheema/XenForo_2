<?php
// FROM HASH: 89f54352ddaa84d66a84c105134df28f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Available forms');
	$__finalCompiled .= '
';
	$__templater->pageParams['pageH1'] = $__templater->preEscaped('Available forms');
	$__finalCompiled .= '
';
	$__vars['headrow'] = '';
	$__finalCompiled .= '
';
	$__templater->setPageParam('section', 'snog_forms_nav');
	$__finalCompiled .= '
';
	$__templater->setPageParam('head.' . 'metaNoindex', $__templater->preEscaped('<meta name="robots" content="noindex" />'));
	$__finalCompiled .= '
';
	$__templater->setPageParam('head.' . 'metaNofollow', $__templater->preEscaped('<meta name="robots" content="nofollow" />'));
	$__finalCompiled .= '

<div class="block-container">
	<div class="block-body">
		';
	if (!$__templater->test($__vars['forms'], 'empty', array())) {
		$__finalCompiled .= '
		';
		if ($__templater->isTraversable($__vars['headervalues'])) {
			foreach ($__vars['headervalues'] AS $__vars['header']) {
				$__finalCompiled .= '
			';
				if ($__vars['headrow'] !== $__vars['header']) {
					$__finalCompiled .= '
				';
					$__vars['headrow'] = $__vars['header'];
					$__vars['newline'] = '0';
					$__compilerTemp1 = '';
					if ($__templater->isTraversable($__vars['forms'])) {
						foreach ($__vars['forms'] AS $__vars['form']) {
							$__compilerTemp1 .= '
						';
							if ($__vars['form']['Type']['type'] == $__vars['header']) {
								$__compilerTemp1 .= '
							';
								if ($__vars['newline']) {
									$__compilerTemp1 .= '
								<br /><a href="' . $__templater->func('link', array('form/select', $__vars['form'], ), true) . '">' . $__templater->escape($__vars['form']['position']) . '</a>
							';
								} else {
									$__compilerTemp1 .= '
								<a href="' . $__templater->func('link', array('form/select', $__vars['form'], ), true) . '">' . $__templater->escape($__vars['form']['position']) . '</a>
								';
									$__vars['newline'] = '1';
									$__compilerTemp1 .= '
							';
								}
								$__compilerTemp1 .= '
						';
							}
							$__compilerTemp1 .= '
					';
						}
					}
					$__finalCompiled .= $__templater->formRow('
					' . '' . '
					' . '' . '
					' . $__compilerTemp1 . '
				', array(
						'label' => $__templater->escape($__vars['header']),
					)) . '
			';
				}
				$__finalCompiled .= '
		';
			}
		}
		$__finalCompiled .= '
		';
	} else {
		$__finalCompiled .= '
			<div class="block-row">
				' . 'You do not meet the criteria for any forms. No forms are available for you.' . '
			</div>
		';
	}
	$__finalCompiled .= '
	</div>
</div>

';
	$__templater->modifySidebarHtml('_xfWidgetPositionSidebar09307775b88b55de81407a39aa75c196', $__templater->widgetPosition('snogFormListSidebar', array()), 'replace');
	return $__finalCompiled;
}
);