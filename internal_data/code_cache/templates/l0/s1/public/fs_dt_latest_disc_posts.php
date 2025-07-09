<?php
// FROM HASH: 0c2edd9c6d024568bfbbbda2b4be8739
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if (!$__templater->test($__vars['discPosts'], 'empty', array()) AND ($__vars['forum']['Node']['disc_node_id'] AND $__templater->func('in_array', array($__vars['thread']['node_id'], $__vars['xf']['options']['dt_applicable_forums_discussion'], ), false))) {
		$__finalCompiled .= '
	<div class="block" ' . $__templater->func('widget_data', array($__vars['widget'], ), true) . '>
		<div class="block-container">
			<h3 class="block-header">' . 'Latest discussions' . '   </h3>
			<div class="block-body">
				<div class="structItemContainer">
					';
		if ($__templater->isTraversable($__vars['discPosts'])) {
			foreach ($__vars['discPosts'] AS $__vars['post']) {
				$__finalCompiled .= '
						' . $__templater->callMacro('fs_post_macro', 'post', array(
					'note' => $__vars['post'],
				), $__vars) . '	
					';
			}
		}
		$__finalCompiled .= '
				</div>
			</div>
		</div>
	</div>
';
	}
	$__finalCompiled .= '

';
	return $__finalCompiled;
}
);