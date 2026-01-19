<?php
// FROM HASH: 7aed49b4d5fa7e7100d5dcd00267c96a
return array(
'macros' => array('type_chooser' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'thread' => '!',
		'forum' => '!',
		'creatableThreadTypes' => '!',
		'defaultThreadType' => '!',
		'rowType' => 'fullWidth noLabel noTopPadding noBottomPadding mergeNext mergePrev',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	if ($__templater->func('count', array($__vars['creatableThreadTypes'], ), false) > 1) {
		$__finalCompiled .= '
		';
		$__templater->includeCss('input_extended.less');
		$__finalCompiled .= '
		';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['creatableThreadTypes'])) {
			foreach ($__vars['creatableThreadTypes'] AS $__vars['threadTypeId'] => $__vars['threadType']) {
				$__compilerTemp1 .= '
							<li role="none">
								<label class="inputTypes-type">
									<input type="radio" name="discussion_type" value="' . $__templater->escape($__vars['threadTypeId']) . '"
										class="inputTypes-input"
										data-xf-init="disabler"
										data-hide="true"
										data-optional="true"
										data-autofocus="false"
										data-container=".js-threadTypeData[data-type-id=\'' . $__templater->escape($__vars['threadTypeId']) . '\']"
										' . (($__vars['threadTypeId'] == $__vars['defaultThreadType']) ? 'checked="checked"' : '') . '
									/>
									<span class="inputTypes-display inputTypes-display--type_' . $__templater->escape($__vars['threadTypeId']) . '">
										<span class="inputTypes-icon" aria-hidden="true">
											';
				$__vars['typeIcon'] = $__templater->method($__vars['threadType'], 'getTypeIconClass', array());
				$__compilerTemp1 .= '
											';
				if ($__vars['typeIcon']) {
					$__compilerTemp1 .= '
												' . $__templater->fontAwesome($__templater->escape($__vars['typeIcon']), array(
					)) . '
											';
				} else {
					$__compilerTemp1 .= '
												<i class="inputTypes-defaultIcon"></i>
											';
				}
				$__compilerTemp1 .= '
										</span>
										<span class="inputTypes-title">' . $__templater->escape($__templater->method($__vars['threadType'], 'getTypeTitle', array())) . '</span>
									</span>
								</label>
							</li>
						';
			}
		}
		$__finalCompiled .= $__templater->formRow('
			<div class="hScroller inputTypesScroller" data-xf-init="h-scroller">
				<div class="hScroller-scroll">
					<ul class="inputTypes" role="radiogroup" aria-label="' . $__templater->filter('thread_type', array(array('for_attr', array()),), true) . '">
						' . $__compilerTemp1 . '
					</ul>
				</div>
			</div>
		', array(
			'rowtype' => $__vars['rowType'],
		)) . '
	';
	} else {
		$__finalCompiled .= '
		' . $__templater->formHiddenVal('discussion_type', $__vars['defaultThreadType'], array(
		)) . '
	';
	}
	$__finalCompiled .= '

';
	return $__finalCompiled;
}
),
'type_fields' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'thread' => '!',
		'forum' => '!',
		'creatableThreadTypes' => '!',
		'defaultThreadType' => '!',
		'subContext' => '!',
		'extraOptions' => array(),
		'draftOverride' => null,
		'formRowSepVariant' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '
			';
	if ($__templater->isTraversable($__vars['creatableThreadTypes'])) {
		foreach ($__vars['creatableThreadTypes'] AS $__vars['threadTypeId'] => $__vars['threadType']) {
			$__compilerTemp1 .= '
				';
			$__compilerTemp2 = '';
			$__compilerTemp2 .= '
							' . $__templater->filter($__templater->method($__vars['threadType'], 'renderExtraDataEdit', array($__vars['thread'], 'create', $__vars['subContext'], array('draft' => (($__vars['subContext'] == 'quick') ? null : $__vars['forum']->{'draft_thread'}), 'draftOverride' => $__vars['draftOverride'], ) + $__vars['extraOptions'], )), array(array('raw', array()),), true) . '
						';
			if (strlen(trim($__compilerTemp2)) > 0) {
				$__compilerTemp1 .= '
					<li class="js-threadTypeData" data-type-id="' . $__templater->escape($__vars['threadTypeId']) . '" style="' . (($__vars['threadTypeId'] != $__vars['defaultThreadType']) ? 'display:none;' : '') . '">
						<hr class="formRowSep ' . $__templater->escape($__vars['formRowSepVariant']) . '" />
						' . $__compilerTemp2 . '
					</li>
				';
			}
			$__compilerTemp1 .= '
			';
		}
	}
	$__compilerTemp1 .= '
		';
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
		<ul class="listPlain">
		' . $__compilerTemp1 . '
		</ul>
	';
	}
	$__finalCompiled .= '

';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['forum']['node_id'] == $__vars['xf']['options']['fs_escrow_applicable_forum']) {
		$__finalCompiled .= '
';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Escrow Start');
		$__finalCompiled .= '
	';
	} else {
		$__finalCompiled .= '
	';
		if ((($__vars['xf']['reply']['containerKey'] == ('node-' . $__vars['xf']['options']['fs_questionAnswerForum'])) OR ($__templater->method($__vars['xf']['app']['request'], 'getRoutePath', array()) == 'esperto/'))) {
			$__finalCompiled .= '
	';
			$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Submit your question');
			$__finalCompiled .= '
';
		} else {
			$__finalCompiled .= '
	';
			if (($__vars['forum']['forum_type_id'] == 'snog_movies_movie') AND (!$__vars['xf']['options']['tmdbthreads_mix'])) {
				$__finalCompiled .= '
	';
				$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Post movie');
				$__finalCompiled .= '
';
			} else {
				$__finalCompiled .= '
';
				$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Post thread');
				$__finalCompiled .= '	
';
			}
			$__finalCompiled .= '

';
		}
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '


';
	$__templater->setPageParam('head.' . 'metaNoindex', $__templater->preEscaped('<meta name="robots" content="noindex" />'));
	$__finalCompiled .= '

';
	$__templater->breadcrumbs($__templater->method($__vars['forum'], 'getBreadcrumbs', array()));
	$__finalCompiled .= '

';
	$__vars['titleFinalHtml'] = $__templater->preEscaped('');
	$__compilerTemp1 = '';
	if ($__vars['forum']['node_id'] == $__vars['xf']['options']['fs_escrow_applicable_forum']) {
		$__compilerTemp1 .= '
	' . $__templater->formPrefixInputRow($__vars['prefixes'], array(
			'type' => 'thread',
			'prefix-value' => ($__vars['forum']['draft_thread']['prefix_id'] ?: ($__vars['thread']['prefix_id'] ?: $__vars['forum']['default_prefix_id'])),
			'textbox-value' => (($__vars['title'] ?: $__vars['thread']['title']) ?: $__vars['forum']['draft_thread']['title']),
			'textbox-class' => 'input--title',
			'placeholder' => 'Escrow title',
			'autofocus' => 'autofocus',
			'maxlength' => $__templater->func('max_length', array('XF:Thread', 'title', ), false),
			'help-href' => $__templater->func('link', array('forums/prefix-help', $__vars['forum'], ), false),
		), array(
			'label' => 'Title',
			'rowtype' => 'fullWidth noLabel',
			'finalhtml' => $__templater->escape($__vars['titleFinalHtml']),
		)) . '
		';
	} else {
		$__compilerTemp1 .= '
	' . $__templater->formPrefixInputRow($__vars['prefixes'], array(
			'type' => 'thread',
			'rows' => '1',
			'prefix-value' => (($__vars['forum']['node_id'] == $__vars['xf']['options']['fs_auction_applicable_forum']) ? $__vars['xf']['options']['auction_thread_prefix_id'] : ($__vars['forum']['draft_thread']['prefix_id'] ?: ($__vars['thread']['prefix_id'] ?: $__vars['forum']['default_prefix_id']))),
			'textbox-value' => (($__vars['title'] ?: $__vars['thread']['title']) ?: $__vars['forum']['draft_thread']['title']),
			'textbox-class' => 'input--title',
			'placeholder' => $__vars['forum']['thread_prompt'],
			'autofocus' => 'autofocus',
			'maxlength' => $__templater->func('max_length', array('XF:Thread', 'title', ), false),
			'help-href' => $__templater->func('link', array('forums/prefix-help', $__vars['forum'], ), false),
		), array(
			'label' => 'Title',
			'rowtype' => 'fullWidth noLabel',
			'finalhtml' => $__templater->escape($__vars['titleFinalHtml']),
		)) . '
';
	}
	$__compilerTemp2 = '';
	if ($__vars['attachmentData']) {
		$__compilerTemp2 .= '
						' . $__templater->callMacro('helper_attach_upload', 'upload_block', array(
			'attachmentData' => $__vars['attachmentData'],
			'forceHash' => $__vars['forum']['draft_thread']['attachment_hash'],
		), $__vars) . '
					';
	}
	$__compilerTemp3 = '';
	if ($__vars['xf']['options']['multiQuote']) {
		$__compilerTemp3 .= '
						' . $__templater->callMacro('multi_quote_macros', 'button', array(
			'href' => $__templater->func('link', array('threads/multi-quote', $__vars['thread'], ), false),
			'messageSelector' => '.js-post',
			'storageKey' => 'multiQuoteThread',
		), $__vars) . '
					';
	}
	$__compilerTemp4 = '';
	if ($__vars['forum']['node_id'] == $__vars['xf']['options']['fs_auction_applicable_forum']) {
		$__compilerTemp4 .= '
	' . $__templater->formRow(' 
	         <div class="inputGroup">         
			 ' . $__templater->formDateInput(array(
			'name' => 'ends_on',
			'value' => ($__vars['data']['ends_on'] ? $__templater->func('date', array($__vars['data']['ends_on'], 'Y-m-d', ), false) : $__templater->func('date', array($__vars['xf']['time'], 'Y-m-d', ), false)),
			'required' => 'true',
		)) . '            
			 <span class="inputGroup-splitter"></span> 
			 <span class="inputGroup" dir="ltr">  
			 ' . $__templater->formTextBox(array(
			'name' => 'ends_on_time',
			'class' => 'input--date time start',
			'required' => 'true',
			'type' => 'time',
			'value' => ($__vars['data']['ends_on'] ? $__templater->method($__vars['data'], 'getFormatedTime', array()) : ''),
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
			 ' . $__templater->formHiddenVal('category_id', $__vars['category_id'], array(
		)) . '
			 ';
	}
	$__compilerTemp5 = '';
	if ($__vars['forum']['node_id'] == $__vars['xf']['options']['fs_escrow_applicable_forum']) {
		$__compilerTemp5 .= '
	' . $__templater->formTextBoxRow(array(
			'name' => 'to_user',
			'value' => ($__vars['starterFilter'] ? $__vars['starterFilter']['username'] : ''),
			'ac' => 'single',
			'maxlength' => $__templater->func('max_length', array($__vars['xf']['visitor'], 'username', ), false),
			'id' => 'ctrl_started_by',
		), array(
			'label' => 'User',
		)) . '
				' . $__templater->formNumberBoxRow(array(
			'name' => 'escrow_amount',
			'value' => '',
			'min' => '0',
		), array(
			'explain' => 'Total Amount:' . ' ' . '$' . $__templater->escape($__vars['xf']['visitor']['deposit_amount']),
			'label' => 'Escrow Amount',
		)) . '
			 ';
	}
	$__compilerTemp6 = '';
	$__compilerTemp7 = '';
	$__compilerTemp7 .= '
						' . $__templater->callMacro('custom_fields_macros', 'custom_fields_edit', array(
		'type' => 'threads',
		'set' => $__vars['thread']['custom_fields'],
		'editMode' => $__templater->method($__vars['thread'], 'getFieldEditMode', array(true, )),
		'onlyInclude' => $__vars['forum']['field_cache'],
		'requiredOnly' => ($__vars['inlineMode'] ? true : false),
	), $__vars) . '
					';
	if (strlen(trim($__compilerTemp7)) > 0) {
		$__compilerTemp6 .= '
					<hr class="formRowSep" />
					' . $__compilerTemp7 . '
				';
	}
	$__compilerTemp8 = '';
	if ($__vars['canEditTags']) {
		$__compilerTemp8 .= '
					<hr class="formRowSep" />
					';
		$__compilerTemp9 = '';
		if ($__vars['forum']['min_tags']) {
			$__compilerTemp9 .= '
								' . 'This content must have at least ' . $__templater->escape($__vars['forum']['min_tags']) . ' tag(s).' . '
							';
		}
		$__compilerTemp8 .= $__templater->formTokenInputRow(array(
			'name' => 'tags',
			'value' => (($__vars['thread']['tags'] ? $__templater->filter($__vars['thread']['tags'], array(array('join', array(', ', )),), false) : $__vars['forum']['draft_thread']['tags']) ?: $__vars['tags']),
			'href' => $__templater->func('link', array('misc/tag-auto-complete', ), false),
			'min-length' => $__vars['xf']['options']['tagLength']['min'],
			'max-length' => $__vars['xf']['options']['tagLength']['max'],
			'max-tokens' => $__vars['xf']['options']['maxContentTags'],
		), array(
			'label' => 'Tags',
			'explain' => '
							' . 'Multiple tags may be separated by commas.' . '
							' . $__compilerTemp9 . '
						',
		)) . '
				';
	}
	$__compilerTemp10 = '';
	if ($__vars['forum']['node_id'] == $__vars['xf']['options']['fs_escrow_applicable_forum']) {
		$__compilerTemp10 .= '
	
	';
	} else {
		$__compilerTemp10 .= '
	';
		if ((!$__vars['xf']['visitor']['user_id']) AND (!$__templater->method($__vars['forum'], 'canCreateThreadPreReg', array()))) {
			$__compilerTemp10 .= '
					' . $__templater->includeTemplate('fs_add_register_form_fields', $__vars) . '
				';
		} else if ($__vars['xf']['visitor']['user_id']) {
			$__compilerTemp10 .= '
					' . $__templater->callMacro('helper_thread_options', 'watch_input', array(
				'thread' => $__vars['thread'],
			), $__vars) . '
					';
			if ((($__vars['xf']['reply']['containerKey'] == ('node-' . $__vars['xf']['options']['fs_questionAnswerForum'])) OR ($__templater->method($__vars['xf']['app']['request'], 'getRoutePath', array()) == 'esperto/'))) {
				$__compilerTemp10 .= '
 
';
			} else {
				$__compilerTemp10 .= '
	' . $__templater->callMacro('helper_thread_options', 'thread_status', array(
					'thread' => $__vars['thread'],
				), $__vars) . '
';
			}
			$__compilerTemp10 .= '
' . $__templater->callMacro('EWRporta_article_macros', 'thread_promote', array(
				'thread' => $__vars['thread'],
			), $__vars) . '
				';
		}
		$__compilerTemp10 .= '	
';
	}
	$__compilerTemp11 = '';
	if ($__templater->method($__vars['thread'], 'canToggleAiBots', array())) {
		$__compilerTemp11 .= '
	' . $__templater->formCheckBoxRow(array(
		), array(array(
			'name' => 'bs_aib_enable_bots',
			'label' => 'Enable AI bots',
			'checked' => $__vars['thread']['bs_aib_enable_bots'],
			'_type' => 'option',
		)), array(
		)) . '
';
	}
	$__compilerTemp12 = '';
	if ($__vars['forum']['node_id'] == $__vars['xf']['options']['fs_escrow_applicable_forum']) {
		$__compilerTemp12 .= '
' . $__templater->formSubmitRow(array(
			'submit' => 'Post Escrow',
			'icon' => 'write',
			'sticky' => 'true',
		), array(
		)) . '
	';
	} else {
		$__compilerTemp12 .= '
	' . $__templater->formSubmitRow(array(
			'submit' => 'Post thread',
			'icon' => 'write',
			'sticky' => 'true',
		), array(
		)) . '
';
	}
	$__finalCompiled .= $__templater->form('

	<div class="block-container">
		<div class="block-body">

			' . '' . '

			' . $__compilerTemp1 . '

			' . '

			' . $__templater->callMacro(null, 'type_chooser', array(
		'thread' => $__vars['thread'],
		'forum' => $__vars['forum'],
		'creatableThreadTypes' => $__vars['creatableThreadTypes'],
		'defaultThreadType' => $__vars['defaultThreadType'],
	), $__vars) . '
			
			
			
			<div class="js-inlineNewPostFields">
				' . $__templater->formEditorRow(array(
		'name' => 'message',
		'value' => ($__vars['post']['message'] ?: $__vars['forum']['draft_thread']['message']),
		'attachments' => ($__vars['attachmentData'] ? $__vars['attachmentData']['attachments'] : array()),
		'data-preview-url' => $__templater->func('link', array('forums/thread-preview', $__vars['forum'], ), false),
	), array(
		'rowtype' => 'fullWidth noLabel mergePrev',
		'label' => 'Message',
	)) . '

				' . $__templater->formRow('
					' . $__compilerTemp2 . '

					' . $__compilerTemp3 . '
				', array(
		'rowtype' => 'fullWidth noLabel mergePrev noTopPadding',
	)) . '
				

				' . $__compilerTemp4 . '
			 
			 ' . $__compilerTemp5 . '
			 
			 ' . $__templater->callMacro(null, 'type_fields', array(
		'thread' => $__vars['thread'],
		'forum' => $__vars['forum'],
		'creatableThreadTypes' => $__vars['creatableThreadTypes'],
		'defaultThreadType' => $__vars['defaultThreadType'],
		'draftOverride' => $__vars['typeDataDraftOverride'],
		'subContext' => 'full',
	), $__vars) . '

				' . $__compilerTemp6 . '

				' . $__compilerTemp8 . '

				<hr class="formRowSep" />
				' . $__compilerTemp10 . '

				' . $__compilerTemp11 . '
' . $__templater->formRowIfContent($__templater->func('captcha', array(false, false)), array(
		'label' => 'Verification',
	)) . '
			</div>
		</div>

		' . $__compilerTemp12 . '
	</div>

' . $__templater->includeTemplate('avForumsTagEss_forum_post_thread_tag_suggestion_js', $__vars) . '
' . $__templater->formHiddenVal('nodeId', $__vars['forum']['node_id'], array(
	)) . '
', array(
		'action' => ((!$__templater->test($__vars['forum']['TVForum'], 'empty', array()) AND $__vars['forum']['TVForum']['tv_parent_id']) ? $__templater->func('link', array('forums/newepisode', $__vars['forum'], ), false) : $__templater->func('link', array('forums/post-thread', $__vars['forum'], ), false)),
		'ajax' => 'true',
		'class' => 'block',
		'data-xf-init' => ' ' . ($__vars['xf']['options']['tagessSuggestTags'] ? 'tagess-suggest-from-title' : '') . ' tagess-suggest-from-prefix attachment-manager',
		'draft' => (($__vars['forum']['node_id'] == $__vars['xf']['options']['fs_escrow_applicable_forum']) ? '' : $__templater->func('link', array('forums/draft', $__vars['forum'], ), false)),
	)) . '

' . '

';
	return $__finalCompiled;
}
);