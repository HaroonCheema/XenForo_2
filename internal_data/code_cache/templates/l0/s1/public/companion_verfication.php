<?php
// FROM HASH: 051bdde58019fcdb766bb866e24e7102
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
		<div class="formRow-explain">' . 'For verification purposes, please select and include a link to your profile on another listing site. We accept profile links from P411 and TER, as well as profiles on similar sites. If you do not have a profile on another site, select “Get Verified” and we will verify your identity for a Sinsations profile.' . '</div>
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
		'data-container' => '.js-privatedelights',
		'value' => '3',
		'label' => 'Private Delights',
		'_type' => 'option',
	),
	array(
		'data-hide' => 'true',
		'data-xf-init' => 'disabler',
		'data-container' => '.js-slixa',
		'value' => '4',
		'label' => 'Slixa',
		'_type' => 'option',
	),
	array(
		'data-hide' => 'true',
		'data-xf-init' => 'disabler',
		'data-container' => '.js-ter',
		'value' => '5',
		'label' => 'TER',
		'_type' => 'option',
	),
	array(
		'data-hide' => 'true',
		'data-xf-init' => 'disabler',
		'data-container' => '.js-tryst',
		'value' => '6',
		'label' => 'Tryst',
		'_type' => 'option',
	),
	array(
		'data-hide' => 'true',
		'data-xf-init' => 'disabler',
		'data-container' => '.js-tna',
		'value' => '7',
		'label' => 'tna',
		'_type' => 'option',
	),
	array(
		'data-hide' => 'true',
		'data-xf-init' => 'disabler',
		'data-container' => '.js-tob',
		'value' => '8',
		'label' => 'tob',
		'_type' => 'option',
	),
	array(
		'data-hide' => 'true',
		'data-xf-init' => 'disabler',
		'data-container' => '.js-oh2',
		'value' => '9',
		'label' => 'oh2',
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
		'name' => 'comp_verify_val',
	), array(
		'label' => 'P411 ID',
		'explain' => '0 to 7 max characters',
		'hint' => 'Required',
	)) . '
</div>


<div class="js-privatedelights" data-platform="Private Delights" hint="' . 'Required' . '" >
	' . $__templater->formTextBoxRow(array(
		'name' => 'comp_verify_val',
	), array(
		'label' => 'Listing Site URL',
		'explain' => 'Direct link to your profile on that site.',
	)) . '
</div>

<div class="js-slixa" data-platform="Slixa" hint="' . 'Required' . '">
	' . $__templater->formTextBoxRow(array(
		'name' => 'comp_verify_val',
	), array(
		'label' => 'Listing Site URL',
		'explain' => 'Direct link to your profile on that site.',
	)) . '
</div>

<div class="js-ter" data-platform="TER">
	' . $__templater->formTextBoxRow(array(
		'name' => 'comp_verify_val',
	), array(
		'label' => 'TER Link',
		'explain' => 'Direct link to your profile on that site.',
		'hint' => 'Required',
	)) . '
</div>

<div class="js-tryst" data-platform="Tryst">
	' . $__templater->formTextBoxRow(array(
		'name' => 'comp_verify_val',
	), array(
		'label' => 'Listing Site URL',
		'explain' => 'Direct link to your profile on that site.',
		'hint' => 'Required',
	)) . '
</div>
<div class="js-tna" data-platform="tna">
	' . $__templater->formTextBoxRow(array(
		'name' => 'comp_verify_val',
	), array(
		'label' => 'Listing Site URL',
		'explain' => 'Direct link to your profile on that site.',
		'hint' => 'Required',
	)) . '
</div>
<div class="js-tob" data-platform="tob">
	' . $__templater->formTextBoxRow(array(
		'name' => 'comp_verify_val',
	), array(
		'label' => 'Listing Site URL',
		'explain' => 'Direct link to your profile on that site.',
		'hint' => 'Required',
	)) . '
</div>
<div class="js-oh2" data-platform="oh2">
	' . $__templater->formTextBoxRow(array(
		'name' => 'comp_verify_val',
	), array(
		'label' => 'Listing Site URL',
		'explain' => 'Direct link to your profile on that site.',
		'hint' => 'Required',
	)) . '
</div>

' . $__templater->formTextBoxRow(array(
		'name' => 'fs_regis_referral',
	), array(
		'label' => 'Referral',
		'explain' => 'Enter the provider SWB username or copy and paste their profile and receive a free month.',
	));
	return $__finalCompiled;
}
);