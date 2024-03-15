<?php
// FROM HASH: 19cd056813425f9385c3799f656b322a
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<mjx-container display="true" jax="CHTML">
	<formula  id="mathJaxEqu" class="mathJaxEqu">' . $__templater->escape($__vars['equation']) . '</formula>
</mjx-container>

<script>
	var preview = document.getElementsByClassName("mathJaxEqu");

	MathJax.typeset(preview);
</script>';
	return $__finalCompiled;
}
);