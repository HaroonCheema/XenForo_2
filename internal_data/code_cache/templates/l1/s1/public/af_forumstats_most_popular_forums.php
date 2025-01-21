<?php
// FROM HASH: 56d5e9c007e1d7d03b81e9bcd5a100cf
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="block-body">
    ';
	if (!$__templater->test($__vars['forums'], 'empty', array())) {
		$__finalCompiled .= '
        ';
		$__compilerTemp1 = '';
		$__vars['i'] = 0;
		if ($__templater->isTraversable($__vars['forums'])) {
			foreach ($__vars['forums'] AS $__vars['forum']) {
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
					'class' => 'dataList-cell--main',
					'href' => $__templater->func('link', array('forums', $__vars['forum'], ), false),
					'_type' => 'cell',
					'html' => '
                        <div class="dataList-textRow">' . $__templater->escape($__vars['forum']['title']) . '</div>
                    ',
				);
				$__compilerTemp2[] = array(
					'class' => 'dataList-cell--min dataList-cell--alt unit-posts',
					'_type' => 'cell',
					'html' => '
                        <div class="miniCol">
                            ' . $__templater->filter($__vars['forum']['message_count'], array(array('number', array()),), true) . '
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