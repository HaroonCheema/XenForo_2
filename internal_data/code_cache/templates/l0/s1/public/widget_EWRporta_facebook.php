<?php
// FROM HASH: dd87060e4b68da6a96a610b0464ec40e
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__vars['html'] = $__templater->preEscaped('
	<script src="//connect.facebook.net/en_US/all.js#xfbml=1"></script>
	<div class="fb-page" style="width: 100%"
		data-tabs="timeline"
		data-href="' . $__templater->escape($__vars['options']['href']) . '"
		data-height="' . $__templater->escape($__vars['options']['height']) . '"
		data-small-header="' . ($__vars['options']['small_header'] ? 'true' : 'false') . '"
		data-hide-cover="' . ($__vars['options']['hide_cover'] ? 'true' : 'false') . '"
		data-hide-cta="' . ($__vars['options']['hide_cta'] ? 'true' : 'false') . '"
		data-show-facepile="' . ($__vars['options']['show_facepile'] ? 'true' : 'false') . '"
		data-width="500"
		data-adapt-container-width="true">
	</div>
');
	$__finalCompiled .= '

';
	if (!$__vars['options']['advanced_mode']) {
		$__finalCompiled .= '
	<div class="block">
		<div class="block-container">
			<h3 class="block-minorHeader">' . $__templater->escape($__vars['title']) . '</h3>
			<div class="block-body block-row">
				' . $__templater->escape($__vars['html']) . '
			</div>
		</div>
	</div>
';
	} else {
		$__finalCompiled .= '
	<div class="block">
		' . $__templater->escape($__vars['html']) . '
	</div>
';
	}
	return $__finalCompiled;
}
);