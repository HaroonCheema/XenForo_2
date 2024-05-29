<?php
// FROM HASH: 7a8fdf969ff7f3bf6bc3283471a957cc
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['question'] != null) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit question');
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Add question' . $__vars['xf']['language']['label_separator']);
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__vars['question']['question_type'] == 'radio') {
		$__compilerTemp1 .= '
								';
		if ($__templater->isTraversable($__vars['field']['field_choices'])) {
			foreach ($__vars['field']['field_choices'] AS $__vars['choice'] => $__vars['text']) {
				$__compilerTemp1 .= '
									<div class="inputGroup">
											' . $__templater->form('
												' . $__templater->formTextBox(array(
					'name' => 'options-radio[]',
					'value' => 'Choice',
					'size' => '12',
					'maxlength' => '25',
					'data-i' => '0',
					'dir' => 'ltr',
					'style' => 'margin-right:10px;',
				)) . '
											    ' . $__templater->formRadio(array(
					'name' => 'correct-radio[]',
				), array(array(
					'label' => 'Correct',
					'class' => 'myRadio',
					'name' => 'correct-radio[]',
					'selected' => (($__vars['select'] == $__vars['choice']) ? $__vars['select'] : ''),
					'_type' => 'option',
				))) . '
										', array(
				)) . '
									</div><br>
								';
			}
		}
		$__compilerTemp1 .= '
							';
	}
	$__compilerTemp2 = '';
	if ($__vars['question']) {
		$__compilerTemp2 .= '
									';
		if ($__templater->isTraversable($__vars['field']['field_choices'])) {
			foreach ($__vars['field']['field_choices'] AS $__vars['choice'] => $__vars['text']) {
				$__compilerTemp2 .= '
										<div class="inputGroup">

											  ' . $__templater->form('
													' . $__templater->formTextBox(array(
					'name' => 'optionsssscheckbox[]',
					'placeholder' => 'Choice',
					'size' => '12',
					'maxlength' => '25',
					'data-i' => '0',
					'dir' => 'ltr',
					'style' => 'margin-right:10px;',
				)) . '
													' . $__templater->formCheckBox(array(
					'name' => 'correctss-checkbox[]',
				), array(array(
					'label' => 'Correct',
					'class' => 'mycheckbox',
					'name' => 'ss-checkbox[]',
					'value' => '0',
					'_type' => 'option',
				))) . '
												', array(
				)) . '

										</div>
									';
			}
		}
		$__compilerTemp2 .= '
								';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			
			' . $__templater->formTextAreaRow(array(
		'name' => 'question_title',
		'value' => $__vars['question']['question_title'],
		'dir' => 'ltr',
	), array(
		'label' => 'Question',
		'explain' => 'Type the Question and the selection the  choice below.',
	)) . '
			

		' . $__templater->formRadioRow(array(
		'name' => 'question_type',
	), array(array(
		'value' => 'textbox',
		'selected' => (($__vars['question']['question_type'] == 'textbox') ? $__vars['question']['question_type'] : ''),
		'label' => 'Single-Line Text Box',
		'data-hide' => 'true',
		'_dependent' => array('

						' . $__templater->formRow('

						' . $__templater->formTextBox(array(
		'name' => 'question_correct_answer',
		'value' => $__vars['question']['question_correct_answer'],
		'size' => '24',
	)) . '
						', array(
		'rowtype' => 'input',
		'label' => 'Correct Answer',
		'explain' => 'Enter the correct answer for single line text box',
	)) . '

					'),
		'_type' => 'option',
	),
	array(
		'value' => 'radio',
		'selected' => (($__vars['question']['question_type'] == 'radio') ? $__vars['question']['question_type'] : ''),
		'label' => 'Single-Selection Radio',
		'data-hide' => 'true',
		'_dependent' => array('
						<div class="inputGroup-container">
							' . $__compilerTemp1 . '
						
							<input type="hidden" name="radio-key" id="radio-key" value="0" />
							<div class="radio-selection-button">
								 ' . $__templater->button('Add choice', array(
		'class' => 'add-radio',
	), '', array(
	)) . '
								 ' . $__templater->button('Remove Choice', array(
		'class' => 'remove-radio',
	), '', array(
	)) . '
							</div><br>
							<div class="radio-selection">
							
									<div class="clone-radio-selection" style="display:flex;margin-top: 10px;">
										
												' . $__templater->formTextBox(array(
		'name' => 'options-radio[]',
		'placeholder' => 'Choice',
		'size' => '12',
		'maxlength' => '25',
		'data-i' => '0',
		'dir' => 'ltr',
		'style' => 'margin-right:10px;',
	)) . '
											    ' . $__templater->formRadio(array(
		'name' => 'correct-radio[]',
	), array(array(
		'label' => 'Correct',
		'class' => 'myRadio',
		'name' => 'correct-radio[]',
		'value' => '0',
		'_type' => 'option',
	))) . '
											
											
								  </div>
							</div>
						</div>
						
					
					
					
					
					'),
		'_type' => 'option',
	),
	array(
		'value' => 'checkbox',
		'selected' => (($__vars['question']['question_type'] == 'checkbox') ? $__vars['question']['question_type'] : ''),
		'label' => 'Multiple-Selection Checkbox',
		'data-hide' => 'true',
		'_dependent' => array('
				
						<div class="inputGroup-container">
								' . $__compilerTemp2 . '

							<input type="hidden" name="checkbox-key" id="checkbox-key" value="0" />
							
							<div class="check-selection-button">
								 ' . $__templater->button('Add choice', array(
		'class' => 'add-checkbox',
	), '', array(
	)) . '
								 ' . $__templater->button('Remove Choice', array(
		'class' => 'remove-checkbox',
	), '', array(
	)) . '
							</div><br>
							
							<div class="checkbox-selection">
							
									<div class="clone-checkbox-selection" style="display:flex;margin-top: 10px;">
										
										  
												' . $__templater->formTextBox(array(
		'name' => 'options-checkbox[]',
		'placeholder' => 'Choice',
		'size' => '12',
		'maxlength' => '25',
		'data-i' => '0',
		'dir' => 'ltr',
		'style' => 'margin-right:10px;',
	)) . '
											    ' . $__templater->formCheckBox(array(
		'name' => 'correct-checkbox[]',
	), array(array(
		'label' => 'Correct',
		'class' => 'mycheckbox',
		'name' => 'correct-checkbox[]',
		'value' => '0',
		'_type' => 'option',
	))) . '
											
											
								  </div>
							</div>
						</div>
					
				'),
		'_type' => 'option',
	)), array(
		'label' => 'Answer Format Type',
	)) . '
		
		
		</div>
		' . $__templater->formSubmitRow(array(
		'sticky' => 'true',
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('quiz-qsn/save', $__vars['question'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	)) . '
 <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
$(document).ready(function() {
  // Clone the first cloneable radio element
  var initialClone = $(\'.clone-radio-selection\').first().clone();
  var initialCheckboxClone = $(\'.clone-checkbox-selection\').first().clone();

  $(\'.add-radio\').on(\'click\', function() {

	var newClone = initialClone.clone();
	 var radioInClone = newClone.find(\'.myRadio\');

	 var currentValue = parseFloat($(\'#radio-key\').val());
    
	
	 var modifiedValue = currentValue + 1;

     $(\'#radio-key\').val(modifiedValue);
    
	 radioInClone.val(modifiedValue);

    $(\'.radio-selection\').append(newClone);
	  
  });


  $(\'.remove-radio\').on(\'click\', function() {

	  var allClones = $(\'.clone-radio-selection\');
	  var currentValue = parseFloat($(\'#radio-key\').val());
    
	  var modifiedValue = currentValue - 1;

       $(\'#radio-key\').val(modifiedValue);
	   
	  var numberOfClones = allClones.length;
	  
	  if (numberOfClones > 1) {
    		$(\'.clone-radio-selection\').last().remove();
	  }
  });
	// Clone the first cloneable checkbox element
	
 
  $(\'.add-checkbox\').on(\'click\', function() {

	  
	 var newClone = initialCheckboxClone.clone();
	 var checkboxInClone = newClone.find(\'.mycheckbox\');

	  var currentValueCheckbox = parseFloat($(\'#checkbox-key\').val());
	  var modifiedValue = currentValueCheckbox + 1;

     $(\'#checkbox-key\').val(modifiedValue);
    
	 checkboxInClone.val(modifiedValue);

    $(\'.checkbox-selection\').append(newClone);
	  
  });


  $(\'.remove-checkbox\').on(\'click\', function() {

	  var allCheckboxClones = $(\'.clone-checkbox-selection\');
	  var currentValue = parseFloat($(\'#checkbox-key\').val());
    
	  var modifiedValue = currentValue - 1;

       $(\'#checkbox-key\').val(modifiedValue);
	   
	  var numberOfClones = allCheckboxClones.length;
	  
	  if (numberOfClones > 1) {
    		$(\'.clone-checkbox-selection\').last().remove();
	  }
  });
});
</script>';
	return $__finalCompiled;
}
);