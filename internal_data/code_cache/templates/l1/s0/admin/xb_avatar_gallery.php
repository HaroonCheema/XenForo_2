<?php
// FROM HASH: 91d75f83713e5e6f3987312609f9be9a
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Avatars');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('Add avatar', array(
		'href' => $__templater->func('link', array('ag/add', ), false),
		'icon' => 'add',
	), '', array(
	)) . '
');
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if (!$__templater->test($__vars['avatars'], 'empty', array())) {
		$__compilerTemp1 .= '
			<div class="block-body">
				';
		$__compilerTemp2 = '';
		if ($__templater->isTraversable($__vars['avatars'])) {
			foreach ($__vars['avatars'] AS $__vars['avatar']) {
				$__compilerTemp2 .= '
						' . $__templater->dataRow(array(
				), array(array(
					'href' => $__templater->method($__vars['avatar'], 'getAvatarImgUrl', array()),
					'target' => '_blank',
					'_type' => 'cell',
					'html' => '<img src="' . $__templater->escape($__templater->method($__vars['avatar'], 'getAvatarImgUrl', array())) . '" alt="avatar image" width="100" height="100"/>',
				),
				array(
					'href' => $__templater->func('link', array('ag/delete', $__vars['avatar'], ), false),
					'_type' => 'delete',
					'html' => '',
				))) . '
					';
			}
		}
		$__compilerTemp1 .= $__templater->dataList('
					' . $__templater->dataRow(array(
			'rowtype' => 'header',
		), array(array(
			'_type' => 'cell',
			'html' => 'Avatar',
		),
		array(
			'class' => 'dataList-cell--min',
			'_type' => 'cell',
			'html' => '&nbsp;',
		))) . '
					' . $__compilerTemp2 . '
				', array(
			'data-xf-init' => 'responsive-data-list',
		)) . '
			</div>
			<div class="block-footer">
				<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['avatars'], $__vars['total'], ), true) . '</span>
			</div>
		';
	} else {
		$__compilerTemp1 .= '
			<div class="block-body block-row">' . 'No results found.' . '</div>
		';
	}
	$__finalCompiled .= $__templater->form('
	
	<div class="block-container">
		' . $__compilerTemp1 . '
	</div>

	' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => 'ag',
		'params' => $__vars['filters'],
		'wrapperclass' => 'block-outer block-outer--after',
		'perPage' => $__vars['perPage'],
	))) . '
', array(
		'action' => $__templater->func('link', array('ag', ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);