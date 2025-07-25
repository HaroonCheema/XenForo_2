<?php
// FROM HASH: bf5333ba69785edc3ba5edfec73edbca
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped(($__vars['mailingList']['mailing_list_id'] ? 'Edit Mailing List' : 'Add New Mailing List'));
	$__finalCompiled .= '

';
	$__compilerTemp1 = array();
	if ($__templater->isTraversable($__vars['userGroups'])) {
		foreach ($__vars['userGroups'] AS $__vars['userGroup']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['userGroup']['user_group_id'],
				'label' => '
									' . $__templater->escape($__vars['userGroup']['title']) . '
								',
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->form('
    <div class="block-container">
        <div class="block-body">
			
            ' . $__templater->formTextBoxRow(array(
		'name' => 'title',
		'value' => $__vars['mailingList']['title'],
	), array(
		'label' => 'Title',
	)) . '
			
			 ' . $__templater->formTextBoxRow(array(
		'name' => 'subject',
		'value' => $__vars['mailingList']['subject'],
	), array(
		'label' => 'Subject',
	)) . '
            
            ' . $__templater->formEditorRow(array(
		'name' => 'description',
		'value' => $__vars['mailingList']['description'],
	), array(
		'label' => 'Description',
	)) . '
            
            ' . $__templater->formTextBoxRow(array(
		'name' => 'from_email',
		'value' => $__vars['mailingList']['from_email'],
	), array(
		'label' => 'From Email',
	)) . '
            
            ' . $__templater->formTextBoxRow(array(
		'name' => 'from_name',
		'value' => $__vars['mailingList']['from_name'],
	), array(
		'label' => 'From Name',
	)) . '
            
            ' . $__templater->formRadioRow(array(
		'name' => 'type',
		'value' => $__vars['mailingList']['type'],
	), array(array(
		'value' => '0',
		'label' => 'File Based',
		'data-hide' => 'true',
		'_dependent' => array('
							' . $__templater->formUploadRow(array(
		'name' => 'email_file',
		'accept' => '.xlsx,.xls',
		'dependent' => '[name=type]',
		'showif' => '0',
	), array(
		'explain' => 'First Column will be consider as email.Only support excel file.',
		'label' => 'Excel File',
	)) . '
					'),
		'_type' => 'option',
	),
	array(
		'value' => '1',
		'label' => 'User Group Based',
		'data-hide' => 'true',
		'_dependent' => array('
					' . $__templater->formCheckBoxRow(array(
		'name' => 'usergroup_ids',
		'dependent' => '[name=type]',
		'showif' => '1',
		'value' => $__vars['mailingList']['usergroup_ids'],
	), $__compilerTemp1, array(
		'label' => 'User Groups',
	)) . '
					'),
		'_type' => 'option',
	)), array(
		'label' => 'Type',
	)) . '
         
            
            ' . $__templater->formNumberBoxRow(array(
		'name' => 'emails_per_hour',
		'value' => $__vars['mailingList']['emails_per_hour'],
		'min' => '1',
	), array(
		'label' => 'Emails Per Hour',
	)) . '
            
            ' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'active',
		'label' => 'Active',
		'value' => '1',
		'selected' => $__vars['mailingList']['active'],
		'_type' => 'option',
	)), array(
	)) . '
        </div>
        
       	' . $__templater->formSubmitRow(array(
		'sticky' => 'true',
		'icon' => 'save',
	), array(
	)) . '
    </div>
', array(
		'action' => $__templater->func('link', array('mailing-lists/save', $__vars['mailingList'], ), false),
		'upload' => 'true',
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);