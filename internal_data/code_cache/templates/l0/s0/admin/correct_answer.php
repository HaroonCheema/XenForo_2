<?php
// FROM HASH: 3139f97f3d8c935add8333799576be80
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->includeJs(array(
		'src' => 'xf/sort.js, vendor/dragula/dragula.js',
	));
	$__finalCompiled .= '
';
	$__templater->includeCss('public:dragula.less');
	$__finalCompiled .= '
';
	$__compilerTemp1 = '';
	if ($__templater->isTraversable($__vars['field']['field_choices'])) {
		foreach ($__vars['field']['field_choices'] AS $__vars['choice'] => $__vars['text']) {
			$__compilerTemp1 .= '
							<div class="inputGroup">
								<span class="inputGroup-text dragHandle"
									aria-label="' . $__templater->filter('Drag handle', array(array('for_attr', array()),), true) . '"></span>
								' . $__templater->formTextBox(array(
				'name' => 'field_choice[]',
				'value' => $__vars['choice'],
				'placeholder' => 'Value (A-Z, 0-9, and _ only)',
				'size' => '24',
				'maxlength' => '25',
				'dir' => 'ltr',
			)) . '
								<span class="inputGroup-splitter"></span>
								' . $__templater->formTextBox(array(
				'name' => 'field_choice_text[]',
				'value' => $__vars['text'],
				'placeholder' => 'Text',
				'size' => '24',
			)) . '
							</div>
						';
		}
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			
			' . $__templater->formTextAreaRow(array(
		'name' => 'question',
		'dir' => 'ltr',
	), array(
		'label' => 'Question',
		'explain' => 'Type the Question and the selection the  choice below.',
	)) . '
			

			
		</div>

			<h3 class="block-formSectionHeader">
				<span class="collapseTrigger collapseTrigger--block" data-xf-click="toggle" data-target="< :up:next">
					<span class="block-formSectionHeader-aligner">' . 'Options for choice fields' . '</span>
				</span>
			</h3>
			<div class="block-body block-body--collapsible">
				' . $__templater->formRow('

					<div class="inputGroup-container" data-xf-init="list-sorter" data-drag-handle=".dragHandle">
						' . $__compilerTemp1 . '
						<div class="inputGroup is-undraggable js-blockDragafter" data-xf-init="field-adder"
							data-remove-class="is-undraggable js-blockDragafter">
							<span class="inputGroup-text dragHandle"
								aria-label="' . $__templater->filter('Drag handle', array(array('for_attr', array()),), true) . '"></span>
							' . $__templater->formTextBox(array(
		'name' => 'field_choice[]',
		'placeholder' => 'Value (A-Z, 0-9, and _ only)',
		'size' => '24',
		'maxlength' => '25',
		'data-i' => '0',
		'dir' => 'ltr',
	)) . '
							
							<span class="inputGroup-splitter"></span>
							' . $__templater->formTextBox(array(
		'name' => 'field_choice_text[]',
		'placeholder' => 'Text',
		'size' => '24',
		'data-i' => '0',
	)) . '
							' . $__templater->formRadio(array(
	), array(array(
		'label' => '
								',
		'_type' => 'option',
	))) . '
						</div>
					</div>
				', array(
		'rowtype' => 'input',
		'label' => 'Possible choices',
		'explain' => 'The value represents the internal value for the choice. The text field is shown when the field is displayed. You should not change the value field if any users have selected that choice; if you do, users will lose their selection.',
	)) . '
			</div>
		

			</div>
	

		
		

		' . $__templater->formSubmitRow(array(
		'sticky' => 'true',
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array($__vars['prefix'] . '/save', $__vars['field'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);