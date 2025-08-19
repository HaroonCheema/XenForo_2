<?php
// FROM HASH: 15e999948085234c9150610de359a6d9
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Using callbacks');
	$__finalCompiled .= '

<div class="block">
	<div class="block-container">
		<div class="block-body block-row">
			' . '<p>If you want to generate the ad code using a PHP callback, you can do so by specifying the callback with arguments (optional) in the following format:</p>

<blockquote>
	<code>
		callback=\\Path\\To\\MyCallbackClass::MyCallbackMethod<br>arguments={"arg1":"val1","arg2":"val2"}
	</code>
</blockquote>

<p>Callback signature:</p>

<blockquote>
	<code>
		<em>\\Siropu\\AdsManager\\Entity\\Ad</em> <b>$ad</b>, <em>array</em> <b>$params</b>
	</code>
</blockquote>

<p>Your callback must <b>return</b> a valid HTML code.</p>' . '
		</div>
	</div>
</div>';
	return $__finalCompiled;
}
);