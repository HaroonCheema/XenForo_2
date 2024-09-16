<?php
// FROM HASH: 16d96e82e88aa2776de254f39c096be1
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->method($__vars['tag'], 'exists', array())) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Confirm action');
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Add tag to blacklist');
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__vars['tag'] AND $__templater->method($__vars['tag'], 'exists', array())) {
		$__compilerTemp1 .= '
				' . $__templater->formInfoRow('
					' . 'Please confirm that you want to blacklist the following tag:' . $__vars['xf']['language']['label_separator'] . '
					<strong><a href="' . $__templater->func('link', array('tags/edit', $__vars['tag'], ), true) . '">' . $__templater->escape($__vars['tagName']) . '</a></strong>
				', array(
			'rowtype' => 'confirm',
		)) . '
			';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__compilerTemp1 . '
			' . $__templater->formTextBoxRow(array(
		'name' => 'new_tag',
		'value' => $__vars['tagName'],
	), array(
		'label' => 'Tag',
	)) . '
			' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'isRegex',
		'label' => 'Use regex (regular expressions) instead of direct text match',
		'value' => '1',
		'selected' => $__vars['isRegex'],
		'hint' => 'Blacklist via regex using <a href="http://www.php.net/manual/en/reference.pcre.pattern.syntax.php">php regex syntax</a><br/>
Note: use a full expression, including delimiters and switches.',
		'_type' => 'option',
	)), array(
	)) . '
		</div>

		' . $__templater->formSubmitRow(array(
	), array(
		'rowtype' => 'simple',
		'html' => '
				' . $__templater->button('
					<i class="fa fa-ban" aria-hidden="true"></i> ' . 'Blacklist' . '
				', array(
		'type' => 'submit',
		'name' => 'test_gravatar',
		'class' => 'button--primary',
		'value' => '1',
	), '', array(
	)) . '
			',
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('tags/blacklist', null, array('existing_tag_id' => ($__vars['tag'] ? $__vars['tag']['tag_id'] : 0), ), ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);