<?php
// FROM HASH: 07de98cc6f4ff07736512f1993c13d02
return array(
'macros' => array('xgtForumIstatistikleri' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'template' => '!',
		'position' => '!',
		'location' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '	
		' . ($__vars['xf']['xengentrForumIstatistikleriForumIstatistikRepo'] ? $__templater->filter($__templater->method($__vars['xf']['xengentrForumIstatistikleriForumIstatistikRepo'], 'renderForumIstatistikleri', array()), array(array('raw', array()),), true) : null) . '
	';
	return $__finalCompiled;
}
),
'xgt_istatistik_konum' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'template' => '!',
		'position' => '!',
		'location' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__vars['templateName'] = $__vars['template'];
	$__finalCompiled .= '
	';
	$__vars['position'] = $__vars['position'];
	$__finalCompiled .= '
	';
	$__vars['location'] = $__vars['location'];
	$__finalCompiled .= ' 
	';
	if (($__templater->func('property', array('xgt_Forumistatik_konumlari', ), false) == 'kendikonumum') AND ($__vars['location'] == 'kendikonumum')) {
		$__finalCompiled .= '
		<!-- Kendi konumum tum sayfalarda -->
		';
		if ($__vars['xf']['options']['xgtForumistatik_konumu_tumsayfalarda']) {
			$__finalCompiled .= '
			' . $__templater->callMacro(null, 'xgtForumIstatistikleri', array(
				'template' => $__vars['templateName'],
				'position' => $__vars['position'],
				'location' => $__vars['location'],
			), $__vars) . '
		';
		} else if ($__vars['xf']['reply']['template'] == 'forum_list') {
			$__finalCompiled .= '
			' . $__templater->callMacro(null, 'xgtForumIstatistikleri', array(
				'template' => $__vars['templateName'],
				'position' => $__vars['position'],
				'location' => $__vars['location'],
			), $__vars) . '
		';
		}
		$__finalCompiled .= '
	';
	}
	$__finalCompiled .= '	
	';
	if (($__templater->func('property', array('xgt_Forumistatik_konumlari', ), false) == 'iceriklerustu') AND ($__vars['location'] == 'iceriklerustu')) {
		$__finalCompiled .= '
		<!-- İceriklerin üzerinde -->
		';
		if ($__vars['xf']['options']['xgtForumistatik_konumu_tumsayfalarda']) {
			$__finalCompiled .= '
			' . $__templater->callMacro(null, 'xgtForumIstatistikleri', array(
				'template' => $__vars['templateName'],
				'position' => $__vars['position'],
				'location' => $__vars['location'],
			), $__vars) . '
		';
		} else if ($__vars['xf']['reply']['template'] == 'forum_list') {
			$__finalCompiled .= '
			' . $__templater->callMacro(null, 'xgtForumIstatistikleri', array(
				'template' => $__vars['templateName'],
				'position' => $__vars['position'],
				'location' => $__vars['location'],
			), $__vars) . '
		';
		}
		$__finalCompiled .= '	
	';
	}
	$__finalCompiled .= ' 
	';
	if (($__templater->func('property', array('xgt_Forumistatik_konumlari', ), false) == 'forumlarustu') AND ($__vars['location'] == 'forumlarustu')) {
		$__finalCompiled .= '
		<!-- Forumlar üstü -->
		' . $__templater->callMacro(null, 'xgtForumIstatistikleri', array(
			'template' => $__vars['templateName'],
			'position' => $__vars['position'],
			'location' => $__vars['location'],
		), $__vars) . '
	';
	}
	$__finalCompiled .= ' 
	';
	if (($__templater->func('property', array('xgt_Forumistatik_konumlari', ), false) == 'forumlaralti') AND ($__vars['location'] == 'forumlaralti')) {
		$__finalCompiled .= '
		<!-- Forumlar altı -->
		' . $__templater->callMacro(null, 'xgtForumIstatistikleri', array(
			'template' => $__vars['templateName'],
			'position' => $__vars['position'],
			'location' => $__vars['location'],
		), $__vars) . '
	';
	}
	$__finalCompiled .= '
	';
	if (($__templater->func('property', array('xgt_Forumistatik_konumlari', ), false) == 'breadcrumbsustu') AND (($__vars['location'] == 'breadcrumbsustu') AND ($__vars['template'] == 'forum_list'))) {
		$__finalCompiled .= '
		<!-- Breadcrumbsustu üstü -->
		' . $__templater->callMacro(null, 'xgtForumIstatistikleri', array(
			'template' => $__vars['templateName'],
			'position' => $__vars['position'],
			'location' => $__vars['location'],
		), $__vars) . '
	';
	}
	$__finalCompiled .= ' 
	';
	if (($__templater->func('property', array('xgt_Forumistatik_konumlari', ), false) == 'breadcrumbsalt') AND (($__vars['location'] == 'breadcrumbsalt') AND ($__vars['template'] == 'forum_list'))) {
		$__finalCompiled .= '
		<!-- Breadcrumbsustu altı -->
		' . $__templater->callMacro(null, 'xgtForumIstatistikleri', array(
			'template' => $__vars['templateName'],
			'position' => $__vars['position'],
			'location' => $__vars['location'],
		), $__vars) . '
	';
	}
	$__finalCompiled .= ' 
	' . '	
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';

	return $__finalCompiled;
}
);