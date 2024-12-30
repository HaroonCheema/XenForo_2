<?php
// FROM HASH: 0ca3d26e567de68bf2f436530860a47a
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if (!$__templater->test($__vars['forms'], 'empty', array())) {
		$__finalCompiled .= '
	';
		$__vars['headrow'] = '';
		$__finalCompiled .= '
	<div class="block"' . $__templater->func('widget_data', array($__vars['widget'], ), true) . '>
		<div class="block-container">
			';
		if ($__vars['style'] == 'full') {
			$__finalCompiled .= '
				<h3 class="block-minorHeader">
					<a href="' . $__templater->func('link', array('form', ), true) . '" rel="nofollow">' . $__templater->escape($__vars['title']) . '</a>
				</h3>
				<div class="block-body">
					<div class="structItemContainer">
						';
			if (!$__templater->test($__vars['forms'], 'empty', array())) {
				$__finalCompiled .= '
							';
				if ($__templater->isTraversable($__vars['headervalues'])) {
					foreach ($__vars['headervalues'] AS $__vars['header']) {
						$__finalCompiled .= '
								';
						if ($__vars['headrow'] !== $__vars['header']) {
							$__finalCompiled .= '
									';
							$__vars['headrow'] = $__vars['header'];
							$__vars['newline'] = '0';
							$__compilerTemp1 = '';
							if ($__templater->isTraversable($__vars['forms'])) {
								foreach ($__vars['forms'] AS $__vars['form']) {
									$__compilerTemp1 .= '
											';
									if ($__vars['form']['Type']['type'] == $__vars['header']) {
										$__compilerTemp1 .= '
												';
										if ($__vars['newline']) {
											$__compilerTemp1 .= '
													<br /><a href="' . $__templater->func('link', array('form/select', $__vars['form'], ), true) . '">' . $__templater->escape($__vars['form']['position']) . '</a>
												';
										} else {
											$__compilerTemp1 .= '
													<a href="' . $__templater->func('link', array('form/select', $__vars['form'], ), true) . '">' . $__templater->escape($__vars['form']['position']) . '</a>
													';
											$__vars['newline'] = '1';
											$__compilerTemp1 .= '
												';
										}
										$__compilerTemp1 .= '
											';
									}
									$__compilerTemp1 .= '
										';
								}
							}
							$__finalCompiled .= $__templater->formRow('
										' . '' . '
										' . '' . '
										' . $__compilerTemp1 . '
									', array(
								'label' => $__templater->escape($__vars['header']),
							)) . '
								';
						}
						$__finalCompiled .= '
							';
					}
				}
				$__finalCompiled .= '
						';
			} else {
				$__finalCompiled .= '
							<div class="block-row">
								' . 'No results found.' . '
							</div>
						';
			}
			$__finalCompiled .= '
					</div>
				</div>
			';
		} else {
			$__finalCompiled .= '
				<h3 class="block-minorHeader">
					<a href="' . $__templater->func('link', array('form', ), true) . '" rel="nofollow">' . $__templater->escape($__vars['title']) . '</a>
				</h3>
				<ul class="block-body">
					';
			if (!$__templater->test($__vars['forms'], 'empty', array())) {
				$__finalCompiled .= '
						<li>
						';
				if ($__templater->isTraversable($__vars['headervalues'])) {
					foreach ($__vars['headervalues'] AS $__vars['header']) {
						$__finalCompiled .= '
							';
						if ($__vars['headrow'] !== $__vars['header']) {
							$__finalCompiled .= '
								';
							if ($__vars['header']) {
								$__finalCompiled .= '
									<div class="block-footer">
										' . $__templater->escape($__vars['header']) . '
									</div>
								';
							}
							$__finalCompiled .= '
								';
							$__vars['headrow'] = $__vars['header'];
							$__finalCompiled .= '
								';
							$__vars['newline'] = '0';
							$__finalCompiled .= '
								';
							if ($__templater->isTraversable($__vars['forms'])) {
								foreach ($__vars['forms'] AS $__vars['form']) {
									$__finalCompiled .= '
									';
									if ($__vars['form']['Type']['type'] == $__vars['header']) {
										$__finalCompiled .= '
										<div class="block-row">
										';
										if ($__vars['newline']) {
											$__finalCompiled .= '
											<a href="' . $__templater->func('link', array('form/select', $__vars['form'], ), true) . '">' . $__templater->escape($__vars['form']['position']) . '</a>
										';
										} else {
											$__finalCompiled .= '
											<a href="' . $__templater->func('link', array('form/select', $__vars['form'], ), true) . '">' . $__templater->escape($__vars['form']['position']) . '</a>
											';
											$__vars['newline'] = '1';
											$__finalCompiled .= '
										';
										}
										$__finalCompiled .= '
										</div>
									';
									}
									$__finalCompiled .= '
								';
								}
							}
							$__finalCompiled .= '
							';
						}
						$__finalCompiled .= '
						';
					}
				}
				$__finalCompiled .= '
						</li>
					';
			} else {
				$__finalCompiled .= '
						<li class="block-row block-row--minor">
							' . 'No results found.' . '
						</li>
					';
			}
			$__finalCompiled .= '
				</ul>
			';
		}
		$__finalCompiled .= '
		</div>
	</div>
';
	}
	return $__finalCompiled;
}
);