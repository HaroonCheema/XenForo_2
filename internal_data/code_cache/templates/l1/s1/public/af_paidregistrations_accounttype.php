<?php
// FROM HASH: f6281458889e8699485a82af829e5d69
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Choose ' . 'Account Type');
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

    .accountTypesOverlay
    {
        max-width: calc(100% - 20px);
    }
');
	$__finalCompiled .= '

';
	$__templater->inlineJs('
!function($, window, document)
{
    "use strict";

    var $modal = $(\'.overlay-container #accountTypes\');

    if ($modal.length)
    {
        $modal.closest(\'.overlay\').addClass(\'accountTypesOverlay\');
    }
}
(jQuery, window, document);
');
	$__finalCompiled .= '

' . $__templater->callMacro('af_paidregistrations_accounttype_macros', 'account_types', array(
		'accountTypeRows' => $__vars['accountTypeRows'],
	), $__vars);
	return $__finalCompiled;
}
);