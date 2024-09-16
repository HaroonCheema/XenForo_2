<?php
// FROM HASH: fce33fa98af0ca29e0c7a0874a43b408
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Tags');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('Add tag', array(
		'href' => $__templater->func('link', array('tags/add', ), false),
		'icon' => 'add',
	), '', array(
	)) . '
');
	$__finalCompiled .= '

';
	$__templater->includeCss('avForumsTagEss_tag_list.less');
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if (!$__templater->test($__vars['tags'], 'empty', array())) {
		$__compilerTemp1 .= '
			<div class="block-body">
				';
		$__compilerTemp2 = '';
		if ($__templater->isTraversable($__vars['tags'])) {
			foreach ($__vars['tags'] AS $__vars['tag']) {
				$__compilerTemp2 .= '
						';
				$__compilerTemp3 = array(array(
					'name' => 'selected_tags[]',
					'value' => $__vars['tag']['tag_id'],
					'_type' => 'toggle',
					'html' => '',
				)
,array(
					'href' => $__templater->func('link', array('tags/edit', $__vars['tag'], ), false),
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['tag']['tag']),
				));
				if ($__vars['tag']['SynonymOf']) {
					$__compilerTemp3[] = array(
						'href' => $__templater->func('link', array('tags/edit', $__vars['tag'], ), false),
						'_type' => 'cell',
						'html' => $__templater->escape($__vars['tag']['SynonymOf']['ParentTag']['tag']),
					);
				} else {
					$__compilerTemp3[] = array(
						'href' => $__templater->func('link', array('tags/edit', $__vars['tag'], ), false),
						'_type' => 'cell',
						'html' => 'N/A',
					);
				}
				$__compilerTemp3[] = array(
					'href' => $__templater->func('link', array('tags/edit', $__vars['tag'], ), false),
					'_type' => 'cell',
					'html' => $__templater->filter($__vars['tag']['use_count'], array(array('number', array()),), true),
				);
				$__compilerTemp4 = '';
				if ($__vars['tag']['last_use_date']) {
					$__compilerTemp4 .= '
									' . $__templater->func('date_dynamic', array($__vars['tag']['last_use_date'], array(
					))) . '
									';
				} else {
					$__compilerTemp4 .= '
									&nbsp;
								';
				}
				$__compilerTemp3[] = array(
					'href' => $__templater->func('link', array('tags/edit', $__vars['tag'], ), false),
					'_type' => 'cell',
					'html' => '
								' . $__compilerTemp4 . '
							',
				);
				$__compilerTemp3[] = array(
					'href' => $__templater->func('link_type', array('public', 'tags', $__vars['tag'], ), false),
					'_type' => 'action',
					'html' => 'View',
				);
				$__compilerTemp3[] = array(
					'href' => $__templater->func('link', array('tags/merge', $__vars['tag'], ), false),
					'overlay' => 'true',
					'_type' => 'action',
					'html' => 'Merge',
				);
				$__compilerTemp3[] = array(
					'href' => $__templater->func('link', array('tags/wiki', $__vars['tag'], ), false),
					'class' => 'dataList-cell--iconic',
					'overlay' => 'true',
					'data-xf-init' => 'tooltip',
					'title' => 'Wiki',
					'_type' => 'action',
					'html' => '	
	<i class="' . (($__vars['xf']['versionId'] > 2010000) ? 'fab fa-wikipedia-w' : 'fa fa-wikipedia-w') . ' dataList-wiki" aria-hidden="true"></i>
',
				);
				$__compilerTemp3[] = array(
					'href' => $__templater->func('link', array('tags/blacklist', null, array('existing_tag_id' => $__vars['tag']['tag_id'], ), ), false),
					'class' => 'dataList-cell--iconic',
					'overlay' => 'true',
					'data-xf-init' => 'tooltip',
					'title' => 'Blacklist',
					'_type' => 'action',
					'html' => '
	<i class="fa fa-ban dataList-blackList" aria-hidden="true"></i>
',
				);
				$__compilerTemp3[] = array(
					'href' => $__templater->func('link', array('tags/delete', $__vars['tag'], ), false),
					'_type' => 'delete',
					'html' => '',
				);
				$__compilerTemp2 .= $__templater->dataRow(array(
				), $__compilerTemp3) . '
					';
			}
		}
		$__compilerTemp1 .= $__templater->dataList('
					' . $__templater->dataRow(array(
			'rowtype' => 'header',
		), array(array(
			'class' => 'dataList-cell--min',
			'_type' => 'cell',
			'html' => $__templater->formCheckBox(array(
			'standalone' => 'true',
		), array(array(
			'check-all' => '.dataList',
			'data-xf-init' => 'tooltip',
			'title' => 'Select all',
			'_type' => 'option',
		))),
		),
		array(
			'_type' => 'cell',
			'html' => 'Tag',
		),
		array(
			'_type' => 'cell',
			'html' => 'Synonym of',
		),
		array(
			'_type' => 'cell',
			'html' => 'Total',
		),
		array(
			'_type' => 'cell',
			'html' => 'Last used',
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
' . $__templater->includeTemplate('avForumsTagEss_tag_list_footer', $__vars) . '
		';
	} else {
		$__compilerTemp1 .= '
			<div class="block-body block-row">' . 'No results found.' . '</div>
		';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-outer">
		<span class="filterBlock">
			' . $__templater->formTextBox(array(
		'name' => 'containing',
		'value' => $__vars['filters']['containing'],
		'placeholder' => 'Tag contains' . $__vars['xf']['language']['ellipsis'],
		'class' => 'input--inline filterBlock-input',
	)) . '
			<span>
				<span class="filterBlock-label">' . 'Ordered by' . $__vars['xf']['language']['label_separator'] . '</span>
				' . $__templater->formSelect(array(
		'name' => 'order',
		'value' => ($__vars['filters']['order'] ? $__vars['filters']['order'] : 'tag'),
		'class' => 'input--inline filterBlock-input',
	), array(array(
		'value' => 'tag',
		'label' => 'Tag',
		'_type' => 'option',
	),
	array(
		'value' => 'use_count',
		'label' => 'Total',
		'_type' => 'option',
	),
	array(
		'value' => 'last_use_date',
		'label' => 'Last used',
		'_type' => 'option',
	))) . '
			</span>
			' . $__templater->button('Go', array(
		'type' => 'submit',
	), '', array(
	)) . '
		</span>
	</div>
	<div class="block-container">
		' . $__compilerTemp1 . '
	</div>

	' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => 'tags',
		'params' => $__vars['filters'],
		'wrapperclass' => 'block-outer block-outer--after',
		'perPage' => $__vars['perPage'],
	))) . '
', array(
		'action' => $__templater->func('link', array('tags', ), false),
		'class' => 'block',
	));
	return $__finalCompiled;
}
);