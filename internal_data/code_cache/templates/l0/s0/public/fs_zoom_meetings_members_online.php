<?php
// FROM HASH: cddafb721bb8baedbf93e627b37d3c05
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
	if (!$__templater->test($__vars['online'], 'empty', array())) {
		$__finalCompiled .= '
					<ul class="listInline listInline--comma">
						';
		if ($__templater->isTraversable($__vars['online'])) {
			foreach ($__vars['online'] AS $__vars['val']) {
				$__compilerTemp1 = '';
				if ($__vars['val']['User']) {
					$__compilerTemp1 .= '
								<li>' . $__templater->func('username_link', array($__vars['val']['User'], true, array(
						'class' => ((!$__vars['val']['User']) ? 'username--invisible' : ''),
					))) . '</li>
								';
				} else {
					$__compilerTemp1 .= '
								<li>' . $__templater->escape($__vars['val']['username']) . '</li>
							';
				}
				$__finalCompiled .= trim('
							' . $__compilerTemp1 . '
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
			<span class="block-footer-counter">' . 'Total:&nbsp;' . $__templater->func('number', array($__vars['total'], ), true) . ' (members:&nbsp;' . $__templater->func('number', array($__vars['members'], ), true) . ', guests:&nbsp;' . $__templater->func('number', array($__vars['guests'], ), true) . ')' . '</span>
		</div>
	</div>
</div>';
	return $__finalCompiled;
}
);