<?php
// FROM HASH: 7da439a78bb72f04c5950b254abefa95
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->form('

	<div class="block-container">
		<div class="block-body">

			' . $__templater->formRow('
				' . $__templater->escape($__vars['user']['Profile']['sotd']) . '
			', array(
		'label' => 'Sotd',
	)) . '

			' . $__templater->formRow('
				' . $__templater->escape($__vars['user']['Profile']['sotd_img']) . '
			', array(
		'label' => 'Sotd Image',
	)) . '

			' . $__templater->formRow('
				' . $__templater->escape($__vars['user']['Profile']['sotd_link']) . '
			', array(
		'label' => 'Sotd Link',
	)) . '

			' . $__templater->formRow('
				' . $__templater->func('date_dynamic', array($__vars['user']['Profile']['sotd_date'], array(
	))) . ' 
			', array(
		'label' => 'Sotd Date',
	)) . '

			' . $__templater->formRow('
				' . $__templater->escape($__vars['user']['Profile']['sotd_hide']) . '
			', array(
		'label' => 'Sotd Hide',
	)) . '

			' . $__templater->formRow('
				' . $__templater->escape($__vars['user']['Profile']['sotd_streak']) . '
			', array(
		'label' => 'Sotd Streak',
	)) . '

			' . $__templater->formRow('
				' . $__templater->escape($__vars['user']['Profile']['review_count']) . '
			', array(
		'label' => 'Review Count',
	)) . '

			' . $__templater->formRow('
				' . $__templater->escape($__vars['user']['Profile']['wardrobe_icon']) . '
			', array(
		'label' => 'Wardrobe Icon',
	)) . '

			' . $__templater->formRow('
				' . $__templater->escape($__vars['user']['Profile']['wardrobe_hide']) . '
			', array(
		'label' => 'Wardrobe Hide',
	)) . '

		</div>
	</div>
', array(
		'action' => $__templater->func('link', array('quiz/quiz-start', $__vars['quiz'], ), false),
		'class' => 'block',
	));
	return $__finalCompiled;
}
);