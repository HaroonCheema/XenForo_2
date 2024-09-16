<?php
// FROM HASH: 0af554d2654aad69bed135a1d01f5558
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Blacklisted tags');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('Blacklist tag', array(
		'href' => $__templater->func('link', array('tags/blacklist', ), false),
		'icon' => 'add',
	), '', array(
	)) . '
');
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if (!$__templater->test($__vars['blacklistedTags'], 'empty', array())) {
		$__compilerTemp1 .= '
			<div class="block-body">
				';
		$__compilerTemp2 = '';
		if ($__templater->isTraversable($__vars['blacklistedTags'])) {
			foreach ($__vars['blacklistedTags'] AS $__vars['blacklistedTag']) {
				$__compilerTemp2 .= '
						' . $__templater->dataRow(array(
				), array(array(
					'name' => 'selected_tags[]',
					'value' => $__vars['blacklistedTag']['blacklist_id'],
					'_type' => 'toggle',
					'html' => '',
				),
				array(
					'_type' => 'cell',
					'html' => '
								' . $__templater->formCheckBox(array(
					'standalone' => 'true',
				), array(array(
					'value' => '1',
					'selected' => $__vars['blacklistedTag']['regex'],
					'readonly' => 'true',
					'disabled' => 'true',
					'_type' => 'option',
				))) . '
							',
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['blacklistedTag']['tag']),
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['blacklistedTag']['User']['username']),
				),
				array(
					'href' => $__templater->func('link', array('tags/delete-blacklist', null, array('blacklist_id' => $__vars['blacklistedTag']['blacklist_id'], ), ), false),
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
			'class' => 'dataList-cell--min',
			'_type' => 'cell',
			'html' => $__templater->formCheckBox(array(
			'standalone' => 'true',
		), array(array(
			'data-match' => 'input:checkbox[name=\'selected_tags[]\']',
			'check-all' => '< .block-container',
			'data-xf-init' => 'tooltip',
			'title' => 'Select all',
			'_type' => 'option',
		))),
		),
		array(
			'class' => 'dataList-cell--min',
			'_type' => 'cell',
			'html' => 'Regex',
		),
		array(
			'_type' => 'cell',
			'html' => 'Tag',
		),
		array(
			'class' => 'dataList-cell--min',
			'_type' => 'cell',
			'html' => 'User',
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

			<div class="block-footer block-footer--split">
				<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['blacklistedTags'], $__vars['total'], ), true) . '</span>

				<span class="block-footer-select">
					' . $__templater->formCheckBox(array(
			'standalone' => 'true',
		), array(array(
			'data-match' => 'input:checkbox[name=\'selected_tags[]\']',
			'check-all' => '< .block-container',
			'label' => 'Select all',
			'_type' => 'option',
		))) . '
				</span>

				<span class="block-footer-controls">
					' . $__templater->formSelect(array(
			'name' => 'state',
			'class' => 'input--inline',
			'style' => 'font-family: \'Font Awesome 5 Pro\',\'FontAwesome\';',
		), array(array(
			'label' => 'With selected' . $__vars['xf']['language']['ellipsis'],
			'_type' => 'option',
		),
		array(
			'value' => 'delete',
			'label' => '&#xf1f8; ' . 'Delete',
			'_type' => 'option',
		))) . '
					' . $__templater->button('Go', array(
			'type' => 'submit',
		), '', array(
		)) . '
				</span>
			</div>
		';
	} else {
		$__compilerTemp1 .= '
			<div class="block-body block-row">' . 'No blacklisted tags found' . '</div>
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
		'link' => 'tags/blacklisted',
		'params' => $__vars['filters'],
		'wrapperclass' => 'block-outer block-outer--after',
		'perPage' => $__vars['perPage'],
	))) . '
', array(
		'action' => $__templater->func('link', array('tags/blacklisted', ), false),
		'class' => 'block',
	));
	return $__finalCompiled;
}
);