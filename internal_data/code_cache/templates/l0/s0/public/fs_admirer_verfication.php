<?php
// FROM HASH: 24448efe056a2ed164d1d52bba7ac7bf
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<style>
	.js-privatedelights .formRow-explain,
	.js-slixa .formRow-explain,
	.js-ter .formRow-explain,
	.js-tryst .formRow-explain,
	.js-tna .formRow-explain,
	.js-tob .formRow-explain,
	.js-oh2 .formRow-explain
	{
		color: red;
		font-weight: 700;
	}

</style>
<dl class="formRow formRow--customField" data-field="ReceiveEmailfromOther">
	<dt>

	</dt>
	<dd>
		<ul class="field_ReceiveEmailfromOther listColumns inputChoices" role="group" aria-labelledby="_xfUid-15-1751015160">
			<span class="iconic-label">' . 'Verification' . '</span>

		</ul>
		<div class="formRow-explain">' . 'For verification purposes, please select and include a link to your profile on another listing site. We accept profile links from P411, TNA, OH2 and TOB, as well as profiles on similar sites. If you do not have a profile on another site, select “Get Verified” and we will verify your identity for a SWB profile.' . '</div>
	</dd>
</dl>
' . '
' . $__templater->formSelectRow(array(
		'name' => 'comp_verify_key',
	), array(array(
		'data-hide' => 'true',
		'data-xf-init' => 'disabler',
		'data-container' => '.js-refferal',
		'value' => '1',
		'label' => 'Get Verified',
		'_type' => 'option',
	),
	array(
		'data-hide' => 'true',
		'data-xf-init' => 'disabler',
		'data-container' => '.js-p411',
		'value' => '2',
		'label' => 'P411',
		'_type' => 'option',
	),
	array(
		'data-hide' => 'true',
		'data-xf-init' => 'disabler',
		'data-container' => '.js-tna',
		'value' => '3',
		'label' => 'tna',
		'_type' => 'option',
	),
	array(
		'data-hide' => 'true',
		'data-xf-init' => 'disabler',
		'data-container' => '.js-oh2',
		'value' => '4',
		'label' => 'oh2',
		'_type' => 'option',
	),
	array(
		'data-hide' => 'true',
		'data-xf-init' => 'disabler',
		'data-container' => '.js-tob',
		'value' => '5',
		'label' => 'tob',
		'_type' => 'option',
	)), array(
		'label' => 'Verification',
		'hint' => 'Required',
	)) . '

<div class="js-refferal" data-platform="refferal">
	' . '
</div>

<div class="js-p411" data-platform="P411">
	' . $__templater->formTextBoxRow(array(
		'name' => 'adm_verify_val',
	), array(
		'label' => 'P411 ID',
		'explain' => '',
		'hint' => 'Required',
	)) . '
</div>

<div class="js-tna" data-platform="tna">
	' . $__templater->formTextBoxRow(array(
		'name' => 'adm_verify_val',
	), array(
		'label' => 'Listing Site URL',
		'explain' => 'Direct link to your profile on that site.',
		'hint' => 'Required',
	)) . '
</div>

<div class="js-oh2" data-platform="oh2">
	' . $__templater->formTextBoxRow(array(
		'name' => 'adm_verify_val',
	), array(
		'label' => 'Listing Site URL',
		'explain' => 'Direct link to your profile on that site.',
		'hint' => 'Required',
	)) . '
</div>

<div class="js-tob" data-platform="tob">
	' . $__templater->formTextBoxRow(array(
		'name' => 'adm_verify_val',
	), array(
		'label' => 'Listing Site URL',
		'explain' => 'Direct link to your profile on that site.',
		'hint' => 'Required',
	)) . '
</div>';
	return $__finalCompiled;
}
);