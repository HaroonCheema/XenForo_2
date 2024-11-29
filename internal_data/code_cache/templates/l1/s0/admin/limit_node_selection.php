<?php
// FROM HASH: 49f8e7a9344bf1c7da6c4364369ad24d
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__vars['currentIndex'] = '0';
	$__compilerTemp1 = '';
	if ($__templater->func('count', array($__vars['options']['unique_node_ids'], ), false)) {
		$__compilerTemp1 .= '
		';
		$__vars['i'] = 0;
		if ($__templater->isTraversable($__vars['options']['unique_node_ids'])) {
			foreach ($__vars['options']['unique_node_ids'] AS $__vars['key'] => $__vars['nodeId']) {
				$__vars['i']++;
				$__compilerTemp1 .= '

			<div class="clone-limit-selection" style="display:flex;margin-top: 10px;" data-index="' . $__templater->escape($__vars['i']) . '">
				<div class="forum-selection" style="width:80%;">
					';
				$__compilerTemp2 = array();
				$__compilerTemp3 = $__templater->method($__vars['nodeTree'], 'getFlattened', array(0, ));
				if ($__templater->isTraversable($__compilerTemp3)) {
					foreach ($__compilerTemp3 AS $__vars['treeEntry']) {
						$__compilerTemp2[] = array(
							'value' => $__vars['treeEntry']['record']['node_id'],
							'disabled' => ($__vars['treeEntry']['record']['node_type_id'] != 'Forum'),
							'label' => '
								' . $__templater->filter($__templater->func('repeat', array('&nbsp;&nbsp;', $__vars['treeEntry']['depth'], ), false), array(array('raw', array()),), true) . ' ' . $__templater->escape($__vars['treeEntry']['record']['title']) . '
							',
							'_type' => 'option',
						);
					}
				}
				$__compilerTemp1 .= $__templater->formSelect(array(
					'name' => 'options[unique_node_ids][' . $__vars['i'] . '][]',
					'value' => $__vars['nodeId'],
					'multiple' => 'multiple',
					'size' => '4',
				), $__compilerTemp2) . '
					<span style="font-size: 13px;color: #8c8c8c;">' . 'Select node against limit.' . '</span>
				</div>
				<div style="width:80%;margin-right:10px;">
					' . $__templater->formTextBox(array(
					'name' => 'options[node_limits][' . $__vars['i'] . ']',
					'value' => ($__vars['options']['node_limits'][$__vars['i']] ?: -1),
					'style' => 'margin-left:10px;',
				)) . '
					<span style="font-size: 13px;color: #8c8c8c;margin-left: 10px;">' . 'Empty limit will discard.-1 will be consider unlimit.' . '</span>
				</div>
			</div>

			';
				$__vars['currentIndex'] = ($__vars['i'] + 1);
				$__compilerTemp1 .= '
		';
			}
		}
		$__compilerTemp1 .= '
	';
	}
	$__compilerTemp4 = array(array(
		'value' => '0',
		'label' => 'None',
		'_type' => 'option',
	));
	$__compilerTemp5 = $__templater->method($__vars['nodeTree'], 'getFlattened', array(0, ));
	if ($__templater->isTraversable($__compilerTemp5)) {
		foreach ($__compilerTemp5 AS $__vars['treeEntry']) {
			$__compilerTemp4[] = array(
				'value' => $__vars['treeEntry']['record']['node_id'],
				'disabled' => ($__vars['treeEntry']['record']['node_type_id'] != 'Forum'),
				'label' => '
							' . $__templater->filter($__templater->func('repeat', array('&nbsp;&nbsp;', $__vars['treeEntry']['depth'], ), false), array(array('raw', array()),), true) . ' ' . $__templater->escape($__vars['treeEntry']['record']['title']) . '
						',
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->formRow('
	<div class="check-selection-button">
		' . $__templater->button('Add Limit', array(
		'class' => 'add-limit',
	), '', array(
	)) . '
		' . $__templater->button('Remove Limit', array(
		'class' => 'remove-limit',
	), '', array(
	)) . '
	</div><br>

	' . '' . '

	' . $__compilerTemp1 . '

	<div class="limit-selection">
		<div class="clone-limit-selection" style="display:flex;margin-top: 10px;" data-index="' . $__templater->escape($__vars['currentIndex']) . '">
			<div class="forum-selection" style="width:80%;">
				' . $__templater->formSelect(array(
		'name' => 'options[unique_node_ids][' . $__vars['currentIndex'] . '][]',
		'multiple' => 'multiple',
		'size' => '4',
	), $__compilerTemp4) . '
				<span style="font-size: 13px;color: #8c8c8c;">' . 'Select node against limit.' . '</span>
			</div>
			<div style="width:80%;margin-right:10px;">
				' . $__templater->formTextBox(array(
		'name' => 'options[node_limits][' . $__vars['currentIndex'] . ']',
		'style' => 'margin-left:10px;',
	)) . '
				<span style="font-size: 13px;color: #8c8c8c;margin-left: 10px;">' . 'Empty limit will discard.-1 will be consider unlimit.' . '</span>
			</div>
		</div>
	</div>
', array(
		'label' => 'Forum Limit Selection',
	)) . '

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
	$(document).ready(function() {
		var index = $(\'.clone-limit-selection\').last().data(\'index\') + 1;

		var initialCheckboxClone = $(\'.clone-limit-selection\').last().clone();

		$(\'.add-limit\').on(\'click\', function() {
			var newClone = initialCheckboxClone.clone();

			newClone.find(\'select\').attr(\'name\', \'options[unique_node_ids][\' + index + \'][]\');
			newClone.find(\'input\').attr(\'name\', \'options[node_limits][\' + index + \']\');

			newClone.attr(\'data-index\', index);

			$(\'.limit-selection\').append(newClone);

			index++;
		});

		$(\'.remove-limit\').on(\'click\', function() {
			var allCheckboxClones = $(\'.clone-limit-selection\');
			var numberOfClones = allCheckboxClones.length;

			if (numberOfClones > 1) {
				$(\'.clone-limit-selection\').last().remove();
				index--;
			}
		});
	});
</script>';
	return $__finalCompiled;
}
);