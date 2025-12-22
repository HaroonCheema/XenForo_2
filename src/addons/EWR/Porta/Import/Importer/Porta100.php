<?php

namespace EWR\Porta\Import\Importer;

use XF\Import\StepState;

class Porta100 extends \XF\Import\Importer\AbstractForumImporter
{
	/**
	 * @var \XF\Db\Mysqli\Adapter
	 */
	protected $sourceDb;

	public static function getListInfo()
	{
		return [
			'target' => '[8WR] XenPorta 2.x.x',
			'source' => '[8WR] XenPorta 1.0.0',
		];
	}

	protected function getBaseConfigDefault()
	{
		return [
			'db' => [
				'host' => '',
				'username' => '',
				'password' => '',
				'dbname' => '',
				'port' => 3306
			],
			'data_dir' => '',
			'internal_data_dir' => ''
		];
	}

	public function validateBaseConfig(array &$baseConfig, array &$errors)
	{
		$fullConfig = array_replace_recursive($this->getBaseConfigDefault(), $baseConfig);
		$missingFields = false;

		if ($fullConfig['db']['host'])
		{
			$validDbConnection = false;

			try
			{
				$db = new \XF\Db\Mysqli\Adapter($fullConfig['db'], false);
				$db->getConnection();
				$validDbConnection = true;
			}
			catch (\XF\Db\Exception $e)
			{
				$errors[] = \XF::phrase('source_database_connection_details_not_correct_x', ['message' => $e->getMessage()]);
			}
		}
		else
		{
			$missingFields = true;
		}

		if ($missingFields)
		{
			$errors[] = \XF::phrase('please_complete_required_fields');
		}

		return $errors ? false : true;
	}

	public function renderBaseConfigOptions(array $vars)
	{
		return $this->app->templater()->renderTemplate('admin:import_config_EWRporta_porta121', $vars);
	}

	protected function getStepConfigDefault()
	{
		return true;
	}

	public function renderStepConfigOptions(array $vars)
	{
		return false;
	}

	public function validateStepConfig(array $steps, array &$stepConfig, array &$errors)
	{
		return true;
	}

	public function getSteps()
	{
		return [
			'articles' => [
				'title' => \XF::phrase('EWRporta_articles'),
			],
			'features' => [
				'title' => \XF::phrase('EWRporta_features'),
			],
			'authors' => [
				'title' => \XF::phrase('EWRporta_authors'),
			],
			'categories' => [
				'title' => \XF::phrase('categories'),
			],
			'catlinks' => [
				'title' => \XF::phrase('EWRporta_category_links'),
				'depends' => ['articles', 'categories'],
			],
		];
	}

	protected function doInitializeSource()
	{
		$this->sourceDb = new \XF\Db\Mysqli\Adapter(
			$this->baseConfig['db'],
			$this->app->config('fullUnicode')
		);
	}

	// ############################## STEP: ARTICLES #########################

	public function getStepEndArticles()
	{
		return $this->sourceDb->fetchOne("SELECT MAX(thread_id) FROM EWRporta2_articles") ?: 0;
	}

	public function stepArticles(StepState $state, array $stepConfig, $maxTime, $limit = 1000)
	{
		$timer = new \XF\Timer($maxTime);
		
		$articles = $this->sourceDb->fetchAll('
			SELECT *
				FROM EWRporta2_articles
			WHERE thread_id > ? AND thread_id <= ?
			ORDER BY thread_id ASC
			LIMIT ?
		', [$state->startAfter, $state->end, $limit]);

		if (!$state->startAfter)
		{
			$this->app->db->emptyTable('ewr_porta_articles');
		}
		
		if (!$articles)
		{
			return $state->complete();
		}
		
		foreach ($articles AS $article)
		{
			$oldId = $article['thread_id'];
			$state->startAfter = $oldId;
			
			$import = $this->app->em->create('EWR\Porta:Article');
			$import->bulkSet([
				'thread_id' => $article['thread_id'],
				'article_date' => $article['article_date'],
				'article_break' => $article['article_break'],
				'article_title' => $article['article_title'],
				'article_excerpt' => $article['article_excerpt'],
				'article_format' => 1,
				'article_exclude' => 0,
				'article_sticky' => 0,
				'article_icon' => unserialize($article['article_icon']),
			], ['forceSet' => true]);
			$import->save();
			
			$state->imported++;

			if ($timer->limitExceeded())
			{
				break;
			}
		}

		return $state->resumeIfNeeded();
	}

	// ############################## STEP: FEATURES #########################

	public function getStepEndFeatures()
	{
		return $this->sourceDb->fetchOne("SELECT MAX(thread_id) FROM EWRporta2_features") ?: 0;
	}

	public function stepFeatures(StepState $state, array $stepConfig, $maxTime, $limit = 1000)
	{
		$timer = new \XF\Timer($maxTime);
		
		$features = $this->sourceDb->fetchAll('
			SELECT *
				FROM EWRporta2_features
			WHERE thread_id > ? AND thread_id <= ?
			ORDER BY thread_id ASC
			LIMIT ?
		', [$state->startAfter, $state->end, $limit]);

		if (!$state->startAfter)
		{
			$this->app->db->emptyTable('ewr_porta_features');
		}
		
		if (!$features)
		{
			return $state->complete();
		}
		
		foreach ($features AS $feature)
		{
			$oldId = $feature['thread_id'];
			$state->startAfter = $oldId;
			
			$import = $this->app->em->create('EWR\Porta:Feature');
			$import->bulkSet([
				'thread_id' => $feature['thread_id'],
				'feature_date' => $feature['feature_date'],
				'feature_time' => 0,
				'feature_title' => $feature['feature_title'],
				'feature_excerpt' => $feature['feature_excerpt'],
				'feature_media' => '',
			], ['forceSet' => true]);
			$import->save();
			
			$state->imported++;

			if ($timer->limitExceeded())
			{
				break;
			}
		}

		return $state->resumeIfNeeded();
	}

	// ############################## STEP: AUTHORS #########################

	public function stepAuthors(StepState $state)
	{
		$authors = $this->sourceDb->fetchAll('SELECT * FROM EWRporta2_authors ORDER BY user_id');
		
		$this->app->db->emptyTable('ewr_porta_authors');
		
		foreach ($authors AS $author)
		{
			$import = $this->app->em->create('EWR\Porta:Author');
			$import->bulkSet([
				'user_id' => $author['user_id'],
				'author_name' => $author['author_name'],
				'author_byline' => $author['author_byline'],
				'author_status' => $author['author_status'],
				'author_order' => $author['author_order'],
				'author_time' => 0,
			], ['forceSet' => true]);
			$import->save();
			
			$state->imported++;
		}

		return $state->complete();
	}

	// ############################## STEP: CATEGORIES #########################

	public function stepCategories(StepState $state)
	{
		$categories = $this->sourceDb->fetchAll('SELECT * FROM EWRporta2_categories ORDER BY category_id');
		
		$this->app->db->emptyTable('ewr_porta_categories');
		
		foreach ($categories AS $category)
		{
			$import = $this->app->em->create('EWR\Porta:Category');
			$import->bulkSet([
				'style_id' => $category['style_id'],
				'category_id' => $category['category_id'],
				'category_name' => $category['category_name'],
				'category_description' => $category['category_desc'],
			], ['forceSet' => true]);
			$import->save();
			
			$state->imported++;
		}

		return $state->complete();
	}

	// ############################## STEP: CATEGORY LINKS #########################

	public function getStepEndCatlinks()
	{
		return $this->sourceDb->fetchOne("SELECT COUNT(*) FROM EWRporta2_catlinks") ?: 0;
	}

	public function stepCatlinks(StepState $state)
	{
		$timer = new \XF\Timer($maxTime);
		
		$catlinks = $this->sourceDb->fetchAll('
			SELECT *
				FROM EWRporta2_catlinks
			ORDER BY category_id ASC, thread_id ASC
			LIMIT ?, ?
		', [$state->startAfter, $limit]);

		if (!$state->startAfter)
		{
			$this->app->db->emptyTable('ewr_porta_catlinks');
		}
		
		if (!$catlinks)
		{
			return $state->complete();
		}
		
		foreach ($catlinks AS $catlink)
		{
			$import = $this->app->em->create('EWR\Porta:CatLink');
			$import->bulkSet([
				'category_id' => $catlink['category_id'],
				'thread_id' => $catlink['thread_id'],
			], ['forceSet' => true]);
			$import->save();
			
			$state->imported++;
			$state->startAfter = $state->imported;

			if ($timer->limitExceeded())
			{
				break;
			}
		}

		return $state->resumeIfNeeded();
	}
}