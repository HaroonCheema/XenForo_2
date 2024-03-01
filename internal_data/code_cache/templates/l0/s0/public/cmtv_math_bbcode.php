<?php
// FROM HASH: b4de486437e58e0e4ad24724cbf2701b
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div id="mathJaxEqu">' . $__templater->escape($__vars['equation']) . '</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var mathJaxEqu = document.getElementById(\'mathJaxEqu\').innerText;

        // Render the equation using MathJax
        MathJax.tex2chtmlPromise(mathJaxEqu)
            .then((node) => {
                // Replace the content of the div with the rendered equation
                document.getElementById(\'mathJaxEqu\').innerHTML = \'\';
                document.getElementById(\'mathJaxEqu\').appendChild(node);
                return MathJax.startup.promise;
            })
            .then(() => {
                MathJax.typesetPromise();
            });
    });
</script>';
	return $__finalCompiled;
}
);