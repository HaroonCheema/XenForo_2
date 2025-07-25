<?php
// FROM HASH: ce6144df15ac757a8a833c2427cd55b9
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Mail Listing');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('Add list', array(
		'href' => $__templater->func('link', array('mailing-lists/add', ), false),
		'icon' => 'add',
	), '', array(
	)) . '
');
	$__finalCompiled .= '

<div class="block">
	';
	if (!$__templater->test($__vars['mailingLists'], 'empty', array())) {
		$__finalCompiled .= '
		<div class="block-outer">
			' . $__templater->callMacro('filter_macros', 'quick_filter', array(
			'key' => 'mailing-lists',
			'ajax' => $__templater->func('link', array('mailing-lists', null, ), false),
			'class' => 'block-outer-opposite',
		), $__vars) . '
		</div>
	';
	}
	$__finalCompiled .= '


	<div class="block-container">
		';
	if (!$__templater->test($__vars['mailingLists'], 'empty', array())) {
		$__finalCompiled .= '
			';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['mailingLists'])) {
			foreach ($__vars['mailingLists'] AS $__vars['mailingList']) {
				$__compilerTemp1 .= '
							';
				$__compilerTemp2 = array(array(
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['mailingList']['title']),
				));
				if ($__vars['mailingList']['type']) {
					$__compilerTemp2[] = array(
						'_type' => 'cell',
						'html' => 'UserGroups',
					);
				} else {
					$__compilerTemp2[] = array(
						'_type' => 'cell',
						'html' => 'File',
					);
				}
				if ($__vars['mailingList']['process_status'] == 0) {
					$__compilerTemp2[] = array(
						'_type' => 'cell',
						'html' => 'Pending',
					);
				} else if ($__vars['mailingList']['process_status'] == 1) {
					$__compilerTemp2[] = array(
						'_type' => 'cell',
						'html' => 'Processing',
					);
				} else if ($__vars['mailingList']['process_status'] == 2) {
					$__compilerTemp2[] = array(
						'_type' => 'cell',
						'html' => 'Completed',
					);
				}
				$__compilerTemp2[] = array(
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['mailingList']['total_emails']),
				);
				$__compilerTemp2[] = array(
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['mailingList']['sent_emails']),
				);
				$__compilerTemp3 = '';
				if ($__vars['mailingList']['process_status'] == 2) {
					$__compilerTemp3 .= '
										Completed	
									';
				} else if ($__vars['mailingList']['next_run']) {
					$__compilerTemp3 .= '
										' . $__templater->func('date_dynamic', array($__vars['mailingList']['next_run'], array(
					))) . '
									';
				} else if (!$__vars['mailingList']['next_run']) {
					$__compilerTemp3 .= '
										Soon Start
									';
				}
				$__compilerTemp2[] = array(
					'_type' => 'cell',
					'html' => '
									' . $__compilerTemp3 . '
								',
				);
				$__compilerTemp2[] = array(
					'name' => 'active[' . $__vars['mailingList']['mailing_list_id'] . ']',
					'selected' => $__vars['mailingList']['active'],
					'class' => 'dataList-cell--separated',
					'submit' => 'true',
					'tooltip' => 'Enable / disable \'' . $__vars['mailingList']['title'] . '\'',
					'_type' => 'toggle',
					'html' => '',
				);
				$__compilerTemp2[] = array(
					'href' => $__templater->func('link', array('mailing-lists/queue-list', $__vars['mailingList'], ), false),
					'_type' => 'action',
					'html' => 'List',
				);
				$__compilerTemp2[] = array(
					'href' => $__templater->func('link', array('mailing-lists/edit', $__vars['mailingList'], ), false),
					'_type' => 'action',
					'html' => 'Edit',
				);
				$__compilerTemp2[] = array(
					'href' => $__templater->func('link', array('mailing-lists/delete', $__vars['mailingList'], ), false),
					'_type' => 'delete',
					'html' => '',
				);
				$__compilerTemp1 .= $__templater->dataRow(array(
				), $__compilerTemp2) . '
						';
			}
		}
		$__finalCompiled .= $__templater->form('
			
				<div class="block-body">

					' . $__templater->dataList('
						' . $__templater->dataRow(array(
			'rowtype' => 'header',
		), array(array(
			'_type' => 'cell',
			'html' => 'Title',
		),
		array(
			'_type' => 'cell',
			'html' => 'Type',
		),
		array(
			'_type' => 'cell',
			'html' => 'Status',
		),
		array(
			'_type' => 'cell',
			'html' => 'Total Emails',
		),
		array(
			'_type' => 'cell',
			'html' => 'Send Mails',
		),
		array(
			'_type' => 'cell',
			'html' => 'Next Run',
		),
		array(
			'class' => 'dataList-cell--min',
			'_type' => 'cell',
			'html' => '&nbsp;',
		),
		array(
			'class' => 'dataList-cell--min',
			'_type' => 'cell',
			'html' => '&nbsp;',
		),
		array(
			'class' => 'dataList-cell--min',
			'_type' => 'cell',
			'html' => '&nbsp;',
		),
		array(
			'class' => 'dataList-cell--min',
			'_type' => 'cell',
			'html' => '&nbsp;',
		))) . '
						' . $__compilerTemp1 . '
					', array(
			'data-xf-init' => 'responsive-data-list',
		)) . '
				</div>
				<div class="block-footer block-footer--split">
					<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['items'], $__vars['total'], ), true) . '</span>
				</div>
			', array(
			'action' => $__templater->func('link', array('mailing-lists/toggle', ), false),
			'class' => 'block',
			'ajax' => 'true',
		)) . '
		';
	} else {
		$__finalCompiled .= '
			<div class="block-body block-row">' . 'No results found.' . '</div>
		';
	}
	$__finalCompiled .= '
	</div>

	' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => 'mailing-lists',
		'params' => $__vars['filters'],
		'wrapperclass' => 'js-filterHide block-outer block-outer--after',
		'perPage' => $__vars['perPage'],
	))) . '
	
</div>';
	return $__finalCompiled;
}
);