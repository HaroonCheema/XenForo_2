<?php
// FROM HASH: adec05ca7ced18a86e5a05068a1712b0
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<li class="block-row block-row--separated ' . ($__templater->method($__vars['thread'], 'isIgnored', array()) ? 'is-ignored' : '') . ' js-inlineModContainer" data-author="' . ($__templater->escape($__vars['thread']['User']['username']) ?: $__templater->escape($__vars['thread']['username'])) . '">
	<div class="contentRow ' . ((!$__templater->method($__vars['thread'], 'isVisible', array())) ? 'is-deleted' : '') . '">
		<span class="contentRow-figure">
			' . $__templater->func('avatar', array($__vars['thread']['User'], 's', false, array(
		'defaultname' => $__vars['thread']['username'],
	))) . '
		</span>
		<div class="contentRow-main">
			<h3 class="contentRow-title">
				<a href="' . $__templater->func('link', array('threads', $__vars['thread'], ), true) . '">' . $__templater->func('prefix', array('thread', $__vars['thread'], ), true);
	$__compilerTemp1 = $__vars;
	$__compilerTemp1['columnList'] = $__vars['thread']['Forum']['display_fields']['forum_view']['prefix'];
	$__compilerTemp1['fieldData'] = $__vars['thread']['custom_fields'];
	$__finalCompiled .= trim('
' . $__templater->includeTemplate('altf_list_prefix', $__compilerTemp1) . '
') . ' ' . $__templater->func('highlight', array($__vars['thread']['title'], $__vars['options']['term'], ), true) . '</a>
			';
	if ($__templater->method($__vars['thread'], 'canDisplayThreadRating', array())) {
		$__finalCompiled .= '
	' . $__templater->callMacro('BRATR_rating_macros', 'stars_text', array(
			'rating' => $__vars['thread']['brivium_rating_avg'],
			'count' => $__vars['thread']['brivium_rating_count'],
			'rowClass' => 'block-outer-opposite',
		), $__vars) . '
';
	}
	$__finalCompiled .= '
</h3>
			
			' . $__templater->func('dump', array($__vars['options']['term'], ), true) . '

			<div class="contentRow-snippet">' . $__templater->func('bb_code_snippet', array($__vars['thread']['FirstPost']['message'], 'post', $__vars['thread']['FirstPost'], 300, ), true) . '</div>

			';
	$__compilerTemp2 = $__vars;
	$__compilerTemp2['columnList'] = $__vars['thread']['Forum']['display_fields']['search']['metadata'];
	$__compilerTemp2['fieldData'] = $__vars['thread']['custom_fields'];
	$__finalCompiled .= $__templater->includeTemplate('altf_thread_field_search_list', $__compilerTemp2) . '
<div class="contentRow-minor contentRow-minor--hideLinks">
				<ul class="listInline listInline--bullet">
					';
	if (($__vars['options']['mod'] == 'thread') AND $__templater->method($__vars['thread'], 'canUseInlineModeration', array())) {
		$__finalCompiled .= '
						<li>' . $__templater->formCheckBox(array(
			'standalone' => 'true',
		), array(array(
			'value' => $__vars['thread']['thread_id'],
			'class' => 'js-inlineModToggle',
			'data-xf-init' => 'tooltip',
			'title' => 'Select for moderation',
			'_type' => 'option',
		))) . '</li>
					';
	}
	$__finalCompiled .= '
					<li>' . $__templater->func('username_link', array($__vars['thread']['User'], false, array(
		'defaultname' => $__vars['thread']['username'],
	))) . '</li>
					<li>' . 'Thread' . '</li>
					<li>' . $__templater->func('date_dynamic', array($__vars['thread']['post_date'], array(
	))) . '</li>
					';
	if ($__vars['xf']['options']['enableTagging'] AND $__vars['thread']['tags']) {
		$__finalCompiled .= '
						<li>
							' . $__templater->callMacro('tag_macros', 'simple_list', array(
			'tags' => $__vars['thread']['tags'],
			'containerClass' => 'contentRow-minor',
			'highlightTerm' => ($__vars['options']['tag'] ?: $__vars['options']['term']),
		), $__vars) . '
						</li>
					';
	}
	$__finalCompiled .= '
					<li>' . 'Replies' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->filter($__vars['thread']['reply_count'], array(array('number', array()),), true) . '</li>
					<li>' . 'Forum' . $__vars['xf']['language']['label_separator'] . ' <a href="' . $__templater->func('link', array('forums', $__vars['thread']['Forum'], ), true) . '">' . $__templater->escape($__vars['thread']['Forum']['title']) . '</a></li>
				</ul>
			</div>
		</div>
	</div>
</li>';
	return $__finalCompiled;
}
);