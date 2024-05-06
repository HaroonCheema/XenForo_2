<?php
// FROM HASH: ae8a9f58903d1ecc377a02f45e24c6b7
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('IP Search');
	$__finalCompiled .= '


<div class="block">
	<div class="block-container">
		<h2 class="block-tabHeader tabs" data-xf-init="tabs" role="tablist">
			<a class="tabs-tab is-active" role="tab" tabindex="0" aria-controls="user-search">' . 'Find IP addresses for user' . '</a>
			<a class="tabs-tab" role="tab" tabindex="0" aria-controls="ip-search">' . 'Find Users by IP address' . '</a>
		</h2>

		<ul class="tabPanes">
			<li class="is-active" role="tabpanel" id="user-search">
				' . $__templater->form('
					<div class="block-body">
						' . $__templater->formRow('
							
							<ul class="inputList">
								<li>' . $__templater->formTextBox(array(
		'name' => 'username',
		'ac' => 'single',
		'maxlength' => $__templater->func('max_length', array($__vars['xf']['visitor'], 'username', ), false),
	)) . '</li>

								' . '
							</ul>
						', array(
		'label' => 'Username',
	)) . '

						<hr class="formRowSep" />

					</div>
					' . $__templater->formSubmitRow(array(
		'sticky' => 'true',
		'icon' => 'search',
	), array(
	)) . '
				', array(
		'action' => $__templater->func('link', array('ip-search/user-ips', ), false),
	)) . '
			</li>
			
			<li role="tabpanel" id="ip-search">
				' . $__templater->form('
					<div class="block-body">
						' . $__templater->formTextBoxRow(array(
		'name' => 'ip',
	), array(
		'label' => 'IP address',
		'explain' => 'Enter an IP address to see a list of all users logged as having posted content using that IP. You may enter a partial IP address such as 192.168.*, 192.168.0.0/16, or 2001:db8::/32.',
	)) . '
					</div>
					' . $__templater->formSubmitRow(array(
		'icon' => 'search',
	), array(
	)) . '
				', array(
		'action' => $__templater->func('link', array('members/ip-users', ), false),
	)) . '
			</li>
		</ul>
	</div>
</div>';
	return $__finalCompiled;
}
);