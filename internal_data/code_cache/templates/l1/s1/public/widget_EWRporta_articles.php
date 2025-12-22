<?php
// FROM HASH: c560abaae0c50991dc7a513f306545d5
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if (!$__templater->test($__vars['articles'], 'empty', array())) {
		$__finalCompiled .= '
	';
		$__templater->includeCss('message.less');
		$__finalCompiled .= '
	';
		$__templater->includeCss('EWRporta.less');
		$__finalCompiled .= '
	';
		$__templater->includeCss('EWRporta_articles.less');
		$__finalCompiled .= '

	';
		if ($__vars['options']['masonry']) {
			$__finalCompiled .= '
		';
			$__vars['msnry'] = $__templater->preEscaped('1');
			$__finalCompiled .= '
		';
			$__templater->includeJs(array(
				'src' => '8wayrun/porta/images.js',
			));
			$__finalCompiled .= '
		';
			$__templater->includeJs(array(
				'src' => '8wayrun/porta/masonry.js',
			));
			$__finalCompiled .= '
	';
		}
		$__finalCompiled .= '
	
	';
		$__templater->includeJs(array(
			'src' => '8wayrun/porta/portal.js',
		));
		$__finalCompiled .= '
	
	<div class="block ' . ($__vars['msnry'] ? 'porta-masonry' : '') . '" ' . $__templater->func('widget_data', array($__vars['widget'], ), true) . '
			data-xf-init="' . ($__vars['msnry'] ? 'porta-masonry' : '') . '">
		';
		if ($__templater->isTraversable($__vars['articles'])) {
			foreach ($__vars['articles'] AS $__vars['article']) {
				$__finalCompiled .= trim('
			' . $__templater->callMacro('EWRporta_articles_macros', 'article_block', array(
					'article' => $__vars['article'],
					'catlinks' => $__vars['catlinks'][$__vars['article']['thread_id']],
					'attachments' => $__vars['attachments'],
				), $__vars) . '
		');
			}
		}
		$__finalCompiled .= '
	</div>
';
	}
	return $__finalCompiled;
}
);