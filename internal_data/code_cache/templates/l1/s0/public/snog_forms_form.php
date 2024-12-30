<?php
// FROM HASH: 6fa02a3065fd287e83098fe70fa9045a
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

';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped($__templater->escape($__vars['form']['position']));
	$__finalCompiled .= '

';
	if (($__vars['forum'] AND $__vars['form']['threadapp']) OR $__vars['form']['quickreply']) {
		$__finalCompiled .= '
	';
		$__templater->setPageParam('section', 'forums');
		$__finalCompiled .= '
	';
		if (!$__vars['form']['quickreply']) {
			$__finalCompiled .= '
		';
			$__templater->breadcrumbs($__templater->method($__vars['forum'], 'getBreadcrumbs', array()));
			$__finalCompiled .= '
	';
		}
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
	';
		if ($__vars['form']['active'] AND ($__templater->func('empty', array($__vars['form']['Type'])) OR $__vars['form']['Type']['navtab'])) {
			$__finalCompiled .= '
		';
			$__templater->setPageParam('section', 'snog_forms_nav');
			$__finalCompiled .= '
	';
		}
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	$__templater->setPageParam('head.' . 'metaNoindex', $__templater->preEscaped('<meta name="robots" content="noindex" />'));
	$__finalCompiled .= '
';
	$__templater->setPageParam('head.' . 'metaNofollow', $__templater->preEscaped('<meta name="robots" content="nofollow" />'));
	$__finalCompiled .= '

';
	$__templater->pageParams['pageH1'] = $__templater->preEscaped($__templater->escape($__vars['form']['position']));
	$__finalCompiled .= '

' . $__templater->callMacro('snog_forms_macro', 'form', array(
		'form' => $__vars['form'],
		'warnings' => $__vars['warnings'],
		'questions' => $__vars['questions'],
		'conditionQuestions' => $__vars['conditionQuestions'],
		'canSubmit' => $__vars['canSubmit'],
		'replyThread' => $__vars['replythread'],
		'attachmentData' => $__vars['attachmentData'],
		'noupload' => $__vars['noupload'],
		'nodeTree' => $__vars['nodeTree'],
	), $__vars) . '

';
	$__templater->modifySidebarHtml('_xfWidgetPositionSidebar9b9fe5a323cb5d693cbf89c5f5c492da', $__templater->widgetPosition('snogFormSidebar', array()), 'replace');
	return $__finalCompiled;
}
);