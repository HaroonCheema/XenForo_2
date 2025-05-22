<?php
// FROM HASH: a8e511ee5ff99b92db31f9e14838ef45
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->includeCss('pf_es_editor_symbols.less');
	$__finalCompiled .= '

<div class="menu-scroller">
	<div class="menu-row">
		<ul class="pfEsSymbolList js-pfEsSymbolsList">		
			';
	if ($__templater->isTraversable($__vars['symbols'])) {
		foreach ($__vars['symbols'] AS $__vars['symbol']) {
			$__finalCompiled .= '
				<li>
					<a class="js-psEsSymbol" data-value="' . $__templater->escape($__vars['symbol']) . '">' . $__templater->filter($__vars['symbol'], array(array('raw', array()),), true) . '</a>
				</li>
			';
		}
	}
	$__finalCompiled .= '
		</ul>
	</div>
</div>';
	return $__finalCompiled;
}
);