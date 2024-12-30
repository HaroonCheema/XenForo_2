<?php
// FROM HASH: da8fe09e3fa40a9c9ba56ed9b974abbf
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->includeJs(array(
		'src' => 'xf/prefix_menu.js',
		'min' => '1',
	));
	$__finalCompiled .= '
';
	$__templater->includeCss('prefix_menu.less');
	$__finalCompiled .= '
<script src="' . $__templater->func('js_url', array('vendor/jquery/jquery-3.3.1.min.js', ), true) . '"></script>

<div class="block"' . $__templater->func('widget_data', array($__vars['widget'], ), true) . '>
	<div class="block-container">
		<h3 class="block-minorHeader">
			<a href="' . $__templater->escape($__vars['link']) . '" rel="nofollow">' . $__templater->escape($__vars['title']) . '</a>
		</h3>
		<div class="block-body">
			' . $__templater->callMacro('snog_forms_macro', 'form', array(
		'form' => $__vars['form'],
		'warnings' => $__vars['warnings'],
		'questions' => $__vars['questions'],
		'conditionQuestions' => $__vars['conditionQuestions'],
		'expected' => $__vars['expected'],
		'canSubmit' => $__vars['canSubmit'],
		'replyThread' => $__vars['replythread'],
		'attachmentData' => $__vars['attachmentData'],
		'noupload' => $__vars['noupload'],
		'row' => $__vars['row'],
		'nodeTree' => $__vars['nodeTree'],
	), $__vars) . '
		</div>
	</div>
</div>';
	return $__finalCompiled;
}
);