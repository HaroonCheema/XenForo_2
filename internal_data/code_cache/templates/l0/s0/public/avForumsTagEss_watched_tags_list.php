<?php
// FROM HASH: 694e2de57367d0d7f733f5768b6bfc52
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Watched tags');
	$__templater->pageParams['pageNumber'] = $__vars['page'];
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['watchedTags'], 'empty', array())) {
		$__finalCompiled .= '
	';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['watchedTags'])) {
			foreach ($__vars['watchedTags'] AS $__vars['watchedTag']) {
				$__compilerTemp1 .= '
						';
				$__vars['extra'] = ($__vars['thread']['Watch'][$__vars['xf']['visitor']['user_id']]['email_subscribe'] ? 'Email' : '');
				$__compilerTemp1 .= '
						' . $__templater->callMacro('avForumsTagEss_macros', 'item', array(
					'watchedTag' => $__vars['watchedTag'],
					'chooseName' => 'thread_ids',
					'showWatched' => false,
					'extraInfo' => $__vars['extra'],
					'allowEdit' => false,
				), $__vars) . '
					';
			}
		}
		$__finalCompiled .= $__templater->form('
		<div class="block-outer">
			' . $__templater->func('page_nav', array(array(
			'page' => $__vars['page'],
			'total' => $__vars['total'],
			'link' => 'watched/tags',
			'wrapperclass' => 'block-outer-main',
			'perPage' => $__vars['perPage'],
		))) . '
			<div class="block-outer-opposite">
				' . $__templater->button('Manage watched tags', array(
			'class' => 'button--link menuTrigger',
			'data-xf-click' => 'menu',
			'aria-expanded' => 'false',
			'aria-haspopup' => 'true',
		), '', array(
		)) . '
				<div class="menu" data-menu="menu" aria-hidden="true">
					<div class="menu-content">
						<h3 class="menu-header">' . 'Manage watched tags' . '</h3>
						<!--[AVForums/TagEssentials:manage_menu:top]-->
						<a href="' . $__templater->func('link', array('watched/tags/manage', null, array('state' => 'watch_no_alert', ), ), true) . '" data-xf-click="overlay" class="menu-linkRow">' . 'Disable alert notifications' . '</a>
						<a href="' . $__templater->func('link', array('watched/tags/manage', null, array('state' => 'watch_no_email', ), ), true) . '" data-xf-click="overlay" class="menu-linkRow">' . 'Disable email notification' . '</a>
						<a href="' . $__templater->func('link', array('watched/tags/manage', null, array('state' => 'delete', ), ), true) . '" data-xf-click="overlay" class="menu-linkRow">' . 'Stop watching tags' . '</a>
						<!--[AVForums/TagEssentials:manage_menu:bottom]-->
					</div>
				</div>
			</div>
		</div>

		<div class="block-container">
			<div class="block-body">
				<div class="structItemContainer">
					' . $__compilerTemp1 . '
				</div>
			</div>
			<div class="block-footer block-footer--split">
				<span class="block-footer-counter"></span>
				<span class="block-footer-select">' . $__templater->formCheckBox(array(
			'standalone' => 'true',
		), array(array(
			'check-all' => '< .block-container',
			'label' => 'Select all',
			'_type' => 'option',
		))) . '</span>
				<span class="block-footer-controls">
						' . $__templater->formSelect(array(
			'name' => 'state',
			'class' => 'input--inline',
		), array(array(
			'label' => 'With selected' . $__vars['xf']['language']['ellipsis'],
			'_type' => 'option',
		),
		array(
			'value' => 'watch_alert',
			'label' => 'Enable alert notifications',
			'_type' => 'option',
		),
		array(
			'value' => 'watch_no_alert',
			'label' => 'Disable alert notifications',
			'_type' => 'option',
		),
		array(
			'value' => 'watch_email',
			'label' => 'Enable email notification',
			'_type' => 'option',
		),
		array(
			'value' => 'watch_no_email',
			'label' => 'Disable email notification',
			'_type' => 'option',
		),
		array(
			'value' => 'delete',
			'label' => 'Stop watching',
			'_type' => 'option',
		))) . '
					' . $__templater->button('Go', array(
			'type' => 'submit',
		), '', array(
		)) . '
				</span>
			</div>
		</div>

		' . $__templater->func('page_nav', array(array(
			'link' => 'watched/tags',
			'page' => $__vars['page'],
			'total' => $__vars['total'],
			'wrapperclass' => 'block-outer block-outer--after',
			'perPage' => $__vars['perPage'],
		))) . '

		' . $__templater->func('show_ignored', array(array(
			'wrapperclass' => 'block-outer block-outer-opposite block-outer--after',
		))) . '
	', array(
			'action' => $__templater->func('link', array('watched/tags/update', ), false),
			'ajax' => 'true',
			'class' => 'block',
			'autocomplete' => 'off',
		)) . '
';
	} else {
		$__finalCompiled .= '
	<div class="blockMessage">
		';
		if ($__vars['page'] > 1) {
			$__finalCompiled .= '
			' . 'There are no tags to display' . '
		';
		} else {
			$__finalCompiled .= '
			<p>' . 'You are not watching any tags' . '</p>
		';
		}
		$__finalCompiled .= '
	</div>
';
	}
	return $__finalCompiled;
}
);