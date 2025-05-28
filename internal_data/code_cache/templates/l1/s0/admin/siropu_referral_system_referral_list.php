<?php
// FROM HASH: 18a55e5d5f66f3e87d2614ef8c78cc6f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Referrals');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('Add referral', array(
		'href' => $__templater->func('link', array('referral-system/referrals/add', ), false),
		'icon' => 'add',
		'data-xf-click' => 'overlay',
	), '', array(
	)) . '
');
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body block-row">
			' . $__templater->formTextBox(array(
		'name' => 'username',
		'placeholder' => 'Referrer' . $__vars['xf']['language']['ellipsis'],
		'type' => 'search',
		'value' => '',
		'data-xf-init' => 'auto-complete',
		'data-single' => 'true',
		'class' => 'input--inline',
	)) . '
			' . $__templater->button('Find referrals', array(
		'type' => 'submit',
		'icon' => 'search',
	), '', array(
	)) . '
		</div>
	</div>
', array(
		'action' => $__templater->func('link', array('referral-system/referrals', ), false),
		'class' => 'block',
	)) . '

';
	if (!$__templater->test($__vars['referrals'], 'empty', array())) {
		$__finalCompiled .= '
	<div class="block">
		<div class="block-container">
			<div class="block-body">
				';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['referrals'])) {
			foreach ($__vars['referrals'] AS $__vars['referral']) {
				$__compilerTemp1 .= '
						';
				$__vars['ip'] = $__templater->filter($__templater->method($__vars['referral'], 'getIp', array('register', )), array(array('ip', array()),), false);
				$__compilerTemp2 = '';
				if ($__vars['ip']) {
					$__compilerTemp2 .= '
									<a href="' . $__templater->func('link', array('users/ip-users', null, array('ip' => $__vars['ip'], ), ), true) . '" data-xf-click="overlay">' . $__templater->escape($__vars['ip']) . '</a>
								';
				} else {
					$__compilerTemp2 .= '
									' . 'N/A' . '
								';
				}
				$__compilerTemp1 .= $__templater->dataRow(array(
				), array(array(
					'_type' => 'cell',
					'html' => $__templater->func('username_link', array($__vars['referral'], true, array(
				))),
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->func('date_dynamic', array($__vars['referral']['register_date'], array(
				))),
				),
				array(
					'_type' => 'cell',
					'html' => '
								' . '' . '
								' . $__compilerTemp2 . '
							',
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->filter($__vars['referral']['message_count'], array(array('number', array()),), true),
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->func('username_link', array($__vars['referral']['SRS_Referrer'], true, array(
				))),
				),
				array(
					'href' => $__templater->func('link', array('referral-system/referrals/delete', $__vars['referral'], ), false),
					'_type' => 'delete',
					'html' => '',
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
			'html' => 'User',
		),
		array(
			'_type' => 'cell',
			'html' => 'Joined',
		),
		array(
			'_type' => 'cell',
			'html' => 'IP',
		),
		array(
			'_type' => 'cell',
			'html' => 'Messages',
		),
		array(
			'_type' => 'cell',
			'html' => 'Referrer',
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
				<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['referrals'], $__vars['total'], ), true) . '</span>
			</div>
		</div>
	</div>

	' . $__templater->func('page_nav', array(array(
			'page' => $__vars['page'],
			'total' => $__vars['total'],
			'params' => $__vars['linkParams'],
			'link' => 'referral-system/referrals',
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