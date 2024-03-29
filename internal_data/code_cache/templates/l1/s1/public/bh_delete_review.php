<?php
// FROM HASH: 58bd22c2a03426e2a2fe810e1940c3f1
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Delete review');
	$__finalCompiled .= '

';
	$__templater->breadcrumbs($__templater->method($__vars['item'], 'getBreadcrumbs', array()));
	$__finalCompiled .= '

';
	$__templater->includeJs(array(
		'src' => 'xf/thread.js',
		'min' => '1',
	));
	$__finalCompiled .= '
' . $__templater->form('
	
	<div class="block-container">
		<div class="block-body">
			' . $__templater->callMacro('helper_action', 'delete_type', array(
		'canHardDelete' => $__templater->method($__vars['review'], 'canDelete', array('hard', )),
	), $__vars) . '

			' . '
		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'delete',
		'sticky' => 'true',
	), array(
	)) . '
	</div>
	' . $__templater->func('redirect_input', array(null, null, true)) . '
', array(
		'action' => $__templater->func('link', array($__vars['route'] . '/delete', $__vars['review'], ), false),
		'class' => 'block',
		'ajax' => 'true',
		'data-xf-init' => 'thread-edit-form',
		'data-item-selector' => '.js-itemReview-' . $__vars['item']['item_id'] . ($__vars['review'] ? ('-' . $__vars['review']->{'item_rating_id'}) : ''),
	));
	return $__finalCompiled;
}
);