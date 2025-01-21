<?php
// FROM HASH: d84bd33167ccf8840242137e66782e65
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="block-body">
    ';
	if (!$__templater->test($__vars['threads'], 'empty', array())) {
		$__finalCompiled .= '
        ';
		$__compilerTemp1 = '';
		$__vars['i'] = 0;
		if ($__templater->isTraversable($__vars['threads'])) {
			foreach ($__vars['threads'] AS $__vars['thread']) {
				$__vars['i']++;
				$__compilerTemp1 .= '
                ';
				$__vars['canPreview'] = $__templater->method($__vars['thread'], 'canPreview', array());
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
					'class' => 'dataList-cell--main ' . ($__templater->method($__vars['thread'], 'isUnread', array()) ? 'dataList-cell--highlighted' : ''),
					'href' => $__templater->func('link', array('threads', $__vars['thread'], ), false),
					'_type' => 'cell',
					'html' => '
                        <div class="dataList-textRow">
                            <span data-xf-init="' . ($__vars['canPreview'] ? 'preview-tooltip' : '') . '" data-preview-url="' . ($__vars['canPreview'] ? $__templater->func('link', array('threads/preview', $__vars['thread'], ), true) : '') . '">' . ($__vars['options']['thread_prefix'] ? $__templater->func('prefix', array('thread', $__vars['thread'], $__vars['options']['thread_prefix'], ), true) : '') . $__templater->escape($__vars['thread']['title']) . '</span>
                        </div>
                    ',
				);
				$__compilerTemp2[] = array(
					'class' => 'dataList-cell--min dataList-cell--alt unit-likes',
					'_type' => 'cell',
					'html' => '
                        <div class="miniCol">
                            ' . $__templater->filter($__vars['thread']['first_post_likes'], array(array('number', array()),), true) . '
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