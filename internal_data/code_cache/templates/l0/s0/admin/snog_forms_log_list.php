<?php
// FROM HASH: 69a769fcba9cb5d9e369056598c5e4fb
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Form submit log');
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['entries'], 'empty', array())) {
		$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('
		' . 'Clear' . '
	', array(
			'href' => $__templater->func('link', array('logs/forms-logs/clear', ), false),
			'icon' => 'delete',
			'overlay' => 'true',
		), '', array(
		)) . '
');
	}
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['entries'], 'empty', array())) {
		$__finalCompiled .= '
	<div class="block" class="block">
		<div class="block-container">
			<div class="block-body">
				';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['entries'])) {
			foreach ($__vars['entries'] AS $__vars['entry']) {
				$__compilerTemp1 .= '
							';
				$__compilerTemp2 = '';
				if ($__vars['entry']['User']) {
					$__compilerTemp2 .= '
												' . $__templater->func('username_link', array($__vars['entry']['User'], false, array(
					))) . '
											';
				} else {
					$__compilerTemp2 .= '
												' . $__templater->filter($__vars['entry']['ip_address'], array(array('ip', array()),), true) . '
											';
				}
				$__compilerTemp1 .= $__templater->dataRow(array(
					'overlay' => 'true',
					'label' => ($__vars['entry']['Form'] ? $__templater->escape($__vars['entry']['Form']['position']) : 'Deleted form'),
					'href' => $__templater->func('link', array('logs/forms-logs', $__vars['entry'], ), false),
					'delete' => $__templater->func('link', array('logs/forms-logs/delete', $__vars['entry'], ), false),
					'dir' => 'auto',
					'explain' => '
									<ul class="listInline listInline--bullet">
										<li>' . $__templater->func('date_dynamic', array($__vars['entry']['log_date'], array(
				))) . '</li>
										<li>
											' . $__compilerTemp2 . '
										</li>
									</ul>
								',
				), array()) . '
						';
			}
		}
		$__finalCompiled .= $__templater->dataList('
					<tbody>
						' . $__compilerTemp1 . '
					</tbody>
				', array(
		)) . '
			</div>
			<div class="block-footer">
				<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['entries'], $__vars['total'], ), true) . '</span>
			</div>
		</div>

		<div class="block-outer block-outer--after">
			' . $__templater->func('page_nav', array(array(
			'page' => $__vars['page'],
			'total' => $__vars['total'],
			'link' => 'logs/forms-logs',
			'wrapperclass' => 'block-outer-opposite',
			'perPage' => $__vars['perPage'],
		))) . '
		</div>

	</div>
	';
	} else {
		$__finalCompiled .= '
	<div class="blockMessage">' . 'There is nothing to display.' . '</div>
';
	}
	return $__finalCompiled;
}
);