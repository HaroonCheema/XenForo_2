<?php
// FROM HASH: 49358e6e5c90e4a0d7c727cf8d6656d0
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('AI bots');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('Add bot', array(
		'href' => $__templater->func('link', array('ai-bots/add', ), false),
		'icon' => 'add',
	), '', array(
	)) . '
');
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['bots'], 'empty', array())) {
		$__finalCompiled .= '
	';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['handlers'])) {
			foreach ($__vars['handlers'] AS $__vars['handlerClass'] => $__vars['handlerTitle']) {
				$__compilerTemp1 .= '
						';
				if (!$__templater->test($__vars['groupedBots'][$__vars['handlerClass']], 'empty', array())) {
					$__compilerTemp1 .= '
							' . $__templater->dataRow(array(
						'rowtype' => 'subsection',
						'rowclass' => 'dataList-row--noHover',
					), array(array(
						'colspan' => '4',
						'_type' => 'cell',
						'html' => $__templater->escape($__vars['handlerTitle']),
					))) . '
							';
					if ($__templater->isTraversable($__vars['groupedBots'][$__vars['handlerClass']])) {
						foreach ($__vars['groupedBots'][$__vars['handlerClass']] AS $__vars['bot']) {
							$__compilerTemp1 .= '
								' . $__templater->dataRow(array(
							), array(array(
								'class' => 'dataList-cell--min dataList-cell--image dataList-cell--imageSmall',
								'href' => $__templater->func('link', array('ai-bots/edit', $__vars['bot'], ), false),
								'_type' => 'cell',
								'html' => '
										' . $__templater->func('avatar', array($__vars['bot']['User'], 's', false, array(
								'href' => '',
							))) . '
									',
							),
							array(
								'href' => $__templater->func('link', array('ai-bots/edit', $__vars['bot'], ), false),
								'label' => $__templater->func('username_link', array($__vars['bot']['User'], true, array(
								'notooltip' => 'true',
								'href' => '',
							))),
								'_type' => 'main',
								'html' => '',
							),
							array(
								'name' => 'is_active[' . $__vars['bot']['bot_id'] . ']',
								'selected' => $__vars['bot']['is_active'],
								'class' => 'dataList-cell--separated',
								'submit' => 'true',
								'tooltip' => 'Enable / disable \'' . $__vars['bot']['username'] . '\'',
								'_type' => 'toggle',
								'html' => '',
							),
							array(
								'href' => $__templater->func('link', array('ai-bots/delete', $__vars['bot'], ), false),
								'_type' => 'delete',
								'html' => '',
							))) . '
							';
						}
					}
					$__compilerTemp1 .= '
						';
				}
				$__compilerTemp1 .= '
					';
			}
		}
		$__finalCompiled .= $__templater->form('
		<div class="block-container">
			<div class="block-body">
				' . $__templater->dataList('
					' . $__compilerTemp1 . '
				', array(
		)) . '
			</div>
		</div>
	', array(
			'action' => $__templater->func('link', array('ai-bots/toggle', ), false),
			'class' => 'block',
			'ajax' => 'true',
		)) . '
	' . $__templater->func('page_nav', array(array(
			'page' => $__vars['page'],
			'total' => $__vars['total'],
			'link' => 'ai-bots',
			'perPage' => $__vars['perPage'],
		))) . '
	';
	} else {
		$__finalCompiled .= '
	<div class="blockMessage">' . 'There are currently no active bots.' . '</div>
';
	}
	return $__finalCompiled;
}
);