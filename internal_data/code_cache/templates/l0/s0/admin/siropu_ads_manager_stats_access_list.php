<?php
// FROM HASH: 24f89c36b0d561cecbcc1ab6b4a98c84
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Stats access');
	$__finalCompiled .= '
';
	$__templater->pageParams['pageDescription'] = $__templater->preEscaped('This tool allows you to give statistics access to advertisers that are not registered.');
	$__templater->pageParams['pageDescriptionMeta'] = true;
	$__finalCompiled .= '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('Add stats access', array(
		'href' => $__templater->func('link', array('ads-manager/stats-access/add', ), false),
		'icon' => 'add',
	), '', array(
	)) . '
');
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['statsAccess'], 'empty', array())) {
		$__finalCompiled .= '
	<div class="block">
		<div class="block-container">
			<div class="block-body">
				';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['statsAccess'])) {
			foreach ($__vars['statsAccess'] AS $__vars['access']) {
				$__compilerTemp1 .= '
						' . $__templater->dataRow(array(
					'label' => $__templater->escape($__vars['access']['title']),
					'href' => $__templater->func('link', array('ads-manager/stats-access/edit', $__vars['access'], ), false),
					'delete' => $__templater->func('link', array('ads-manager/stats-access/delete', $__vars['access'], ), false),
				), array(array(
					'href' => $__templater->func('link', array('ads-manager/stats-access/link', $__vars['access'], ), false),
					'class' => 'dataList-cell--separated',
					'title' => $__templater->filter('Stats access key link', array(array('for_attr', array()),), false),
					'data-xf-init' => 'tooltip',
					'overlay' => 'true',
					'width' => '1%',
					'_type' => 'cell',
					'html' => '
								' . $__templater->fontAwesome('fas fa-link', array(
				)) . '
							',
				))) . '
					';
			}
		}
		$__finalCompiled .= $__templater->dataList('
					' . $__templater->dataRow(array(
			'rowtype' => 'header',
		), array(array(
			'width' => '50%',
			'_type' => 'cell',
			'html' => 'Title',
		),
		array(
			'_type' => 'cell',
			'html' => '',
		),
		array(
			'_type' => 'cell',
			'html' => '',
		))) . '
					' . $__compilerTemp1 . '
				', array(
			'data-xf-init' => 'responsive-data-list',
		)) . '
			</div>
			<div class="block-footer">
				<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['statsAccess'], ), true) . '</span>
			</div>
		</div>
	</div>
';
	} else {
		$__finalCompiled .= '
	<div class="blockMessage">' . 'No stats access.' . '</div>
';
	}
	return $__finalCompiled;
}
);