<?php
// FROM HASH: 418a938c7875380d6b8c0d4cfe560146
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->method($__vars['coupon'], 'isInsert', array())) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Add coupon');
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit coupon' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['coupon']['title']));
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['coupon'], 'isUpdate', array())) {
		$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('', array(
			'href' => $__templater->func('link', array('thmonetize-coupons/delete', $__vars['coupon'], ), false),
			'icon' => 'delete',
			'overlay' => 'true',
		), '', array(
		)) . '
');
	}
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<h2 class="block-tabHeader tabs hScroller" data-xf-init="tabs h-scroller" role="tablist">
            <span class="hScroller-scroll">
                <a class="tabs-tab is-active" role="tab" aria-controls="thmonetize-coupons-options">' . 'Coupon options' . '</a>
                ' . $__templater->callMacro('helper_criteria', 'user_tabs', array(), $__vars) . '
            </span>
        </h2>
		
		<ul class="tabPanes block-body">
            <li class="is-active" role="tabpanel" id="thmonetize-coupons-options">
				' . $__templater->formTextBoxRow(array(
		'name' => 'title',
		'value' => $__vars['coupon']['title'],
		'maxlength' => $__templater->func('max_length', array($__vars['coupon'], 'title', ), false),
	), array(
		'label' => 'Title',
	)) . '

				' . $__templater->formTextBoxRow(array(
		'name' => 'code',
		'value' => $__vars['coupon']['code'],
		'maxlength' => $__templater->func('max_length', array($__vars['coupon'], 'code', ), false),
	), array(
		'label' => 'Code',
	)) . '

				<hr class="formRowSep" />

				' . $__templater->formRadioRow(array(
		'name' => 'type',
		'value' => $__vars['coupon']['type'],
	), array(array(
		'value' => 'amount',
		'label' => 'Fixed amount',
		'_dependent' => array('
							' . $__templater->formNumberBox(array(
		'name' => 'value',
		'min' => '1',
		'value' => (($__vars['coupon']['type'] == 'amount') ? $__vars['coupon']['value'] : ''),
	)) . '
						'),
		'_type' => 'option',
	),
	array(
		'value' => 'percent',
		'label' => 'Percentage',
		'_dependent' => array('
							' . $__templater->formNumberBox(array(
		'name' => 'value',
		'min' => '1',
		'max' => '99',
		'value' => (($__vars['coupon']['type'] == 'percent') ? $__vars['coupon']['value'] : ''),
	)) . '
						'),
		'_type' => 'option',
	)), array(
		'label' => 'Type',
	)) . '

				<hr class="formRowSep" />

				' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'active',
		'selected' => $__vars['coupon']['active'],
		'label' => 'Active',
		'_type' => 'option',
	)), array(
		'label' => 'Options',
	)) . '
			</li>
			
			' . $__templater->callMacro('helper_criteria', 'user_panes', array(
		'criteria' => $__templater->method($__vars['userCriteria'], 'getCriteriaForTemplate', array()),
		'data' => $__templater->method($__vars['userCriteria'], 'getExtraTemplateData', array()),
	), $__vars) . '
		</ul>

		' . $__templater->formSubmitRow(array(
		'sticky' => 'true',
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('thmonetize-coupons/save', $__vars['coupon'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);