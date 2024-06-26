<?php
// FROM HASH: 7bc82582c20caad68f72926f6c1c9f9f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Search');
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">

		<div class="block-body">
			' . $__templater->includeTemplate('fs_search_form_post', $__vars) . '
		</div>

		' . $__templater->formSubmitRow(array(
		'icon' => 'search',
		'sticky' => 'true',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('search-own-thread/save', $__vars['data'], ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);