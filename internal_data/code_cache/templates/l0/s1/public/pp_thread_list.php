<?php
// FROM HASH: 3cff5afcfe75625d82c97c743c366e4f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped($__templater->escape($__vars['thread']['title']));
	$__templater->pageParams['pageNumber'] = $__vars['page'];
	$__finalCompiled .= '

';
	$__templater->includeCss('structured_list.less');
	$__finalCompiled .= '

';
	$__templater->breadcrumbs($__templater->method($__vars['thread'], 'getBreadcrumbs', array()));
	$__finalCompiled .= '

	<div class="block-container">
		<div class="block-body">
			<div class="structItemContainer">
				<div class="structItemContainer-group js-threadList">
					';
	if (!$__templater->test($__vars['prefixPosts'], 'empty', array())) {
		$__finalCompiled .= '
						';
		if ($__templater->isTraversable($__vars['prefixPosts'])) {
			foreach ($__vars['prefixPosts'] AS $__vars['prefixPost']) {
				$__finalCompiled .= '
							' . $__templater->callMacro(null, 'pp_thread_list_macros::item', array(
					'thread' => $__vars['prefixPost']['Post']['Thread'],
					'post' => $__vars['prefixPost']['Post'],
					'forum' => $__vars['forum'],
				), $__vars) . '
						';
			}
		}
		$__finalCompiled .= '
					';
	} else {
		$__finalCompiled .= '
						<div class="structItem js-emptyThreadList">
							<div class="structItem-cell">' . 'There are no threads in this forum.' . '</div>
						</div>
					';
	}
	$__finalCompiled .= '
				</div>
			</div>
		</div>
	</div>';
	return $__finalCompiled;
}
);