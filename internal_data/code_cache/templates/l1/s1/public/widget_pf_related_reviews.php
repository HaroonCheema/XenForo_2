<?php
// FROM HASH: 7ea91051abd0f4b6c2d8518199a679c5
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="block-container">
        <h3 class="block-minorHeader">Recensioni già presenti nel forum:</h3>
        <div class="block-body">
            <div class="block-row">
			<ul>
				';
	$__vars['i'] = 0;
	if ($__templater->isTraversable($__vars['forum_threads'])) {
		foreach ($__vars['forum_threads'] AS $__vars['key'] => $__vars['thread']) {
			$__vars['i']++;
			$__finalCompiled .= '
					<li>
						<a href="' . $__templater->func('link', array('threads', $__vars['thread'], ), true) . '" target="_blank">' . $__templater->escape($__vars['thread']['Forum']['title']) . ' - ' . $__templater->escape($__vars['thread']['title']) . '</a>
					</li>
				';
		}
	}
	$__finalCompiled .= '
			</ul>
        </div>
    </div>
</div>

	<div class="block-container">
        <h3 class="block-minorHeader">Annunci presenti su EH:</h3>
        <div class="block-body">
            <div class="block-row">
			<ul>
				';
	$__vars['i'] = 0;
	if ($__templater->isTraversable($__vars['eh_ads'])) {
		foreach ($__vars['eh_ads'] AS $__vars['key'] => $__vars['ad']) {
			$__vars['i']++;
			$__finalCompiled .= '
					<li>
						<a href="' . $__templater->escape($__vars['ad']['url']) . '" target="_blank">' . $__templater->escape($__vars['ad']['city']) . ' - ' . $__templater->escape($__vars['ad']['title']) . '</a>
					</li>
				';
		}
	}
	$__finalCompiled .= '
			</ul>
        </div>
    </div>
</div>';
	return $__finalCompiled;
}
);