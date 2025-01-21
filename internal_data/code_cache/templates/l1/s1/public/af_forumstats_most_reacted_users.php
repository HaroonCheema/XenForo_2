<?php
// FROM HASH: 25d99e834578d1280194431b2c0823d1
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="block-body">
    ';
	if (!$__templater->test($__vars['users'], 'empty', array())) {
		$__finalCompiled .= '
        ';
		$__compilerTemp1 = '';
		$__vars['i'] = 0;
		if ($__templater->isTraversable($__vars['users'])) {
			foreach ($__vars['users'] AS $__vars['user']) {
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
				$__compilerTemp2[] = array(
					'class' => 'dataList-cell--min dataList-cell--image dataList-cell--imageSmall',
					'href' => $__templater->func('link', array('members', $__vars['user'], ), false),
					'_type' => 'cell',
					'html' => '
                        ' . $__templater->func('avatar', array($__vars['user'], 'xxs', false, array(
					'defaultname' => $__vars['user']['username'],
				))) . '
                    ',
				);
				$__compilerTemp2[] = array(
					'href' => $__templater->func('link', array('members', $__vars['user'], ), false),
					'class' => 'dataList-cell--main dataList-cell--min',
					'_type' => 'cell',
					'html' => '
                        ' . $__templater->func('username_link', array($__vars['user'], ($__vars['options']['rich_usernames'] ? 'true' : ''), array(
					'notooltip' => 'true',
					'href' => '',
				))) . '
                    ',
				);
				$__compilerTemp2[] = array(
					'class' => 'dataList-cell--min dataList-cell--alt unit-score',
					'_type' => 'cell',
					'html' => '
                        <div class="miniCol">
                            ' . $__templater->filter($__vars['user']['reaction_score'], array(array('number', array()),), true) . '
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