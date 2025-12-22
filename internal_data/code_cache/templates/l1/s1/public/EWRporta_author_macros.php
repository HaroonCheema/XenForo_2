<?php
// FROM HASH: 0a940aa1a4233dfbc3262d0aba48022a
return array(
'macros' => array('author_block' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'author' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="block">
		<div class="block-container">
			<div class="block-body">
				<div class="contentRow contentRow--alignMiddle porta-author-block">
					<div class="contentRow-figure porta-author-image">
						<img src="' . $__templater->func('base_url', array($__vars['author']['image'], ), true) . '" alt="' . $__templater->escape($__vars['author']['author_name']) . '" />
					</div>
					<div class="contentRow-main">
						<div class="porta-author-icon">
							' . $__templater->func('avatar', array($__vars['author']['User'], 's', false, array(
		'defaultname' => $__vars['author']['User']['username'],
	))) . '
						</div>

						<h3 class="message-articleUserName porta-author-name">
							<a href="' . $__templater->func('link', array('ewr-porta/authors', $__vars['author']['User'], ), true) . '">' . $__templater->escape($__vars['author']['author_name']) . '</a>

							';
	if ($__templater->method($__vars['xf']['visitor'], 'hasAdminPermission', array('EWRporta', )) OR (($__vars['xf']['visitor']->{'user_id'} == $__vars['author']['user_id']))) {
		$__finalCompiled .= '
								<a href="' . $__templater->func('link', array('ewr-porta/authors/edit', $__vars['author']['User'], ), true) . '">
									' . $__templater->fontAwesome('fa-pencil', array(
		)) . '
								</a>
							';
	}
	$__finalCompiled .= '
						</h3>

						<div class="message-articleWrittenBy porta-author-status">' . $__templater->escape($__vars['author']['author_status']) . '</div>

						<div class="message-articleUserBlurb porta-author-byline">
							' . $__templater->func('bb_code', array($__vars['author']['author_byline'], 'ewr_porta_author', $__vars['author'], ), true) . '
						</div>
					</div>
				</div>
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