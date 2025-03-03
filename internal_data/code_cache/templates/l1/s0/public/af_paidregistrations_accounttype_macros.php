<?php
// FROM HASH: 1545359b595e526a50c60de094dd2902
return array(
'macros' => array('account_types' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'accountTypeRows' => '!',
		'giftUser' => null,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
    ';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '
                ';
	if ($__templater->isTraversable($__vars['accountTypeRows'])) {
		foreach ($__vars['accountTypeRows'] AS $__vars['accountTypeRow']) {
			$__compilerTemp1 .= '
                    <div class="accountTypesRow">
                        ';
			if ($__templater->isTraversable($__vars['accountTypeRow'])) {
				foreach ($__vars['accountTypeRow'] AS $__vars['accountType']) {
					$__compilerTemp1 .= '
                            ' . $__templater->callMacro(null, 'account_type', array(
						'accountType' => $__vars['accountType'],
						'giftUser' => $__vars['giftUser'],
					), $__vars) . '
                        ';
				}
			}
			$__compilerTemp1 .= '
                    </div>
                ';
		}
	}
	$__compilerTemp1 .= '
            ';
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
        ';
		$__templater->setPageParam('head.' . 'afprGoogleFonts', $__templater->preEscaped('
            <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:400,700" />
        '));
		$__finalCompiled .= '

        ';
		$__templater->includeCss('af_paidregistrations_accounttype.less');
		$__finalCompiled .= '

        <div id="accountTypes">
            ' . $__compilerTemp1 . '
        </div>
    ';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'account_type' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'accountType' => '!',
		'giftUser' => null,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
    ';
	$__vars['id'] = $__vars['accountType']['account_type_id'];
	$__finalCompiled .= '
    <div class="accountType" data-id="' . $__templater->escape($__vars['id']) . '">
        <div class="accountType-inner">
            ';
	if ($__vars['accountType']['is_featured']) {
		$__finalCompiled .= '
                <div class="featured">' . 'Featured' . '</div>
            ';
	}
	$__finalCompiled .= '
            <div class="accountType-title">
                <h3>' . $__templater->escape($__vars['accountType']['title']) . '</h3>
                <div class="priceContainer ' . ($__vars['accountType']['allow_custom_amount'] ? 'customAmount' : '') . '">
                    <div class="price">
                        ' . ($__vars['accountType']['allow_custom_amount'] ? 'Custom Amount' : $__templater->escape($__vars['accountType']['cost'])) . '
                        <div class="duration">' . $__templater->escape($__vars['accountType']['length_phrase']) . '</div>
                    </div>
                </div>
            </div>
            <div class="accountType-content">
                <ul>
                    ';
	if ($__templater->isTraversable($__vars['accountType']['features_list'])) {
		foreach ($__vars['accountType']['features_list'] AS $__vars['feature']) {
			$__finalCompiled .= '
                        <li>' . $__templater->filter($__vars['feature'], array(array('raw', array()),), true) . '</li>
                    ';
		}
	}
	$__finalCompiled .= '
                </ul>
            </div>
            <div class="btn">
                ';
	if ($__vars['giftUser']) {
		$__finalCompiled .= '
                    <a href="' . $__templater->func('link', array('purchase/gift-upgrade', null, array('accountType' => $__vars['accountType']['account_type_id'], 'userId' => $__vars['giftUser']['user_id'], ), ), true) . '" data-xf-click="overlay">' . 'Gift Now' . '</a>
                ';
	} else if ($__vars['xf']['visitor']['user_id']) {
		$__finalCompiled .= '
                    <a href="' . $__templater->func('link', array('account/upgrade-payment-options', null, array('accountType' => $__vars['accountType']['account_type_id'], ), ), true) . '" data-xf-click="overlay">' . 'Upgrade Now' . '</a>
                ';
	} else {
		$__finalCompiled .= '
                    ';
		if ($__vars['accountType']['user_upgrade_id'] == -1) {
			$__finalCompiled .= '
                        <a href="' . $__templater->func('link', array('register', null, array('accountType' => $__vars['accountType']['account_type_id'], ), ), true) . '">' . 'Join Now' . '</a>
                    ';
		} else {
			$__finalCompiled .= '
                        <a href="' . $__templater->func('link', array('register/purchase', null, array('accountType' => $__vars['accountType']['account_type_id'], ), ), true) . '" data-xf-click="overlay">' . 'Join Now' . '</a>
                    ';
		}
		$__finalCompiled .= '
                ';
	}
	$__finalCompiled .= '
            </div>
        </div>
    </div>
    ';
	$__templater->inlineCss('
        .accountType[data-id="' . $__vars['id'] . '"] .accountType-title {
            background: ' . $__vars['accountType']['color'] . ';
        }
        .accountType[data-id="' . $__vars['id'] . '"] .accountType-title > h3 {
            background: ' . $__vars['accountType']['color_dark'] . ';
        }
        .accountType[data-id="' . $__vars['id'] . '"] .priceContainer {
            background: ' . $__vars['accountType']['color_dark'] . ';
        }
    ');
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

';
	return $__finalCompiled;
}
);