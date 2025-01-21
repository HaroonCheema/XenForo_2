<?php
// FROM HASH: 76316c22634d6f356e20da96e6fe7399
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="block-body">
    ';
	if (!$__templater->test($__vars['resources'], 'empty', array())) {
		$__finalCompiled .= '
        ';
		$__compilerTemp1 = '';
		$__vars['i'] = 0;
		if ($__templater->isTraversable($__vars['resources'])) {
			foreach ($__vars['resources'] AS $__vars['resource']) {
				$__vars['i']++;
				$__compilerTemp1 .= '

                ';
				$__compilerTemp2 = array();
				if ($__vars['options']['show_counter']) {
					$__compilerTemp2[] = array(
						'class' => 'dataList-cell--min dataList-cell--alt dataList-cell--forumStats-counter',
						'_type' => 'cell',
						'html' => '
                            ' . $__templater->filter($__vars['i'], array(array('number', array()),), true) . '
                        ',
					);
				}
				if ($__vars['xf']['options']['xfrmAllowIcons']) {
					$__compilerTemp2[] = array(
						'class' => 'dataList-cell--min dataList-cell--alt dataList-cell--image dataList-cell--imageSmall',
						'href' => $__templater->func('link', array('resources', $__vars['resource'], ), false),
						'_type' => 'cell',
						'html' => '
                            ' . $__templater->func('resource_icon', array($__vars['resource'], 'xxs', $__templater->func('link', array('resources', $__vars['resource'], ), false), ), true) . '
                        ',
					);
				} else {
					$__compilerTemp2[] = array(
						'class' => 'dataList-cell--min dataList-cell--alt dataList-cell--image dataList-cell--imageSmall',
						'href' => $__templater->func('link', array('members', $__vars['resource']['User'], ), false),
						'_type' => 'cell',
						'html' => '
                            ' . $__templater->func('avatar', array($__vars['resource']['User'], 'xxs', false, array(
					))) . '
                        ',
					);
				}
				$__compilerTemp2[] = array(
					'class' => 'dataList-cell--main',
					'href' => $__templater->func('link', array('resources', $__vars['resource'], ), false),
					'_type' => 'cell',
					'html' => '
                        <div class="dataList-textRow">' . ($__vars['options']['prefix'] ? $__templater->func('prefix', array('resource', $__vars['resource'], $__vars['options']['prefix'], ), true) : '') . $__templater->escape($__vars['resource']['title']) . '</div>
                    ',
				);
				$__compilerTemp2[] = array(
					'class' => 'dataList-cell--min dataList-cell--alt',
					'_type' => 'cell',
					'html' => '
                        <div class="miniCol">
                            ' . $__templater->func('date_dynamic', array($__vars['resource']['last_update'], array(
				))) . '
                        </div>
                    ',
				);
				$__compilerTemp1 .= $__templater->dataRow(array(
				), $__compilerTemp2) . '

            ';
			}
		}
		$__finalCompiled .= $__templater->dataList('
            ' . $__compilerTemp1 . '
        ', array(
			'data-xf-init' => '',
		)) . '
    ';
	} else {
		$__finalCompiled .= '
        <div class="block-row">
            ' . 'No results found.' . '
        </div>
    ';
	}
	$__finalCompiled .= '
</div>';
	return $__finalCompiled;
}
);