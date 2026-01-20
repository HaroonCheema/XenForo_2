<?php
// FROM HASH: 6a5cec1d44f3259bf768f6408bf5cf60
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit post');
	$__finalCompiled .= '

';
	$__templater->breadcrumbs($__templater->method($__vars['thread'], 'getBreadcrumbs', array()));
	$__finalCompiled .= '

';
	if ($__vars['removeAjax']) {
		$__finalCompiled .= '
	' . $__templater->includeTemplate('post_edit_remove_ajax', $__vars) . '
';
	} else {
		$__finalCompiled .= '
	';
		$__compilerTemp1 = '';
		if ($__templater->method($__vars['post'], 'isFirstPost', array()) AND $__templater->method($__vars['thread'], 'canEdit', array())) {
			$__compilerTemp1 .= '
				' . $__templater->formPrefixInputRow(($__templater->method($__vars['thread'], 'isPrefixEditable', array()) ? $__vars['prefixes'] : array()), array(
				'type' => 'thread',
				'prefix-value' => $__vars['thread']['prefix_id'],
				'multi-prefix-value' => $__vars['thread']['sv_prefix_ids'],
				'multi-prefix-content-parent' => $__vars['thread']['Forum'],
				'multi-prefix-content' => $__vars['thread'],
				'textbox-value' => $__vars['thread']['title'],
				'placeholder' => 'Title' . $__vars['xf']['language']['ellipsis'],
				'maxlength' => $__templater->func('max_length', array($__vars['thread'], 'title', ), false),
				'help-href' => $__templater->func('link', array('forums/prefix-help', $__vars['forum'], ), false),
			), array(
				'label' => 'Title',
				'rowtype' => ($__vars['quickEdit'] ? 'fullWidth' : ''),
			)) . '
			';
		}
		$__compilerTemp2 = '';
		if ($__templater->func('is_applicable_forum', array($__vars['forum'], ), false) AND (!$__templater->method($__vars['post'], 'isFirstPost', array()))) {
			$__compilerTemp2 .= '
	<div class="prefixContainer">
		' . $__templater->callMacro('sv_multiprefix_prefix_macros', 'select', array(
				'name' => 'sv_prefix_ids',
				'prefixes' => $__vars['prefixes'],
				'multiple' => true,
				'selected' => $__vars['post']['sv_prefix_ids'],
				'contentParent' => $__vars['forum'],
				'type' => 'thread',
				'forumPrefixesLimit' => $__vars['force_limit_prefix'],
				'required' => true,
			), $__vars) . '
	</div>

';
		}
		$__compilerTemp3 = '';
		if ($__vars['attachmentData']) {
			$__compilerTemp3 .= '
					' . $__templater->callMacro('helper_attach_upload', 'upload_block', array(
				'attachmentData' => $__vars['attachmentData'],
			), $__vars) . '
				';
		}
		$__compilerTemp4 = '';
		if (($__vars['forum']['node_id'] == $__vars['xf']['options']['fs_escrow_applicable_forum']) AND $__templater->method($__vars['post'], 'isFirstPost', array())) {
			$__compilerTemp4 .= '
    			' . $__templater->formTextBoxRow(array(
				'name' => 'to_user',
				'value' => ($__vars['thread']['Escrow']['User']['username'] ?: ''),
				'ac' => 'single',
				'maxlength' => $__templater->func('max_length', array($__vars['xf']['visitor'], 'username', ), false),
				'id' => 'ctrl_started_by',
			), array(
				'label' => 'User',
			)) . '
                ' . $__templater->formNumberBoxRow(array(
				'name' => 'escrow_amount',
				'value' => ($__vars['thread']['Escrow']['escrow_amount'] ?: ''),
				'min' => '0',
			), array(
				'explain' => 'Total Amount:' . ' ' . $__templater->escape($__vars['xf']['visitor']['deposit_amount']),
				'label' => 'Escrow Amount',
			)) . '
			 ';
		}
		$__compilerTemp5 = '';
		if ($__vars['forum']['node_id'] == $__vars['xf']['options']['fs_auction_applicable_forum']) {
			$__compilerTemp5 .= '
			 ' . $__templater->formRow(' 
	         <div class="inputGroup">         
			 ' . $__templater->formDateInput(array(
				'name' => 'ends_on',
				'value' => ($__vars['thread']['auction_end_date'] ? $__templater->method($__vars['thread'], 'getFormatedDate', array()) : $__templater->func('date', array($__vars['xf']['time'], 'Y-m-d', ), false)),
				'required' => 'true',
			)) . '            
			 <span class="inputGroup-splitter"></span> 
			 <span class="inputGroup" dir="ltr">  
			 ' . $__templater->formTextBox(array(
				'name' => 'ends_on_time',
				'class' => 'input--date time start',
				'required' => 'true',
				'type' => 'time',
				'value' => ($__vars['thread']['auction_end_date'] ? $__templater->method($__vars['thread'], 'getFormatedTime', array()) : ''),
				'data-xf-init' => 'time-picker',
				'data-moment' => $__vars['timeFormat'],
			)) . '</span>          
			 </div>        
			 ', array(
				'label' => 'AUCTION ENDS ON',
				'rowtype' => 'input',
				'hint' => 'Required',
				'explain' => 'Choose a date.2 to 5 days is the most used range with 3 days being the most common.',
			)) . '
			 ';
		}
		$__compilerTemp6 = '';
		if ($__templater->method($__vars['post'], 'isFirstPost', array()) AND $__templater->method($__vars['thread'], 'canEdit', array())) {
			$__compilerTemp6 .= '
				';
			$__compilerTemp7 = '';
			$__compilerTemp7 .= '
						' . $__templater->filter($__templater->method($__vars['thread']['TypeHandler'], 'renderExtraDataEdit', array($__vars['thread'], 'edit', ($__vars['quickEdit'] ? 'first_post_quick' : 'first_post'), )), array(array('raw', array()),), true) . '
					';
			if (strlen(trim($__compilerTemp7)) > 0) {
				$__compilerTemp6 .= '
					';
				if (!$__vars['quickEdit']) {
					$__compilerTemp6 .= '
						<hr class="formRowSep" />
					';
				}
				$__compilerTemp6 .= '
					' . $__compilerTemp7 . '
				';
			}
			$__compilerTemp6 .= '

				';
			$__compilerTemp8 = '';
			$__compilerTemp8 .= '
						' . $__templater->callMacro('custom_fields_macros', 'custom_fields_edit', array(
				'type' => 'threads',
				'set' => $__vars['thread']['custom_fields'],
				'editMode' => $__templater->method($__vars['thread'], 'getFieldEditMode', array()),
				'onlyInclude' => $__vars['forum']['field_cache'],
				'rowType' => ($__vars['quickEdit'] ? 'fullWidth' : ''),
			), $__vars) . '
					';
			if (strlen(trim($__compilerTemp8)) > 0) {
				$__compilerTemp6 .= '
					<hr class="formRowSep" />
					' . $__compilerTemp8 . '
				';
			}
			$__compilerTemp6 .= '
			';
		}
		$__compilerTemp9 = '';
		if ($__templater->method($__vars['post'], 'canEditSilently', array())) {
			$__compilerTemp9 .= '
				' . $__templater->formRow('
					' . $__templater->callMacro('helper_action', 'edit_type', array(
				'canEditSilently' => $__templater->method($__vars['post'], 'canEditSilently', array()),
			), $__vars) . '
				', array(
				'rowtype' => ($__vars['quickEdit'] ? 'fullWidth noLabel' : ''),
			)) . '
			';
		}
		$__compilerTemp10 = '';
		if ($__templater->method($__vars['post'], 'canSendModeratorActionAlert', array())) {
			$__compilerTemp10 .= '
				' . $__templater->formRow('
					' . $__templater->callMacro('helper_action', 'author_alert', array(
				'row' => false,
			), $__vars) . '
				', array(
				'rowtype' => ($__vars['quickEdit'] ? 'fullWidth noLabel' : ''),
			)) . '
			';
		}
		$__compilerTemp11 = '';
		if ($__vars['quickEdit']) {
			$__compilerTemp11 .= '
					' . $__templater->button('Cancel', array(
				'class' => 'js-cancelButton',
			), '', array(
			)) . '
				';
		}
		$__finalCompiled .= $__templater->form('

	<div class="block-container">
		<div class="block-body">
			<span class="u-anchorTarget js-editContainer"></span>
			' . $__compilerTemp1 . '

			' . $__compilerTemp2 . '
' . $__templater->formEditorRow(array(
			'name' => 'message',
			'value' => $__vars['post']['message'],
			'attachments' => $__vars['attachmentData']['attachments'],
			'data-min-height' => ($__vars['quickEdit'] ? 100 : ''),
			'data-preview-url' => $__templater->func('link', array('posts/preview', $__vars['post'], ), false),
		), array(
			'rowtype' => 'fullWidth noLabel',
			'label' => 'Message',
		)) . '

			' . $__templater->formRow('
				' . $__compilerTemp3 . '
			', array(
			'rowtype' => ($__vars['quickEdit'] ? 'fullWidth noLabel mergePrev' : ''),
		)) . '
' . $__compilerTemp4 . '

' . $__compilerTemp5 . '

			' . $__compilerTemp6 . '

			' . $__compilerTemp9 . '

			' . $__compilerTemp10 . '
		</div>
		' . $__templater->formSubmitRow(array(
			'icon' => 'save',
			'sticky' => 'true',
		), array(
			'rowtype' => ($__vars['quickEdit'] ? 'simple' : ''),
			'html' => '
				' . $__compilerTemp11 . '
			',
		)) . '
	</div>
', array(
			'action' => $__templater->func('link', array('posts/edit', $__vars['post'], ), false),
			'ajax' => 'true',
			'class' => 'block',
			'data-xf-init' => 'attachment-manager' . (($__templater->method($__vars['post'], 'isFirstPost', array()) AND $__templater->method($__vars['thread'], 'canEdit', array())) ? ' post-edit' : ''),
		)) . '
';
	}
	return $__finalCompiled;
}
);