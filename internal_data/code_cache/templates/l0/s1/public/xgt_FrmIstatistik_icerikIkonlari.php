<?php
// FROM HASH: eb404e1187477afd0dea9ff383e421fa
return array(
'extensions' => array('thread_type_question_solved' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
						<i class="fal fa-check-circle _icerikIkonu--cozuldu" aria-hidden="true" title="' . $__templater->filter('Solved', array(array('for_attr', array()),), true) . '" data-xf-init="tooltip" title="' . $__templater->filter('Solved', array(array('for_attr', array()),), true) . '"></i>
						<span class="u-srOnly">' . 'Solved' . '</span>
					';
	return $__finalCompiled;
},
'thread_type_poll' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '													
							<i class="fal fa-chart-bar _icerikIkonu--anket" aria-hidden="true" title="' . $__templater->filter('Poll', array(array('for_attr', array()),), true) . '" data-xf-init="tooltip" title="' . $__templater->filter('Poll', array(array('for_attr', array()),), true) . '"></i>
							<span class="u-srOnly">' . 'Poll' . '</span>
						';
	return $__finalCompiled;
},
'thread_type_article' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
							<i class="fal fa-file-alt _icerikIkonu--makale" aria-hidden="true" title="' . $__templater->filter('Article', array(array('for_attr', array()),), true) . '" data-xf-init="tooltip" title="' . $__templater->filter('Article', array(array('for_attr', array()),), true) . '"></i>
							<span class="u-srOnly">' . 'Article' . '</span>
						';
	return $__finalCompiled;
},
'thread_type_question' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
							<i class="fal fa-question-circle _icerikIkonu--soru" aria-hidden="true" title="' . $__templater->filter('Question', array(array('for_attr', array()),), true) . '" data-xf-init="tooltip" title="' . $__templater->filter('Question', array(array('for_attr', array()),), true) . '"></i>
							<span class="u-srOnly">' . 'Question' . '</span>
						';
	return $__finalCompiled;
},
'thread_type_suggestion' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
							<i class="fal fa-bullseye-arrow _icerikIkonu--cozuldu" aria-hidden="true" title="' . $__templater->filter('Suggestion', array(array('for_attr', array()),), true) . '" data-xf-init="tooltip" title="' . $__templater->filter('Suggestion', array(array('for_attr', array()),), true) . '"></i>
							<span class="u-srOnly">' . 'Suggestion' . '</span>
						';
	return $__finalCompiled;
},
'thread_type_resource' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '													
							<i class="fal fa-cog _icerikIkonu--kaynak" aria-hidden="true" title="' . $__templater->filter('Resource', array(array('for_attr', array()),), true) . '" data-xf-init="tooltip" title="' . $__templater->filter('Resource', array(array('for_attr', array()),), true) . '"></i>
							<span class="u-srOnly">' . 'Resource' . '</span>
						';
	return $__finalCompiled;
},
'thread_type_discussion' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
							<i class="fal fa-comments _icerikIkonu--konu" aria-hidden="true" title="' . $__templater->filter('Discussion', array(array('for_attr', array()),), true) . '" data-xf-init="tooltip" title="' . $__templater->filter('Discussion', array(array('for_attr', array()),), true) . '"></i>
							<span class="u-srOnly">' . 'Discussion' . '</span>
						';
	return $__finalCompiled;
},
'statuses' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
				';
	if (($__templater->func('property', array('reactionSummaryOnLists', ), false) == 'status') AND $__vars['thread']['first_post_reactions']) {
		$__finalCompiled .= '
					' . $__templater->func('reactions_summary', array($__vars['thread']['first_post_reactions'])) . '
				';
	}
	$__finalCompiled .= '
				';
	if ($__vars['thread']['discussion_type'] == 'redirect') {
		$__finalCompiled .= '
				';
	} else if (($__vars['thread']['discussion_type'] == 'question') AND $__vars['thread']['type_data']['solution_post_id']) {
		$__finalCompiled .= '
					' . $__templater->renderExtension('thread_type_question_solved', $__vars, $__extensions) . '
				';
	} else if ((!$__vars['forum']) OR ($__vars['forum']['forum_type_id'] == 'discussion')) {
		$__finalCompiled .= '
					';
		if ($__vars['thread']['discussion_type'] == 'poll') {
			$__finalCompiled .= '
						' . $__templater->renderExtension('thread_type_poll', $__vars, $__extensions) . '
					';
		} else if ($__vars['thread']['discussion_type'] == 'article') {
			$__finalCompiled .= '
						' . $__templater->renderExtension('thread_type_article', $__vars, $__extensions) . '
					';
		} else if ($__vars['thread']['discussion_type'] == 'question') {
			$__finalCompiled .= '
						' . $__templater->renderExtension('thread_type_question', $__vars, $__extensions) . '
					';
		} else if ($__vars['thread']['discussion_type'] == 'suggestion') {
			$__finalCompiled .= '
						' . $__templater->renderExtension('thread_type_suggestion', $__vars, $__extensions) . '
					';
		} else if ($__vars['thread']['discussion_type'] == 'resource') {
			$__finalCompiled .= '
						' . $__templater->renderExtension('thread_type_resource', $__vars, $__extensions) . '
					';
		} else {
			$__finalCompiled .= '
						' . $__templater->renderExtension('thread_type_discussion', $__vars, $__extensions) . '
					';
		}
		$__finalCompiled .= '
				';
	}
	$__finalCompiled .= '
			';
	return $__finalCompiled;
}),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '
			' . $__templater->renderExtension('statuses', $__vars, $__extensions) . '
		';
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
	<div class="_icerikIkonu">
		' . $__compilerTemp1 . '
	</div>
';
	}
	return $__finalCompiled;
}
);