<?php
// FROM HASH: 0823bf4a4de4a7ec5c5dfcabc2194247
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="structItem">
		<div class="structItem-cell structItem-cell--icon">
			<div class="structItem-iconContainer">
				' . $__templater->func('avatar', array($__vars['xf']['visitor'], 's', false, array(
	))) . '
			</div>
		</div>
		<div class="structItem-cell structItem-cell--main">
			<div class="structItem-title">
				<a href="http://sponsor-url..." rel="nofollow" target="_blank">Sponsor name</a>
			</div>
			<div class="structItem-minor">
				Description.
			</div>
		</div>
	</div>';
	return $__finalCompiled;
}
);