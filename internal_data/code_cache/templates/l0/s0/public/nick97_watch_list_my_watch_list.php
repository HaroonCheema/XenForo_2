<?php
// FROM HASH: e791c2bf3a2b0a47c95adadd15ade921
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Watch List');
	$__finalCompiled .= '

';
	$__templater->wrapTemplate('account_wrapper', $__vars);
	$__finalCompiled .= '

<div class="block-container">
	<div class="block-body">

		';
	$__templater->includeCss('structured_list.less');
	$__finalCompiled .= '
		';
	$__templater->includeCss('xfrm.less');
	$__finalCompiled .= '
			';
	if ($__templater->isTraversable($__vars['movies'])) {
		foreach ($__vars['movies'] AS $__vars['movie']) {
			$__finalCompiled .= '
		
		<div class="structItem structItem--resource" data-author="' . ($__templater->escape($__vars['resource']['User']['username']) ?: $__templater->escape($__vars['resource']['username'])) . '">
					
			<div class="structItem-cell structItem-cell--icon structItem-cell--iconExpanded">
				<div class="structItem-iconContainer">

					<img class="tvPoster" src="' . $__templater->escape($__templater->method($__vars['movie'], 'getImageUrl', array())) . '">

				</div>
			</div>
			<div class="structItem-cell structItem-cell--main" data-xf-init="touch-proxy">

				<div class="structItem-title">

					<a href="' . $__templater->func('link', array('resources', $__vars['resource'], ), true) . '" class="" data-tp-primary="on">' . $__templater->escape($__vars['movie']['Thread']['title']) . '</a>

				</div>

				';
			if ($__vars['resource']['resource_state'] != 'deleted') {
				$__finalCompiled .= '
					<div class="structItem-resourceTagLine">' . $__templater->escape($__vars['movie']['tmdb_tagline']) . '</div>
				';
			}
			$__finalCompiled .= '
			</div>
			<div class="structItem-cell structItem-cell--resourceMeta">

				<dl class="pairs pairs--justified structItem-minor structItem-metaItem structItem-metaItem--status">
					<dt>' . 'Status' . '</dt>
					<dd>' . $__templater->escape($__vars['movie']['tmdb_status']) . '</dd>
				</dl>

				<dl class="pairs pairs--justified structItem-minor structItem-metaItem structItem-metaItem--release">
					<dt>' . 'Release' . '</dt>
					<dd><a href="' . $__templater->func('link', array('resources/updates', $__vars['resource'], ), true) . '" class="u-concealed">' . $__templater->escape($__vars['movie']['tmdb_release']) . '</a></dd>
				</dl>

			</div>
		</div>
				';
		}
	}
	$__finalCompiled .= '

	</div>
	
	
</div>';
	return $__finalCompiled;
}
);