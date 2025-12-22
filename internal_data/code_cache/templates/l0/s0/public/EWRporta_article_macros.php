<?php
// FROM HASH: 203cc580bdcb5e5c6d68e8ea06be5e3e
return array(
'macros' => array('post' => array(
'extends' => 'post_macros::post',
'extensions' => array('extra_classes' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= 'message--simple ' . $__templater->renderExtensionParent($__vars, null, $__extensions);
	return $__finalCompiled;
},
'user_cell' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= $__templater->callMacro(null, 'post_user_info', array(
		'post' => $__vars['post'],
	), $__vars);
	return $__finalCompiled;
},
'attribution' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= $__templater->callMacro(null, 'post_attribution', array(
		'post' => $__vars['post'],
		'thread' => $__vars['thread'],
	), $__vars);
	return $__finalCompiled;
},
'signature' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	
	return $__finalCompiled;
}),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	' . $__templater->renderExtension('extra_classes', $__vars, $__extensions) . '
	' . $__templater->renderExtension('user_cell', $__vars, $__extensions) . '
	' . $__templater->renderExtension('attribution', $__vars, $__extensions) . '
	' . $__templater->renderExtension('signature', $__vars, $__extensions) . '
';
	return $__finalCompiled;
}
),
'answer' => array(
'extends' => 'post_question_macros::answer',
'extensions' => array('extra_classes' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= 'message--simple ' . $__templater->renderExtensionParent($__vars, null, $__extensions);
	return $__finalCompiled;
},
'user_cell' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= $__templater->callMacro(null, 'post_user_info', array(
		'post' => $__vars['post'],
	), $__vars);
	return $__finalCompiled;
},
'attribution' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= $__templater->callMacro(null, 'post_attribution', array(
		'post' => $__vars['post'],
		'thread' => $__vars['thread'],
	), $__vars);
	return $__finalCompiled;
},
'signature' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	
	return $__finalCompiled;
}),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	' . $__templater->renderExtension('extra_classes', $__vars, $__extensions) . '
	' . $__templater->renderExtension('user_cell', $__vars, $__extensions) . '
	' . $__templater->renderExtension('attribution', $__vars, $__extensions) . '
	' . $__templater->renderExtension('signature', $__vars, $__extensions) . '
';
	return $__finalCompiled;
}
),
'suggestion' => array(
'extends' => 'post_suggestion_macros::suggestion',
'extensions' => array('extra_classes' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= 'message--simple ' . $__templater->renderExtensionParent($__vars, null, $__extensions);
	return $__finalCompiled;
},
'user_cell' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= $__templater->callMacro(null, 'post_user_info', array(
		'post' => $__vars['post'],
	), $__vars);
	return $__finalCompiled;
},
'attribution' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= $__templater->callMacro(null, 'post_attribution', array(
		'post' => $__vars['post'],
		'thread' => $__vars['thread'],
	), $__vars);
	return $__finalCompiled;
},
'signature' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	
	return $__finalCompiled;
}),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	' . $__templater->renderExtension('extra_classes', $__vars, $__extensions) . '
	' . $__templater->renderExtension('user_cell', $__vars, $__extensions) . '
	' . $__templater->renderExtension('attribution', $__vars, $__extensions) . '
	' . $__templater->renderExtension('signature', $__vars, $__extensions) . '
';
	return $__finalCompiled;
}
),
'post_user_info' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'post' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="message-cell message-cell--user">
		' . $__templater->callMacro('message_macros', 'user_info_simple', array(
		'user' => $__vars['post']['User'],
		'fallbackName' => $__vars['post']['username'],
	), $__vars) . '
	</div>
';
	return $__finalCompiled;
}
),
'post_attribution' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'post' => '!',
		'thread' => '!',
		'hidePosition' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<header class="message-attribution message-attribution--plain">
		<div class="message-attribution-main">
			<ul class="listInline listInline--bullet">
				<li class="message-attribution-user">
					<h4 class="attribution">
						' . $__templater->func('username_link', array($__vars['post']['User'], true, array(
		'defaultname' => $__vars['post']['username'],
	))) . '
					</h4>
				</li>
				<li><a href="' . $__templater->func('link', array('threads/post', $__vars['thread'], array('post_id' => $__vars['post']['post_id'], ), ), true) . '"
					   class="u-concealed" rel="nofollow">' . $__templater->func('date_dynamic', array($__vars['post']['post_date'], array(
	))) . '</a></li>
			</ul>
		</div>

		<ul class="message-attribution-opposite message-attribution-opposite--list">
			';
	if ($__templater->method($__vars['post'], 'isUnread', array())) {
		$__finalCompiled .= '
				<li><span class="message-newIndicator">' . 'New' . '</span></li>
			';
	}
	$__finalCompiled .= '
			<li>
				<a href="' . $__templater->func('link', array('threads/post', $__vars['thread'], array('post_id' => $__vars['post']['post_id'], ), ), true) . '"
					class="message-attribution-gadget"
					data-xf-init="share-tooltip" data-href="' . $__templater->func('link', array('posts/share', $__vars['post'], ), true) . '"
					rel="nofollow">
					' . $__templater->fontAwesome('fa-share-alt', array(
	)) . '
				</a>
			</li>
			';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '
						' . $__templater->callMacro('bookmark_macros', 'link', array(
		'content' => $__vars['post'],
		'class' => 'message-attribution-gadget bookmarkLink--highlightable',
		'confirmUrl' => $__templater->func('link', array('posts/bookmark', $__vars['post'], ), false),
		'showText' => false,
	), $__vars) . '
					';
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
				<li>
					' . $__compilerTemp1 . '
				</li>
			';
	}
	$__finalCompiled .= '
			';
	if (!$__vars['hidePosition']) {
		$__finalCompiled .= '
				<li>
					<a href="' . $__templater->func('link', array('threads/post', $__vars['thread'], array('post_id' => $__vars['post']['post_id'], ), ), true) . '" rel="nofollow">
						#' . $__templater->func('number', array($__vars['post']['position'] + 1, ), true) . '
					</a>
				</li>
			';
	}
	$__finalCompiled .= '
		</ul>
	</header>
';
	return $__finalCompiled;
}
),
'thread_tools' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'thread' => '!',
		'article' => '!',
		'feature' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '
			';
	if ($__templater->method($__vars['xf']['visitor'], 'hasPermission', array('EWRporta', 'submitArticles', ))) {
		$__compilerTemp1 .= '
				<a href="' . $__templater->func('link', array('threads/article-edit', $__vars['thread'], ), true) . '"
						class="menu-linkRow">
					';
		if ($__vars['article'] AND $__templater->method($__vars['article'], 'canEdit', array())) {
			$__compilerTemp1 .= '
						' . 'Edit article promotion' . '
					';
		} else {
			$__compilerTemp1 .= '
						' . 'Promote to article' . '
					';
		}
		$__compilerTemp1 .= '
				</a>
			';
	}
	$__compilerTemp1 .= '

			';
	if ($__templater->method($__vars['xf']['visitor'], 'hasPermission', array('EWRporta', 'submitFeatures', ))) {
		$__compilerTemp1 .= '
				<a href="' . $__templater->func('link', array('threads/feature-edit', $__vars['thread'], ), true) . '"
						class="menu-linkRow">
					';
		if ($__vars['feature']) {
			$__compilerTemp1 .= '
						' . 'Edit feature promotion' . '
					';
		} else {
			$__compilerTemp1 .= '
						' . 'Promote to feature' . '
					';
		}
		$__compilerTemp1 .= '
				</a>
			';
	}
	$__compilerTemp1 .= '
		';
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
		<div class="menu-separator"></div>

		' . $__compilerTemp1 . '
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'thread_promote' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'thread' => '!',
		'rowType' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__compilerTemp1 = array();
	if ($__templater->method($__vars['xf']['visitor'], 'hasPermission', array('EWRporta', 'submitArticles', ))) {
		$__compilerTemp1[] = array(
			'name' => 'article-promote',
			'value' => '1',
			'selected' => $__templater->func('in_array', array($__vars['thread']['node_id'], $__vars['xf']['options']['EWRporta_article_forums'], ), false),
			'label' => 'Promote to article',
			'hint' => 'You will be redirected to the article promotion page after posting this thread',
			'_type' => 'option',
		);
	}
	$__finalCompiled .= $__templater->formCheckBoxRow(array(
		'hideempty' => 'true',
	), $__compilerTemp1, array(
		'rowtype' => $__vars['rowType'],
		'label' => 'Articles',
	)) . '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

' . '

' . '

' . '
	
' . '

' . '

';
	return $__finalCompiled;
}
);