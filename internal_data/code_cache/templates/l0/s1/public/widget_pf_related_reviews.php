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
		<a href="' . $__templater->func('link', array('threads', $__vars['thread'], ), true) . '" target="_blank"><b>' . $__templater->escape($__vars['thread']['Forum']['title']) . ' - ' . $__templater->escape($__vars['thread']['title']) . '</b></a>

		';
			$__vars['threadUsers'] = $__templater->method($__vars['thread'], 'getThisThreadUsers', array());
			$__finalCompiled .= '
		';
			if ($__vars['threadUsers']) {
				$__finalCompiled .= '
			<ul class="listInline listInline--comma">
				';
				if ($__vars['threadUsers']['currentThread']) {
					$__finalCompiled .= '
					' . trim('
						<li>' . $__templater->func('username_link', array($__vars['threadUsers']['currentThread']['User'], true, array(
						'class' => '',
						'style' => 'color: ' . $__vars['xf']['options']['fs_who_replied_thread_starter_color'] . '; font-weight: bold;',
					))) . '</li>
					') . '
				';
				}
				$__finalCompiled .= '
				';
				if ($__templater->isTraversable($__vars['threadUsers']['users'])) {
					foreach ($__vars['threadUsers']['users'] AS $__vars['user']) {
						$__finalCompiled .= trim('
					<li>' . $__templater->func('username_link', array($__vars['user'], true, array(
							'class' => '',
						))) . '</li>
					');
					}
				}
				$__finalCompiled .= '

				<a href="#"
				   class="message-attribution-gadget"
				   data-xf-init="share-tooltip"
				   data-href="' . $__templater->func('link', array('posts/share', $__vars['thread']['FirstPost'], ), true) . '"
				   rel="nofollow">
					' . $__templater->fontAwesome('fa-copy', array(
				)) . '
				</a>
			</ul>
		';
			}
			$__finalCompiled .= '

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