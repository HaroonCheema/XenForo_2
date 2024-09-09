<?php
// FROM HASH: 3a378e4ddba0b0e08b518e86c8369b97
return array(
'macros' => array('identity_images' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'item' => '!',
		'redirect' => '/',
		'page' => '0',
	); },
'extensions' => array('user_avatar' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
									<div class="message-avatar">
										<div class="message-avatar-wrapper">
											' . $__templater->func('avatar', array($__vars['item']['User'], 'm', false, array(
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
										<h4 class="message-name">' . $__templater->func('username_link', array($__vars['item']['User'], true, array(
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
													<li>' . $__templater->func('date_dynamic', array($__vars['item']['create_date'], array(
	))) . '</li>
												';
	return $__finalCompiled;
},
'attributes_opposite' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
													<li>
														<a href="' . (($__templater->func('link', array('item/queue', null, array('page' => $__vars['page'], ), ), true) . '#withdraw-') . $__templater->escape($__vars['item']['id'])) . '" rel="nofollow">
															#' . $__templater->filter($__vars['item']['id'], array(array('number', array()),), true) . '
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
															<dl class="pairs pairs--columns pairs--fluidHuge">
																<dt>' . 'Identity image' . '</dt>
																<dd>
																	<a href="' . $__templater->escape($__templater->method($__vars['item'], 'getImgUrl', array(true, 'govImage', ))) . '" rel="external" target="_blank">
																		<img src="' . $__templater->escape($__templater->method($__vars['item'], 'getImgUrl', array(true, 'govImage', ))) . '" style="width: ' . $__templater->escape($__vars['xf']['options']['fs_female_verification_images_pixels']['width']) . 'px; height: ' . $__templater->escape($__vars['xf']['options']['fs_female_verification_images_pixels']['height']) . 'px; float: right;"/>
																	</a>
																</dd>
															</dl>
														';
	return $__finalCompiled;
},
'data_wallet' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
															<dl class="pairs pairs--columns pairs--fluidHuge">
																<dt>' . 'Selfi image' . '</dt>
																<dd>
																	<a href="' . $__templater->escape($__templater->method($__vars['item'], 'getImgUrl', array(true, 'selfiImage', ))) . '" rel="external" target="_blank">
																		<img src="' . $__templater->escape($__templater->method($__vars['item'], 'getImgUrl', array(true, 'selfiImage', ))) . '" style="width: ' . $__templater->escape($__vars['xf']['options']['fs_female_verification_images_pixels']['width']) . 'px; height: ' . $__templater->escape($__vars['xf']['options']['fs_female_verification_images_pixels']['height']) . 'px; float: right;"/>
																	</a>
																</dd>
															</dl>

														';
	return $__finalCompiled;
},
'data_sum' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
															<dl class="pairs pairs--columns pairs--fluidHuge">
																<dt>' . 'Blank paper image' . '</dt>
																<dd>
																	<a href="' . $__templater->escape($__templater->method($__vars['item'], 'getImgUrl', array(true, 'paperImage', ))) . '" rel="external" target="_blank">
																		<img src="' . $__templater->escape($__templater->method($__vars['item'], 'getImgUrl', array(true, 'paperImage', ))) . '" style="width: ' . $__templater->escape($__vars['xf']['options']['fs_female_verification_images_pixels']['width']) . 'px; height: ' . $__templater->escape($__vars['xf']['options']['fs_female_verification_images_pixels']['height']) . 'px; float: right;"/>
																	</a>
																</dd>
															</dl>
														';
	return $__finalCompiled;
},
'data_end' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	
	return $__finalCompiled;
},
'data_starts' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	
	return $__finalCompiled;
},
'data_box_one' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
															<dl class="pairs pairs--columns pairs--fluidHuge">
																<dt>' . 'Name, phone or email' . '</dt>
																<dd>
																	' . $__templater->escape($__vars['item']['boxOne']) . '
																</dd>
															</dl>
														';
	return $__finalCompiled;
},
'data_box_two' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
															<dl class="pairs pairs--columns pairs--fluidHuge">
																<dt>' . 'Hadle or site' . '</dt>
																<dd>
																	' . $__templater->escape($__vars['item']['boxTwo']) . '
																</dd>
															</dl>

														';
	return $__finalCompiled;
},
'data_ends' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	
	return $__finalCompiled;
},
'actions' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '

							' . $__templater->formRadio(array(
		'name' => 'female_state',
	), array(array(
		'value' => 'pending',
		'checked' => (($__vars['item']['female_state'] == 'pending') ? 'checked' : ''),
		'data-xf-click' => 'pb-wq-withdraw-control',
		'label' => '
									' . 'Pending' . '
								',
		'_type' => 'option',
	),
	array(
		'value' => 'sent',
		'checked' => (($__vars['item']['female_state'] == 'sent') ? 'checked' : ''),
		'data-xf-click' => 'pb-wq-withdraw-control',
		'label' => '
									' . 'Approve' . '
								',
		'_type' => 'option',
	),
	array(
		'value' => 'rejected',
		'checked' => (($__vars['item']['female_state'] == 'rejected') ? 'checked' : ''),
		'data-xf-click' => 'pb-wq-withdraw-control',
		'label' => 'Reject',
		'_dependent' => array($__templater->formTextBox(array(
		'name' => 'reason',
		'maxlength' => $__templater->func('max_length', array($__vars['item'], 'reject_reason', ), false),
		'placeholder' => 'Optional',
	))),
		'html' => '
										<div class="formRow-explain">' . 'This will be shown to the user if provided.' . '</div>
									',
		'_type' => 'option',
	))) . '

						';
	return $__finalCompiled;
}),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	$__templater->includeCss('message.less');
	$__compilerTemp1 = '';
	if ($__vars['item']['verify_type'] == 'images') {
		$__compilerTemp1 .= '

										<div class="message-content">

											<div class="message-userContent">
												<div class="message-body">

													<div class="pairWrapper pairWrapper--spaced">

														' . $__templater->renderExtension('data_start', $__vars, $__extensions) . '

														' . $__templater->renderExtension('data_payment_system', $__vars, $__extensions) . '

														' . $__templater->renderExtension('data_wallet', $__vars, $__extensions) . '

														' . $__templater->renderExtension('data_sum', $__vars, $__extensions) . '

														' . $__templater->renderExtension('data_end', $__vars, $__extensions) . '

													</div>


												</div>
											</div>

										</div>
										';
	} else {
		$__compilerTemp1 .= '

										<div class="message-content">

											<div class="message-userContent">
												<div class="message-body">

													<div class="pairWrapper pairWrapper--spaced">

														' . $__templater->renderExtension('data_starts', $__vars, $__extensions) . '

														' . $__templater->renderExtension('data_box_one', $__vars, $__extensions) . '

														' . $__templater->renderExtension('data_box_two', $__vars, $__extensions) . '

														' . $__templater->renderExtension('data_ends', $__vars, $__extensions) . '

													</div>


												</div>
											</div>

										</div>
									';
	}
	$__finalCompiled .= $__templater->form('
		<span class="u-anchorTarget" id="withdraw-' . $__templater->escape($__vars['item']['id']) . '"></span>

		<div class="block-body">

			<div class="message">
				' . '' . '
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

									' . $__compilerTemp1 . '

								</div>
							</div>
							<div class="message-expandLink js-expandLink"><a>' . 'Click to expand...' . '</a></div>
						</div>
					</div>

					<div class="message-cell message-cell--extra">
						' . $__templater->renderExtension('actions', $__vars, $__extensions) . '
					</div>

				</div>
			</div>

		</div>

		' . $__templater->formSubmitRow(array(
		'icon' => 'save',
	), array(
		'rowtype' => 'simple',
	)) . '

	', array(
		'class' => 'block-container withdrawalQueue-item',
		'action' => $__templater->func('link', array('female-verify/queue/save', $__vars['item'], ), false),
		'ajax' => 'true',
	)) . '

';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Female pendings');
	$__finalCompiled .= '

';
	$__templater->setPageParam('section', 'fs_female_queue');
	$__finalCompiled .= '

';
	$__templater->includeCss('fs_female_queue_list.less');
	$__finalCompiled .= '
';
	$__templater->includeJs(array(
		'prod' => 'FS/SwbFemaleVerify/female_queue.min.js',
		'dev' => 'FS/SwbFemaleVerify/female_queue.js',
		'addon' => 'FS/SwbFemaleVerify',
	));
	$__finalCompiled .= '

<div class="blocks">
	';
	if (!$__templater->test($__vars['items'], 'empty', array())) {
		$__finalCompiled .= '

		';
		if ($__templater->isTraversable($__vars['items'])) {
			foreach ($__vars['items'] AS $__vars['item']) {
				$__finalCompiled .= '
			<div class="block withdrawalQueue">
				' . $__templater->callMacro(null, 'identity_images', array(
					'item' => $__vars['item'],
					'redirect' => $__vars['redirect'],
					'page' => $__vars['page'],
				), $__vars) . '
			</div>

		';
			}
		}
		$__finalCompiled .= '

		<div class="block-outer block-outer--after">
			' . $__templater->func('page_nav', array(array(
			'page' => $__vars['page'],
			'total' => $__vars['total'],
			'link' => 'wallet/queue',
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