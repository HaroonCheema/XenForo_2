<?php
// FROM HASH: 2609153c5cafe0fedc34fc52d0b2888b
return array(
'macros' => array('attachment_item' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'attachment' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<a class="room room--attachment"
	   href="' . $__templater->escape($__vars['attachment']['direct_url']) . '"
	   target="_blank"
	>
		<span class="room-avatar">
			';
	if ($__vars['attachment']['has_thumbnail']) {
		$__finalCompiled .= '
				<img src="' . $__templater->escape($__vars['attachment']['thumbnail_url']) . '" alt="' . $__templater->escape($__vars['attachment']['filename']) . '"
					 width="' . $__templater->escape($__vars['attachment']['thumbnail_width']) . '" height="' . $__templater->escape($__vars['attachment']['thumbnail_height']) . '" loading="lazy" />
				';
	} else if ($__vars['attachment']['is_video'] AND $__vars['canView']) {
		$__finalCompiled .= '
				<video data-xf-init="video-init">
					<source src="' . $__templater->escape($__vars['attachment']['direct_url']) . '" />
				</video>
				';
	} else {
		$__finalCompiled .= '
				<span class="file-typeIcon">
					' . $__templater->fontAwesome($__templater->escape($__vars['attachment']['icon']), array(
		)) . '
				</span>
			';
	}
	$__finalCompiled .= '
		</span>
		
		<span class="room-content">
			<span class="room-title-with-markers">
				<span class="room-title" title="' . $__templater->escape($__vars['attachment']['filename']) . '">
					' . $__templater->escape($__vars['attachment']['filename']) . '
				</span>
				<span class="room-extra">
					<ul class="room-extraInfo">
						<li>' . $__templater->func('date_dynamic', array($__vars['attachment']['attach_date'], array(
	))) . '</li>
					</ul>
				</span>
			</span>
			<span class="room-latest-message js-roomLatestMessage">
				' . $__templater->filter($__vars['attachment']['file_size'], array(array('file_size', array()),), true) . ' · ' . $__templater->escape($__vars['attachment']['Container']['username']) . ' ➝ ' . $__templater->escape($__vars['attachment']['Container']['Conversation']['title']) . '
			</span>
		</span>
	</a>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if (!$__templater->test($__vars['attachments'], 'empty', array())) {
		$__finalCompiled .= '	
	<div class="scrollable-container">
		<div class="scrollable">
			<div class="attachment-items-container">
				';
		if ($__templater->isTraversable($__vars['attachments'])) {
			foreach ($__vars['attachments'] AS $__vars['attachment']) {
				$__finalCompiled .= '
					' . $__templater->callMacro(null, 'attachment_item', array(
					'attachment' => $__vars['attachment'],
					'canView' => true,
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
	<div class="search-fault">' . 'No attachments found.' . '</div>
';
	}
	$__finalCompiled .= '

';
	return $__finalCompiled;
}
);