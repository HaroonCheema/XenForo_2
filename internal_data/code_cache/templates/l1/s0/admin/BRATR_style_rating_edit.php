<?php
// FROM HASH: 46701f0790f38ea5ce87ae841c95f9ec
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->method($__vars['styleRating'], 'isInsert', array())) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Add New Style Rating');
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit Rating Style' . $__vars['xf']['language']['label_separator']);
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['styleRating'], 'isUpdate', array())) {
		$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('', array(
			'href' => $__templater->func('link', array('bratr-style-rating/delete', $__vars['styleRating'], ), false),
			'icon' => 'delete',
			'overlay' => 'true',
		), '', array(
		)) . '
');
	}
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__templater->method($__vars['styleRating'], 'isUpdate', array())) {
		$__compilerTemp1 .= '
				' . $__templater->formRow('
					' . $__templater->filter($__templater->method($__vars['styleRating'], 'getIconHtml', array()), array(array('raw', array()),), true) . '
				', array(
			'label' => 'Rating Style Preview',
		)) . '
			';
	}
	$__compilerTemp2 = '';
	if ($__templater->method($__vars['styleRating'], 'isUpdate', array())) {
		$__compilerTemp2 .= '
					' . $__templater->button('', array(
			'href' => $__templater->func('link', array('bratr-style-rating/delete', $__vars['styleRating'], ), false),
			'overlay' => 'true',
			'icon' => 'delete',
		), '', array(
		)) . '
				';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">

			' . $__compilerTemp1 . '

			' . $__templater->formUploadRow(array(
		'name' => 'upload',
		'accept' => 'image/*',
	), array(
		'label' => 'Upload Rating Style Image',
	)) . '

			' . $__templater->formRow('

				<div class="inputGroup inputGroup--numbers">
					' . $__templater->formNumberBox(array(
		'name' => 'icon_width',
		'min' => '0',
		'value' => $__vars['styleRating']['icon_width'],
		'placeholder' => 'Icon width',
	)) . '
					<span class="inputGroup-text">x</span>
					' . $__templater->formNumberBox(array(
		'name' => 'icon_height',
		'min' => '0',
		'value' => $__vars['styleRating']['icon_height'],
		'placeholder' => 'Icon Height',
	)) . '
					<span class="inputGroup-text">' . 'Pixels' . '</span>
				</div>
			', array(
		'rowtype' => 'input',
		'label' => 'Dimensions',
		'explain' => 'The dimensions of the rating icon.',
	)) . '

			' . $__templater->formNumberBoxRow(array(
		'name' => 'icon_second_position',
		'min' => '0',
		'value' => $__vars['styleRating']['icon_second_position'],
		'placeholder' => 'Position of icon half',
	), array(
		'label' => 'Spacing',
	)) . '

		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'save',
		'class' => 'js-submitButton',
		'data-ajax-redirect' => ($__templater->method($__vars['styleRating'], 'isInsert', array()) ? '1' : '0'),
	), array(
		'html' => '
				' . $__templater->button('Save and exit', array(
		'type' => 'submit',
		'name' => 'exit',
		'icon' => 'save',
		'accesskey' => 'e',
	), '', array(
	)) . '
				' . $__compilerTemp2 . '
			',
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('bratr-style-rating/save', $__vars['styleRating'], ), false),
		'ajax' => 'true',
		'class' => 'block',
		'upload' => 'true',
	));
	return $__finalCompiled;
}
);