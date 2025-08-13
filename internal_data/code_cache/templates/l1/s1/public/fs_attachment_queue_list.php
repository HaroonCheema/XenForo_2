<?php
// FROM HASH: 42e34a00e1c88f3223ea43fd789120d0
return array(
'macros' => array('fs_attachment_form' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'attachment' => '!',
		'redirect' => '/',
		'page' => '0',
	); },
'extensions' => array('user_avatar' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
							<div class="message-avatar">
								<div class="message-avatar-wrapper">
									' . $__templater->func('avatar', array($__vars['attachment']['Data']['User'], 'm', false, array(
		'itemprop' => 'image',
	))) . '
								</div>
							</div>
						';
	return $__finalCompiled;
},
'user_name' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
								<h4 class="message-name">' . $__templater->func('username_link', array($__vars['attachment']['Data']['User'], true, array(
		'itemprop' => 'name',
	))) . '</h4>
							';
	return $__finalCompiled;
},
'user_wrapper' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
					<section itemscope itemtype="https://schema.org/Person" class="message-user">
						' . $__templater->renderExtension('user_avatar', $__vars, $__extensions) . '

						<div class="message-userDetails">
							' . $__templater->renderExtension('user_name', $__vars, $__extensions) . '
						</div>

						<span class="message-userArrow"></span>
					</section>
				';
	return $__finalCompiled;
},
'attributes_main' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
											<li>' . $__templater->func('date_dynamic', array($__vars['attachment']['attach_date'], array(
	))) . '</li>
										';
	return $__finalCompiled;
},
'attributes_opposite' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
											<li>
												<a href="' . $__templater->func('link', array('posts/', $__vars['attachment']['Post'], ), true) . '" target="_blank" rel="nofollow">
													' . $__templater->escape($__vars['attachment']['Post']['Thread']['title']) . '
												</a>
											</li>
										';
	return $__finalCompiled;
},
'attributes' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
									<ul class="message-attribution-main listInline">
										' . $__templater->renderExtension('attributes_main', $__vars, $__extensions) . '
									</ul>

									<ul class="message-attribution-opposite message-attribution-opposite--list">
										' . $__templater->renderExtension('attributes_opposite', $__vars, $__extensions) . '
									</ul>
									' . '
								';
	return $__finalCompiled;
},
'data_start' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	
	return $__finalCompiled;
},
'data_payment_system' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '

												<a class="file-preview\'js-lbImage" href="' . $__templater->escape($__vars['attachment']['direct_url']) . '" target="_blank">
													<img src="' . $__templater->escape($__vars['attachment']['thumbnail_url']) . '" alt="' . $__templater->escape($__vars['attachment']['filename']) . '"
														 width="' . $__templater->escape($__vars['attachment']['thumbnail_width']) . '" height="' . $__templater->escape($__vars['attachment']['thumbnail_height']) . '" loading="lazy" />
												</a>
											';
	return $__finalCompiled;
},
'data_end' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	
	return $__finalCompiled;
},
'actions' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
					<div>

						' . $__templater->formRadio(array(
		'name' => 'attachments[' . $__vars['attachment']['attachment_id'] . ']',
	), array(array(
		'value' => 'pending',
		'checked' => 'checked',
		'data-xf-click' => 'fs-attachment-queue-control',
		'label' => '
								' . 'Pending' . '
							',
		'_type' => 'option',
	),
	array(
		'value' => 'approve',
		'data-xf-click' => 'fs-attachment-queue-control',
		'label' => '
								' . 'Approve' . '
							',
		'_type' => 'option',
	),
	array(
		'value' => 'rejected',
		'data-xf-click' => 'fs-attachment-queue-control',
		'label' => 'Reject',
		'_type' => 'option',
	))) . '

					</div>

				';
	return $__finalCompiled;
}),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	<div class="message">
		';
	$__templater->includeCss('message.less');
	$__finalCompiled .= '
		<div class="message-inner">
			<div class="message-cell message-cell--user">

				' . $__templater->renderExtension('user_wrapper', $__vars, $__extensions) . '

			</div>

			<div class="message-cell message-cell--main">
				<div class="message-expandWrapper js-expandWatch">
					<div class="message-expandContent js-expandContent">
						<div class="message-main">

							<header class="message-attribution">
								' . $__templater->renderExtension('attributes', $__vars, $__extensions) . '
							</header>

							<div class="message-content">

								<div class="message-userContent">
									<div class="message-body">

										<div class="pairWrapper pairWrapper--spaced">

											' . $__templater->renderExtension('data_start', $__vars, $__extensions) . '

											' . $__templater->renderExtension('data_payment_system', $__vars, $__extensions) . '

											' . $__templater->renderExtension('data_end', $__vars, $__extensions) . '

										</div>

									</div>
								</div>

							</div>

						</div>
					</div>
					<div class="message-expandLink js-expandLink"><a>' . 'Click to expand...' . '</a></div>
				</div>
			</div>

			<div class="message-cell message-cell--extra" style="display: flex; flex-direction: column; justify-content: space-between;">
				' . $__templater->renderExtension('actions', $__vars, $__extensions) . '
			</div>

		</div>
	</div>


	' . $__templater->func('redirect_input', array($__vars['redirect'], null, true)) . '

';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('[FS] Attachment Approval Queue');
	$__finalCompiled .= '

<div class="blocks">
	';
	if (!$__templater->test($__vars['pendingAttachments'], 'empty', array())) {
		$__finalCompiled .= '

		<div class="block-outer block-outer--before">
			' . $__templater->func('page_nav', array(array(
			'page' => $__vars['page'],
			'total' => $__vars['total'],
			'link' => 'attachment-queue/',
			'params' => $__vars['conditions'],
			'wrapperclass' => 'block-outer-main',
			'perPage' => $__vars['perPage'],
		))) . '
		</div>

		';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['pendingAttachments'])) {
			foreach ($__vars['pendingAttachments'] AS $__vars['attachment']) {
				$__compilerTemp1 .= '

					';
				if ($__vars['attachment']['Data']) {
					$__compilerTemp1 .= '
						<div class="block">
							<div class="block-container approvalQueue-item js-approvalQueue-item">
								<div class="block-body">
									' . $__templater->callMacro(null, 'fs_attachment_form', array(
						'attachment' => $__vars['attachment'],
						'redirect' => $__vars['redirect'],
						'page' => $__vars['page'],
					), $__vars) . '
								</div>
							</div>
						</div>
					';
				}
				$__compilerTemp1 .= '

				';
			}
		}
		$__finalCompiled .= $__templater->form('

			<div class="blocks">
				' . $__compilerTemp1 . '

				<div class="block">
					<div class="block-container block-container--none" >
						' . $__templater->formSubmitRow(array(
			'icon' => 'save',
			'sticky' => '.js-stickyParent',
		), array(
			'rowtype' => 'standalone',
		)) . '
					</div>
				</div>
			</div>
		', array(
			'class' => 'js-stickyParent approvalQueue',
			'action' => $__templater->func('link', array('attachment-queue/save', ), false),
			'ajax' => 'true',
		)) . '


		<div class="block-outer block-outer--after">
			' . $__templater->func('page_nav', array(array(
			'page' => $__vars['page'],
			'total' => $__vars['total'],
			'link' => 'attachment-queue/',
			'params' => $__vars['conditions'],
			'wrapperclass' => 'block-outer-main',
			'perPage' => $__vars['perPage'],
		))) . '
		</div>

		';
	} else {
		$__finalCompiled .= '

		<div class="block">
			<div class="block-container">
				<div class="block-body">
					<div class="formInfoRow">
						' . 'No results found.' . '
					</div>
				</div>
			</div>
		</div>

	';
	}
	$__finalCompiled .= '
</div>

';
	return $__finalCompiled;
}
);