<?php
// FROM HASH: 9e3b261f53c11a5b63889aca9927e510
return array(
'macros' => array('depth1' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'node' => '!',
		'extras' => '!',
		'children' => '!',
		'childExtras' => '!',
		'depth' => '1',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="block">
		<div class="block-container">
			<div class="block-body">
				' . $__templater->callMacro(null, 'forum', array(
		'node' => $__vars['node'],
		'extras' => $__vars['extras'],
		'children' => $__vars['children'],
		'childExtras' => $__vars['childExtras'],
		'depth' => $__vars['depth'],
	), $__vars) . '
			</div>
		</div>
	</div>
';
	return $__finalCompiled;
}
),
'depth2' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'node' => '!',
		'extras' => '!',
		'children' => '!',
		'childExtras' => '!',
		'depth' => '1',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	' . $__templater->callMacro(null, 'forum', array(
		'node' => $__vars['node'],
		'extras' => $__vars['extras'],
		'children' => $__vars['children'],
		'childExtras' => $__vars['childExtras'],
		'depth' => $__vars['depth'],
	), $__vars) . '
';
	return $__finalCompiled;
}
),
'depthN' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'node' => '!',
		'extras' => '!',
		'children' => '!',
		'childExtras' => '!',
		'depth' => '1',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<li>
		<a href="' . $__templater->func('link', array('forums', $__vars['node'], ), true) . '" class="subNodeLink subNodeLink--forum ' . ($__vars['extras']['hasNew'] ? 'subNodeLink--unread' : '') . '">' . $__templater->escape($__vars['node']['title']) . '</a>
		' . $__templater->callMacro('forum_list', 'sub_node_list', array(
		'children' => $__vars['children'],
		'childExtras' => $__vars['childExtras'],
		'depth' => ($__vars['depth'] + 1),
	), $__vars) . '
	</li>
';
	return $__finalCompiled;
}
),
'forum' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'node' => '!',
		'extras' => '!',
		'children' => '!',
		'childExtras' => '!',
		'depth' => '!',
		'chooseName' => '',
		'bonusInfo' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	<div class="node node--id' . $__templater->escape($__vars['node']['node_id']) . ' node--depth' . $__templater->escape($__vars['depth']) . ' node--forum ' . ($__vars['extras']['hasNew'] ? 'node--unread' : 'node--read') . '">
		<div class="node-body">
			';
	if ($__templater->method($__vars['node'], 'getIcon', array())) {
		$__finalCompiled .= '
	<div class="node-icon--custom read" 
		 style="background-image: url(' . $__templater->func('base_url', array($__templater->method($__vars['node'], 'getIcon', array()), ), true) . ');
				width: ' . $__templater->escape($__vars['xf']['options']['Fs_NodeIcon_nodeDimensions']['width']) . 'px;
				height: ' . $__templater->escape($__vars['xf']['options']['Fs_NodeIcon_nodeDimensions']['height']) . 'px;">
	</div>
';
	} else {
		$__finalCompiled .= '
	<span class="node-icon" aria-hidden="true"
		  style="width: ' . $__templater->escape($__vars['xf']['options']['Fs_NodeIcon_nodeDimensions']['width']) . 'px;
				 height: ' . $__templater->escape($__vars['xf']['options']['Fs_NodeIcon_nodeDimensions']['height']) . 'px;">
		' . $__templater->fontAwesome(($__templater->escape($__templater->method($__vars['node']['Data']['TypeHandler'], 'getTypeIconClass', array())) ?: 'fa-comments'), array(
		)) . '
	</span>
';
	}
	$__finalCompiled .= '
			<div class="node-main js-nodeMain">
				';
	if ($__vars['chooseName']) {
		$__finalCompiled .= '
					' . $__templater->formCheckBox(array(
			'standalone' => 'true',
		), array(array(
			'labelclass' => 'u-pullRight',
			'class' => 'js-chooseItem',
			'name' => $__vars['chooseName'] . '[]',
			'value' => $__vars['node']['node_id'],
			'_type' => 'option',
		))) . '
				';
	}
	$__finalCompiled .= '

				';
	$__vars['descriptionDisplay'] = $__templater->func('property', array('nodeListDescriptionDisplay', ), false);
	$__finalCompiled .= '
				<h3 class="node-title">
					<a href="' . $__templater->func('link', array('forums', $__vars['node'], ), true) . '" data-xf-init="' . (($__vars['descriptionDisplay'] == 'tooltip') ? 'element-tooltip' : '') . '" data-shortcut="node-description">' . $__templater->escape($__vars['node']['title']) . '</a>
				</h3>
				';
	if (($__vars['descriptionDisplay'] != 'none') AND $__vars['node']['description']) {
		$__finalCompiled .= '
					<div class="node-description ' . (($__vars['descriptionDisplay'] == 'tooltip') ? 'node-description--tooltip js-nodeDescTooltip' : '') . '">' . $__templater->filter($__vars['node']['description'], array(array('raw', array()),), true) . '</div>
				';
	}
	$__finalCompiled .= '

				<div class="node-meta">
					';
	if (!$__vars['extras']['privateInfo']) {
		$__finalCompiled .= '
						<div class="node-statsMeta">
							<dl class="pairs pairs--inline">
								<dt>' . 'Threads' . '</dt>
								<dd>' . $__templater->filter($__vars['extras']['discussion_count'], array(array('number_short', array(1, )),), true) . '</dd>
							</dl>
							<dl class="pairs pairs--inline">
								<dt>' . 'Messages' . '</dt>
								<dd>' . $__templater->filter($__vars['extras']['message_count'], array(array('number_short', array(1, )),), true) . '</dd>
							</dl>
						</div>
					';
	}
	$__finalCompiled .= '

					';
	if (($__vars['depth'] == 2) AND ($__templater->func('property', array('nodeListSubDisplay', ), false) == 'menu')) {
		$__finalCompiled .= '
						' . $__templater->callMacro('forum_list', 'sub_nodes_menu', array(
			'children' => $__vars['children'],
			'childExtras' => $__vars['childExtras'],
			'depth' => ($__vars['depth'] + 1),
		), $__vars) . '
					';
	}
	$__finalCompiled .= '
				</div>

				';
	if (($__vars['depth'] == 2) AND ($__templater->func('property', array('nodeListSubDisplay', ), false) == 'flat')) {
		$__finalCompiled .= '
					' . $__templater->callMacro('forum_list', 'sub_nodes_flat', array(
			'children' => $__vars['children'],
			'childExtras' => $__vars['childExtras'],
			'depth' => ($__vars['depth'] + 1),
		), $__vars) . '
				';
	}
	$__finalCompiled .= '

				';
	if (!$__templater->test($__vars['bonusInfo'], 'empty', array())) {
		$__finalCompiled .= '
					<div class="node-bonus">' . $__templater->escape($__vars['bonusInfo']) . '</div>
				';
	}
	$__finalCompiled .= '
			</div>

			';
	if (!$__vars['extras']['privateInfo']) {
		$__finalCompiled .= '
				<div class="node-stats">
					<dl class="pairs pairs--rows">
						<dt>' . 'Threads' . '</dt>
						<dd>' . $__templater->filter($__vars['extras']['discussion_count'], array(array('number_short', array(1, )),), true) . '</dd>
					</dl>
					<dl class="pairs pairs--rows">
						<dt>' . 'Messages' . '</dt>
						<dd>' . $__templater->filter($__vars['extras']['message_count'], array(array('number_short', array(1, )),), true) . '</dd>
					</dl>
				</div>
			';
	}
	$__finalCompiled .= '

';
	$__vars['svMultiPrefixSubtitle'] = (($__vars['svMultiPrefixSubtitle'] === null) ? $__templater->func('property', array('svMultiPrefixSubtitle', ), false) : $__vars['svMultiPrefixSubtitle']);
	$__finalCompiled .= '
			<div class="node-extra">
				';
	if ($__vars['extras']['privateInfo']) {
		$__finalCompiled .= '
					<span class="node-extra-placeholder">' . 'Private' . '</span>
				';
	} else if ($__vars['extras']['LastThread']) {
		$__finalCompiled .= '
';
		if ($__vars['svMultiPrefixSubtitle'] === 'subtitle') {
			$__finalCompiled .= '
	';
			$__vars['isSubTitle'] = true;
			$__finalCompiled .= '
	';
			$__vars['isSubTitle2'] = $__templater->func('property', array('svMultiPrefixSubTitlePrefixUnderThreadInfo', ), false);
			$__finalCompiled .= '	
	';
			$__compilerTemp1 = '';
			$__compilerTemp2 = '';
			$__compilerTemp2 .= '
				' . $__templater->func('prefix', array('thread', $__vars['extras']['LastThread'], ), true) . '
			';
			if (strlen(trim($__compilerTemp2)) > 0) {
				$__compilerTemp1 .= '
		';
				$__templater->includeCss('svMultiPrefix_node_list_forum_subtitle2.less');
				$__compilerTemp1 .= '

		<div class="node-extra-row node-extra-row--svPrefixes">
			' . $__compilerTemp2 . '
		</div>
	';
			}
			$__vars['svPrefixHtml'] = $__templater->preEscaped(trim($__compilerTemp1 . '
'));
			$__finalCompiled .= '
	';
			if (!$__templater->func('strlen', array($__vars['svPrefixHtml'], ), false)) {
				$__vars['isSubTitle'] = false;
			}
			$__finalCompiled .= '
';
		} else {
			$__finalCompiled .= '
	';
			$__vars['isSubTitle'] = false;
			$__finalCompiled .= '
';
		}
		$__finalCompiled .= '
					<div class="node-extra-icon' . ($__vars['isSubTitle'] ? ' node-extra-icon--prefix' : '') . '">
						';
		if ($__templater->method($__vars['xf']['visitor'], 'isIgnoring', array($__vars['extras']['last_post_user_id'], ))) {
			$__finalCompiled .= '
							' . $__templater->func('avatar', array(null, 'xs', false, array(
			))) . '
						';
		} else {
			$__finalCompiled .= '
							' . $__templater->func('avatar', array($__vars['extras']['LastPostUser'], 'xs', false, array(
				'defaultname' => $__vars['extras']['last_post_username'],
			))) . '
						';
		}
		$__finalCompiled .= '
					</div>
					<div class="node-extra-row">
						';
		if ($__templater->method($__vars['extras']['LastThread'], 'isUnread', array())) {
			$__finalCompiled .= '
							<a href="' . $__templater->func('link', array('threads/unread', $__vars['extras']['LastThread'], ), true) . '" class="node-extra-title" title="' . $__templater->escape($__vars['extras']['LastThread']['title']) . '">' . (($__vars['svMultiPrefixSubtitle'] == '') ? $__templater->func('prefix', array('thread', $__vars['extras']['LastThread'], ), true) : '') . $__templater->escape($__vars['extras']['LastThread']['title']) . (($__vars['svMultiPrefixSubtitle'] === 'suffix') ? $__templater->func('prefix', array('thread', $__vars['extras']['LastThread'], ), true) : '') . '</a>
						';
		} else {
			$__finalCompiled .= '
							<a href="' . $__templater->func('link', array('threads/post', $__vars['extras']['LastThread'], array('post_id' => $__vars['extras']['last_post_id'], ), ), true) . '" class="node-extra-title" title="' . $__templater->escape($__vars['extras']['LastThread']['title']) . '">' . (($__vars['svMultiPrefixSubtitle'] == '') ? $__templater->func('prefix', array('thread', $__vars['extras']['LastThread'], ), true) : '') . $__templater->escape($__vars['extras']['LastThread']['title']) . (($__vars['svMultiPrefixSubtitle'] === 'suffix') ? $__templater->func('prefix', array('thread', $__vars['extras']['LastThread'], ), true) : '') . '</a>
						';
		}
		$__finalCompiled .= '
					</div>
';
		if ($__vars['isSubTitle'] AND (!$__vars['isSubTitle2'])) {
			$__finalCompiled .= $__templater->filter($__vars['svPrefixHtml'], array(array('raw', array()),), true);
		}
		$__finalCompiled .= '

					<div class="node-extra-row">
						<ul class="listInline listInline--bullet">
							<li>' . $__templater->func('date_dynamic', array($__vars['extras']['last_post_date'], array(
			'class' => 'node-extra-date',
		))) . '</li>
							';
		if ($__templater->method($__vars['xf']['visitor'], 'isIgnoring', array($__vars['extras']['last_post_user_id'], ))) {
			$__finalCompiled .= '
								<li class="node-extra-user">' . 'Ignored member' . '</li>
							';
		} else {
			$__finalCompiled .= '
								<li class="node-extra-user">' . $__templater->func('username_link', array($__vars['extras']['LastPostUser'], false, array(
				'defaultname' => $__vars['extras']['last_post_username'],
			))) . '</li>
							';
		}
		$__finalCompiled .= '
						</ul>
					</div>
';
		if ($__vars['isSubTitle'] AND $__vars['isSubTitle2']) {
			$__finalCompiled .= $__templater->filter($__vars['svPrefixHtml'], array(array('raw', array()),), true);
		}
		$__finalCompiled .= '
				';
	} else {
		$__finalCompiled .= '
					<span class="node-extra-placeholder">' . 'None' . '</span>
				';
	}
	$__finalCompiled .= '
			</div>
		</div>
	</div>

	';
	if ($__vars['depth'] == 1) {
		$__finalCompiled .= '
		' . $__templater->callMacro('forum_list', 'node_list', array(
			'children' => $__vars['children'],
			'extras' => $__vars['childExtras'],
			'depth' => ($__vars['depth'] + 1),
		), $__vars) . '
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

' . '

' . '

';
	return $__finalCompiled;
}
);