<?php
// FROM HASH: 1d17b31bfc6355a50b5dbfc4fc3cde90
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="alias_profiles">
    ' . $__templater->callMacro('af_paidregistrations_purchase', 'payment_profile_selectrow', array(
		'upgrade' => $__vars['upgrade'],
		'profiles' => $__vars['profiles'],
	), $__vars) . '
</div>';
	return $__finalCompiled;
}
);