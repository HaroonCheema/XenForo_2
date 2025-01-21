<?php
// FROM HASH: 7002a051d48ba90447ed0d2170441014
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
					'class' => 'dataList-cell--min dataList-cell--alt dataList-cell--image dataList-cell--imageSmall',
					'href' => $__templater->func('link', array('members', $__vars['thread']['User'], ), false),
					'_type' => 'cell',
					'html' => '
                        ' . $__templater->func('avatar', array($__vars['thread']['User'], 'xxs', false, array(
					'defaultname' => $__vars['thread']['username'],
				))) . '
                    ',
				);
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
				if ($__vars['options']['show_forum_title']) {
					$__compilerTemp2[] = array(
						'class' => 'dataList-cell--min dataList-cell--forumStats-forumTitle',
						'_type' => 'cell',
						'html' => '
                            <a href="' . $__templater->func('link', array('forums', $__vars['thread']['Forum'], ), true) . '">' . $__templater->escape($__vars['thread']['Forum']['title']) . '</a>
                        ',
					);
				}
				$__compilerTemp2[] = array(
					'class' => 'dataList-cell--min dataList-cell--alt',
					'_type' => 'cell',
					'html' => '
                        <div class="miniCol">
                            ' . $__templater->func('date_dynamic', array($__vars['thread']['post_date'], array(
				))) . '
                        </div>
                    ',
				);
				if ($__vars['options']['show_last_poster']) {
					$__compilerTemp2[] = array(
						'class' => 'dataList-cell--min dataList-cell--alt',
						'_type' => 'cell',
						'html' => '
                            ' . $__templater->func('username_link', array($__vars['thread']['LastPoster'], ($__vars['options']['show_last_poster_rich'] ? 'true' : ''), array(
						'defaultname' => $__vars['thread']['last_post_username'],
					))) . '
                        ',
					);
				}
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