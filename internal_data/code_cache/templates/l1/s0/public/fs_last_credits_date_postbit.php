<?php
// FROM HASH: 5e2bf445b5f072f1cdeac8294c01c4f7
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__vars['lastCreditDate'] = $__templater->method($__vars['user'], 'getLastCreditDate', array());
	$__finalCompiled .= '

';
	if ($__vars['lastCreditDate']) {
		$__finalCompiled .= '
	<dl class="pairs pairs--justified">
		<dt title="' . 'Last credit given' . '">' . 'Last credit given' . '</dt>
		<dd>
			';
		$__vars['lastCreditDateTime'] = $__templater->func('date', array($__vars['lastCreditDate']['purchased_at'], 'M j, Y', ), false) . ' at ' . $__templater->func('time', array($__vars['lastCreditDate']['purchased_at'], ), false);
		$__finalCompiled .= '
			
			<span title="' . $__templater->escape($__vars['lastCreditDateTime']) . '">
				' . $__templater->func('snippet', array($__vars['lastCreditDateTime'], 4, array('stripBbCode' => true, ), ), true) . '
			</span>

		</dd>
	</dl>
';
	}
	return $__finalCompiled;
}
);