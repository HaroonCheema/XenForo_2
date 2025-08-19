<?php
// FROM HASH: 9e3499bb006c7afa718e984fbfaf3945
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Embed');
	$__finalCompiled .= '

';
	$__templater->includeJs(array(
		'src' => 'siropu/am/admin.js',
		'min' => '1',
	));
	$__finalCompiled .= '

<style>
	.samEmbedCodeRow
	{
		display: none;
	}
</style>

';
	$__vars['jsEmbed'] = $__templater->preEscaped(trim('
<script>
	$(function() {
		$(\'.samEmbed\').each(function() {
			$(this).attr(\'src\', $(this).data(\'src\')).removeAttr(\'data-src\');
		});
	});
</script>
'));
	$__finalCompiled .= '

';
	$__compilerTemp1 = array(array(
		'label' => 'Select size',
		'_type' => 'option',
	));
	$__compilerTemp2 = $__templater->method($__vars['xf']['samAdmin'], 'getAdSizes', array());
	if ($__templater->isTraversable($__compilerTemp2)) {
		foreach ($__compilerTemp2 AS $__vars['sizes']) {
			$__compilerTemp1[] = array(
				'label' => $__vars['sizes']['group'],
				'_type' => 'optgroup',
				'options' => array(),
			);
			end($__compilerTemp1); $__compilerTemp3 = key($__compilerTemp1);
			if ($__templater->isTraversable($__vars['sizes']['sizes'])) {
				foreach ($__vars['sizes']['sizes'] AS $__vars['size']) {
					$__compilerTemp1[$__compilerTemp3]['options'][] = array(
						'value' => $__vars['size'],
						'label' => $__templater->escape($__vars['size']),
						'_type' => 'option',
					);
				}
			}
		}
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formSelectRow(array(
		'name' => 'size',
		'value' => $__vars['unitSize'],
		'class' => 'samUnitSizes',
	), $__compilerTemp1, array(
		'label' => 'Unit size',
	)) . '

			' . $__templater->formTextAreaRow(array(
		'rows' => '5',
		'readonly' => 'true',
		'class' => 'samEmbedCode',
	), array(
		'label' => 'Embed code',
		'explain' => 'Place the code above in your non XenForo page where you want the ad(s) to display.',
		'rowclass' => 'samEmbedCodeRow',
	)) . '

			<hr class="formRowSep" />
			
			' . $__templater->formTextAreaRow(array(
		'rows' => '5',
		'readonly' => 'true',
		'class' => 'samEmbedCodeJs',
	), array(
		'label' => 'JavaScript embed code',
		'explain' => 'Use this code instead if you are using external ads and experiencing slow page load.',
		'hint' => 'Alternative',
		'rowclass' => 'samEmbedCodeRow',
	)) . '
			' . $__templater->formTextAreaRow(array(
		'rows' => '10',
		'readonly' => 'true',
		'value' => $__vars['jsEmbed'],
	), array(
		'explain' => 'Place this code before the closing <b>&#x3C;/body&#x3E;</b> tag on the site where the embed code will be used. This code requires jQuery in order to function. If your site doesn\'t uses jQuey, place the following code before the above code: <b>&#x3C;script src=&#x22;https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js&#x22;&#x3E;&#x3C;/script&#x3E;</b>',
		'rowclass' => 'samEmbedCodeRow',
	)) . '
		</div>
	</div>
', array(
		'class' => 'block',
		'data-xf-init' => 'siropu-ads-manager-embed',
		'data-embed-url' => $__vars['url'],
	));
	return $__finalCompiled;
}
);