<?php
// FROM HASH: 7903632273cb9373f276e07804c35dc6
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Gift Upgrade: ' . $__templater->escape($__vars['user']['username']) . '');
	$__finalCompiled .= '

';
	$__templater->breadcrumb($__templater->preEscaped('Account upgrades'), $__templater->func('link', array('account/upgrades', ), false), array(
	));
	$__finalCompiled .= '

';
	$__templater->inlineCss('
    .accountType-title .priceContainer {
        font-size: ' . $__vars['xf']['options']['af_paidregistrations_priceFontSize'] . ';
    }
    .accountType {
        margin-left: ' . $__vars['xf']['options']['af_paidregistrations_box_margin'] . ';
        margin-right: ' . $__vars['xf']['options']['af_paidregistrations_box_margin'] . ';
    }
    @media (max-width: ' . $__templater->func('property', array('responsiveWide', ), false) . ')
    {
        .accountType {
            margin-left: auto;
            margin-right: auto;
        }
    }
');
	$__finalCompiled .= '

' . $__templater->callMacro('af_paidregistrations_accounttype_macros', 'account_types', array(
		'accountTypeRows' => $__vars['accountTypeRows'],
		'giftUser' => $__vars['user'],
	), $__vars);
	return $__finalCompiled;
}
);