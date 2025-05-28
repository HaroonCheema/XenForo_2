<?php
// FROM HASH: 1dc825ea765b321c7724a11622e549a8
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Referrer log');
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['entries'], 'empty', array())) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageAction'] = $__templater->preEscaped('
		' . $__templater->button('Clear log', array(
			'href' => $__templater->func('link', array('referral-system/referrer-log/clear', ), false),
			'overlay' => 'true',
			'icon' => 'delete',
		), '', array(
		)) . '
	');
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body block-row">
			' . $__templater->formTextBox(array(
		'name' => 'referrer',
		'placeholder' => 'Referrer' . $__vars['xf']['language']['ellipsis'],
		'type' => 'search',
		'value' => $__vars['linkParams']['referrer'],
		'data-xf-init' => 'auto-complete',
		'data-single' => 'true',
		'class' => 'input--inline',
	)) . '
			' . $__templater->button('Find', array(
		'type' => 'submit',
	), '', array(
	)) . '
		</div>
	</div>
', array(
		'action' => $__templater->func('link', array('referral-system/referrer-log', ), false),
		'class' => 'block',
	)) . '

';
	if (!$__templater->test($__vars['entries'], 'empty', array())) {
		$__finalCompiled .= '
	<div class="block">
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
									' . $__templater->func('username_link', array($__vars['entry']['User'], true, array(
					))) . '
								';
				} else {
					$__compilerTemp2 .= '
									' . 'N/A' . '
								';
				}
				$__compilerTemp1 .= $__templater->dataRow(array(
					'delete' => $__templater->func('link', array('referral-system/referrer-log/delete', $__vars['entry'], ), false),
				), array(array(
					'_type' => 'cell',
					'html' => $__templater->func('date_dynamic', array($__vars['entry']['date'], array(
				))),
				),
				array(
					'_type' => 'cell',
					'html' => '
								' . $__compilerTemp2 . '
							',
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['entry']['url']),
				))) . '
					';
			}
		}
		$__finalCompiled .= $__templater->dataList('
					<thead>
						' . $__templater->dataRow(array(
			'rowtype' => 'header',
		), array(array(
			'_type' => 'cell',
			'html' => 'Date',
		),
		array(
			'_type' => 'cell',
			'html' => 'Referrer username',
		),
		array(
			'_type' => 'cell',
			'html' => 'Referrer URL',
		),
		array(
			'_type' => 'cell',
			'html' => '',
		))) . '
					</thead>
					' . $__compilerTemp1 . '
				', array(
			'data-xf-init' => 'responsive-data-list',
		)) . '
			</div>
			<div class="block-footer">
				<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['entries'], $__vars['total'], ), true) . '</span>
			</div>
		</div>
	</div>

	' . $__templater->func('page_nav', array(array(
			'page' => $__vars['page'],
			'total' => $__vars['total'],
			'params' => $__vars['linkParams'],
			'link' => 'referral-system/referrer-log',
			'wrapperclass' => 'block-outer block-outer--after',
			'perPage' => $__vars['perPage'],
		))) . '
';
	} else {
		$__finalCompiled .= '
	<div class="blockMessage">' . 'No entries have been logged.' . '</div>
';
	}
	return $__finalCompiled;
}
);