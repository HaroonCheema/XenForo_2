<?php
// FROM HASH: 6bf1ef3258a1179c938f46054cf61b61
return array(
'macros' => array('addCheckboxes' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'namePrefix' => null,
		'additional' => null,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<a onclick="toggle(\'' . $__templater->escape($__vars['namePrefix']) . '[temp_media_id]\');">' . 'Show' . '</a> <br />
	<div id="' . $__templater->escape($__vars['namePrefix']) . '[temp_media_id]" class="ts-mgm-checkboxes">
		';
	if ($__templater->isTraversable($__vars['additional'])) {
		foreach ($__vars['additional'] AS $__vars['cat']) {
			$__finalCompiled .= '
			';
			$__compilerTemp1 = array();
			if ($__vars['namePrefix']) {
				$__vars['name'] = $__vars['namePrefix'] . '[additional][]';
			} else {
				$__vars['name'] = 'additional[]';
			}
			$__compilerTemp1[] = array(
				'value' => $__vars['cat']['category_id'],
				'name' => $__vars['name'],
				'label' => $__templater->escape($__vars['cat']['title']) . ' ',
				'_type' => 'option',
			);
			$__finalCompiled .= $__templater->formCheckBox(array(
			), $__compilerTemp1) . '
		';
		}
	}
	$__finalCompiled .= '
	</div>
';
	return $__finalCompiled;
}
),
'addCheckboxes2' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'namePrefix' => null,
		'additional' => null,
		'mediaItemAdditionals' => null,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	
	<dl class="formRow formRow--input" >
		<dt><a onclick="toggle(\'' . $__templater->escape($__vars['namePrefix']) . '[temp_media_id]\');">' . 'Show' . ' ' . 'Additional categories' . '</a></dt>
	</dl>
	<div id="' . $__templater->escape($__vars['namePrefix']) . '[temp_media_id]" class="ts-mgm-checkboxes">
		';
	$__compilerTemp1 = array();
	if ($__templater->isTraversable($__vars['additional'])) {
		foreach ($__vars['additional'] AS $__vars['cat']) {
			if ($__vars['namePrefix']) {
				$__vars['name'] = $__vars['namePrefix'] . '[additional][]';
			} else {
				$__vars['name'] = 'additional[]';
			}
			$__compilerTemp1[] = array(
				'value' => $__vars['cat']['category_id'],
				'name' => $__vars['name'],
				'label' => $__templater->escape($__vars['cat']['title']) . ' ',
				'checked' => ($__templater->func('in_array', array($__vars['cat'], $__vars['mediaItemAdditionals'], ), false) ? 'true' : ''),
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->formCheckBoxRow(array(
	), $__compilerTemp1, array(
		'label' => 'Additional categories',
	)) . '
	</div>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

';
	return $__finalCompiled;
}
);