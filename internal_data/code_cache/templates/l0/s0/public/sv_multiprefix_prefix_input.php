<?php
// FROM HASH: 07013393c6240974f61a584d92b08aab
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = '';
	if ($__vars['rows']) {
		$__compilerTemp1 .= '
		<textarea rows="' . $__templater->escape($__vars['rows']) . '" name="' . $__templater->escape($__vars['textboxName']) . '"
                  data-xf-init="textarea-handler ' . $__templater->escape($__vars['xfInit']) . '" data-single-line="true"
                  class="input js-titleInput ' . $__templater->escape($__vars['textboxClass']) . '"
                  autocomplete="off"
                  ' . $__templater->filter($__vars['attrsHtml'], array(array('raw', array()),), true) . '>' . $__templater->escape($__vars['textboxValue']) . '</textarea>
	';
	} else {
		$__compilerTemp1 .= '
        <input type="text" name="' . $__templater->escape($__vars['textboxName']) . '"
               data-xf-init="' . $__templater->escape($__vars['xfInit']) . '"
               class="input js-titleInput ' . $__templater->escape($__vars['textboxClass']) . '"
               value="' . $__templater->escape($__vars['textboxValue']) . '"
               autocomplete="off"
               ' . $__templater->filter($__vars['attrsHtml'], array(array('raw', array()),), true) . '/>
    ';
	}
	$__vars['textbox'] = $__templater->preEscaped('
    ' . $__compilerTemp1 . '
');
	$__finalCompiled .= '
';
	$__vars['selectbox'] = $__templater->preEscaped('
	' . $__templater->callMacro('sv_multiprefix_prefix_macros', 'select', array(
		'name' => $__vars['prefixName'],
		'multiple' => true,
		'includeNone' => false,
		'includeAny' => false,
		'prefixes' => $__vars['prefixes'],
		'selected' => $__vars['prefixValue'],
		'type' => $__vars['prefixType'],
		'class' => 'js-prefixSelect u-noJsOnly',
		'contentParent' => $__vars['prefixContentParent'],
		'content' => $__vars['prefixContent'],
		'listenTo' => $__vars['listenTo'],
		'href' => $__vars['href'],
	), $__vars) . '
');
	$__finalCompiled .= '

';
	if ($__vars['prefixes'] OR $__vars['href']) {
		$__finalCompiled .= '
	';
		if ($__vars['excludeRow'] !== 'prefix') {
			$__finalCompiled .= '
		<div class="prefixContainer">
			' . $__templater->filter($__vars['selectbox'], array(array('raw', array()),), true) . '
		</div>
	';
		}
		$__finalCompiled .= '

	';
		if ($__vars['excludeRow'] !== 'title') {
			$__finalCompiled .= '
		<div class="inputGroup">
			' . $__templater->filter($__vars['textbox'], array(array('raw', array()),), true) . '
		</div>
	';
		}
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
    ';
		if ($__vars['excludeRow'] !== 'title') {
			$__finalCompiled .= '
		' . $__templater->filter($__vars['textbox'], array(array('raw', array()),), true) . '
	';
		}
		$__finalCompiled .= '
';
	}
	return $__finalCompiled;
}
);