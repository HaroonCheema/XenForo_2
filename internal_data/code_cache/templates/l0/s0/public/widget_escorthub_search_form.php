<?php
// FROM HASH: 4f54ed46ec3812d5d8f6e179745a0937
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="block">
    <div class="block-container">
        <h3 class="block-minorHeader">EscortHub search form</h3>
        <div class="block-body">
            <div class="block-row">
                <div class="container">
					' . $__templater->form('
						' . $__templater->formTextBoxRow(array(
		'name' => 'phone',
		'type' => 'tel',
		'required' => 'required',
	), array(
		'label' => 'Phone Number',
		'hint' => 'Required',
	)) . '
						' . $__templater->formSubmitRow(array(
		'submit' => 'Search',
		'icon' => 'search',
	), array(
	)) . '
					', array(
		'id' => 'phone-search',
		'class' => 'block',
		'action' => $__templater->func('link', array('escorthub-search/index', ), false),
		'ajax' => 'true',
		'data-redirect' => 'off',
		'data-xf-init' => 'phone-search',
	)) . '
				  <div id="remote-data"></div>
				</div>
            </div>
        </div>
    </div>
</div>

';
	$__templater->includeJs(array(
		'src' => 'PunterForum/RelatedReviews/phone-search.js',
		'addon' => 'PunterForum/RelatedReviews',
	));
	return $__finalCompiled;
}
);