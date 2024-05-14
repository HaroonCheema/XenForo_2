<?php
// FROM HASH: 00ef2663fc11192fa6a4dd4d82c0d997
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Rebuild Review / Rating Stats');
	$__finalCompiled .= '

';
	if (!$__vars['success']) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageAction'] = $__templater->preEscaped('
		' . $__templater->button('<i class="fas fa-sync"></i> ' . 'Rebuild Stats', array(
			'href' => $__templater->func('link', array('bh-rebuild-reviews/rebuild-stats', ), false),
		), '', array(
		)) . '
	');
		$__finalCompiled .= '
	
	<div class="blockMessage blockMessage--important blockMessage--iconic">
		' . 'If you import reviews or notice any inaccuracies in review/rating statistics, please rebuild the review stats.' . '
	</div>
';
	} else {
		$__finalCompiled .= '
	<div class="blockMessage blockMessage--success blockMessage--iconic">
		' . $__templater->formInfoRow($__templater->escape($__vars['message']), array(
			'rowtype' => 'confirm',
		)) . '
	</div>
';
	}
	return $__finalCompiled;
}
);