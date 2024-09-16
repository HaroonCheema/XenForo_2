<?php
// FROM HASH: 38ab1be91d2438d657f5b529c1ce2e89
return array(
'macros' => array('tag_item' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'tag' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<a href="' . $__templater->func('link', array('tags', $__vars['tag'], ), true) . '" class="tagItem" dir="auto">' . $__templater->escape($__vars['tag']['tag']) . '</a>
';
	return $__finalCompiled;
}
),
'tag_wiki' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'tag' => '!',
		'wikiBody' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__templater->includeCss('bb_code.less');
	$__finalCompiled .= '
	<div class="tagWiki">
		<article class="message-body">
			' . $__templater->callAdsMacro('tag_wiki_above_content', array(
		'tag' => $__vars['tag'],
	), $__vars) . '
			<div class="bbCodeBlock bbCodeBlock--expandable bbCodeBlock--tagWiki">
				<div class="bbCodeBlock-content">
					<div class="bbCodeBlock-expandContent">
						' . $__templater->func('bb_code', array($__vars['wikiBody'], 'tag_wiki', $__vars['tag'], ), true) . '
					</div>
					<div class="bbCodeBlock-expandLink"><a>' . 'Click to expand...' . '</a></div>
				</div>
			</div>
			' . $__templater->callAdsMacro('tag_wiki_below_content', array(
		'tag' => $__vars['tag'],
	), $__vars) . '
		</article>
	</div>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->includeCss('message.less');
	$__finalCompiled .= '
';
	$__templater->includeCss('avForumsTagEss_tag_preview.less');
	$__finalCompiled .= '

<div class="tagSynonyms">
	<i class="fa fa-tags" aria-hidden="true" title="' . $__templater->filter('Synonyms', array(array('for_attr', array()),), true) . '"></i>
	<span class="u-srOnly">' . 'Synonyms' . '</span>

	' . $__templater->callMacro(null, 'tag_item', array(
		'tag' => $__vars['tag'],
	), $__vars) . '

	';
	if ($__vars['tag']['SynonymOf']['ParentTag']) {
		$__finalCompiled .= '
		' . $__templater->callMacro(null, 'tag_item', array(
			'tag' => $__vars['tag']['SynonymOf']['ParentTag'],
		), $__vars) . '
	';
	}
	$__finalCompiled .= '

	';
	if (!$__templater->test($__vars['tag']['Synonyms'], 'empty', array())) {
		$__finalCompiled .= '
		';
		if ($__templater->isTraversable($__vars['tag']['Synonyms'])) {
			foreach ($__vars['tag']['Synonyms'] AS $__vars['synonym']) {
				$__finalCompiled .= '
			' . $__templater->callMacro(null, 'tag_item', array(
					'tag' => $__vars['synonym']['Tag'],
				), $__vars) . '
		';
			}
		}
		$__finalCompiled .= '
	';
	}
	$__finalCompiled .= '
</div>

';
	if ($__vars['tag']['SynonymOf'] AND $__vars['tag']['SynonymOf']['ParentTag']) {
		$__finalCompiled .= '
	<div class="tagWiki">
		' . 'Synonym of \'' . $__templater->escape($__vars['tag']['SynonymOf']['ParentTag']['tag']) . '\'' . '
	</div>
';
	} else if ($__vars['tag']['tagess_wiki_description']) {
		$__finalCompiled .= '
	' . $__templater->callMacro(null, 'tag_wiki', array(
			'tag' => $__vars['tag'],
			'wikiBody' => $__vars['tag']['tagess_wiki_description'],
		), $__vars) . '
';
	} else if ($__vars['tag']['tagess_wiki_tagline']) {
		$__finalCompiled .= '
	' . $__templater->callMacro(null, 'tag_wiki', array(
			'tag' => $__vars['tag'],
			'wikiBody' => $__vars['tag']['tagess_wiki_tagline'],
		), $__vars) . '
';
	}
	$__finalCompiled .= '

';
	if (!$__vars['tag']['SynonymOf']['ParentTag']) {
		$__finalCompiled .= '
	<div class="tagAdditionalLinks">
		' . $__templater->button('Recent contents', array(
			'href' => $__templater->func('link', array('tags', $__vars['tag'], ), false),
			'class' => 'button--link',
		), '', array(
		)) . '

		';
		if ($__vars['tag']['tagess_wiki_description'] OR $__vars['tag']['tagess_wiki_tagline']) {
			$__finalCompiled .= '
			' . $__templater->button('View information', array(
				'href' => $__templater->func('link', array('tags/wiki', $__vars['tag'], ), false),
				'class' => 'button--link',
			), '', array(
			)) . '
		';
		}
		$__finalCompiled .= '

		';
		if ($__vars['xf']['options']['tagess_topUsers']) {
			$__finalCompiled .= '
			' . $__templater->button('Top users', array(
				'href' => $__templater->func('link', array('tags/top-users', $__vars['tag'], ), false),
				'class' => 'button--link',
			), '', array(
			)) . '
		';
		}
		$__finalCompiled .= '
	</div>
';
	}
	$__finalCompiled .= '

' . '

';
	return $__finalCompiled;
}
);