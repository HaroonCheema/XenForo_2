<?php
// FROM HASH: 11a24d4bf9243815e9355d14199106fc
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Members who gifted this content');
	$__finalCompiled .= '
';
	$__templater->setPageParam('head.' . 'metaNoindex', $__templater->preEscaped('<meta name="robots" content="noindex" />'));
	$__finalCompiled .= '

';
	$__templater->breadcrumbs($__templater->method($__vars['handler'], 'getBreadCrumbs', array($__vars['entity'], )));
	$__finalCompiled .= '

<div class="block">
	<div class="block-container">
		<ol class="block-body">
			';
	if ($__templater->isTraversable($__vars['gifts'])) {
		foreach ($__vars['gifts'] AS $__vars['gift']) {
			$__finalCompiled .= '
				<li class="block-row block-row--separated">
					';
			$__vars['extraTemplate'] = $__templater->preEscaped('
						' . $__templater->func('date_time', array($__vars['gift']['gift_date'], ), true) . '
					');
			$__finalCompiled .= '
					' . $__templater->callMacro('member_list_macros', 'item', array(
				'user' => $__vars['gift']['User'],
				'extraData' => $__vars['extraTemplate'],
			), $__vars) . '
				</li>
			';
		}
	}
	$__finalCompiled .= '
		</ol>

		<div class="block-outer block-outer--after">
			<span class="note">' . 'Some gifters may be anonymous.' . '</span>
			';
	if ($__vars['hasMore']) {
		$__finalCompiled .= '
				<a class="button OverlayCloser OverlayTrigger" href="' . $__templater->escape($__vars['moreLink']) . '">' . 'More' . $__vars['xf']['language']['ellipsis'] . '</a>
			';
	}
	$__finalCompiled .= '
		</div>
	</div>
</div>';
	return $__finalCompiled;
}
);