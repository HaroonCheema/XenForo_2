<?php
// FROM HASH: 9eadf95e770ec3c3be07576ec1bd13dc
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->includeCss('BRATR_icon_rating_option_template.less');
	$__finalCompiled .= '

';
	$__compilerTemp1 = array();
	$__compilerTemp1[] = array(
		'label' => 'Use Rating Style',
		'_type' => 'optgroup',
		'options' => array(),
	);
	end($__compilerTemp1); $__compilerTemp2 = key($__compilerTemp1);
	$__compilerTemp1[$__compilerTemp2]['options'][] = array(
		'value' => '',
		'label' => 'Xenforo Default',
		'_type' => 'option',
	);
	$__compilerTemp1[$__compilerTemp2]['options'][] = array(
		'value' => 'style-rating',
		'label' => 'Rating Styles',
		'_type' => 'option',
	);
	$__compilerTemp1[$__compilerTemp2]['options'][] = array(
		'value' => 'font-awesome',
		'label' => 'Font Awesome Icon',
		'_type' => 'option',
	);
	$__compilerTemp1[] = array(
		'label' => 'Hearts Style',
		'_type' => 'optgroup',
		'options' => array(),
	);
	end($__compilerTemp1); $__compilerTemp3 = key($__compilerTemp1);
	$__compilerTemp1[$__compilerTemp3]['options'][] = array(
		'value' => 'heart-blue',
		'label' => 'Blue hearts',
		'_type' => 'option',
	);
	$__compilerTemp1[$__compilerTemp3]['options'][] = array(
		'value' => 'heart-green',
		'label' => 'Green hearts',
		'_type' => 'option',
	);
	$__compilerTemp1[$__compilerTemp3]['options'][] = array(
		'value' => 'heart-red',
		'label' => 'Red hearts',
		'_type' => 'option',
	);
	$__compilerTemp1[$__compilerTemp3]['options'][] = array(
		'value' => 'heart-yellow',
		'label' => 'Yellow hearts',
		'_type' => 'option',
	);
	$__compilerTemp1[] = array(
		'label' => 'Circle Stars Style',
		'_type' => 'optgroup',
		'options' => array(),
	);
	end($__compilerTemp1); $__compilerTemp4 = key($__compilerTemp1);
	$__compilerTemp1[$__compilerTemp4]['options'][] = array(
		'value' => 'circle-star-blue',
		'label' => 'Blue circle stars',
		'_type' => 'option',
	);
	$__compilerTemp1[$__compilerTemp4]['options'][] = array(
		'value' => 'circle-star-green',
		'label' => 'Green circle stars',
		'_type' => 'option',
	);
	$__compilerTemp1[$__compilerTemp4]['options'][] = array(
		'value' => 'circle-star-red',
		'label' => 'Red circle stars',
		'_type' => 'option',
	);
	$__compilerTemp1[$__compilerTemp4]['options'][] = array(
		'value' => 'circle-star-yellow',
		'label' => 'Yellow circle stars',
		'_type' => 'option',
	);
	$__compilerTemp1[] = array(
		'label' => 'Paws Style',
		'_type' => 'optgroup',
		'options' => array(),
	);
	end($__compilerTemp1); $__compilerTemp5 = key($__compilerTemp1);
	$__compilerTemp1[$__compilerTemp5]['options'][] = array(
		'value' => 'paw-blue',
		'label' => 'Blue paws',
		'_type' => 'option',
	);
	$__compilerTemp1[$__compilerTemp5]['options'][] = array(
		'value' => 'paw-green',
		'label' => 'Green paws',
		'_type' => 'option',
	);
	$__compilerTemp1[$__compilerTemp5]['options'][] = array(
		'value' => 'paw-red',
		'label' => 'Red paws',
		'_type' => 'option',
	);
	$__compilerTemp1[$__compilerTemp5]['options'][] = array(
		'value' => 'paw-yellow',
		'label' => 'Yellow paws',
		'_type' => 'option',
	);
	$__compilerTemp1[] = array(
		'label' => 'Stars Style',
		'_type' => 'optgroup',
		'options' => array(),
	);
	end($__compilerTemp1); $__compilerTemp6 = key($__compilerTemp1);
	$__compilerTemp1[$__compilerTemp6]['options'][] = array(
		'value' => 'star-blue',
		'label' => 'Blue stars',
		'_type' => 'option',
	);
	$__compilerTemp1[$__compilerTemp6]['options'][] = array(
		'value' => 'star-green',
		'label' => 'Green stars',
		'_type' => 'option',
	);
	$__compilerTemp1[$__compilerTemp6]['options'][] = array(
		'value' => 'star-red',
		'label' => 'Red stars',
		'_type' => 'option',
	);
	$__compilerTemp1[$__compilerTemp6]['options'][] = array(
		'value' => 'star-yellow',
		'label' => 'Yellow stars',
		'_type' => 'option',
	);
	$__compilerTemp1[] = array(
		'label' => 'Ticks Style',
		'_type' => 'optgroup',
		'options' => array(),
	);
	end($__compilerTemp1); $__compilerTemp7 = key($__compilerTemp1);
	$__compilerTemp1[$__compilerTemp7]['options'][] = array(
		'value' => 'tick-blue',
		'label' => 'Blue ticks',
		'_type' => 'option',
	);
	$__compilerTemp1[$__compilerTemp7]['options'][] = array(
		'value' => 'tick-green',
		'label' => 'Green ticks',
		'_type' => 'option',
	);
	$__compilerTemp1[$__compilerTemp7]['options'][] = array(
		'value' => 'tick-red',
		'label' => 'Red ticks',
		'_type' => 'option',
	);
	$__compilerTemp1[$__compilerTemp7]['options'][] = array(
		'value' => 'tick-yellow',
		'label' => 'Yellow ticks',
		'_type' => 'option',
	);
	$__compilerTemp1[] = array(
		'label' => 'Drops Style',
		'_type' => 'optgroup',
		'options' => array(),
	);
	end($__compilerTemp1); $__compilerTemp8 = key($__compilerTemp1);
	$__compilerTemp1[$__compilerTemp8]['options'][] = array(
		'value' => 'drop-blue',
		'label' => 'Blue drops',
		'_type' => 'option',
	);
	$__compilerTemp1[$__compilerTemp8]['options'][] = array(
		'value' => 'drop-green',
		'label' => 'Green drops',
		'_type' => 'option',
	);
	$__compilerTemp1[$__compilerTemp8]['options'][] = array(
		'value' => 'drop-red',
		'label' => 'Red drops',
		'_type' => 'option',
	);
	$__compilerTemp1[$__compilerTemp8]['options'][] = array(
		'value' => 'drop-yellow',
		'label' => 'Yellow drops',
		'_type' => 'option',
	);
	$__compilerTemp1[] = array(
		'label' => 'Arrows Style',
		'_type' => 'optgroup',
		'options' => array(),
	);
	end($__compilerTemp1); $__compilerTemp9 = key($__compilerTemp1);
	$__compilerTemp1[$__compilerTemp9]['options'][] = array(
		'value' => 'arrow-blue',
		'label' => 'Blue arrows',
		'_type' => 'option',
	);
	$__compilerTemp1[$__compilerTemp9]['options'][] = array(
		'value' => 'arrow-green',
		'label' => 'Green arrows',
		'_type' => 'option',
	);
	$__compilerTemp1[$__compilerTemp9]['options'][] = array(
		'value' => 'arrow-red',
		'label' => 'Red arrows',
		'_type' => 'option',
	);
	$__compilerTemp1[$__compilerTemp9]['options'][] = array(
		'value' => 'arrow-yellow',
		'label' => 'Yellow arrows',
		'_type' => 'option',
	);
	$__finalCompiled .= $__templater->formRow('

	<div class="inputGroup">
		' . $__templater->formSelect(array(
		'name' => $__vars['inputName'],
		'value' => $__vars['option']['option_value'],
		'class' => 'BriviumSelectIconRating input--autoSize',
	), $__compilerTemp1) . '

		<div class="iconRating"><div class="' . $__templater->escape($__vars['preparedOption']['option_value']) . '"></div></div>
	</div>
', array(
		'rowtype' => 'input',
		'label' => $__templater->escape($__vars['option']['title']),
		'hint' => $__templater->escape($__vars['hintHtml']),
		'explain' => $__templater->escape($__vars['explainHtml']),
		'html' => $__templater->escape($__vars['listedHtml']),
	)) . '

';
	$__templater->inlineJs('
	//<script>
		$(function()
		{
			$(\'.BriviumSelectIconRating\').change(function(e)
			{
				var $divIconRating = $(\'.iconRating\'),
					$class = $(this).val();
				$divIconRating.find(\'div\').attr(\'class\',\'\');
				$divIconRating.find(\'div\').addClass($class );
			});
            $(\'.BriviumSelectIconRating\').trigger(\'change\');
		});
	//</script>
');
	return $__finalCompiled;
}
);