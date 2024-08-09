<?php
// FROM HASH: 5685d5d5d30a994c2b6d3b04cae7c2fd
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="inputGroup u-inputSpacer">
	<button type="submit" class="button--primary button">
		<span class="button-text">' . 'Filter' . '</span>
	</button>
	';
	if ($__vars['filters']) {
		$__finalCompiled .= '
		' . $__templater->button('
			<span class="button-text">' . 'Clear' . '</span>
		', array(
			'href' => $__templater->func('link', array('forums', $__vars['forum'], ), false),
			'class' => 'button--primary button button--clear-filter',
		), '', array(
		)) . '
	';
	}
	$__finalCompiled .= '
</div>';
	return $__finalCompiled;
}
);