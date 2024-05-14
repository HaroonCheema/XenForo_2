<?php
// FROM HASH: dbc92f0e9864138319b481eba3a71102
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit Ad' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['locationName']));
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">

			' . $__templater->formHiddenVal('template_title', $__vars['adTemplate']['title'], array(
	)) . '
			
			' . $__templater->formTextAreaRow(array(
		'name' => 'template_code',
		'value' => $__vars['adTemplate']['template'],
		'autosize' => 'true',
		'rows' => '10',
		'explaine' => 'bh_ad_code_explain',
	), array(
		'label' => 'Ad Code',
	)) . '
			
		</div>

		' . $__templater->formSubmitRow(array(
		'sticky' => 'true',
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('bh-ads/save', ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);