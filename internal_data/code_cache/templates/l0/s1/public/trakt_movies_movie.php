<?php
// FROM HASH: 47f31da637cb2966b8c835fad224b1fa
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped($__templater->func('prefix', array('thread', $__vars['thread'], 'escaped', ), true) . $__templater->escape($__vars['thread']['title']));
	$__finalCompiled .= '
';
	$__templater->pageParams['pageH1'] = $__templater->preEscaped($__templater->func('prefix', array('thread', $__vars['thread'], ), true) . $__templater->escape($__vars['thread']['title']));
	$__finalCompiled .= '

';
	if ($__vars['xf']['options']['traktthreads_use_rating']) {
		$__finalCompiled .= '
	';
		$__vars['rating'] = $__vars['thread']['traktMovie']['trakt_rating'];
		$__finalCompiled .= '
	<div style="margin-bottom:10px;">
		' . $__templater->callMacro('rating_macros', 'stars_text', array(
			'rating' => $__vars['rating'],
			'text' => 'Rating' . ': ' . $__vars['thread']['traktMovie']['trakt_rating'] . '/5 ' . $__vars['thread']['traktMovie']['trakt_votes'] . ' ' . 'Votes',
		), $__vars) . '
	
		';
		if ($__vars['xf']['visitor']['user_id']) {
			$__finalCompiled .= '
			<a href="' . $__templater->func('link', array('traktMovies/rate', $__vars['thread']['traktMovie'], ), true) . '" data-xf-click="overlay"><button type="button" class="button--link button"><span class="button-text">' . 'Add/Change rating' . '</span></button></a>
		';
		}
		$__finalCompiled .= '
	</div>
';
	}
	$__finalCompiled .= '

<div class="movieBlock">
	';
	if ($__templater->func('property', array('trakt_movies_messagePosterPosition', ), false) == 'left') {
		$__finalCompiled .= '
		<div class="moviethreadposter">
			<img src="' . $__templater->escape($__templater->method($__vars['thread']['traktMovie'], 'getImageUrl', array('l', ))) . '" />
		</div>
	';
	}
	$__finalCompiled .= '
	
	<div class="message' . (($__templater->func('property', array('trakt_movies_messagePosterPosition', ), false) == 'left') ? ' messageMovie' : ' messageMovieLeft') . '">
		';
	if ($__vars['xf']['options']['traktthreads_showThreadInfo']['title']) {
		$__finalCompiled .= '<b>' . 'Title' . ':</b> ' . $__templater->escape($__vars['thread']['traktMovie']['trakt_title']) . '<br />';
	}
	$__finalCompiled .= '
		';
	if ($__vars['xf']['options']['traktthreads_showThreadInfo']['tagline'] AND $__vars['thread']['traktMovie']['trakt_tagline']) {
		$__finalCompiled .= '<p><b>' . 'Tagline' . ':</b> ' . $__templater->escape($__vars['thread']['traktMovie']['trakt_tagline']) . '</p>';
	}
	$__finalCompiled .= '
		';
	if ($__vars['xf']['options']['traktthreads_showThreadInfo']['genres'] AND $__vars['thread']['traktMovie']['trakt_genres']) {
		$__finalCompiled .= '<p><b>' . 'Genre' . ':</b> ' . $__templater->escape($__vars['thread']['traktMovie']['trakt_genres']) . '</p>';
	}
	$__finalCompiled .= '
		';
	if ($__vars['xf']['options']['traktthreads_showThreadInfo']['director'] AND $__vars['thread']['traktMovie']['trakt_director']) {
		$__finalCompiled .= '<p><b>' . 'Director' . ':</b> ' . $__templater->escape($__vars['thread']['traktMovie']['trakt_director']) . '</p>';
	}
	$__finalCompiled .= '
		';
	if ($__vars['xf']['options']['traktthreads_showThreadInfo']['cast'] AND $__vars['thread']['traktMovie']['trakt_cast']) {
		$__finalCompiled .= '<p><b>' . 'Cast' . ':</b> ' . $__templater->escape($__vars['thread']['traktMovie']['trakt_cast']) . '</p>';
	}
	$__finalCompiled .= '
		';
	if ($__vars['xf']['options']['traktthreads_showThreadInfo']['release_date'] AND $__vars['thread']['traktMovie']['trakt_release']) {
		$__finalCompiled .= '<p><b>' . 'Release' . ':</b> ' . $__templater->escape($__vars['thread']['traktMovie']['trakt_release']) . '</p>';
	}
	$__finalCompiled .= '
		';
	if ($__vars['xf']['options']['traktthreads_showThreadInfo']['runtime'] AND $__vars['thread']['traktMovie']['trakt_runtime']) {
		$__finalCompiled .= '<p><b>' . 'Runtime' . ':</b> ' . $__templater->escape($__vars['thread']['traktMovie']['trakt_runtime']) . '</p>';
	}
	$__finalCompiled .= '
		';
	if ($__vars['xf']['options']['traktthreads_showThreadInfo']['plot'] AND $__vars['thread']['traktMovie']['trakt_plot']) {
		$__finalCompiled .= '<b>' . 'Plot' . ':</b> ' . $__templater->escape($__vars['thread']['traktMovie']['trakt_plot']);
	}
	$__finalCompiled .= '
	</div>
	
	';
	if ($__templater->func('property', array('trakt_movies_messagePosterPosition', ), false) == 'right') {
		$__finalCompiled .= '
		<div class="moviethreadposter">
			<img src="' . $__templater->escape($__templater->method($__vars['thread']['traktMovie'], 'getImageUrl', array('l', ))) . '" />
		</div>
	';
	}
	$__finalCompiled .= '
</div>

';
	if ($__vars['xf']['options']['traktthreads_showThreadInfo']['trailer'] AND $__vars['thread']['traktMovie']['trakt_trailer']) {
		$__finalCompiled .= '
	<div class="bbMediaWrapper">
		<div class="bbMediaWrapper-inner">
			<iframe width="500"
				height="300"
				allowfullscreen
				src="https://www.youtube.com/embed/' . $__templater->escape($__vars['thread']['traktMovie']['trakt_trailer']) . '?wmode=opaque&start=0"
				style="border:none;"></iframe>
		</div>
	</div>
	<p></p>
';
	}
	$__finalCompiled .= '

';
	if (!$__vars['xf']['options']['traktthreads_force_comments']) {
		$__finalCompiled .= '
	' . $__templater->func('bb_code', array($__vars['thread']['traktMovie']['comment'], 'post', $__vars['post']['User'], array('attachments' => ($__vars['post']['attach_count'] ? $__vars['post']['Attachments'] : array()), 'viewAttachments' => $__templater->method($__vars['thread'], 'canViewAttachments', array()), ), ), true) . '
';
	}
	$__finalCompiled .= '

';
	$__vars['fpSnippet'] = $__templater->func('snippet', array($__vars['post']['message'], 0, array('stripBbCode' => true, ), ), false);
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__vars['thread']['traktMovie']['trakt_rating'] > 0) {
		$__compilerTemp1 .= ',
		"aggregateRating": {
    		"@type": "AggregateRating",
    		"bestRating": "5",
			"worstRating": "1",
    		"ratingCount": "' . $__templater->escape($__vars['thread']['traktMovie']['trakt_votes']) . '",
    		"ratingValue": "' . $__templater->escape($__vars['thread']['traktMovie']['trakt_rating']) . '"
  		}';
	}
	$__templater->setPageParam('ldJsonHtml', '
	<script type="application/ld+json">
	{
		"@context": "https://schema.org",
		"@type": "DiscussionForumPosting",
		"@id": "' . $__templater->filter($__templater->func('link', array('canonical:threads', $__vars['thread'], ), false), array(array('escape', array('js', )),), true) . '",
		"headline": "' . $__templater->filter($__vars['thread']['title'], array(array('escape', array('htmljs', )),), true) . '",
		"datePublished": "' . $__templater->func('date', array($__vars['post']['post_date'], 'Y-m-d', ), true) . '",
		"articleBody": "' . $__templater->filter($__vars['fpSnippet'], array(array('escape', array('htmljs', )),), true) . '",
		"articleSection": "' . $__templater->filter($__vars['thread']['Forum']['Node']['title'], array(array('escape', array('htmljs', )),), true) . '",
		"author": {
			"@type": "Person",
			"name": "' . $__templater->filter(($__vars['thread']['User'] ? $__vars['thread']['User']['username'] : $__vars['thread']['username']), array(array('escape', array('htmljs', )),), true) . '"
		},
		"interactionStatistic": {
			"@type": "InteractionCounter",
			"interactionType": "https://schema.org/ReplyAction",
			"userInteractionCount": ' . $__templater->escape($__vars['thread']['reply_count']) . '
		}
	}
	</script>
	
	<script type="application/ld+json">
	{
  		"@context": "http://schema.org/",
  		"@type": "Movie",
  		"name": "' . $__templater->escape($__vars['thread']['traktMovie']['trakt_title']) . '",
		"director": "' . $__templater->escape($__vars['thread']['traktMovie']['trakt_director']) . '",
		"dateCreated": "' . $__templater->escape($__vars['thread']['traktMovie']['trakt_release']) . '",
		"duration": "PT' . $__templater->escape($__vars['thread']['traktMovie']['trakt_runtime']) . 'M",
  		"image": "' . $__templater->escape($__templater->method($__vars['thread']['traktMovie'], 'getImageUrl', array('l', ))) . '",
  		"description": "' . $__templater->escape($__vars['thread']['traktMovie']['trakt_plot']) . '"' . $__compilerTemp1 . '
	}
	</script>
');
	return $__finalCompiled;
}
);