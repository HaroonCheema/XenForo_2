<?php
// FROM HASH: f04c75e91a982866a4fe7f48adb48008
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<ul class="_xgtIstatistik-konuListe">
	';
	if ($__templater->isTraversable($__vars['results'])) {
		foreach ($__vars['results'] AS $__vars['userId'] => $__vars['data']) {
			$__finalCompiled .= '
		<li class="_xgtIstatistik-satir">				
			<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--avatar">
				' . $__templater->func('avatar', array($__vars['data']['user'], 'xxs', false, array(
			))) . '
			</div>
			<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--konu">
				' . $__templater->func('username_link', array($__vars['data']['user'], true, array(
			))) . '
			</div>
			';
			if ($__vars['data']['value']) {
				$__finalCompiled .= '
				<div class="_xgtIstatistik-satir--hucre _xgtIstatistik-satir--cevap" data-xf-init="tooltip" title="' . 'Mesajı' . '">
					' . $__templater->escape($__vars['data']['value']) . '
				</div>
			';
			}
			$__finalCompiled .= '
		</li>  
	';
		}
	}
	$__finalCompiled .= '
</ul>';
	return $__finalCompiled;
}
);