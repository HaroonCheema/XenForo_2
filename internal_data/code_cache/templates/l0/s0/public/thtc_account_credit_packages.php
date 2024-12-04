<?php
// FROM HASH: 67de6f30e87e5d163ae688b116987510
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('
	' . 'Credit packages' . '
');
	$__finalCompiled .= '

';
	$__vars['pageSelected'] = 'thtc_credit_packages';
	$__finalCompiled .= '
';
	$__templater->wrapTemplate('account_wrapper', $__vars);
	$__finalCompiled .= '

<div class="blockMessage blockMessage--important blockMessage--iconic">
	' . 'Your remaining credits:' . ' <strong>' . $__templater->escape($__vars['xf']['visitor']['thtc_credits_cache']) . '</strong>
</div>

';
	if (!$__templater->test($__vars['available'], 'empty', array())) {
		$__finalCompiled .= '
	<div class="block">
		<div class="block-container">
			<h2 class="block-header">' . 'Available credit packages' . '</h2>

			<div class="block-body">
				';
		if ($__templater->isTraversable($__vars['available'])) {
			foreach ($__vars['available'] AS $__vars['creditPackage']) {
				$__finalCompiled .= '
					';
				$__compilerTemp1 = '';
				if (($__templater->func('count', array($__vars['creditPackage']['payment_profile_ids'], ), false) > 1)) {
					$__compilerTemp1 .= '
									';
					$__compilerTemp2 = array(array(
						'label' => $__vars['xf']['language']['parenthesis_open'] . 'Choose a payment method' . $__vars['xf']['language']['parenthesis_close'],
						'_type' => 'option',
					));
					if ($__templater->isTraversable($__vars['creditPackage']['payment_profile_ids'])) {
						foreach ($__vars['creditPackage']['payment_profile_ids'] AS $__vars['profileId']) {
							if ($__vars['profiles'][$__vars['profileId']]) {
								$__compilerTemp2[] = array(
									'value' => $__vars['profileId'],
									'label' => $__templater->escape($__vars['profiles'][$__vars['profileId']]),
									'_type' => 'option',
								);
							}
						}
					}
					$__compilerTemp1 .= $__templater->formSelect(array(
						'name' => 'payment_profile_id',
					), $__compilerTemp2) . '

									<span class="inputGroup-splitter"></span>

									' . $__templater->button('', array(
						'type' => 'submit',
						'icon' => 'purchase',
					), '', array(
					)) . '
									';
				} else {
					$__compilerTemp1 .= '
									' . $__templater->button('', array(
						'type' => 'submit',
						'icon' => 'purchase',
					), '', array(
					)) . '

									' . $__templater->formHiddenVal('payment_profile_id', $__templater->filter($__vars['creditPackage']['payment_profile_ids'], array(array('first', array()),), false), array(
					)) . '
								';
				}
				$__finalCompiled .= $__templater->formRow('

						' . $__templater->form('
							<div class="inputGroup">
								' . $__compilerTemp1 . '
							</div>
							<div class="js-paymentProviderReply-credit_package' . $__templater->escape($__vars['creditPackage']['credit_package_id']) . '"></div>
						', array(
					'action' => $__templater->func('link', array('purchase', $__vars['creditPackage'], array('credit_package_id' => $__vars['creditPackage']['credit_package_id'], ), ), false),
					'ajax' => 'true',
					'data-xf-init' => 'payment-provider-container',
				)) . '

					', array(
					'rowtype' => 'button',
					'label' => $__templater->escape($__vars['creditPackage']['title']),
					'hint' => '' . $__templater->escape($__vars['creditPackage']['credits']) . ' credits' . ' - ' . $__templater->escape($__vars['creditPackage']['cost_phrase']),
					'explain' => $__templater->filter($__vars['creditPackage']['description'], array(array('raw', array()),), true),
				)) . '
				';
			}
		}
		$__finalCompiled .= '

				';
		if ($__vars['xf']['options']['thtc_newPostNodeId'] AND $__vars['xf']['options']['thtc_newThreadCreditPackage']) {
			$__finalCompiled .= '
					<hr class="formRowSep">

					' . $__templater->formRow('
						' . $__templater->button('
							' . 'Post thread' . '
						', array(
				'type' => 'submit',
				'href' => $__templater->func('link', array('forums/post-thread', array('node_id' => $__vars['xf']['options']['thtc_newPostNodeId'], ), ), false),
				'icon' => 'write',
			), '', array(
			)) . '
					', array(
				'rowtype' => 'button',
				'label' => 'Post on the forum',
				'explain' => 'Submit a thread for review. If it\'s approved, you\'ll receive credits in return.',
			)) . '
				';
		}
		$__finalCompiled .= '
			</div>
		</div>
	</div>
';
	}
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['purchases'], 'empty', array())) {
		$__finalCompiled .= '
	<div class="block">
		<div class="block-container">
			<h2 class="block-header">' . 'Purchased credit packages' . '</h2>
			<div class="block-body">
				';
		$__compilerTemp3 = '';
		if ($__templater->isTraversable($__vars['purchases'])) {
			foreach ($__vars['purchases'] AS $__vars['purchase']) {
				$__compilerTemp3 .= '
						';
				$__vars['purchaseRequest'] = $__vars['purchase']['PurchaseRequest'];
				$__compilerTemp3 .= '
						';
				$__compilerTemp4 = '';
				if ($__vars['purchase']['expires_at']) {
					$__compilerTemp4 .= '
									';
					if ($__vars['purchase']['expires_at'] < $__vars['xf']['time']) {
						$__compilerTemp4 .= '
										' . $__templater->func('date_dynamic', array($__vars['purchase']['expires_at'], array(
						))) . '
										';
					} else {
						$__compilerTemp4 .= '
										' . 'Expired' . '
									';
					}
					$__compilerTemp4 .= '
									';
				} else {
					$__compilerTemp4 .= '
									' . 'Never' . '
								';
				}
				$__compilerTemp3 .= $__templater->dataRow(array(
				), array(array(
					'_type' => 'cell',
					'html' => ($__templater->escape($__vars['purchase']['CreditPackage']['title']) ?: 'N/A'),
				),
				array(
					'_type' => 'cell',
					'html' => '
								' . $__templater->func('date_dynamic', array($__vars['purchase']['purchased_at'], array(
				))) . '
							',
				),
				array(
					'_type' => 'cell',
					'html' => '
								' . $__templater->escape($__vars['purchase']['remaining_credits']) . ' / ' . $__templater->escape($__vars['purchase']['total_credits']) . '
							',
				),
				array(
					'_type' => 'cell',
					'html' => '
								' . $__compilerTemp4 . '
							',
				))) . '
					';
			}
		}
		$__finalCompiled .= $__templater->dataList('
					' . $__templater->dataRow(array(
			'rowtype' => 'subsection',
		), array(array(
			'_type' => 'cell',
			'html' => '
							' . 'Credit package' . '
						',
		),
		array(
			'_type' => 'cell',
			'html' => '
							' . 'Purchase date' . '
						',
		),
		array(
			'_type' => 'cell',
			'html' => '
							' . 'Remaining credits' . '
						',
		),
		array(
			'_type' => 'cell',
			'html' => '
							' . 'Expiration date' . '
						',
		))) . '
					' . $__compilerTemp3 . '
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
			'link' => 'account/thtc-credit-packages',
			'params' => $__vars['linkParams'],
			'wrapperclass' => 'block-outer block-outer--after',
			'perPage' => $__vars['perPage'],
		))) . '
	</div>
';
	}
	return $__finalCompiled;
}
);