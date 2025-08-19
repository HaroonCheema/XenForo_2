<?php
// FROM HASH: 6068b97d3177e7ec3227deae0b1117de
return array(
'macros' => array('ad_unit' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'ads' => '!',
		'position' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '
			';
	if ($__templater->isTraversable($__vars['ads'])) {
		foreach ($__vars['ads'] AS $__vars['type'] => $__vars['data']) {
			$__compilerTemp1 .= '
				';
			if ($__templater->isTraversable($__vars['data'])) {
				foreach ($__vars['data'] AS $__vars['typeAds']) {
					$__compilerTemp1 .= '
					' . $__templater->callMacro(null, 'ad_' . $__vars['type'], array(
						'ads' => $__vars['typeAds'],
						'position' => $__vars['position'],
					), $__vars) . '
				';
				}
			}
			$__compilerTemp1 .= '
			';
		}
	}
	$__compilerTemp1 .= '
		';
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
		' . $__compilerTemp1 . '
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'ad_code' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'ads' => '!',
		'position' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if ($__templater->isTraversable($__vars['ads'])) {
		foreach ($__vars['ads'] AS $__vars['ad']) {
			$__finalCompiled .= '
		<div style="' . $__templater->escape($__vars['ad']['email_inline_style']) . '">' . $__templater->filter(($__templater->method($__vars['ad'], 'isCallback', array()) ? $__vars['ad']['callback'] : ($__vars['ad']['content_1'] ?: $__vars['ad']['content_2'])), array(array('raw', array()),), true) . '</div>
	';
		}
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'ad_banner' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'ads' => '!',
		'position' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if ($__templater->isTraversable($__vars['ads'])) {
		foreach ($__vars['ads'] AS $__vars['ad']) {
			$__finalCompiled .= '
		<div style="' . $__templater->escape($__vars['ad']['email_inline_style']) . '">
			';
			if ($__vars['ad']['content_2']) {
				$__finalCompiled .= '
				' . $__templater->filter(($__vars['ad']['content_1'] ?: $__vars['ad']['content_2']), array(array('raw', array()),), true) . '
			';
			} else {
				$__finalCompiled .= '
				<a href="' . $__templater->escape($__templater->method($__vars['ad'], 'getEmailTargetUrl', array($__vars['position'], ))) . '"><img src="' . $__templater->escape($__templater->method($__vars['ad'], 'getEmailImageUrl', array($__vars['position'], ))) . '" style="width:100%;max-width:100%;" alt="' . $__templater->filter($__vars['ad']['content_4'], array(array('for_attr', array()),), true) . '"></a>
			';
			}
			$__finalCompiled .= '
		</div>
	';
		}
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'ad_text' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'ads' => '!',
		'position' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if ($__templater->isTraversable($__vars['ads'])) {
		foreach ($__vars['ads'] AS $__vars['ad']) {
			$__finalCompiled .= '
		<div style="padding:10px;background:#fefefe;border:1px solid #cbcbcb;border-radius:4px;' . $__templater->escape($__vars['ad']['email_inline_style']) . '">
			';
			if ($__templater->method($__vars['ad'], 'hasBanner', array())) {
				$__finalCompiled .= '
				<div style="float:left;width:150px;margin-right:10px;">
					';
				if ($__vars['ad']['content_2']) {
					$__finalCompiled .= '
						' . $__templater->filter(($__vars['ad']['content_1'] ?: $__vars['ad']['content_2']), array(array('raw', array()),), true) . '
					';
				} else {
					$__finalCompiled .= '
						<a href="' . $__templater->escape($__templater->method($__vars['ad'], 'getEmailTargetUrl', array($__vars['position'], ))) . '"><img src="' . $__templater->escape($__templater->method($__vars['ad'], 'getEmailImageUrl', array($__vars['position'], ))) . '" alt="' . $__templater->filter($__vars['ad']['content_4'], array(array('for_attr', array()),), true) . '"></a>
					';
				}
				$__finalCompiled .= '
				</div>
			';
			}
			$__finalCompiled .= '
			<div style="' . ($__templater->method($__vars['ad'], 'hasBanner', array()) ? 'margin-left: 160px;' : '') . '">
				<div style="font-weight:bold;font-size:16px;margin-bottom:5px;">
					<a href="' . $__templater->escape($__templater->method($__vars['ad'], 'getEmailTargetUrl', array($__vars['position'], ))) . '">' . $__templater->escape($__vars['ad']['title']) . '</a>
				</div>
				<div>
					' . $__templater->filter($__vars['ad']['description'], array(array('nl2br', array()),), true) . '
				</div>
			</div>
			<div style="clear: both;"></div>
		</div>
	';
		}
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'ad_link' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'ads' => '!',
		'position' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if ($__templater->isTraversable($__vars['ads'])) {
		foreach ($__vars['ads'] AS $__vars['ad']) {
			$__finalCompiled .= '
		<div style="' . $__templater->escape($__vars['ad']['email_inline_style']) . '">
			<a href="' . $__templater->escape($__templater->method($__vars['ad'], 'getEmailTargetUrl', array($__vars['position'], ))) . '">' . $__templater->escape($__vars['ad']['title']) . '</a>
		</div>
	';
		}
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

' . '

' . '

' . '

';
	return $__finalCompiled;
}
);