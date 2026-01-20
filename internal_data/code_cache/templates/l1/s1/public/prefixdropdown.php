<?php
// FROM HASH: 7a06281e0ddb91964adb3c790dd46468
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__vars['videosClipsIds'] = $__templater->filter($__vars['xf']['options']['pp_videos_and_clips_ids'], array(array('split', array(',', )),), false);
	$__finalCompiled .= '

<div style="display: inline-block; margin-left:15px; margin-top:-2px">
	';
	$__compilerTemp1 = array(array(
		'value' => '0',
		'label' => 'Show all' . $__vars['xf']['language']['ellipsis'],
		'_type' => 'option',
	));
	if ($__templater->isTraversable($__vars['drpMenu'])) {
		foreach ($__vars['drpMenu'] AS $__vars['groupId'] => $__vars['values']) {
			if ($__vars['groupId']) {
				$__compilerTemp1[] = array(
					'label' => $__templater->func('phrase_dynamic', array('thread_prefix_group.' . $__vars['groupId'], ), false) . '  ',
					'_type' => 'optgroup',
					'options' => array(),
				);
				end($__compilerTemp1); $__compilerTemp2 = key($__compilerTemp1);
				if ($__templater->isTraversable($__vars['values'])) {
					foreach ($__vars['values'] AS $__vars['value']) {
						if (($__vars['value'] == 'V') AND ($__templater->func('count', array($__vars['videosClipsIds'], ), false) > 1)) {
							$__compilerTemp1[$__compilerTemp2]['options'][] = array(
								'value' => $__vars['xf']['options']['pp_videos_and_clips_ids'],
								'label' => ' ' . 'Videos & Clips' . '  ',
								'_type' => 'option',
							);
						} else {
							$__compilerTemp1[$__compilerTemp2]['options'][] = array(
								'value' => $__vars['value'],
								'label' => $__templater->func('phrase_dynamic', array('thread_prefix.' . $__vars['value'], ), true) . '  ',
								'_type' => 'option',
							);
						}
					}
				}
			}
		}
	}
	$__finalCompiled .= $__templater->form('
		' . $__templater->formSelect(array(
		'name' => 'content_type',
		'class' => 'js-presetChange',
		'value' => $__vars['preId'],
		'onchange' => 'updateFormAction(this)',
	), $__compilerTemp1) . '
	', array(
		'action' => $__templater->func('link', array('threads&', $__vars['thread'], ), false),
	)) . '
</div>

' . '

';
	$__templater->inlineJs('
  function updateFormAction(selectElement) {
    const form = selectElement.closest(\'form\');
    var selectedValue = selectElement.value;
    const threadId = \'' . $__vars['thread'] . '\';

    if (selectedValue == 0) {
        form.action = \'' . $__templater->func('link', array('threads', $__vars['thread'], ), false) . '\';
    } else 
    {
		var link;
        link = \'' . $__templater->func('link', array('threads/', $__vars['thread'], ), false) . '\';
	   	console.log(link);
	    if(link.indexOf(\'?\') != -1) 
	    {
	        form.action = link +"&prefix_id="+selectedValue;
	    }
	    else
	    {
	        form.action = link+"?prefix_id="+selectedValue;
	    }
    }
    }
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

			$form.submit();
		});
	});
');
	return $__finalCompiled;
}
);