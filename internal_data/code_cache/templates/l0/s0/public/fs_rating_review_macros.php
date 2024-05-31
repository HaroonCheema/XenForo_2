<?php
// FROM HASH: 3f643b7871232948923881884e61aa15
return array(
'macros' => array('review' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'review' => '!',
		'showResource' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	$__templater->includeCss('message.less');
	$__finalCompiled .= '
	';
	$__templater->includeJs(array(
		'src' => 'xf/comment.js',
		'min' => '1',
	));
	$__finalCompiled .= '

	<div class="message message--simple">
		<span class="u-anchorTarget" id="resource-review-' . $__templater->escape($__vars['review']['rating_id']) . '"></span>
		<div class="message-inner">
			<span class="message-cell message-cell--user">
				' . $__templater->callMacro('message_macros', 'user_info_simple', array(
		'user' => $__vars['review']['User'],
		'fallbackName' => 'Deleted member',
	), $__vars) . '
			</span>
			<div class="message-cell message-cell--main">
				<div class="message-content js-messageContent">
					<div class="message-attribution message-attribution--plain">

						<h3 class="node-title">
							<a href="' . $__templater->func('link', array('account/upgrades', $__vars['review']['Upgrade']['user_upgrade_id'], ), true) . '">' . $__templater->escape($__vars['review']['Upgrade']['title']) . '</a>

							';
	if ($__templater->method($__vars['review'], 'isImage', array())) {
		$__finalCompiled .= '
								<img src="' . $__templater->escape($__templater->method($__vars['review'], 'getImgUrl', array(true, ))) . '" style="width:80px; height:80px; float: right;" >
							';
	}
	$__finalCompiled .= '
						</h3>

						<ul class="listInline listInline--bullet">
							<li class="message-attribution-user">
								' . $__templater->func('username_link', array($__vars['review']['User'], false, array(
		'defaultname' => 'Deleted member',
	))) . '
							</li>
							<li>
								' . $__templater->callMacro('rating_macros', 'stars', array(
		'rating' => $__vars['review']['rating'],
		'class' => 'ratingStars--smaller',
	), $__vars) . '
							</li>
							<li><a href="' . $__templater->func('link', array('resources/review', $__vars['review'], ), true) . '" class="u-concealed">' . $__templater->func('date_dynamic', array($__vars['review']['rating_date'], array(
	))) . '</a></li>
						</ul>
					</div>

					<div class="message-body">
						' . $__templater->func('structured_text', array($__vars['review']['message'], ), true) . '
					</div>
				</div>

				';
	if (($__vars['xf']['visitor']['is_admin'] OR ($__vars['xf']['visitor']['user_id'] == $__vars['review']['user_id']))) {
		$__finalCompiled .= ' 
					';
		$__compilerTemp1 = '';
		$__compilerTemp1 .= '

								';
		$__compilerTemp2 = '';
		$__compilerTemp2 .= '

											<a href="' . $__templater->func('link', array('package-rating/delete', $__vars['review'], ), true) . '"
											   class="actionBar-action actionBar-action--delete actionBar-action--menuItem"
											   data-xf-click="overlay">
												' . 'Delete' . '
											</a>

										';
		if (strlen(trim($__compilerTemp2)) > 0) {
			$__compilerTemp1 .= '
									<div class="actionBar-set actionBar-set--internal">
										' . $__compilerTemp2 . '
									</div>
								';
		}
		$__compilerTemp1 .= '
							';
		if (strlen(trim($__compilerTemp1)) > 0) {
			$__finalCompiled .= '
						<div class="message-actionBar actionBar">
							' . $__compilerTemp1 . '
						</div>
					';
		}
		$__finalCompiled .= '
				';
	}
	$__finalCompiled .= '

			</div>

		</div>
	</div>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';

	return $__finalCompiled;
}
);