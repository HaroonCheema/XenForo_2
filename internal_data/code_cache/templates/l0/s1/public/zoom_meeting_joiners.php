<?php
// FROM HASH: a77ceee048a03f1920e155dfe3b22539
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped($__templater->escape($__vars['meeting']['topic']));
	$__finalCompiled .= '

';
	$__templater->breadcrumbs($__templater->method($__vars['meeting']['Category'], 'getBreadcrumbs', array()));
	$__finalCompiled .= '
' . $__templater->callMacro('zoom_meeting_macro', 'header', array(
		'meeting' => $__vars['meeting'],
	), $__vars) . '

' . $__templater->callMacro('zoom_meeting_macro', 'tabs', array(
		'meeting' => $__vars['meeting'],
		'selected' => 'joiner',
	), $__vars) . '

<div class="block">
    <div class="block-container">
        <div class="block-body">
            ';
	$__compilerTemp1 = '';
	if (!$__templater->test($__vars['users'], 'empty', array())) {
		$__compilerTemp1 .= '
					' . $__templater->dataRow(array(
			'rowtype' => 'header',
		), array(array(
			'_type' => 'cell',
			'html' => 'Username',
		),
		array(
			'_type' => 'cell',
			'html' => 'Join',
		),
		array(
			'_type' => 'cell',
			'html' => 'Left',
		))) . '

						';
		if ($__templater->isTraversable($__vars['users'])) {
			foreach ($__vars['users'] AS $__vars['user']) {
				$__compilerTemp1 .= '
							';
				$__compilerTemp2 = array(array(
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['user']['username']),
				)
,array(
					'_type' => 'cell',
					'html' => $__templater->func('date_dynamic', array($__vars['user']['join_date'], array(
				))),
				));
				if ($__vars['user']['left_date']) {
					$__compilerTemp2[] = array(
						'_type' => 'cell',
						'html' => $__templater->func('date_dynamic', array($__vars['user']['left_date'], array(
					))),
					);
				} else {
					$__compilerTemp2[] = array(
						'_type' => 'cell',
						'html' => 'Joined',
					);
				}
				$__compilerTemp1 .= $__templater->dataRow(array(
				), $__compilerTemp2) . '
                    ';
			}
		}
		$__compilerTemp1 .= '
                ';
	} else {
		$__compilerTemp1 .= '
                    ' . $__templater->dataRow(array(
		), array(array(
			'colspan' => '2',
			'_type' => 'cell',
			'html' => 'No User Found...!',
		))) . '
                ';
	}
	$__finalCompiled .= $__templater->dataList('
				' . $__compilerTemp1 . '
            ', array(
		'data-xf-init' => 'responsive-data-list',
	)) . '
        </div>
    </div>
    ';
	$__compilerTemp3 = '';
	$__compilerTemp3 .= '
                ' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => 'meetings/joiners',
		'data' => $__vars['meeting'],
		'wrapperclass' => 'block-outer-main',
		'perPage' => $__vars['perPage'],
	))) . '
            ';
	if (strlen(trim($__compilerTemp3)) > 0) {
		$__finalCompiled .= '
        <div class="block-outer block-outer--after">
            ' . $__compilerTemp3 . '
        </div>
    ';
	}
	$__finalCompiled .= '
</div>';
	return $__finalCompiled;
}
);