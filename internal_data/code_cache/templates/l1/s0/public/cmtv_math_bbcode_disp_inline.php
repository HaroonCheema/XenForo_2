<?php
// FROM HASH: 3e7e66c75a238df9eaadf68a150ea597
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<formula  id="mathJaxEqu" class="mathJaxEqu">' . $__templater->escape($__vars['equation']) . '</formula>

<script>
	var preview = document.getElementsByClassName("mathJaxEqu");
	if(preview.length==!0)
	{
		MathJax.typeset(preview);
	}
</script>';
	return $__finalCompiled;
}
);