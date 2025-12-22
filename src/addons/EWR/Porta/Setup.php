<?php

namespace EWR\Porta;

use XF\Db\Schema\Alter;
use XF\Db\Schema\Create;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;

class Setup extends AbstractSetup
{
	use StepRunnerInstallTrait;
	use StepRunnerUpgradeTrait;
	use StepRunnerUninstallTrait;
	
	public function installStep1()
	{
		$this->schemaManager()->createTable('ewr_porta_articles', function(Create $table)
		{
			$table->checkExists(true);
			$table->addColumn('thread_id', 				'int', 10);
			$table->addColumn('article_date',			'int', 10);
			$table->addColumn('article_break',			'text');
			$table->addColumn('article_title',			'varchar', 255);
			$table->addColumn('article_excerpt',		'text');
			$table->addColumn('article_format',			'int', 1);
			$table->addColumn('article_exclude',		'int', 1);
			$table->addColumn('article_sticky',			'int', 1);
			$table->addColumn('article_icon',			'blob');
			$table->addPrimaryKey('thread_id');
		});
		
		$this->schemaManager()->createTable('ewr_porta_authors', function(Create $table)
		{
			$table->checkExists(true);
			$table->addColumn('user_id', 				'int', 10);
			$table->addColumn('author_name',			'varchar', 255);
			$table->addColumn('author_byline',			'text');
			$table->addColumn('author_status',			'varchar', 255);
			$table->addColumn('author_order',			'int', 10);
			$table->addColumn('author_time',			'int', 10);
			$table->addPrimaryKey('user_id');
		});
		
		$this->schemaManager()->createTable('ewr_porta_categories', function(Create $table)
		{
			$table->checkExists(true);
			$table->addColumn('style_id', 				'int', 10);
			$table->addColumn('category_id', 			'int', 10)->autoIncrement();
			$table->addColumn('category_name',			'varchar', 255);
			$table->addColumn('category_description',	'text');
			$table->addPrimaryKey('category_id');
		});
		
		$this->schemaManager()->createTable('ewr_porta_catlinks', function(Create $table)
		{
			$table->checkExists(true);
			$table->addColumn('category_id',			'int', 10);
			$table->addColumn('thread_id',				'int', 10);
			$table->addPrimaryKey(['category_id', 'thread_id']);
		});
		
		$this->schemaManager()->createTable('ewr_porta_features', function(Create $table)
		{
			$table->checkExists(true);
			$table->addColumn('thread_id', 				'int', 10);
			$table->addColumn('feature_date',			'int', 10);
			$table->addColumn('feature_time',			'int', 10);
			$table->addColumn('feature_title',			'varchar', 255);
			$table->addColumn('feature_excerpt',		'text');
			$table->addColumn('feature_media',			'varchar', 255);
			$table->addPrimaryKey('thread_id');
		});
	}
	
	public function uninstallStep1()
	{
		$this->schemaManager()->dropTable('ewr_porta_articles');
		$this->schemaManager()->dropTable('ewr_porta_authors');
		$this->schemaManager()->dropTable('ewr_porta_categories');
		$this->schemaManager()->dropTable('ewr_porta_catlinks');
		$this->schemaManager()->dropTable('ewr_porta_features');
		
		\XF\Util\File::deleteAbstractedDirectory('data://authors');
		\XF\Util\File::deleteAbstractedDirectory('data://features');
	}
	
	public function upgrade2000Step1()
	{
		$this->installStep1();
	}
	
	public function upgrade2016Step1()
	{
		$articles = $this->db()->fetchAll("SELECT thread_id, article_icon FROM ewr_porta_articles");
		
		foreach ($articles AS $article)
		{
			$this->db()->update('ewr_porta_articles',
				[ 'article_icon' => json_encode(unserialize($article['article_icon'])) ],
				'thread_id = ?', $article['thread_id']
			);
		}
	}
}