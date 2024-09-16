<?php
// FROM HASH: 19afa66e322017ecdb5712fbce7b34bb
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['xf']['options']['enableTagging'] AND ($__templater->method($__vars['thread'], 'canEditTags', array()) OR $__vars['thread']['tags'])) {
		$__finalCompiled .= '
	';
		$__templater->includeCss('avForumsTagEss_thread_view_grouped_tags.less');
		$__finalCompiled .= '

	';
		if ($__vars['thread']['GroupedTags']) {
			$__finalCompiled .= '
		';
			if ($__templater->isTraversable($__vars['thread']['GroupedTags'])) {
				foreach ($__vars['thread']['GroupedTags'] AS $__vars['categoryId'] => $__vars['groupedTagsData']) {
					$__finalCompiled .= '
			<li class="groupedTags">
				';
					if ($__vars['groupedTagsData']['title']) {
						$__finalCompiled .= '
					<i class="fa fa-tags" aria-hidden="true" title="' . $__templater->filter($__vars['groupedTagsData']['title'], array(array('for_attr', array()),), true) . '"></i>
					<span class="u-concealed hiddenCategoryTitle">' . $__templater->escape($__vars['groupedTagsData']['title']) . '</span>
				';
					} else {
						$__finalCompiled .= '
					<i class="fa fa-tags" aria-hidden="true" title="' . $__templater->filter('Tags', array(array('for_attr', array()),), true) . '"></i>
					<span class="u-concealed"></span>
				';
					}
					$__finalCompiled .= '

				';
					if ($__templater->isTraversable($__vars['groupedTagsData']['tags'])) {
						foreach ($__vars['groupedTagsData']['tags'] AS $__vars['groupedTag']) {
							$__finalCompiled .= '
					<a href="' . $__templater->func('link', array('tags', $__vars['groupedTag'], ), true) . '" data-xf-init="preview-tooltip" data-preview-url="' . $__templater->func('link', array('tags/preview', $__vars['groupedTag'], ), true) . '" class="tagItem" dir="auto">' . $__templater->escape($__vars['groupedTag']['tag']) . '</a>
				';
						}
					}
					$__finalCompiled .= '
			</li>
		';
				}
			}
			$__finalCompiled .= '
	';
		}
		$__finalCompiled .= '
	
	';
		if ($__templater->method($__vars['thread'], 'canEditTags', array()) AND (!$__vars['hideEditLink'])) {
			$__finalCompiled .= '
		<li>
			<a href="' . $__templater->func('link', array('threads/tags', $__vars['thread'], ), true) . '" class="u-concealed" data-xf-click="overlay"
			   data-xf-init="tooltip" title="' . $__templater->filter('Edit tags', array(array('for_attr', array()),), true) . '">
				<i class="fa fa-pencil" aria-hidden="true"></i>
				<span class="u-srOnly">' . 'Edit' . '</span>
			</a>
		</li>
	';
		}
		$__finalCompiled .= '
';
	}
	return $__finalCompiled;
}
);