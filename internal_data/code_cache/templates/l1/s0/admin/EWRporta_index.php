<?php
// FROM HASH: 1208178a974a6b0a475dfc9a003a3c42
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('[8WR] XenPorta 2 (Portal) PRO');
	$__finalCompiled .= '
';
	$__templater->pageParams['pageDescription'] = $__templater->preEscaped('Add-on from 8WAYRUN.');
	$__templater->pageParams['pageDescriptionMeta'] = true;
	$__finalCompiled .= '

';
	$__templater->includeCss('EWRporta.less');
	$__finalCompiled .= '

<div class="iconicLinks">
	<ul class="iconicLinks-list">
		<li>
			<a href="' . $__templater->func('link', array('ewr-porta/categories', ), true) . '">
				<div class="iconicLinks-icon">' . $__templater->fontAwesome('fa-fw fa-folder-open', array(
	)) . '</div>
				<div class="iconicLinks-title">' . 'Categories' . '</div>
			</a>
		</li>
		<li>
			<a href="' . $__templater->func('link', array('ewr-porta/articles', ), true) . '">
				<div class="iconicLinks-icon">' . $__templater->fontAwesome('fa-fw fa-newspaper', array(
	)) . '</div>
				<div class="iconicLinks-title">' . 'Articles' . '</div>
			</a>
		</li>
		<li>
			<a href="' . $__templater->func('link', array('ewr-porta/features', ), true) . '">
				<div class="iconicLinks-icon">' . $__templater->fontAwesome('fa-fw fa-images', array(
	)) . '</div>
				<div class="iconicLinks-title">' . 'Features' . '</div>
			</a>
		</li>
	</ul>
</div>

<div class="iconicLinks">
	<ul class="iconicLinks-list">
		<li>
			<a href="' . $__templater->func('link', array('ewr-porta/authors', ), true) . '">
				<div class="iconicLinks-icon">' . $__templater->fontAwesome('fa-fw fa-users', array(
	)) . '</div>
				<div class="iconicLinks-title">' . 'Authors' . '</div>
			</a>
		</li>
		<li>
			<a href="' . $__templater->func('link', array('widgets', ), true) . '">
				<div class="iconicLinks-icon">' . $__templater->fontAwesome('fa-fw fa-cogs', array(
	)) . '</div>
				<div class="iconicLinks-title">' . 'Widgets' . '</div>
			</a>
		</li>
		<li>
			<a href="' . $__templater->func('link', array('options/groups/EWRporta/', ), true) . '">
				<div class="iconicLinks-icon">' . $__templater->fontAwesome('fa-fw fa-sliders-h', array(
	)) . '</div>
				<div class="iconicLinks-title">' . 'Options' . '</div>
			</a>
		</li>
	</ul>
</div>';
	return $__finalCompiled;
}
);