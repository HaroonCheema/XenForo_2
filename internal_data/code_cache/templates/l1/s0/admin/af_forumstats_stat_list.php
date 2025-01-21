<?php
// FROM HASH: 14c4bb886859197f5facaa16d11df0b5
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Advanced Forum Stats');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
    ' . $__templater->button('Add Stat', array(
		'href' => $__templater->func('link', array('forum-stats/add', ), false),
		'icon' => 'add',
		'overlay' => 'true',
	), '', array(
	)) . '
');
	$__finalCompiled .= '


';
	$__vars['totals'] = '0';
	$__compilerTemp1 = '';
	if ($__templater->isTraversable($__vars['forumStatPositions'])) {
		foreach ($__vars['forumStatPositions'] AS $__vars['position'] => $__vars['forumStatPosition']) {
			$__compilerTemp1 .= '
            <div class="block-body">
                ';
			$__compilerTemp2 = '';
			if ($__templater->isTraversable($__vars['forumStatPosition'])) {
				foreach ($__vars['forumStatPosition'] AS $__vars['forumStat']) {
					$__compilerTemp2 .= '
                        ' . $__templater->dataRow(array(
						'label' => $__templater->escape($__vars['forumStat']['title']),
						'href' => $__templater->func('link', array('forum-stats/edit', $__vars['forumStat'], ), false),
						'rowclass' => ($__vars['forumStat']['active'] ? '' : 'dataList-row--deleted'),
						'hint' => '',
						'explain' => '',
					), array(array(
						'name' => 'active[' . $__vars['forumStat']['stat_id'] . ']',
						'selected' => $__vars['forumStat']['active'],
						'class' => 'dataList-cell--separated',
						'submit' => 'true',
						'tooltip' => 'Enable / disable \'' . $__vars['forumStat']['title'] . '\'',
						'_type' => 'toggle',
						'html' => '',
					),
					array(
						'href' => $__templater->func('link', array('forum-stats/delete', $__vars['forumStat'], ), false),
						'tooltip' => 'Delete',
						'_type' => 'delete',
						'html' => '',
					))) . '
                    ';
				}
			}
			$__compilerTemp1 .= $__templater->dataList('
                    ' . $__templater->dataRow(array(
				'rowtype' => 'subsection',
				'rowclass' => 'dataList-row--noHover',
			), array(array(
				'colspan' => '3',
				'_type' => 'cell',
				'html' => 'Position: ' . $__templater->filter($__vars['position'], array(array('to_upper', array('ucwords', )),), true),
			))) . '
                    ' . $__compilerTemp2 . '
                ', array(
			)) . '
            </div>
            ';
			$__vars['totals'] = ($__vars['totals'] + $__templater->func('count', array($__vars['forumStatPosition'], ), false));
			$__compilerTemp1 .= '
        ';
		}
	}
	$__finalCompiled .= $__templater->form('
    <div class="block-container">
        ' . '' . '
        ' . $__compilerTemp1 . '

        <div class="block-footer">
            <span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['totals'], ), true) . '</span>
        </div>
    </div>
', array(
		'action' => $__templater->func('link', array('forum-stats/toggle', ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);