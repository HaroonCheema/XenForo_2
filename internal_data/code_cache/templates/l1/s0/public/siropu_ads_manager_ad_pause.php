<?php
// FROM HASH: 19a235d3cda5563dfa7ccc28b278868f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Pause ad' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['ad']['name']));
	$__finalCompiled .= '

';
	$__vars['maxPauseLength'] = $__templater->method($__vars['xf']['visitor'], 'canPauseAdsSiropuAdsManager', array());
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formInfoRow('
				' . 'This option allows you to pause your ad if your website is down for maintenance or having technichal dificulties and don\'t want to send traffic during that time.' . '
			', array(
		'rowtype' => 'confirm',
	)) . '
			' . $__templater->formNumberBoxRow(array(
		'name' => 'length',
		'min' => '1',
		'max' => (($__vars['maxPauseLength'] > 0) ? $__vars['maxPauseLength'] : ''),
		'units' => 'Hours',
	), array(
		'label' => 'Pause length',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'submit' => 'Pause',
	), array(
		'rowtype' => 'simple',
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('ads-manager/ads/pause', $__vars['ad'], ), false),
		'class' => 'block',
	));
	return $__finalCompiled;
}
);