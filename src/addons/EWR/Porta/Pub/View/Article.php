<?php

namespace EWR\Porta\Pub\View;

class Article extends \XF\Mvc\View
{
	public function renderRss()
	{
		$app = \XF::app();
		$router = $app->router('public');
		$options = $app->options();
		$category = !empty($this->params['category']) ? $this->params['category'] : false;
		$author = !empty($this->params['author']) ? $this->params['author'] : false;
		$indexUrl = $router->buildLink('canonical:ewr-porta');
		
		if ($category)
		{
			$feedLink = $router->buildLink('canonical:ewr-porta/categories/index.rss', $category);
		}
		elseif ($author)
		{
			$feedLink = $router->buildLink('canonical:ewr-porta/authors/index.rss', $author);
		}
		else
		{
			$feedLink = $router->buildLink('canonical:ewr-porta/index.rss', '-');
		}

		if ($category)
		{
			$title = $category->category_name;
			$description = $category->category_description;
		}
		elseif ($author)
		{
			$title = $author->author_name;
			$description = $author->author_status;
		}
		else
		{
			$title = $options->EWRporta_title ?: $options->boardTitle;
			$description = $options->EWRporta_metadesc ?: $options->boardDescription;
		}

		$title = $title ?: $indexUrl;
		$description = $description ?: $title;

		$feed = new \Zend\Feed\Writer\Feed();

		$feed->setEncoding('utf-8')
			->setTitle($title)
			->setDescription($description)
			->setLink($indexUrl)
			->setFeedLink($feedLink, 'rss')
			->setDateModified(\XF::$time)
			->setLastBuildDate(\XF::$time)
			->setGenerator($title);

		$parser = $app->bbCode()->parser();
		$rules = $app->bbCode()->rules('post:rss');

		$bbCodeCleaner = $app->bbCode()->renderer('bbCodeClean');
		$bbCodeRenderer = $app->bbCode()->renderer('html');

		$formatter = $app->stringFormatter();
		$maxLength = $options->discussionRssContentLength;

		foreach ($this->params['articles'] AS $article)
		{
			$entry = $feed->createEntry();

			$entry->setTitle($article->article_title ?: $article->Thread->title)
				->setLink($router->buildLink('canonical:threads', $article->Thread))
				->setDateCreated($article->article_date);

			$firstPost = $article->Thread->FirstPost;

			if ($maxLength)
			{
				$snippet = $bbCodeCleaner->render($formatter->wholeWordTrim(
					$article->article_excerpt ?: $article->Thread->FirstPost->message, $maxLength), $parser, $rules);

				if ($snippet != $article->article_excerpt)
				{
					$snippet .= "\n\n[URL='" . $router->buildLink('canonical:threads', $article->Thread)."']" .
						$article->article_title ?: $article->Thread->title . "[/URL]";
				}

				$renderOptions = $firstPost->getBbCodeRenderOptions('post:rss', 'html');
				$renderOptions['noProxy'] = true;

				$content = trim($bbCodeRenderer->render($snippet, $parser, $rules, $renderOptions));
				if (strlen($content))
				{
					$entry->setContent($content);
				}
			}

			$entry->addAuthor([
				'name' => $article->Thread->username,
				'email' => 'invalid@example.com',
				'uri' => $router->buildLink('canonical:members', $article->Thread)
			]);
			if ($article->Thread->reply_count)
			{
				$entry->setCommentCount($article->Thread->reply_count);
			}

			$feed->addEntry($entry);
		}

		return $feed->export('rss', true);
	}
}