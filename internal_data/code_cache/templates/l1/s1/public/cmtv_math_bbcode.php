<?php
// FROM HASH: 89c1a2b74dbff2005c8fc32894d1e832
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div id="mathJaxEqu">' . $__templater->escape($__vars['equation']) . '</div>

<script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
<script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
<script>
	
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
</script>';
	return $__finalCompiled;
}
);