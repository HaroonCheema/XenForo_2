<?php
// FROM HASH: 790f85c3c5e3d8666060d032a9900c68
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= 'You have a new invoice ' . (((('<a href="' . $__templater->func('link', array('ads-manager/invoices/pay', $__vars['content'], ), true)) . '" class="fauxBlockLink-blockLink">#') . $__templater->escape($__vars['content']['invoice_id'])) . '</a>') . ' of ' . $__templater->filter($__vars['content']['cost_amount'], array(array('currency', array($__vars['content']['cost_currency'], )),), true) . ' for your ad ' . (((('<a href="' . $__templater->func('link', array('ads-manager/ads/edit', $__vars['content']['Ad'], ), true)) . '">') . $__templater->escape($__vars['content']['Ad']['name'])) . '</a>') . '.';
	return $__finalCompiled;
}
);