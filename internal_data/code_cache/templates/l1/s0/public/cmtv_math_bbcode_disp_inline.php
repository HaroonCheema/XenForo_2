<?php
// FROM HASH: 889e25dbec4760236ad0c51bd943fdfc
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<formula  id="mathJaxEqu" class="mathJaxEqu">' . $__templater->escape($__vars['equation']) . '</formula>

<script>
	var preview = document.getElementsByClassName("mathJaxEqu");

		MathJax.typeset(preview);
</script>';
	return $__finalCompiled;
}
);