<?php
// FROM HASH: 788689864fcca463dbea8c94696315c2
return array(
'macros' => array('edit_block' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'article' => '!',
		'thread' => '!',
		'categories' => '!',
		'nonCategories' => '!',
		'attachData' => '',
		'images' => '',
		'medios' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="block-body">
		';
	$__compilerTemp1 = array(array(
		'value' => '',
		'label' => 'Disabled',
		'selected' => (!$__vars['article']['article_icon']),
		'_type' => 'option',
	)
,array(
		'value' => 'avatar',
		'label' => 'Avatar',
		'_type' => 'option',
	));
	if (!$__templater->test($__vars['attachData']['attachments'], 'empty', array())) {
		$__compilerTemp2 = array();
		if ($__templater->isTraversable($__vars['attachData']['attachments'])) {
			foreach ($__vars['attachData']['attachments'] AS $__vars['attach']) {
				$__compilerTemp2[] = array(
					'value' => $__vars['attach']['attachment_id'],
					'label' => '
									' . $__templater->escape($__vars['attach']['attachment_id']) . ' -> ' . $__templater->escape($__vars['attach']['Data']['filename']) . '
								',
					'_type' => 'option',
				);
			}
		}
		$__compilerTemp1[] = array(
			'value' => 'attach',
			'label' => 'Attachment',
			'_dependent' => array('
						' . $__templater->formSelect(array(
			'name' => 'article[article_icon][data]',
			'value' => $__vars['article']['article_icon']['data'],
		), $__compilerTemp2) . '
					'),
			'_type' => 'option',
		);
	}
	if (!$__templater->test($__vars['images'], 'empty', array())) {
		$__compilerTemp3 = array();
		if ($__templater->isTraversable($__vars['images'])) {
			foreach ($__vars['images'] AS $__vars['image']) {
				$__compilerTemp3[] = array(
					'value' => $__vars['image']['url'],
					'label' => '
									' . $__templater->escape($__vars['image']['host']) . ' -> ' . $__templater->escape($__vars['image']['file']) . '
								',
					'_type' => 'option',
				);
			}
		}
		$__compilerTemp1[] = array(
			'value' => 'image',
			'label' => 'Image',
			'_dependent' => array('
						' . $__templater->formSelect(array(
			'name' => 'article[article_icon][data]',
			'value' => $__vars['article']['article_icon']['data'],
		), $__compilerTemp3) . '
					'),
			'_type' => 'option',
		);
	}
	if (!$__templater->test($__vars['medios'], 'empty', array())) {
		$__compilerTemp4 = array();
		if ($__templater->isTraversable($__vars['medios'])) {
			foreach ($__vars['medios'] AS $__vars['medio']) {
				$__compilerTemp4[] = array(
					'value' => $__vars['medio']['media_id'],
					'label' => '
									' . $__templater->escape($__vars['medio']['media_title']) . '
								',
					'_type' => 'option',
				);
			}
		}
		$__compilerTemp1[] = array(
			'value' => 'medio',
			'label' => 'EWRmedio_media',
			'_dependent' => array('
						' . $__templater->formSelect(array(
			'name' => 'article[article_icon][data]',
			'value' => $__vars['article']['article_icon']['data'],
		), $__compilerTemp4) . '
					'),
			'_type' => 'option',
		);
	}
	$__finalCompiled .= $__templater->formRadioRow(array(
		'name' => 'article[article_icon][type]',
		'value' => $__vars['article']['article_icon']['type'],
	), $__compilerTemp1, array(
		'label' => 'Icon',
	)) . '

		' . $__templater->formTextBoxRow(array(
		'name' => 'article[article_break]',
		'value' => $__vars['article']['article_break'],
	), array(
		'label' => 'Break text',
	)) . '

		' . $__templater->formRow('
			<div class="inputGroup">
				' . $__templater->formDateInput(array(
		'name' => 'date',
		'value' => $__templater->func('date', array(($__vars['article'] ? $__vars['article']['article_date'] : $__vars['thread']['post_date']), 'picker', ), false),
	)) . '
				<span class="inputGroup-splitter"></span>
				' . $__templater->formTextBox(array(
		'type' => 'time',
		'name' => 'time',
		'value' => $__templater->func('date', array(($__vars['article'] ? $__vars['article']['article_date'] : $__vars['thread']['post_date']), 'H:i', ), false),
	)) . '
			</div>
		', array(
		'label' => 'Date',
		'rowtype' => 'input',
	)) . '

		' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'article[article_format]',
		'value' => '1',
		'selected' => ($__vars['article'] ? $__vars['article']['article_format'] : true),
		'label' => 'Format thread as an article',
		'_type' => 'option',
	),
	array(
		'name' => 'article[article_sticky]',
		'value' => '1',
		'selected' => $__vars['article']['article_sticky'],
		'label' => 'Sticky to article index',
		'_type' => 'option',
	),
	array(
		'name' => 'article[article_exclude]',
		'value' => '1',
		'selected' => $__vars['article']['article_exclude'],
		'hint' => 'Article will only appear when viewing categories and authors.',
		'label' => 'Exclude from article index',
		'_type' => 'option',
	)), array(
	)) . '
	</div>

	<h2 class="block-formSectionHeader">
		<span class="collapseTrigger collapseTrigger--block' . ($__vars['article']['article_title'] ? ' is-active' : '') . '"
				data-xf-click="toggle" data-target="< :up :next">
			<span class="block-formSectionHeader-aligner">' . 'Excerpt' . '</span>
		</span>
	</h2>
	<div class="block-body block-body--collapsible' . ($__vars['article']['article_title'] ? ' is-active' : '') . '">
		' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'custom_excerpt',
		'value' => '1',
		'checked' => ($__vars['article']['article_title'] ? true : false),
		'data-xf-init' => 'disabler',
		'data-container' => '#Excerpt',
		'data-hide' => 'true',
		'label' => 'Use custom title and excerpt',
		'_type' => 'option',
	)), array(
	)) . '

		<div id="Excerpt">
			' . $__templater->formTextBoxRow(array(
		'name' => 'article[article_title]',
		'maxlength' => $__templater->func('max_length', array('XF:Thread', 'title', ), false),
		'value' => ($__vars['article']['article_title'] ?: $__vars['thread']['title']),
	), array(
		'label' => 'Title',
	)) . '

			' . $__templater->formTextAreaRow(array(
		'name' => 'article[article_excerpt]',
		'rows' => '6',
		'autosize' => 'true',
		'maxlength' => $__vars['xf']['options']['messageMaxLength'],
		'placeholder' => $__vars['thread']['FirstPost']['message'],
		'value' => ($__vars['article']['article_excerpt'] ?: ($__vars['xf']['options']['EWRporta_articles_prefill'] ? $__vars['thread']['FirstPost']['message'] : '')),
	), array(
		'label' => 'Message',
	)) . '
		</div>
	</div>

	<h2 class="block-formSectionHeader">
		<span class="block-formSectionHeader-aligner">' . 'Categories' . '</span>
	</h2>
	<div class="block-body porta-category-form">
		';
	$__compilerTemp5 = array();
	if ($__templater->isTraversable($__vars['categories'])) {
		foreach ($__vars['categories'] AS $__vars['category']) {
			$__compilerTemp5[] = array(
				'name' => 'catlinks[' . $__vars['category']['category_id'] . ']',
				'value' => $__vars['category']['category_id'],
				'selected' => true,
				'label' => $__templater->escape($__vars['category']['category_name']),
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->formCheckBoxRow(array(
	), $__compilerTemp5, array(
	)) . '
		';
	$__compilerTemp6 = array();
	if ($__templater->isTraversable($__vars['nonCategories'])) {
		foreach ($__vars['nonCategories'] AS $__vars['category']) {
			$__compilerTemp6[] = array(
				'name' => 'catlinks[' . $__vars['category']['category_id'] . ']',
				'value' => $__vars['category']['category_id'],
				'selected' => false,
				'label' => $__templater->escape($__vars['category']['category_name']),
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->formCheckBoxRow(array(
	), $__compilerTemp6, array(
	)) . '
	</div>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if (!$__vars['article']) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Promote to article');
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit article promotion');
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	$__templater->breadcrumbs($__templater->method($__vars['thread'], 'getBreadcrumbs', array()));
	$__finalCompiled .= '

';
	$__templater->includeCss('EWRporta.less');
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__vars['article'] AND $__templater->method($__vars['xf']['visitor'], 'hasPermission', array('EWRporta', 'modArticles', ))) {
		$__compilerTemp1 .= '
					' . $__templater->button('Delete' . $__vars['xf']['language']['ellipsis'], array(
			'href' => $__templater->func('link', array('threads/article-delete', $__vars['thread'], ), false),
			'icon' => 'delete',
			'overlay' => 'true',
		), '', array(
		)) . '
				';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		
		' . $__templater->callMacro(null, 'edit_block', array(
		'article' => $__vars['article'],
		'thread' => $__vars['thread'],
		'categories' => $__vars['categories'],
		'nonCategories' => $__vars['nonCategories'],
		'attachData' => $__vars['attachData'],
		'images' => $__vars['images'],
		'medios' => $__vars['medios'],
	), $__vars) . '

		' . $__templater->formSubmitRow(array(
		'icon' => 'save',
		'sticky' => 'true',
	), array(
		'html' => '
				' . $__compilerTemp1 . '
			',
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('threads/article-edit', $__vars['thread'], ), false),
		'class' => 'block',
		'ajax' => 'true',
	)) . '




';
	return $__finalCompiled;
}
);