<?php
// FROM HASH: 0dbddcb393c0a1fdb7b878d8e546e67c
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped(' ' . '[FS] Thread Suggestions' . ' ');
	$__finalCompiled .= '

';
	if (!$__vars['threadModelSpaValues']) {
		$__finalCompiled .= '

	<div class="block">

		<div class="block-container">

			<div class="block-body">
				<div class="blockMessage">
					' . 'No items have been created yet.' . '
				</div>
			</div>

		</div>
	</div>
	';
	} else {
		$__finalCompiled .= '

	';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['threadModelSpaValues'])) {
			foreach ($__vars['threadModelSpaValues'] AS $__vars['key'] => $__vars['val']) {
				$__compilerTemp1 .= '

					<div class="inputGroup-container" data-xf-init="list-sorter" data-drag-handle=".dragHandle">
						' . $__templater->formRow('

							<div class="inputGroup">

								<span class="inputGroup-text"
									  aria-label="">--><a href="' . $__templater->func('link', array('threads', $__vars['val']['thread'], ), true) . '" target="_blank">
									(' . 'Link' . ')
									</a></span>

								' . $__templater->formTextBox(array(
					'name' => 'threadModelSpaFields[' . $__vars['key'] . '][model]',
					'value' => $__vars['val']['modelName'],
					'placeholder' => 'Model name not found...',
					'size' => '24',
					'maxlength' => '',
					'dir' => 'ltr',
				)) . '
								<span class="inputGroup-splitter"></span>
								' . $__templater->formTextBox(array(
					'name' => 'threadModelSpaFields[' . $__vars['key'] . '][spa]',
					'value' => $__vars['val']['spaName'],
					'placeholder' => 'Spa name not found...',
					'size' => '24',
				)) . '

								<span class="inputGroup-text"
									  aria-label=""><a href="' . $__templater->func('link', array('email-logs-detail/send', $__vars['value'], ), true) . '" target="_blank">
									' . 'save' . '
									</a></span>

							</div>

						', array(
					'rowtype' => 'input',
					'label' => $__templater->escape($__vars['val']['thread']['title']),
					'explain' => '',
				)) . '
					</div>

				';
			}
		}
		$__finalCompiled .= $__templater->form('
		<div class="block-container">
			<div class="block-body">

				' . $__compilerTemp1 . '

			</div>
			' . $__templater->formSubmitRow(array(
			'submit' => '',
			'icon' => 'save',
		), array(
		)) . '
		</div>
	', array(
			'action' => $__templater->func('link', array('threads/suggestion', $__vars['thread'], ), false),
			'ajax' => 'true',
			'class' => 'block',
			'data-force-flash-message' => 'true',
		)) . '

';
	}
	return $__finalCompiled;
}
);