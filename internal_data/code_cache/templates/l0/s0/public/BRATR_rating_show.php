<?php
// FROM HASH: 339a3678790ac23bde37293386e1f685
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="block" data-type="review">
	<div class="block-container">
		<div class="block-body block-row block-row--separated">
			' . $__templater->callMacro('BRATR_rating_macros', 'review_public', array(
		'review' => $__vars['rating'],
		'user' => $__vars['user'],
		'thread' => $__vars['thread'],
	), $__vars) . '
		</div>
	</div>
</div>';
	return $__finalCompiled;
}
);