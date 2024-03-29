<?php
// FROM HASH: b8de0e772ef46566ea128df0bbd9a53a
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('');
	$__finalCompiled .= '
<div class="block">
		<div class="block-container">
			<div class="block-body">
					<div class="block-header">
						<h3 class="block-minorHeader">' . '' . $__templater->escape($__vars['item']['Brand']['brand_title']) . ' ' . $__templater->escape($__vars['item']['item_title']) . ' Discussions' . '</h3>
						<div class="p-description">' . 'Here are the most recent ' . $__templater->escape($__vars['item']['item_title']) . ' topics from our community.' . '</div>
					</div>
					<div class="structItemContainer-group js-threadList">
						';
	if (!$__templater->test($__vars['threads'], 'empty', array())) {
		$__finalCompiled .= '
								';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['threads'])) {
			foreach ($__vars['threads'] AS $__vars['thread']) {
				$__compilerTemp1 .= '
										';
				$__compilerTemp2 = array();
				if ($__templater->method($__vars['xf']['visitor'], 'hasPermission', array('bh_brand_hub', 'bh_canEditDiscussionDesc', ))) {
					$__compilerTemp2[] = array(
						'name' => 'thread_ids[]',
						'value' => $__vars['thread']['thread_id'],
						'_type' => 'toggle',
						'html' => '',
					);
				}
				$__compilerTemp2[] = array(
					'_type' => 'cell',
					'html' => '
												' . $__templater->callMacro('bh_thread_list_macros', 'item', array(
					'thread' => $__vars['thread'],
				), $__vars) . '
											',
				);
				$__compilerTemp1 .= $__templater->dataRow(array(
				), $__compilerTemp2) . '
									';
			}
		}
		$__compilerTemp3 = '';
		if ($__templater->method($__vars['xf']['visitor'], 'hasPermission', array('bh_brand_hub', 'bh_canEditDiscussionDesc', ))) {
			$__compilerTemp3 .= '
									<div class="block-footer block-footer--split">
										<span class="block-footer-counter"></span>
										<span class="block-footer-select">' . $__templater->formCheckBox(array(
				'standalone' => 'true',
			), array(array(
				'check-all' => '.dataList',
				'label' => 'Select all',
				'_type' => 'option',
			))) . '</span>
										<span class="block-footer-controls">' . $__templater->button('', array(
				'type' => 'submit',
				'name' => 'quickdelete',
				'value' => '1',
				'icon' => 'delete',
			), '', array(
			)) . '</span>
									</div>
								';
		}
		$__finalCompiled .= $__templater->form('
									

								' . $__templater->dataList('
									' . $__compilerTemp1 . '
								', array(
			'data-xf-init' => 'responsive-data-list',
		)) . '
								' . $__compilerTemp3 . '
							', array(
			'action' => $__templater->func('link', array('bh-item/quick-delete', $__vars['item'], ), false),
			'ajax' => 'true',
			'data-xf-init' => 'select-plus',
			'data-sp-checkbox' => '.dataList-cell--toggle input:checkbox',
			'data-sp-container' => '.dataList-row',
			'data-sp-control' => '.dataList-cell a',
		)) . '
						';
	}
	$__finalCompiled .= '
					</div>
			</div>
		</div>
</div>';
	return $__finalCompiled;
}
);