<?php
// FROM HASH: 10f7d3aa5be622945fbc7a3c48954dfe
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('My Ratings');
	$__finalCompiled .= '

';
	$__templater->wrapTemplate('account_wrapper', $__vars);
	$__finalCompiled .= '

';
	$__compilerTemp1 = array(array(
		'label' => 'Date presets' . $__vars['xf']['language']['label_separator'],
		'value' => '-1',
		'_type' => 'option',
	));
	$__compilerTemp1[] = array(
		'_type' => 'optgroup',
		'options' => array(),
	);
	end($__compilerTemp1); $__compilerTemp2 = key($__compilerTemp1);
	$__compilerTemp1[$__compilerTemp2]['options'] = $__templater->mergeChoiceOptions($__compilerTemp1[$__compilerTemp2]['options'], $__vars['datePresets']);
	$__compilerTemp1[$__compilerTemp2]['options'][] = array(
		'value' => '1995-01-01',
		'label' => 'All time',
		'_type' => 'option',
	);
	$__compilerTemp3 = '';
	if (!$__templater->test($__vars['ratings'], 'empty', array())) {
		$__compilerTemp3 .= '
			' . $__templater->callMacro('BRATR_rating_macros', 'review_list', array(
			'reviews' => $__vars['ratings'],
		), $__vars) . '
		';
	} else {
		$__compilerTemp3 .= '
			<div class="block-body block-row">' . 'No results found.' . '</div>
		';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-outer">
		<div class="filterBlock">
			<ul class="listInline">
				<li>
					<div class="inputGroup inputGroup--auto inputGroup--inline">
						' . $__templater->formDateInput(array(
		'name' => 'start',
		'value' => ($__vars['linkFilters']['start'] ? $__templater->func('date', array($__vars['linkFilters']['start'], 'Y-m-d', ), false) : ''),
		'class' => 'filterBlock-input filterBlock-input--small',
	)) . '
						<span class="inputGroup-text">-</span>
						' . $__templater->formDateInput(array(
		'name' => 'end',
		'value' => ($__vars['linkFilters']['end'] ? $__templater->func('date', array($__vars['linkFilters']['end'], 'Y-m-d', ), false) : ''),
		'class' => 'filterBlock-input filterBlock-input--small',
	)) . '
						<span class="inputGroup-splitter"></span>
					</div>
				</li>
				<li>
					' . $__templater->formSelect(array(
		'name' => 'date_preset',
		'class' => 'js-presetChange filterBlock-input',
	), $__compilerTemp1) . '
				</li>
				<li>
					' . $__templater->button('Go', array(
		'type' => 'submit',
		'class' => 'button--small',
	), '', array(
	)) . '
				</li>
			</ul>
		</div>
	</div>
	<div class="block-container">
		' . $__compilerTemp3 . '
	</div>
	' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => 'account/bratr-my-ratings',
		'params' => $__vars['linkFilters'],
		'wrapperclass' => 'block-outer block-outer--after',
		'perPage' => $__vars['perPage'],
	))) . '
', array(
		'action' => $__templater->func('link', array('account/bratr-my-ratings', ), false),
		'class' => 'block',
		'ajax' => 'true',
	)) . '

';
	$__templater->inlineJs('
	$(function()
	{
		$(\'.js-presetChange\').change(function(e)
		{
			var $ctrl = $(this),
			value = $ctrl.val(),
			$form = $ctrl.closest(\'form\');

			if (value == -1)
			{
				return;
			}

			$form.find($ctrl.data(\'start\') || \'input[name=start]\').val(value);
			$form.find($ctrl.data(\'end\') || \'input[name=end]\').val(\'\');
			$form.submit();
		});
	});
');
	return $__finalCompiled;
}
);