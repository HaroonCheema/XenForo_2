<?php
// FROM HASH: 22c9af1fdc4d9fd9c11744c8bec76945
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Form submit log');
	$__finalCompiled .= '

<div class="block">
	<div class="block-container">
		<div class="block-body">

			' . $__templater->formRow('
				<div class="u-ltr">
					' . $__templater->func('date_dynamic', array($__vars['entry']['log_date'], array(
	))) . '
				</div>
			', array(
		'label' => 'Date',
	)) . '

			';
	if ($__vars['entry']['User']) {
		$__finalCompiled .= '
				' . $__templater->formRow('
					<div class="u-ltr">
						' . $__templater->func('username_link', array($__vars['entry']['User'], false, array(
			'href' => $__templater->func('link', array('users/edit', $__vars['entry']['User'], ), false),
		))) . '
					</div>
				', array(
			'label' => 'Username',
		)) . '
			';
	}
	$__finalCompiled .= '
			
			' . $__templater->formRow('
				<div class="u-ltr">
					' . $__templater->filter($__vars['entry']['ip_address'], array(array('ip', array()),), true) . '
				</div>
			', array(
		'label' => 'IP address',
	)) . '

			';
	$__compilerTemp1 = '';
	if ($__vars['entry']['Form']) {
		$__compilerTemp1 .= '
						<a href="' . $__templater->func('link', array('form-forms/edit', $__vars['entry']['Form'], ), true) . '">
							' . $__templater->escape($__vars['entry']['Form']['position']) . '
						</a>
					';
	} else {
		$__compilerTemp1 .= '
						' . 'Deleted form' . '
					';
	}
	$__finalCompiled .= $__templater->formRow('
				<div class="u-ltr">
					' . $__compilerTemp1 . '
				</div>
			', array(
		'label' => 'Form',
	)) . '

		</div>

		';
	if (!$__templater->test($__vars['answers'], 'empty', array())) {
		$__finalCompiled .= '
			<h3 class="block-formSectionHeader">
				<span class="collapseTrigger collapseTrigger--block" data-xf-click="toggle" data-target="< :up:next">
					<span class="block-formSectionHeader-aligner">' . 'Answers' . '</span>
				</span>
			</h3>
			<div class="block-body block-body--collapsible">
				';
		if ($__templater->isTraversable($__vars['answers'])) {
			foreach ($__vars['answers'] AS $__vars['answer']) {
				$__finalCompiled .= '
					' . $__templater->formRow('
						<div class="u-ltr">
							' . $__templater->escape($__vars['answer']['answer']) . '
						</div>
					', array(
					'label' => $__templater->escape($__vars['answer']['Question']['text']),
				)) . '
				';
			}
		}
		$__finalCompiled .= '
			</div>	
		';
	}
	$__finalCompiled .= '
		
		<div class="block-footer">
			<span class="block-footer-controls">
				' . $__templater->button('', array(
		'href' => $__templater->func('link', array('logs/forms-logs/delete', $__vars['entry'], ), false),
		'icon' => 'delete',
		'overlay' => 'true',
	), '', array(
	)) . '
			</span>
		</div>
	</div>
</div>';
	return $__finalCompiled;
}
);