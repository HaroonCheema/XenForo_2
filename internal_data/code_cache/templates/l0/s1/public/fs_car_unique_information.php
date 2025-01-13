<?php
// FROM HASH: 674311be8adcb2da465363373821381b
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Unique Information');
	$__finalCompiled .= '

<div class="blockMessage">
	<ul>
		<li style="list-style: none; text-align: justify;">' . $__templater->filter($__vars['car_unique_information'], array(array('raw', array()),), true) . '</li>
	</ul>
</div>';
	return $__finalCompiled;
}
);