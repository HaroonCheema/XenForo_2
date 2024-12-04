<?php
// FROM HASH: fd2bda6cdd83f59717bde2e5172e6e3b
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('
	' . 'User Special Credits List' . '
');
	$__finalCompiled .= '
';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('
		' . 'Add Special Credit' . '
	', array(
		'icon' => 'add',
		'href' => $__templater->func('link', array('user-special-credit/add', ), false),
	), '', array(
	)) . '
');
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['specialCredits'], 'empty', array())) {
		$__finalCompiled .= '
   <div class="block">
      <div class="block-container">
         <div class="block-body">
            ';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['specialCredits'])) {
			foreach ($__vars['specialCredits'] AS $__vars['value']) {
				$__compilerTemp1 .= '
                  ' . $__templater->dataRow(array(
				), array(array(
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['value']['User']['username']),
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['value']['User']['special_credit']),
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['value']['Moderator']['username']),
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->func('date_dynamic', array($__vars['value']['given_at'], array(
				))),
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['value']['reason']),
				),
				array(
					'href' => $__templater->func('link', array('user-special-credit/edit', $__vars['value'], ), false),
					'overlay' => 'true',
					'_type' => 'action',
					'html' => 'Edit',
				),
				array(
					'href' => $__templater->func('link', array('user-special-credit/delete', $__vars['value'], ), false),
					'tooltip' => 'Delete',
					'_type' => 'delete',
					'html' => '',
				))) . '
               ';
			}
		}
		$__finalCompiled .= $__templater->dataList('
               ' . $__templater->dataRow(array(
			'rowtype' => 'header',
		), array(array(
			'_type' => 'cell',
			'html' => 'User Name',
		),
		array(
			'_type' => 'cell',
			'html' => 'Credits',
		),
		array(
			'_type' => 'cell',
			'html' => 'Given By:',
		),
		array(
			'_type' => 'cell',
			'html' => 'Time',
		),
		array(
			'_type' => 'cell',
			'html' => 'Reason',
		),
		array(
			'_type' => 'cell',
			'html' => 'Action',
		),
		array(
			'_type' => 'cell',
			'html' => '&nbsp;',
		))) . '
               ' . $__compilerTemp1 . '
            ', array(
			'data-xf-init' => 'responsive-data-list',
		)) . '
         </div>
         <div class="block-footer">
            <span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['specialCredits'], $__vars['total'], ), true) . '</span>
         </div>
      </div>

      ' . $__templater->func('page_nav', array(array(
			'page' => $__vars['page'],
			'total' => $__vars['total'],
			'link' => 'user-special-credit/list',
			'wrapperclass' => 'block-outer block-outer--after',
			'perPage' => $__vars['perPage'],
		))) . '
   </div>
   ';
	} else {
		$__finalCompiled .= '
   <div class="blockMessage">There is no Data</div>
';
	}
	return $__finalCompiled;
}
);