<?php
<<<<<<< HEAD
// FROM HASH: 89c1a2b74dbff2005c8fc32894d1e832
=======
// FROM HASH: b4de486437e58e0e4ad24724cbf2701b
>>>>>>> ec84cb00a69fdecad2b7ec284b83c9f007c870e0
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div id="mathJaxEqu">' . $__templater->escape($__vars['equation']) . '</div>

<<<<<<< HEAD
<script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
<script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
<script>
	
        var mathJaxEqu = document.getElementById(\'mathJaxEqu\').innerText;
=======
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var mathJaxEqu = document.getElementById(\'mathJaxEqu\').innerText;

>>>>>>> ec84cb00a69fdecad2b7ec284b83c9f007c870e0
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
<<<<<<< HEAD
=======
    });
>>>>>>> ec84cb00a69fdecad2b7ec284b83c9f007c870e0
</script>';
	return $__finalCompiled;
}
);