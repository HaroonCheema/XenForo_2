<?php
// FROM HASH: 6e25e796641404eb68cd46984d4c7915
return array(
'macros' => array('result' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'userConv' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="room js-roomResult js-searchClose" 
	   data-room-tag="' . $__templater->escape($__vars['userConv']['conversation_id']) . '"
	   data-room-title="' . $__templater->escape($__vars['userConv']['Master']['title']) . '"
	   data-room-menu-href="' . $__templater->func('link', array('conversations/messenger/menu', array('tag' => $__vars['userConv']['conversation_id'], ), ), true) . '"
	   data-history-url="' . ($__templater->func('contains', array($__templater->method($__vars['xf']['request'], 'filter', array('_xfRequestUri', 'str', )), 'messenger', ), false) ? $__templater->func('link', array('conversations/messenger', array('tag' => $__vars['userConv']['conversation_id'], ), ), true) : $__templater->func('link', array('conversations', $__vars['userConv'], ), true)) . '"
	   data-can-post-message="' . ($__templater->method($__vars['userConv']['Master'], 'canReply', array()) ? 'true' : 'false') . '"
	   data-theme="' . $__templater->filter($__vars['userConv']['Master']['theme'], array(array('json', array()),), true) . '"
	   data-draft-url="' . $__templater->func('link', array('conversations/draft', $__vars['userConv']['Master'], ), true) . '"
	   data-pinned="0"
	   data-xf-click=""
	   data-last-message="' . $__templater->escape($__vars['userConv']['last_message_date']) . '"
	>
		<div class="room-avatar">
			' . $__templater->func('avatar', array($__vars['userConv']['AvatarUser'], 's', false, array(
		'class' => 'js-roomAvatar',
		'notooltip' => 'true',
		'href' => '',
	))) . '
		</div>
		
		<div class="room-content">
			<div class="room-title-with-markers">
				<div class="room-title" title="' . $__templater->escape($__vars['userConv']['Master']['title']) . '">
					' . $__templater->escape($__vars['userConv']['Master']['title']) . '
				</div>
			</div>
			<div class="room-latest-message js-roomLatestMessage">
				' . $__templater->func('date_dynamic', array($__vars['userConv']['Master']['start_date'], array(
	))) . '
				
				';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '
								';
	if (!$__vars['userConv']['Master']['conversation_open']) {
		$__compilerTemp1 .= '
									<li data-xf-init="tooltip" title="' . $__templater->filter('Locked', array(array('for_attr', array()),), true) . '">
										' . $__templater->fontAwesome('fas fa-lock', array(
		)) . '
									</li>
								';
	}
	$__compilerTemp1 .= '
								';
	if ($__vars['userConv']['is_starred']) {
		$__compilerTemp1 .= '
									<li class="extra-item extra-item--attention" data-xf-init="tooltip" title="' . $__templater->filter('Starred', array(array('for_attr', array()),), true) . '">
										' . $__templater->fontAwesome('fas fa-star', array(
		)) . '
									</li>
								';
	}
	$__compilerTemp1 .= '
							';
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
					<div class="room-extra">
						<ul class="room-extraInfo">
							' . $__compilerTemp1 . '
						</ul>
					</div>
				';
	}
	$__finalCompiled .= '
			</div>
		</div>
	</div>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if (!$__templater->test($__vars['userConvs'], 'empty', array())) {
		$__finalCompiled .= '	
	<div class="scrollable-container">
		<div class="scrollable">
			<div class="room-items-container">
				';
		if ($__templater->isTraversable($__vars['userConvs'])) {
			foreach ($__vars['userConvs'] AS $__vars['userConv']) {
				$__finalCompiled .= '
					' . $__templater->callMacro(null, 'result', array(
					'userConv' => $__vars['userConv'],
				), $__vars) . '
				';
			}
		}
		$__finalCompiled .= '
			</div>
		</div>
	</div>
	';
	} else {
		$__finalCompiled .= '
	<div class="search-fault">' . 'No conversations found for your request.' . '</div>
';
	}
	$__finalCompiled .= '

';
	return $__finalCompiled;
}
);