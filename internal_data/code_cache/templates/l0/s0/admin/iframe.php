<?php
// FROM HASH: f64243fb21f109ef2954dfefe48b732f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Iframe Video');
	$__finalCompiled .= '
';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('Add Iframe Video', array(
		'href' => $__templater->func('link', array('iframe/add', ), false),
		'icon' => 'add',
	), '', array(
	)) . '
');
	$__finalCompiled .= '
';
	$__compilerTemp1 = '';
	if (!$__templater->test($__vars['data'], 'empty', array())) {
		$__compilerTemp1 .= '
			<div class="block-body">
				';
		$__compilerTemp2 = '';
		if ($__templater->isTraversable($__vars['data'])) {
			foreach ($__vars['data'] AS $__vars['function']) {
				$__compilerTemp2 .= '
						';
				$__vars['selectDays'] = $__templater->preEscaped($__templater->escape($__templater->method($__vars['function'], 'getDaysFrom', array())));
				$__compilerTemp2 .= $__templater->dataRow(array(
				), array(array(
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['function']['iframe_title']),
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['function']['iframe_URL']),
				),
				array(
					'_type' => 'cell',
					'html' => '
                                ' . '' . '

<span title="' . $__templater->escape($__vars['selectDays']) . '">' . $__templater->func('snippet', array($__vars['selectDays'], 20, array('stripBbCode' => true, ), ), true) . '</span>
                            ',
				),
				array(
					'_type' => 'cell',
					'html' => '
								
								
								' . $__templater->escape($__vars['function']['Brand']['video_feature']),
				),
				array(
					'_type' => 'cell',
					'html' => ($__vars['function']['feature'] ? 'Yes' : 'No'),
				),
				array(
					'href' => $__templater->func('link', array('iframe/edit', $__vars['function'], ), false),
					'_type' => 'action',
					'html' => 'Edit',
				),
				array(
					'href' => $__templater->func('link', array('iframe/delete', $__vars['function'], ), false),
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
			'html' => 'Iframe Title',
		),
		array(
			'_type' => 'cell',
			'html' => 'Iframe Link',
		),
		array(
			'_type' => 'cell',
			'html' => 'Day',
		),
		array(
			'_type' => 'cell',
			'html' => 'Brand Title',
		),
		array(
			'_type' => 'cell',
			'html' => 'Feature video',
		),
		array(
			'class' => 'dataList-cell--min',
			'_type' => 'cell',
			'html' => '&nbsp;',
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
				<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['data'], $__vars['total'], ), true) . '</span>
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
		'link' => 'functions',
		'params' => $__vars['filters'],
		'wrapperclass' => 'block-outer block-outer--after',
		'perPage' => $__vars['perPage'],
	))) . '
', array(
		'action' => $__templater->func('link', array('iframe/toggle', ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);