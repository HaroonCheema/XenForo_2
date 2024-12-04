<?php
// FROM HASH: 89cba92f765e8404e9b3d586598a9d22
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('
	' . 'Gain access' . '
');
	$__finalCompiled .= '

<div class="block">
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formRow('
				' . 'You do not have sufficient credits to view \'' . $__templater->escape($__vars['thread']['title']) . '\'. You can do one of the following to view this thread:' . '
			', array(
	)) . '

			<h3 class="block-formSectionHeader">
				' . 'User upgrades' . '
			</h3>
			';
	if ($__templater->isTraversable($__vars['subscriptions'])) {
		foreach ($__vars['subscriptions'] AS $__vars['upgrade']) {
			$__finalCompiled .= '
				';
			$__compilerTemp1 = '';
			if (($__templater->func('count', array($__vars['upgrade']['payment_profile_ids'], ), false) > 1)) {
				$__compilerTemp1 .= '
								';
				$__compilerTemp2 = array(array(
					'label' => $__vars['xf']['language']['parenthesis_open'] . 'Choose a payment method' . $__vars['xf']['language']['parenthesis_close'],
					'_type' => 'option',
				));
				if ($__templater->isTraversable($__vars['upgrade']['payment_profile_ids'])) {
					foreach ($__vars['upgrade']['payment_profile_ids'] AS $__vars['profileId']) {
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

								' . $__templater->formHiddenVal('payment_profile_id', $__templater->filter($__vars['upgrade']['payment_profile_ids'], array(array('first', array()),), false), array(
				)) . '
							';
			}
			$__finalCompiled .= $__templater->formRow('

					' . $__templater->form('
						<div class="inputGroup">
							' . $__compilerTemp1 . '
						</div>
						<div class="js-paymentProviderReply-user_upgrade' . $__templater->escape($__vars['upgrade']['user_upgrade_id']) . '"></div>
					', array(
				'action' => $__templater->func('link', array('purchase', $__vars['upgrade'], array('user_upgrade_id' => $__vars['upgrade']['user_upgrade_id'], ), ), false),
				'ajax' => 'true',
				'data-xf-init' => 'payment-provider-container',
			)) . '

				', array(
				'rowtype' => 'button',
				'label' => $__templater->escape($__vars['upgrade']['title']),
				'hint' => $__templater->escape($__vars['upgrade']['cost_phrase']),
				'explain' => $__templater->filter($__vars['upgrade']['description'], array(array('raw', array()),), true),
			)) . '
			';
		}
	}
	$__finalCompiled .= '

			<h3 class="block-formSectionHeader">
				' . 'Credit packages' . '
			</h3>
			';
	if ($__templater->isTraversable($__vars['creditPackages'])) {
		foreach ($__vars['creditPackages'] AS $__vars['creditPackage']) {
			$__finalCompiled .= '
				';
			$__compilerTemp3 = '';
			if (($__templater->func('count', array($__vars['creditPackage']['payment_profile_ids'], ), false) > 1)) {
				$__compilerTemp3 .= '
								';
				$__compilerTemp4 = array(array(
					'label' => $__vars['xf']['language']['parenthesis_open'] . 'Choose a payment method' . $__vars['xf']['language']['parenthesis_close'],
					'_type' => 'option',
				));
				if ($__templater->isTraversable($__vars['creditPackage']['payment_profile_ids'])) {
					foreach ($__vars['creditPackage']['payment_profile_ids'] AS $__vars['profileId']) {
						if ($__vars['profiles'][$__vars['profileId']]) {
							$__compilerTemp4[] = array(
								'value' => $__vars['profileId'],
								'label' => $__templater->escape($__vars['profiles'][$__vars['profileId']]),
								'_type' => 'option',
							);
						}
					}
				}
				$__compilerTemp3 .= $__templater->formSelect(array(
					'name' => 'payment_profile_id',
				), $__compilerTemp4) . '

								<span class="inputGroup-splitter"></span>

								' . $__templater->button('', array(
					'type' => 'submit',
					'icon' => 'purchase',
				), '', array(
				)) . '
								';
			} else {
				$__compilerTemp3 .= '
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
							' . $__compilerTemp3 . '
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

				<h3 class="block-formSectionHeader">
					' . 'Post on the forum' . '
				</h3>

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
</div>';
	return $__finalCompiled;
}
);