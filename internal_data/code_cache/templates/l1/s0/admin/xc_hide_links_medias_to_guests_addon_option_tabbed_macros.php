<?php
// FROM HASH: 8f5fdbf5af6441db4ab99d0715f9f9ed
return array(
'macros' => array('base_options' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'groups' => '!',
		'groupedOptions' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
    <div class="block-body ' . (($__templater->method($__vars['groups'], 'count', array()) > 1) ? 'block-body--collapsible' : '') . ' is-active">

        ';
	$__vars['hundred'] = '0';
	$__finalCompiled .= '

        ';
	if ($__templater->isTraversable($__vars['groupedOptions'][$__vars['groupId']])) {
		foreach ($__vars['groupedOptions'][$__vars['groupId']] AS $__vars['option']) {
			$__finalCompiled .= '

            ';
			if ($__vars['group']) {
				$__finalCompiled .= '
                ';
				$__vars['curHundred'] = $__templater->func('floor', array($__vars['option']['Relations'][$__vars['group']['group_id']]['display_order'] / 100, ), false);
				$__finalCompiled .= '
                ';
				if (($__vars['curHundred'] > $__vars['hundred'])) {
					$__finalCompiled .= '
                    ';
					$__vars['hundred'] = $__vars['curHundred'];
					$__finalCompiled .= '
                    <hr class="formRowSep" />
                ';
				}
				$__finalCompiled .= '
            ';
			}
			$__finalCompiled .= '

            ' . $__templater->callMacro('option_macros', 'option_row', array(
				'group' => $__vars['group'],
				'option' => $__vars['option'],
				'includeAddOnHint' => false,
			), $__vars) . '
        ';
		}
	}
	$__finalCompiled .= '
    </div>
';
	return $__finalCompiled;
}
),
'base_addon_options' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'groups' => '!',
		'group' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<h3 class="block-formSectionHeader">
		<span class="' . (($__templater->method($__vars['groups'], 'count', array()) > 1) ? 'collapseTrigger collapseTrigger--block' : '') . ' is-active" data-xf-click="' . (($__templater->method($__vars['groups'], 'count', array()) > 1) ? 'toggle' : '') . '" data-target="< :up:next">
				' . $__templater->escape($__vars['group']['title']) . '
		</span>
		<span class="block-desc">
				' . $__templater->escape($__vars['group']['description']) . '
		</span>
	</h3>
';
	return $__finalCompiled;
}
),
'xc_options' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'groups' => '!',
		'groupedOptions' => '!',
		'addons' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
    <h2 class="block-tabHeader tabs" data-xf-init="tabs" role="tablist">

		<a class="tabs-tab is-active" role="tab" tabindex="0" aria-controls="hideLinkOptions">' . 'Hide links options' . '</a>
		<a class="tabs-tab is-active" role="tab" tabindex="0" aria-controls="hideMediaOptions">' . 'Hide medias options' . '</a>
		<a class="tabs-tab is-active" role="tab" tabindex="0" aria-controls="hideImageOptions">' . 'Hide images options' . '</a>
		<a class="tabs-tab is-active" role="tab" tabindex="0" aria-controls="hideAttachOptions">' . 'Hide attach options' . '</a>
    </h2>
    <ul class="tabPanes">
        <li class="is-active" role="tabpanel" id="hideLinkOptions">
            <div class="block-body">
                ';
	if ($__templater->isTraversable($__vars['groupedOptions']['xc_hide_links_from_guests'])) {
		foreach ($__vars['groupedOptions']['xc_hide_links_from_guests'] AS $__vars['option']) {
			$__finalCompiled .= '
                    ';
			if ($__vars['option']['Relations']['xc_hide_links_from_guests']['display_order'] < 100) {
				$__finalCompiled .= '
                        ' . $__templater->callMacro('option_macros', 'option_row', array(
					'group' => $__vars['group'],
					'option' => $__vars['option'],
				), $__vars) . '
                    ';
			}
			$__finalCompiled .= '
                ';
		}
	}
	$__finalCompiled .= '
            </div>
        </li>
		 <li role="tabpanel" id="hideMediaOptions">
            <div class="block-body">
                ';
	if ($__templater->isTraversable($__vars['groupedOptions']['xc_hide_links_from_guests'])) {
		foreach ($__vars['groupedOptions']['xc_hide_links_from_guests'] AS $__vars['option']) {
			$__finalCompiled .= '
                    ';
			if (($__vars['option']['Relations']['xc_hide_links_from_guests']['display_order'] >= 100) AND ($__vars['option']['Relations']['xc_hide_links_from_guests']['display_order'] < 200)) {
				$__finalCompiled .= '
						' . $__templater->callMacro('option_macros', 'option_row', array(
					'group' => $__vars['group'],
					'option' => $__vars['option'],
				), $__vars) . '
                    ';
			}
			$__finalCompiled .= '
                ';
		}
	}
	$__finalCompiled .= '
            </div>
        </li>
		<li role="tabpanel" id="hideImageOptions">
            <div class="block-body">
                ';
	if ($__templater->isTraversable($__vars['groupedOptions']['xc_hide_links_from_guests'])) {
		foreach ($__vars['groupedOptions']['xc_hide_links_from_guests'] AS $__vars['option']) {
			$__finalCompiled .= '
                    ';
			if (($__vars['option']['Relations']['xc_hide_links_from_guests']['display_order'] >= 200) AND ($__vars['option']['Relations']['xc_hide_links_from_guests']['display_order'] < 300)) {
				$__finalCompiled .= '
                        ' . $__templater->callMacro('option_macros', 'option_row', array(
					'group' => $__vars['group'],
					'option' => $__vars['option'],
				), $__vars) . '
                    ';
			}
			$__finalCompiled .= '
                ';
		}
	}
	$__finalCompiled .= '
            </div>
        </li>
		<li role="tabpanel" id="hideAttachOptions">
            <div class="block-body">
                ';
	if ($__templater->isTraversable($__vars['groupedOptions']['xc_hide_links_from_guests'])) {
		foreach ($__vars['groupedOptions']['xc_hide_links_from_guests'] AS $__vars['option']) {
			$__finalCompiled .= '
                    ';
			if (($__vars['option']['Relations']['xc_hide_links_from_guests']['display_order'] >= 300) AND ($__vars['option']['Relations']['xc_hide_links_from_guests']['display_order'] < 400)) {
				$__finalCompiled .= '
                        ' . $__templater->callMacro('option_macros', 'option_row', array(
					'group' => $__vars['group'],
					'option' => $__vars['option'],
				), $__vars) . '
                    ';
			}
			$__finalCompiled .= '
                ';
		}
	}
	$__finalCompiled .= '
            </div>
        </li>
    </ul>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Options' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['addOn']['title']));
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['groups'], 'empty', array())) {
		$__finalCompiled .= '
	
	';
		$__vars['AddOnRepo'] = $__templater->method($__vars['xf']['app']['em'], 'getRepository', array('XF:AddOn', ));
		$__finalCompiled .= '
	';
		$__vars['addons'] = $__templater->method($__templater->method($__vars['AddOnRepo'], 'findAddOnsForList', array()), 'fetch', array());
		$__finalCompiled .= '
	
	';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['groups'])) {
			foreach ($__vars['groups'] AS $__vars['groupId'] => $__vars['group']) {
				$__compilerTemp1 .= '
				';
				if (!$__templater->test($__vars['groupedOptions'][$__vars['groupId']], 'empty', array())) {
					$__compilerTemp1 .= '
					
					' . $__templater->callMacro(null, 'base_addon_options', array(
						'groups' => $__vars['groups'],
						'group' => $__vars['group'],
					), $__vars) . '
					
					';
					if ($__vars['groupId'] === 'xc_hide_links_from_guests') {
						$__compilerTemp1 .= '

						' . $__templater->callMacro(null, 'xc_options', array(
							'groups' => $__vars['groups'],
							'addons' => $__vars['addons'],
							'groupedOptions' => $__vars['groupedOptions'],
						), $__vars) . '
						
					';
					} else {
						$__compilerTemp1 .= '
					
						' . $__templater->callMacro(null, 'base_options', array(
							'groups' => $__vars['groups'],
						), $__vars) . '
					
					';
					}
					$__compilerTemp1 .= '
				';
				}
				$__compilerTemp1 .= '
			';
			}
		}
		$__finalCompiled .= $__templater->form('
		<div class="block-container">
			' . $__compilerTemp1 . '
			' . $__templater->formSubmitRow(array(
			'sticky' => 'true',
			'icon' => 'save',
		), array(
		)) . '
		</div>
	', array(
			'action' => $__templater->func('link', array('options/update', ), false),
			'ajax' => 'true',
			'class' => 'block',
		)) . '
';
	} else {
		$__finalCompiled .= '
	<div class="blockMessage">' . 'No items have been created yet.' . '</div>
';
	}
	$__finalCompiled .= '

' . '

' . '

';
	return $__finalCompiled;
}
);