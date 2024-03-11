<?php
<<<<<<< HEAD
// FROM HASH: 20907afa386f8773a490f5d97cf6c6fd
=======
// FROM HASH: 26c2d8e8c87b127c07f880d690e88357
>>>>>>> ec84cb00a69fdecad2b7ec284b83c9f007c870e0
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<script>
	const CMTV_MATH_RENDER_OPTIONS =
	{
		"delimiters":
		[
			{left: "[imath]", right: "[/imath]", display: false},
			{left: "[math]",  right: "[/math]", display: true}
		].concat(' . $__templater->filter($__vars['xf']['options']['CMTV_Math_customMathDelimiters'], array(array('raw', array()),), true) . '),

		"ignoredClasses": [].concat(' . $__templater->filter($__vars['xf']['options']['CMTV_Math_ignoredClasses'], array(array('raw', array()),), true) . '),

		"macros": ' . ($__vars['xf']['options']['CMTV_Math_macros'] ? $__templater->filter($__vars['xf']['options']['CMTV_Math_macros'], array(array('raw', array()),), true) : '{}') . '
	};
	
	(function ($, document)
	{
		$(document).on(\'xf:reinit\', function (e)
		{
<<<<<<< HEAD
			
=======
>>>>>>> ec84cb00a69fdecad2b7ec284b83c9f007c870e0
		});
	})
	(jQuery, document);
</script>';
	return $__finalCompiled;
}
);