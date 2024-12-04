<?php
// FROM HASH: 2dc0f85cf686b45b6d2482686ebe4e80
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('User Thread Credit');
	$__finalCompiled .= '
	<h3 class="block-minorHeader">' . 'Thread Credit History' . '</h3>
' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formTextBoxRow(array(
		'name' => 'username',
		'ac' => 'single',
	), array(
		'label' => 'Username',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'Filter',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('admin.1/edit#user-credit/manual', ), false),
		'ajax' => 'true',
		'class' => 'block',
	)) . '
';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('
	hwello
');
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['purchases'], 'empty', array())) {
		$__finalCompiled .= '
	<div class="block">
		<div class="block-container">
			<div class="block-body">
				';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['purchases'])) {
			foreach ($__vars['purchases'] AS $__vars['purchase']) {
				$__compilerTemp1 .= '
						';
				$__vars['purchaseRequest'] = $__vars['purchase']['PurchaseRequest'];
				$__compilerTemp1 .= '
						' . $__templater->dataRow(array(
				), array(array(
					'class' => 'dataList-cell--min dataList-cell--image dataList-cell--imageSmall',
					'_type' => 'cell',
					'html' => '
								' . $__templater->func('avatar', array($__vars['purchase']['User'], 'xs', false, array(
				))) . '
							',
				),
				array(
					'href' => $__templater->func('link', array('users/edit', $__vars['purchase']['User'], ), false),
					'label' => $__templater->func('username_link', array($__vars['purchase']['User'], true, array(
					'notooltip' => 'true',
					'href' => '',
				))),
					'hint' => '
									<ul class="listInline listInline--bullet" style="display: inline-block">
										<li>' . ($__vars['purchaseRequest'] ? ($__templater->escape($__vars['purchaseRequest']['PaymentProfile']['title']) ?: 'Unknown payment profile') : 'Manually granted') . '</li>
										<li>' . $__templater->func('date_dynamic', array($__vars['purchase']['purchased_at'], array(
				))) . '</li>
									</ul>
								',
					'_type' => 'main',
					'html' => '',
				))) . '
					';
			}
		}
		$__finalCompiled .= $__templater->dataList('
					' . $__compilerTemp1 . '
				', array(
		)) . '
			</div>
			<div class="block-footer">
				<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['purchases'], $__vars['total'], ), true) . '</span>
			</div>
		</div>
		' . $__templater->func('page_nav', array(array(
			'page' => $__vars['page'],
			'total' => $__vars['total'],
			'link' => 'thtc-credit-package/purchase-log',
			'data' => $__vars['creditPackage'],
			'params' => $__vars['linkParams'],
			'wrapperclass' => 'block-outer block-outer--after',
			'perPage' => $__vars['perPage'],
		))) . '
	</div>
';
	} else {
		$__finalCompiled .= '
	<div class="blockMessage">' . 'No entries have been logged.' . '</div>
';
	}
	return $__finalCompiled;
}
);