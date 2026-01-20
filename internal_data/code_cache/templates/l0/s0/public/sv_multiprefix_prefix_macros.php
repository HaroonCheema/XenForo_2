<?php
// FROM HASH: 4d155d929cc1f5f5eef060fcf17bf270
return array(
'macros' => array('setup' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__templater->includeJs(array(
		'src' => 'sv/multiprefix/prefix_menu.js',
		'addon' => 'SV/MultiPrefix',
		'min' => '1',
	));
	$__finalCompiled .= '
	';
	$__templater->includeJs(array(
		'prod' => 'vendor/select2/select2.full.min.js',
		'dev' => 'vendor/select2/select2.full.js',
	));
	$__finalCompiled .= '
	';
	$__templater->includeCss('prefix_menu.less');
	$__finalCompiled .= '
	';
	$__templater->includeCss('select2.less');
	$__finalCompiled .= '
	';
	$__templater->includeCss('sv_multiprefix_prefix_input.less');
	$__finalCompiled .= '


	<script class="js-extraPhrases" type="application/json">
		{
			"s2_error_loading": "' . $__templater->filter('The results could not be loaded.', array(array('escape', array('js', )),), true) . '",
			"s2_input_too_long": "' . $__templater->filter('Please delete {count} character(s).', array(array('escape', array('js', )),), true) . '",
			"s2_input_too_short": "' . $__templater->filter('Please enter {count} or more characters.', array(array('escape', array('js', )),), true) . '",
			"s2_loading_more": "' . $__templater->filter('Loading more results...', array(array('escape', array('js', )),), true) . '",
			"s2_maximum_selected": "' . $__templater->filter('You can only select {count} item(s).', array(array('escape', array('js', )),), true) . '",
			"s2_no_results": "' . $__templater->filter('No results found.', array(array('escape', array('js', )),), true) . '",
			"s2_searching": "' . $__templater->filter('Searching...', array(array('escape', array('js', )),), true) . '",
			"sv_prefix_placeholder": "' . $__templater->filter('Prefix' . $__vars['xf']['language']['ellipsis'], array(array('escape', array('js', )),), true) . '",
			"sv_multiprefix_none": "' . $__templater->filter($__vars['xf']['language']['parenthesis_open'] . 'No prefix' . $__vars['xf']['language']['parenthesis_close'], array(array('escape', array('js', )),), true) . '"
		}
	</script>
';
	return $__finalCompiled;
}
),
'select' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'prefixes' => '!',
		'type' => '!',
		'label' => 'Prefix',
		'explain' => '',
		'selected' => '',
		'name' => 'prefix_id',
		'anyLabel' => $__vars['xf']['language']['parenthesis_open'] . 'Any' . $__vars['xf']['language']['parenthesis_close'],
		'noneLabel' => $__vars['xf']['language']['parenthesis_open'] . 'No prefix' . $__vars['xf']['language']['parenthesis_close'],
		'multiple' => false,
		'includeAny' => false,
		'includeNone' => null,
		'class' => '',
		'href' => '',
		'listenTo' => '',
		'minTokens' => 0,
		'maxTokens' => 0,
		'forumPrefixesLimit' => 0,
		'contentParent' => false,
		'content' => false,
		'required' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	' . $__templater->callMacro('sv_multiprefix_prefix_macros', 'setup', array(), $__vars) . '

	<script type="text/template">
        ' . $__templater->func('mustache', array('#rich_prefix', '
            <span class="' . $__templater->func('mustache', array('css_class', ), true) . '"
               data-prefix-id="' . $__templater->func('mustache', array('prefix_id', ), true) . '"
               data-prefix-class="' . $__templater->func('mustache', array('css_class', ), true) . '"
               role="option">' . $__templater->func('mustache', array('title', ), true) . '</span>
        ')) . '
    </script>

	';
	if ($__vars['contentParent']) {
		$__finalCompiled .= '
		';
		$__vars['min_tokens'] = $__vars['contentParent']['sv_min_prefixes'];
		$__finalCompiled .= '
		';
		$__vars['max_tokens'] = $__vars['contentParent']['sv_max_prefixes'];
		$__finalCompiled .= '
	';
	} else {
		$__finalCompiled .= '
		';
		$__vars['min_tokens'] = $__vars['minTokens'];
		$__finalCompiled .= '
		';
		$__vars['max_tokens'] = $__vars['maxTokens'];
		$__finalCompiled .= '
	';
	}
	$__finalCompiled .= '

	';
	if ($__vars['forumPrefixesLimit'] > 0) {
		$__finalCompiled .= '
		';
		$__vars['max_tokens'] = $__vars['forumPrefixesLimit'];
		$__finalCompiled .= '
	';
	}
	$__finalCompiled .= '

	';
	$__compilerTemp1 = array();
	if ($__vars['includeAny']) {
		$__compilerTemp1[] = array(
			'value' => '-1',
			'label' => $__templater->escape($__vars['anyLabel']),
			'_type' => 'option',
		);
	}
	if ($__vars['includeNone']) {
		$__compilerTemp1[] = array(
			'value' => '0',
			'label' => $__templater->escape($__vars['noneLabel']),
			'_type' => 'option',
		);
	}
	$__compilerTemp2 = $__templater->func('array_keys', array($__vars['prefixes'], ), false);
	if ($__templater->isTraversable($__compilerTemp2)) {
		foreach ($__compilerTemp2 AS $__vars['groupId']) {
			if ($__vars['groupId'] > 0) {
				$__compilerTemp1[] = array(
					'label' => $__templater->func('prefix_group', array($__vars['type'], $__vars['groupId'], ), false),
					'_type' => 'optgroup',
					'options' => array(),
				);
				end($__compilerTemp1); $__compilerTemp3 = key($__compilerTemp1);
				if ($__templater->isTraversable($__vars['prefixes'][$__vars['groupId']])) {
					foreach ($__vars['prefixes'][$__vars['groupId']] AS $__vars['prefixId'] => $__vars['prefix']) {
						$__compilerTemp1[$__compilerTemp3]['options'][] = array(
							'value' => $__vars['prefixId'],
							'label' => $__templater->func('prefix_title', array($__vars['type'], $__vars['prefixId'], ), true),
							'data-prefix-class' => $__vars['prefix']['css_class'],
							'_type' => 'option',
						);
					}
				}
			} else {
				if ($__templater->isTraversable($__vars['prefixes'][$__vars['groupId']])) {
					foreach ($__vars['prefixes'][$__vars['groupId']] AS $__vars['prefixId'] => $__vars['prefix']) {
						$__compilerTemp1[] = array(
							'value' => $__vars['prefixId'],
							'label' => $__templater->func('prefix_title', array($__vars['type'], $__vars['prefixId'], ), true),
							'data-prefix-class' => $__vars['prefix']['css_class'],
							'_type' => 'option',
						);
					}
				}
			}
		}
	}
	$__finalCompiled .= $__templater->formSelect(array(
		'name' => $__vars['name'],
		'value' => $__vars['selected'],
		'multiple' => $__vars['multiple'],
		'class' => $__vars['class'],
		'placeholder' => 'Prefix',
		'data-xf-init' => (($__vars['href'] AND $__vars['listenTo']) ? 'sv-multi-prefix-loader' : '') . ' sv-multi-prefix-menu',
		'data-href' => $__vars['href'],
		'data-listen-to' => $__vars['listenTo'],
		'data-min-tokens' => $__vars['min_tokens'],
		'data-max-tokens' => $__vars['max_tokens'],
	), $__compilerTemp1) . '
';
	return $__finalCompiled;
}
),
'row' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'prefixes' => '!',
		'type' => '!',
		'label' => 'Prefix',
		'explain' => '',
		'selected' => '',
		'name' => 'prefix_id',
		'anyLabel' => $__vars['xf']['language']['parenthesis_open'] . 'Any' . $__vars['xf']['language']['parenthesis_close'],
		'noneLabel' => $__vars['xf']['language']['parenthesis_open'] . 'No prefix' . $__vars['xf']['language']['parenthesis_close'],
		'multiple' => false,
		'includeAny' => false,
		'includeNone' => null,
		'class' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	' . $__templater->callMacro('sv_multiprefix_prefix_macros', 'setup', array(), $__vars) . '

    ';
	$__compilerTemp1 = '';
	if ($__vars['explain']) {
		$__compilerTemp1 .= '
            <div class="formRow-explain">' . $__templater->filter($__vars['explain'], array(array('raw', array()),), true) . '</div>
        ';
	}
	$__finalCompiled .= $__templater->formRow('
        ' . $__templater->callMacro(null, 'select', array(
		'prefixes' => $__vars['prefixes'],
		'type' => $__vars['type'],
		'label' => $__vars['label'],
		'explain' => $__vars['explain'],
		'selected' => $__vars['selected'],
		'name' => $__vars['name'],
		'anyLabel' => $__vars['anyLabel'],
		'noneLabel' => $__vars['noneLabel'],
		'multiple' => $__vars['multiple'],
		'includeAny' => $__vars['includeAny'],
		'includeNone' => $__vars['includeNone'],
		'class' => $__vars['class'],
	), $__vars) . '
        ' . $__compilerTemp1 . '
    ', array(
		'rowtype' => 'input',
		'label' => $__templater->escape($__vars['label']),
	)) . '
';
	return $__finalCompiled;
}
),
'render_prefix_filters' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'filters' => '!',
		'prefixes' => '!',
		'contentType' => '!',
		'entity' => '!',
		'container' => '!',
		'route' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__vars['appending'] = $__templater->preEscaped(trim($__templater->callMacro(null, 'render_separator', array(
		'entity' => $__vars['entity'],
		'format' => 'html',
	), $__vars)));
	$__compilerTemp1 = '';
	$__vars['i'] = 0;
	if ($__templater->isTraversable($__vars['prefixes'])) {
		foreach ($__vars['prefixes'] AS $__vars['prefixId'] => $__vars['prefixCss']) {
			$__vars['i']++;
			$__compilerTemp2 = '';
			if ($__vars['i'] > 1) {
				$__compilerTemp2 .= $__templater->filter($__vars['appending'], array(array('raw', array()),), true);
			}
			$__compilerTemp1 .= trim('
' . $__compilerTemp2);
			$__vars['linkParams'] = $__vars['filters'];
			$__vars['removeFilter'] = $__templater->func('in_array', array($__vars['prefixId'], $__vars['linkParams']['prefix_id'], true, ), false);
			$__vars['linkParams']['prefix_id'] = ($__vars['removeFilter'] ? $__templater->filter($__vars['linkParams']['prefix_id'], array(array('replaceValue', array($__vars['prefixId'], null, )),), false) : $__templater->filter($__vars['linkParams']['prefix_id'], array(array('addValue', array($__vars['prefixId'], )),), false));
			$__compilerTemp1 .= trim('
		' . '' . '
		' . '' . '
		' . '' . '
	') . trim('<a href="' . $__templater->func('link', array($__vars['route'], $__vars['container'], $__vars['linkParams'], ), true) . '" class="labelLink" data-xf-init="tooltip" title="' . $__templater->filter(($__vars['removeFilter'] ? 'Remove from filters' : 'Add to filters'), array(array('for_attr', array()),), true) . '"  rel="nofollow"><span class="' . $__templater->filter($__vars['prefixCss'], array(array('for_attr', array()),), true) . '" dir="auto">' . $__templater->func('prefix_title', array($__vars['contentType'], $__vars['prefixId'], ), true) . '</span></a>
');
		}
	}
	$__finalCompiled .= trim('
	' . '
	' . '' . '
	' . $__compilerTemp1 . '
');
	return $__finalCompiled;
}
),
'render_separator' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'entity' => '!',
		'format' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<span class="label-append">&nbsp;</span>
';
	return $__finalCompiled;
}
),
'render_prefix_html' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'prefixes' => '!',
		'contentType' => '!',
		'entity' => '!',
		'withLink' => false,
		'linkType' => '',
		'suffixPad' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = '';
	if ($__vars['appending'] === null) {
		$__compilerTemp1 .= '
		';
		$__vars['appending'] = $__templater->preEscaped(trim($__templater->callMacro(null, 'render_separator', array(
			'entity' => $__vars['entity'],
			'format' => 'html',
		), $__vars)));
		$__compilerTemp1 .= '
	';
	}
	$__compilerTemp2 = '';
	$__vars['i'] = 0;
	if ($__templater->isTraversable($__vars['prefixes'])) {
		foreach ($__vars['prefixes'] AS $__vars['prefixId'] => $__vars['prefixCss']) {
			$__vars['i']++;
			$__compilerTemp3 = '';
			if ($__vars['i'] > 1) {
				$__compilerTemp3 .= $__templater->filter($__vars['appending'], array(array('raw', array()),), true);
			}
			$__compilerTemp2 .= trim('
' . $__compilerTemp3);
			$__vars['prefixHtml'] = $__templater->preEscaped('<span class="' . $__templater->filter($__vars['prefixCss'], array(array('for_attr', array()),), true) . '" dir="auto">' . $__templater->func('prefix_title', array($__vars['contentType'], $__vars['prefixId'], ), true) . '</span>');
			$__compilerTemp4 = '';
			if ($__vars['withLink']) {
				$__compilerTemp4 .= '
			<a href="' . $__templater->filter($__templater->method($__vars['entity'], 'getSvPrefixFilterLink', array($__vars['prefixId'], $__vars['linkType'], )), array(array('for_attr', array()),), true) . '" class="labelLink" rel="nofollow">' . $__templater->escape($__vars['prefixHtml']) . '</a>
		';
			} else {
				$__compilerTemp4 .= '
			' . $__templater->escape($__vars['prefixHtml']) . '
		';
			}
			$__compilerTemp2 .= trim('
		' . '' . '
		' . $__compilerTemp4 . '
');
		}
	}
	$__compilerTemp5 = '';
	if ($__vars['suffixPad']) {
		$__compilerTemp5 .= $__templater->filter($__vars['appending'], array(array('raw', array()),), true);
	}
	$__finalCompiled .= trim('
	' . '
	' . $__compilerTemp1 . '
	' . $__compilerTemp2 . $__compilerTemp5 . '
');
	return $__finalCompiled;
}
),
'prefix_description' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'content' => '!',
		'contentType' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if (!$__templater->test($__vars['content']['sv_prefix_ids'], 'empty', array())) {
		$__finalCompiled .= '
		';
		if ($__templater->isTraversable($__vars['content']['sv_prefix_ids'])) {
			foreach ($__vars['content']['sv_prefix_ids'] AS $__vars['prefixId']) {
				$__finalCompiled .= '
			';
				$__compilerTemp1 = '';
				$__compilerTemp1 .= $__templater->func('prefix_description', array($__vars['contentType'], $__vars['prefixId'], ), true);
				if (strlen(trim($__compilerTemp1)) > 0) {
					$__finalCompiled .= '
				<div class="blockMessage blockMessage--alt blockMessage--small blockMessage--close prefix-description prefix' . $__templater->escape($__vars['prefixId']) . '">
					' . $__compilerTemp1 . '
				</div>
			';
				}
				$__finalCompiled .= '
		';
			}
		}
		$__finalCompiled .= '
	';
	}
	$__finalCompiled .= '
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

' . '

' . '


';
	return $__finalCompiled;
}
);