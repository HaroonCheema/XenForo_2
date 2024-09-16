<?php
// FROM HASH: 412a4b4abbb5625e6d04947244554e72
return array(
'macros' => array('choices_setup' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__templater->includeJs(array(
		'src' => 'sv/vendor/choices/choices.search-basic.js',
		'min' => '1',
		'addon' => 'SV/StandardLib',
	));
	$__finalCompiled .= '
	';
	$__templater->includeJs(array(
		'src' => 'sv/lib/select.js',
		'min' => '1',
		'addon' => 'SV/StandardLib',
	));
	$__finalCompiled .= '
	';
	$__templater->includeCss('svStandardLib_choices.less');
	$__finalCompiled .= '
	<script class="js-extraPhrases" type="application/json">
	{
		"svChoices_loadingText": "' . $__templater->filter('Loading' . $__vars['xf']['language']['ellipsis'], array(array('escape', array('js', )),), true) . '",
		"svChoices_noResultsText": "' . $__templater->filter('No results found.', array(array('escape', array('js', )),), true) . '",
		"svChoices_noChoicesText": "' . $__templater->filter($__vars['xf']['language']['parenthesis_open'] . 'None' . $__vars['xf']['language']['parenthesis_close'], array(array('escape', array('js', )),), true) . '",
		"svChoices_itemSelectText": "' . $__templater->filter('', array(array('escape', array('js', )),), true) . '",
		"svChoices_uniqueItemText": "' . $__templater->filter('Only unique values can be added', array(array('escape', array('js', )),), true) . '",
		"svChoices_customAddItemText": "' . $__templater->filter('Only values matching specific conditions can be added', array(array('escape', array('js', )),), true) . '",
		"svChoices_addItemText": "' . $__templater->filter('Press Enter to add <b>{value}</b>', array(array('escape', array('js', )),), true) . '",
		"svChoices_removeItemLabel": "' . $__templater->filter('Remove item: {value}', array(array('escape', array('js', )),), true) . '",
		"svChoices_maxItemText": "' . $__templater->filter('Only {maxItemCount} values can be added', array(array('escape', array('js', )),), true) . '"
	}
	</script>
';
	return $__finalCompiled;
}
),
'choices_static_render' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'name' => '!',
		'value' => '!',
		'multiple' => '!',
		'placeholder' => '',
		'selectHtml' => '!',
		'controlOptions' => '!',
		'choices' => '!',
		'selectedChoices' => '!',
		'class' => array(),
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="choices inputGroup svChoices--inputGroup ' . $__templater->escape($__vars['class']['containerOuter']) . (($__templater->func('strlen', array('', ), false) > 0) ? ' svChoices--select-prompt' : '') . '" data-type="select-multiple" role="combobox" aria-autocomplete="list" aria-haspopup="true" aria-expanded="false">
		<div class="choices__inner input ' . $__templater->escape($__vars['class']['containerInner']) . '">
			' . $__templater->filter($__vars['selectHtml'], array(array('raw', array()),), true) . '
			<div class="choices__list ' . $__templater->escape($__vars['class']['list']) . ' choices__list--multiple ' . $__templater->escape($__vars['class']['listItems']) . ' u-JsOnly" role="listbox">';
	$__compilerTemp1 = '';
	if ($__templater->isTraversable($__vars['selectedChoices'])) {
		foreach ($__vars['selectedChoices'] AS $__vars['i'] => $__vars['choice']) {
			$__compilerTemp1 .= trim('
					<div class="choices__item ' . $__templater->escape($__vars['class']['item']) . ' choices__item--itemSelectable ' . $__templater->escape($__vars['class']['itemSelectable']) . '" data-item="" data-id="' . $__templater->escape($__vars['i']) . '" data-value="' . $__templater->escape($__vars['choice']['value']) . '" aria-selected="true" role="option" data-deletable=""><button type="button" class="choices__button" aria-label="' . $__templater->filter('Remove item: ' . $__vars['choice']['value'] . '', array(array('for_attr', array()),), true) . '" data-button=""></button>' . ($__vars['choice']['span'] ? (((('<span class="' . $__templater->escape($__vars['choice']['span'])) . '">') . $__templater->escape($__vars['choice']['label'])) . '</span>') : $__templater->escape($__vars['choice']['label'])) . '</div>
				');
		}
	}
	$__finalCompiled .= trim('
				' . $__compilerTemp1 . '
			') . '</div>
			<input type="search" class="choices__input ' . $__templater->escape($__vars['class']['input']) . ' choices__input--cloned ' . $__templater->escape($__vars['class']['inputCloned']) . ' u-JsOnly" autocomplete="off" autocapitalize="off" spellcheck="false" role="textbox" aria-autocomplete="list" ' . ($__vars['selectedChoices'] ? (('style="min-width: ' . ($__vars['placeholder'] ? (1 + $__templater->func('strlen', array($__templater->func('trim', array($__vars['placeholder'], ), false), ), false)) : '1')) . 'ch; width: 1ch;"') : '') . ' ' . ($__vars['placeholder'] ? (((('placeholder="' . $__templater->escape($__vars['placeholder'])) . '" aria-label="') . $__templater->escape($__vars['placeholder'])) . '"') : '') . '>
		</div>
	</div>
';
	return $__finalCompiled;
}
),
'render_prefix_filter' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'filters' => '!',
		'prefixId' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = '';
	if (!$__templater->func('is_scalar', array($__vars['prefixId'], ), false)) {
		$__compilerTemp1 .= '
		';
		$__vars['prefixId'] = (!$__templater->test($__vars['prefixId']['prefix_id'], 'empty', array()) ? $__vars['prefixId']['prefix_id'] : 0);
		$__compilerTemp1 .= '
	';
	}
	$__vars['filterRoute'] = (($__vars['__globals']['filterRoute'] !== null) ? $__vars['__globals']['filterRoute'] : 'forums');
	$__vars['filterContainer'] = ((($__vars['filterRoute'] === 'forums') AND ($__vars['__globals']['filterContainer'] !== null)) ? $__vars['__globals']['filterContainer'] : null);
	$__vars['removeFilter'] = ($__vars['prefixId'] === $__vars['filters']['prefix_id']);
	$__vars['filters'] = ($__vars['removeFilter'] ? $__templater->filter($__vars['filters'], array(array('replace', array('prefix_id', null, )),), false) : $__templater->filter($__vars['filters'], array(array('replace', array('prefix_id', $__vars['prefixId'], )),), false));
	$__compilerTemp2 = '';
	$__compilerTemp3 = '';
	$__compilerTemp3 .= trim($__templater->func('prefix', array('thread', $__vars['prefixId'], ), true));
	if (strlen(trim($__compilerTemp3)) > 0) {
		$__compilerTemp2 .= '
		<a href="' . $__templater->func('link', array($__vars['filterRoute'], $__vars['filterContainer'], $__vars['filters'], ), true) . '" class="labelLink" rel="nofollow" data-xf-init="tooltip" title="' . $__templater->filter(($__vars['removeFilter'] ? 'Remove from filters' : 'Add to filters'), array(array('for_attr', array()),), true) . '"  rel="nofollow">
			' . $__compilerTemp3 . '
		</a>
	';
	}
	$__finalCompiled .= trim('

	' . $__compilerTemp1 . '

	' . '' . '
	' . '' . '

	' . '' . '
	' . '' . '
	' . $__compilerTemp2 . '
');
	return $__finalCompiled;
}
),
'render_forum_filter' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'filters' => '!',
		'nodeId' => '!',
		'forum' => '!',
		'removeFilter' => '!',
		'noFilterValue' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__vars['filterRoute'] = (($__vars['__globals']['filterRoute'] !== null) ? $__vars['__globals']['filterRoute'] : 'forums');
	$__vars['filterContainer'] = ((($__vars['filterRoute'] === 'forums') AND ($__vars['__globals']['filterContainer'] !== null)) ? $__vars['__globals']['filterContainer'] : $__vars['forum']);
	$__vars['removeFilter'] = $__templater->func('in_array', array($__vars['nodeId'], ($__vars['filters']['nodes'] ?: array()), true, ), false);
	$__vars['filters']['nodes'] = ($__vars['removeFilter'] ? ($__templater->filter($__vars['filters']['nodes'], array(array('replaceValue', array($__vars['nodeId'], null, )),), false) ?: $__vars['noFilterValue']) : $__templater->filter($__vars['filters']['nodes'], array(array('addValue', array($__vars['nodeId'], )),), false));
	$__finalCompiled .= trim('

	' . '' . '
	' . '' . '

	' . '' . '
	' . '' . '
	<a href="' . $__templater->func('link', array($__vars['filterRoute'], $__vars['filterContainer'], $__vars['filters'], ), true) . '" class="labelLink" rel="nofollow" data-xf-init="tooltip" title="' . $__templater->filter(($__vars['removeFilter'] ? 'Remove from filters' : 'Add to filters'), array(array('for_attr', array()),), true) . '"  rel="nofollow">
		' . $__templater->escape($__vars['forum']['title']) . '
	</a>
');
	return $__finalCompiled;
}
),
'dynamic_quick_filter' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'key' => '',
		'ajax' => '',
		'class' => '',
		'page' => '',
		'filter' => array(),
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
    ';
	$__templater->includeJs(array(
		'src' => 'xf/filter.js',
		'min' => '1',
	));
	$__finalCompiled .= '
	';
	$__templater->includeJs(array(
		'src' => 'sv/vendor/domurl/url.js',
		'addon' => 'SV/StandardLib',
		'min' => '1',
	));
	$__finalCompiled .= '
	';
	$__templater->includeJs(array(
		'src' => 'sv/lib/xf/filter.js',
		'addon' => 'SV/StandardLib',
		'min' => '1',
	));
	$__finalCompiled .= '
	<script class="js-extraPhrases" type="application/json">
		{
			"no_items_matched_your_filter": "' . $__templater->filter('No items matched your filter.', array(array('escape', array('js', )),), true) . '"
		}
	</script>
	';
	$__templater->includeCss('sv_quick_filter.less');
	$__finalCompiled .= '

    <div class="' . $__templater->escape($__vars['class']) . ' quickFilter u-jsOnly"
         data-xf-init="sv-dynamic-filter"
         data-key="' . $__templater->escape($__vars['key']) . '"
         data-ajax="' . $__templater->escape($__vars['ajax']) . '"
         data-search-target=".userList"
         data-search-row=".userList-row"
		 data-search-limit=".username"
         data-no-results-format="<div class=&quot;blockMessage js-filterNoResults&quot;>%s</div>">
		<div class="inputGroup inputGroup--inline inputGroup--joined">
			<input type="text" class="input js-filterInput" value="' . $__templater->escape($__vars['filter']['text']) . '" placeholder="' . $__templater->filter('Filter' . $__vars['xf']['language']['ellipsis'], array(array('for_attr', array()),), true) . '" data-xf-key="' . $__templater->filter('f', array(array('for_attr', array()),), true) . '" />
			<span class="inputGroup-text">
				' . $__templater->formCheckBox(array(
		'standalone' => 'true',
	), array(array(
		'class' => 'js-filterPrefix',
		'label' => 'Prefix',
		'checked' => $__vars['filter']['prefix'],
		'_type' => 'option',
	))) . '
			</span>
			<i class="inputGroup-text js-filterClear is-disabled" aria-hidden="true"></i>
        </div>
    </div>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

' . '

' . '

' . '

';
	return $__finalCompiled;
}
);