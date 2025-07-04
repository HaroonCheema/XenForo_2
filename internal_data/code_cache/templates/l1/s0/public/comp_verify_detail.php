<?php
// FROM HASH: 74f519dfa46739fe8fbeca30352e0bf1
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="block">
	<div class="block-container">
		<div class="block-body">
			<div class="block-row block-row--separated">
				<h4 class="block-textHeader">' . 'Verification' . '</h4>

				<dl class="pairs pairs--columns pairs--fixedSmall">
					';
	if ($__vars['user']['comp_verify_key'] == 1) {
		$__finalCompiled .= '
						<dt>' . 'Get Verified' . '</dt>
						<dd>' . 'Verified' . '</dd>
						';
	} else {
		$__finalCompiled .= '
						';
		if ($__vars['user']['comp_verify_key'] == 2) {
			$__finalCompiled .= '
							<dt>' . 'P411' . '</dt>
							';
		} else if ($__vars['user']['comp_verify_key'] == 3) {
			$__finalCompiled .= '
							<dt>' . 'Private Delights' . '</dt>
							';
		} else if ($__vars['user']['comp_verify_key'] == 4) {
			$__finalCompiled .= '
							<dt>' . 'Slixa' . '</dt>
							';
		} else if ($__vars['user']['comp_verify_key'] == 5) {
			$__finalCompiled .= '
							<dt>' . 'TER' . '</dt>
							';
		} else if ($__vars['user']['comp_verify_key'] == 6) {
			$__finalCompiled .= '
							<dt>' . 'Tryst' . '</dt>
							';
		} else if ($__vars['user']['comp_verify_key'] == 7) {
			$__finalCompiled .= '
							<dt>' . 'tna' . '</dt>
							';
		} else if ($__vars['user']['comp_verify_key'] == 8) {
			$__finalCompiled .= '
							<dt>' . 'tob' . '</dt>
							';
		} else if ($__vars['user']['comp_verify_key'] == 9) {
			$__finalCompiled .= '
							<dt>' . 'oh2' . '</dt>
						';
		}
		$__finalCompiled .= '

						<dd>' . $__templater->escape($__vars['user']['comp_verify_val']) . '</dd>
					';
	}
	$__finalCompiled .= '

				</dl>

				';
	if ($__vars['user']['fs_regis_referral']) {
		$__finalCompiled .= '
					<dl class="pairs pairs--columns pairs--fixedSmall">
						<dt>Referral</dt>
						<dd>' . $__templater->escape($__vars['user']['fs_regis_referral']) . '</dd>
					</dl>
				';
	}
	$__finalCompiled .= '

			</div>
		</div>
	</div>
</div>';
	return $__finalCompiled;
}
);