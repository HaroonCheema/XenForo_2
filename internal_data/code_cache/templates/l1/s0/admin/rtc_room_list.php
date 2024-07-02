<?php
// FROM HASH: 865145661448aeffa96931a8c00f975a
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Rooms');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('Create room', array(
		'href' => $__templater->func('link', array('chat/rooms/add', ), false),
		'icon' => 'add',
	), '', array(
	)) . '
');
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['rooms'], 'empty', array())) {
		$__finalCompiled .= '
	<div class="block">
		<div class="block-container">
			<div class="block-body">
				';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['rooms'])) {
			foreach ($__vars['rooms'] AS $__vars['room']) {
				$__compilerTemp1 .= '
						';
				$__compilerTemp2 = '';
				if ($__vars['room']['pinned']) {
					$__compilerTemp2 .= '
									' . $__templater->fontAwesome('fa-thumbtack', array(
					)) . '
								';
				}
				$__compilerTemp1 .= $__templater->dataRow(array(
				), array(array(
					'class' => 'dataList-cell--min',
					'href' => $__templater->func('link', array('chat/rooms/edit', $__vars['room'], ), false),
					'_type' => 'cell',
					'html' => '
								' . $__templater->func('rtc_room_avatar', array($__vars['room'], 'xs', ), true) . '
							',
				),
				array(
					'href' => $__templater->func('link', array('chat/rooms', $__vars['room'], ), false),
					'_type' => 'cell',
					'html' => '
								' . $__templater->escape($__vars['room']['tag']) . '
								' . $__compilerTemp2 . '
							',
				),
				array(
					'href' => $__templater->func('link', array('chat/rooms', $__vars['room'], ), false),
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['room']['type']),
				),
				array(
					'href' => $__templater->func('link', array('chat/rooms/delete', $__vars['room'], ), false),
					'tooltip' => 'Delete',
					'_type' => 'delete',
					'html' => '',
				))) . '
					';
			}
		}
		$__finalCompiled .= $__templater->dataList('
					' . $__compilerTemp1 . '
				', array(
		)) . '
			</div>
			<div class="block-footer">
				<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['rooms'], $__vars['total'], ), true) . '</span>
			</div>
		</div>

		' . $__templater->func('page_nav', array(array(
			'page' => $__vars['page'],
			'total' => $__vars['total'],
			'link' => 'chat/rooms',
			'wrapperclass' => 'block-outer block-outer--after',
			'perPage' => $__vars['perPage'],
		))) . '
	</div>
';
	} else {
		$__finalCompiled .= '
	<div class="blockMessage">' . 'There are no rooms in the chat.' . '</div>
';
	}
	return $__finalCompiled;
}
);