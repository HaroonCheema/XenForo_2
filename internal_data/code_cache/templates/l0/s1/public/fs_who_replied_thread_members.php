<?php
// FROM HASH: ed56d5fd26db93d7f66af567fb306db0
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="block" data-widget-section="onlineNow"' . $__templater->func('widget_data', array($__vars['widget'], ), true) . '>
	<div class="block-container">
		<h3 class="block-minorHeader"><a href="#">' . $__templater->escape($__vars['title']) . '</a></h3>
		<div class="block-body">
			<div class="block-row block-row--minor">
				';
	if (!$__templater->test($__vars['thread'], 'empty', array())) {
		$__finalCompiled .= '
					<ul class="listInline listInline--comma">
						' . trim('
							<li>' . $__templater->func('username_link', array($__vars['thread']['User'], true, array(
			'class' => '',
			'style' => 'color: ' . $__vars['xf']['options']['fs_who_replied_thread_starter_color'] . '; font-weight: bold;',
		))) . '</li>
							') . '
						';
		if ($__templater->isTraversable($__vars['users'])) {
			foreach ($__vars['users'] AS $__vars['user']) {
				$__finalCompiled .= trim('
							<li>' . $__templater->func('username_link', array($__vars['user'], true, array(
					'class' => '',
				))) . '</li>
							');
			}
		}
		$__finalCompiled .= '
					</ul>
					';
	} else {
		$__finalCompiled .= '
					' . 'No members online now.' . '
				';
	}
	$__finalCompiled .= '
			</div>
		</div>
		<div class="block-footer">
			<span class="block-footer-counter">' . 'Total:&nbsp;' . $__templater->func('number', array($__vars['total'], ), true) . ' ' . '</span>
		</div>
	</div>
</div>';
	return $__finalCompiled;
}
);