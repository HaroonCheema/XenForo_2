<?php

namespace nick97\TraktMovies;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;

use XF\Db\Schema\Alter;
use XF\Db\Schema\Create;
use XF\Util\File;

class Setup extends AbstractSetup
{
	use StepRunnerInstallTrait;
	use StepRunnerUpgradeTrait;
	use StepRunnerUninstallTrait;

	// ################################## INSTALL ###########################################

	public function installStep1()
	{
		$sm = $this->schemaManager();

		foreach ($this->getTables() as $tableName => $callback)
		{
			$sm->createTable($tableName, $callback);
		}
	}

	public function installStep2()
	{
		$sm = $this->schemaManager();
		foreach ($this->getAlters() as $table => $schema)
		{
			if ($sm->tableExists($table))
			{
				$sm->alterTable($table, $schema);
			}
		}
	}

	public function installStep3()
	{
		$db = $this->db();
		$db->insert('xf_forum_type', [
			'forum_type_id' => 'trakt_movies_movie',
			'handler_class' => 'nick97\TraktMovies:Movie',
			'addon_id' => 'nick97/TraktMovies'
		]);

		$db->insert('xf_thread_type', [
			'thread_type_id' => 'trakt_movies_movie',
			'handler_class' => 'nick97\TraktMovies:Movie',
			'addon_id' => 'nick97/TraktMovies'
		]);

		/** @var \XF\Repository\ForumType $forumTypeRepo */
		$forumTypeRepo = $this->app->repository('XF:ForumType');
		$forumTypeRepo->rebuildForumTypeCache();

		/** @var \XF\Repository\ThreadType $threadTypeRepo */
		$threadTypeRepo = $this->app->repository('XF:ThreadType');
		$threadTypeRepo->rebuildThreadTypeCache();
	}

	public function installStep4()
	{
		$src = 'src/addons/nick97/TraktMovies/defaultdata';
		$this->copyContents($src);
	}

	// ################################## UNINSTALL ###########################################

	public function uninstallStep1()
	{
		$sm = $this->schemaManager();

		foreach (array_keys($this->getTables()) as $tableName)
		{
			$sm->dropTable($tableName);
		}
	}

	public function uninstallStep2()
	{
		$sm = $this->schemaManager();
		foreach ($this->getReverseAlters() as $table => $schema)
		{
			if ($sm->tableExists($table))
			{
				$sm->alterTable($table, $schema);
			}
		}
	}

	public function uninstallStep3()
	{
		$db = $this->db();
		$db->delete('xf_forum_type', 'forum_type_id = ?', 'trakt_movies_movie');
		$db->delete('xf_thread_type','thread_type_id = ?', 'trakt_movies_movie');

		/** @var \XF\Repository\ForumType $forumTypeRepo */
		$forumTypeRepo = $this->app->repository('XF:ForumType');
		$forumTypeRepo->rebuildForumTypeCache();

		/** @var \XF\Repository\ThreadType $threadTypeRepo */
		$threadTypeRepo = $this->app->repository('XF:ThreadType');
		$threadTypeRepo->rebuildThreadTypeCache();
	}

	// ################################## DATA ###########################################

	protected function getTables(): array
	{
		$tables = [];

		$tables['nick97_trakt_movies_thread'] = function (Create $table) {
			$table->checkExists(true);

			$table->addColumn('thread_id', 'INT', 10);
			$table->addColumn('trakt_id', 'INT', 10)->setDefault(0);
			$table->addColumn('imdb_id', 'VARCHAR', 32)->setDefault(0);

			$table->addColumn('trakt_title', 'VARCHAR', 150)->setDefault('');
			$table->addColumn('trakt_plot', 'TEXT')->setDefault(NULL);
			$table->addColumn('trakt_image', 'VARCHAR', 150)->setDefault('');
			$table->addColumn('backdrop_path', 'varchar', 150)->setDefault('');

			$table->addColumn('trakt_genres', 'VARCHAR', 150)->setDefault('');
			$table->addColumn('trakt_director', 'VARCHAR', 150)->setDefault('');
			$table->addColumn('trakt_cast', 'TEXT')->setDefault(NULL);
			$table->addColumn('trakt_release', 'VARCHAR', 150)->setDefault('');
			$table->addColumn('trakt_tagline', 'TEXT')->setDefault(NULL);
			$table->addColumn('trakt_runtime', 'INT', 10)->setDefault(0);
			$table->addColumn('trakt_rating')->type('decimal', '3,2')->setDefault(0);
			$table->addColumn('trakt_votes', 'INT', 10)->setDefault(0);
			$table->addColumn('trakt_trailer', 'VARCHAR', 255)->setDefault('');
			$table->addColumn('trakt_status', 'VARCHAR', 150)->setDefault('');
			$table->addColumn('comment', 'TEXT')->setDefault(NULL);
			$table->addColumn('trakt_popularity')->type('decimal', '19,3')->setDefault(0);

			$table->addColumn('trakt_watch_providers', 'MEDIUMBLOB');
			$table->addColumn('trakt_production_company_ids', 'MEDIUMBLOB')->nullable()->setDefault(null);
			$table->addColumn('trakt_last_change_date', 'BIGINT')->setDefault(0)->unsigned(false);

			$table->addPrimaryKey('thread_id');
			$table->addKey('trakt_id');
		};

		$tables['nick97_trakt_movies_ratings'] = function (Create $table) {
			$table->checkExists(true);

			$table->addColumn('rating_id', 'INT', 10)->autoIncrement();
			$table->addColumn('thread_id', 'INT', 10)->setDefault(0);
			$table->addColumn('user_id', 'INT', 10)->setDefault(0);
			$table->addColumn('rating', 'TINYINT', 1)->setDefault(0);
			$table->addPrimaryKey('rating_id');
			$table->addUniqueKey(['thread_id', 'user_id']);

			$table->addKey('thread_id');
			$table->addKey('user_id');
		};

		$tables['nick97_trakt_movies_person'] = function (Create $table) {
			$table->checkExists(true);

			$table->addColumn('person_id', 'INT', 10)->primaryKey();

			$table->addColumn('profile_path', 'VARCHAR', 150)->setDefault('');
			$table->addColumn('imdb_person_id', 'VARCHAR', 32)->setDefault('');

			$table->addColumn('adult', 'TINYINT', 3)->setDefault(0);
			$table->addColumn('name', 'VARCHAR', 255)->setDefault('');
			$table->addColumn('also_known_as', 'TEXT');
			$table->addColumn('gender', 'TINYINT')->setDefault(0);
			$table->addColumn('biography', 'TEXT');

			$table->addColumn('birthday', 'INT', 10)->setDefault(0);
			$table->addColumn('deathday', 'INT', 10)->setDefault(0);

			$table->addColumn('homepage', 'VARCHAR', 255)->setDefault('');
			$table->addColumn('place_of_birth', 'VARCHAR', 255)->setDefault('');
			$table->addColumn('known_for_department', 'VARCHAR', 255)->setDefault('');

			$table->addColumn('small_image_date', 'INT', 10)->setDefault(0);
			$table->addColumn('large_image_date', 'INT', 10)->setDefault(0);

			$table->addColumn('popularity')->type('decimal', '19,3')->setDefault(0);

			$table->addKey('imdb_person_id');
		};

		$tables['nick97_trakt_movies_cast'] = function (Create $table) {
			$table->checkExists(true);

			$table->addColumn('trakt_id', 'INT', 10);
			$table->addColumn('person_id', 'INT', 10);

			$table->addColumn('cast_id', 'INT', 10)->setDefault(0);

			$table->addColumn('character', 'VARCHAR', 255)->setDefault('');
			$table->addColumn('known_for_department', 'VARCHAR', 255)->setDefault('');

			$table->addColumn('credit_id', 'VARCHAR', 24)->setDefault('');
			$table->addColumn('order', 'INT', 0)->setDefault(0);

			$table->addUniqueKey(['trakt_id', 'person_id']);
			$table->addKey('trakt_id');
			$table->addKey('person_id');
		};

		$tables['nick97_trakt_movies_crew'] = function (Create $table) {
			$table->checkExists(true);

			$table->addColumn('trakt_id', 'INT', 10);
			$table->addColumn('person_id', 'INT', 10);

			$table->addColumn('known_for_department', 'VARCHAR', 255)->setDefault('');
			$table->addColumn('department', 'VARCHAR', 255)->setDefault('');
			$table->addColumn('job', 'VARCHAR', 255)->setDefault('');

			$table->addColumn('credit_id', 'VARCHAR', 24)->setDefault('');
			$table->addColumn('order', 'INT', 0)->setDefault(0);

			$table->addUniqueKey(['trakt_id', 'person_id']);
			$table->addKey('trakt_id');
			$table->addKey('person_id');
		};

		$tables['nick97_trakt_movies_video'] = function (Create $table) {
			$table->checkExists(true);

			$table->addColumn('trakt_id', 'INT', 10);
			$table->addColumn('video_id', 'VARCHAR', 24);

			$table->addColumn('name', 'VARCHAR', 255)->setDefault('');
			$table->addColumn('key', 'VARCHAR', 100)->setDefault('');
			$table->addColumn('site', 'VARCHAR', 100)->setDefault('');
			$table->addColumn('size', 'INT')->setDefault(0);
			$table->addColumn('type', 'VARCHAR', 100)->setDefault('');
			$table->addColumn('official', 'TINYINT', 3)->setDefault(0);
			$table->addColumn('published_at', 'INT')->setDefault(0);

			$table->addColumn('iso_639_1', 'VARCHAR', 2)->setDefault('');
			$table->addColumn('iso_3166_1', 'VARCHAR', 2)->setDefault('');

			$table->addPrimaryKey(['trakt_id', 'video_id']);
			$table->addKey('trakt_id');
			$table->addKey('published_at');
		};

		$tables['nick97_trakt_movies_company'] = function (Create $table) {
			$table->checkExists(true);

			$table->addColumn('company_id', 'INT', 10)->primaryKey();

			$table->addColumn('name', 'VARCHAR', 255);
			$table->addColumn('description', 'TEXT')->nullable();
			$table->addColumn('headquarters', 'VARCHAR', 255)->setDefault('');
			$table->addColumn('homepage', 'VARCHAR', 255)->setDefault('');

			$table->addColumn('logo_path', 'VARCHAR', 255)->setDefault('');
			$table->addColumn('origin_country', 'VARCHAR', 2)->setDefault('');

			$table->addColumn('parent_company_id', 'INT', 10)->setDefault(0);

			$table->addColumn('small_image_date', 'INT', 10)->setDefault(0);
			$table->addColumn('large_image_date', 'INT', 10)->setDefault(0);

			$table->addKey('parent_company_id');
		};

		return $tables;
	}

	protected function getAlters()
	{
		$alters = [];

		$alters['xf_user'] = function (Alter $table) {
			$table->addColumn('trakt_movies_thread_count', 'int')->setDefault(0);
		};

		$alters['xf_user_option'] = function (Alter $table) {
			$table->addColumn('nick97_movies_trakt_watch_region', 'CHAR', 2)->setDefault('US');
		};

		return $alters;
	}

	/**
	 * @return array
	 */
	protected function getReverseAlters()
	{
		$alters = [];

		$alters['xf_user'] = function (Alter $table) {
			$table->dropColumns([
				'trakt_movies_thread_count'
			]);
		};

		$alters['xf_user_option'] = function (Alter $table) {
			$table->dropColumns([
				'nick97_movies_trakt_watch_region'
			]);
		};

		return $alters;
	}

	// ################################## UPGRADE ###########################################

	public function upgrade2000070Step1()
	{
		$sm = $this->schemaManager();

		$sm->createTable('nick97_trakt_movies_thread', function (Create $table) {
			$table->addColumn('thread_id', 'INT', 10);
			$table->addColumn('trakt_id', 'INT', 10)->setDefault(0);
			$table->addColumn('trakt_title', 'VARCHAR', 150)->setDefault('');
			$table->addColumn('trakt_plot', 'TEXT')->setDefault(NULL);
			$table->addColumn('trakt_image', 'VARCHAR', 150)->setDefault('');
			$table->addColumn('trakt_genres', 'VARCHAR', 150)->setDefault('');
			$table->addColumn('trakt_director', 'VARCHAR', 150)->setDefault('');
			$table->addColumn('trakt_cast', 'TEXT')->setDefault(NULL);
			$table->addColumn('trakt_release', 'VARCHAR', 150)->setDefault('');
			$table->addColumn('trakt_tagline', 'TEXT')->setDefault(NULL);
			$table->addColumn('trakt_runtime', 'INT', 10)->setDefault(0);
			$table->addColumn('trakt_rating')->type('decimal', '3,2')->setDefault(0);
			$table->addColumn('trakt_votes', 'INT', 10)->setDefault(0);
			$table->addColumn('trakt_trailer', 'VARCHAR', 255)->setDefault('');
			$table->addColumn('comment', 'TEXT')->setDefault(NULL);
			$table->addPrimaryKey('thread_id');
			$table->addKey('trakt_id');
		});
	}

	public function upgrade2000070Step2()
	{
		$db = $this->db();
		$sm = $this->schemaManager();

		$sm->createTable('nick97_trakt_movies_forum', function (Create $table) {
			$table->addColumn('node_id', 'INT', 10);
			$table->addColumn('trakt_genre', 'BLOB')->nullable();
			$table->addPrimaryKey('node_id');
		});

		// COPY OLD FORUM FIELD TO NEW TABLE
		$tmpData = $db->fetchAll("SELECT node_id, trakt_genre FROM xf_forum WHERE trakt_genre > ''");

		foreach ($tmpData as $data)
		{
			$genres = explode(',', $data['trakt_genre']);

			$db->insert('nick97_trakt_movies_forum', [
				'node_id' => $data['node_id'],
				'trakt_genre' => serialize($genres)
			]);
		}

		// DROP OLD COLUMN
		$sm->alterTable('xf_forum', function (Alter $table) {
			$table->dropColumns(['trakt_genre']);
		});
	}

	public function upgrade2000070Step3()
	{
		$sm = $this->schemaManager();

		$sm->createTable('nick97_trakt_movies_ratings', function (Create $table) {
			$table->addColumn('rating_id', 'INT', 10)->autoIncrement();
			$table->addColumn('thread_id', 'INT', 10)->setDefault(0);
			$table->addColumn('user_id', 'INT', 10)->setDefault(0);
			$table->addColumn('rating', 'TINYINT', 1)->setDefault(0);
			$table->addPrimaryKey('rating_id');
			$table->addKey('thread_id');
			$table->addKey('user_id');
		});
	}

	public function upgrade2000070Step4()
	{
		$src = 'src/addons/nick97/TraktMovies/defaultdata';
		$this->copyContents($src);
	}

	public function upgrade2000170Step1()
	{
		$sm = $this->schemaManager();

		$sm->alterTable('nick97_trakt_movies_thread', function (Alter $table) {
			$table->changeColumn('trakt_tagline', 'TEXT')->setDefault(NULL);
		});
	}

	// 2.2.0

	public function upgrade2020000Step1()
	{
		$db = $this->db();
		$db->insert('xf_forum_type', [
			'forum_type_id' => 'trakt_movies_movie',
			'handler_class' => 'nick97\TraktMovies:Movie',
			'addon_id' => 'nick97/TraktMovies'
		]);

		$db->insert('xf_thread_type', [
			'thread_type_id' => 'trakt_movies_movie',
			'handler_class' => 'nick97\TraktMovies:Movie',
			'addon_id' => 'nick97/TraktMovies'
		]);

		/** @var \XF\Repository\ForumType $forumTypeRepo */
		$forumTypeRepo = $this->app->repository('XF:ForumType');
		$forumTypeRepo->rebuildForumTypeCache();

		/** @var \XF\Repository\ThreadType $threadTypeRepo */
		$threadTypeRepo = $this->app->repository('XF:ThreadType');
		$threadTypeRepo->rebuildThreadTypeCache();
	}

	public function upgrade2020000Step2()
	{
		/** @var \XF\Entity\Forum[] $forums */
		$forums = $this->app->finder('XF:Forum')->where([
			'node_id' => $this->app->options()->traktthreads_forum
		]);
		if (!$forums)
		{
			return;
		}

		$movieForums = $this->db()->fetchAllKeyed("SELECT * FROM nick97_trakt_movies_forum", 'node_id');

		foreach ($forums as $forumId => $forum)
		{
			$forum->forum_type_id = 'trakt_movies_movie';
			$typeConfig = $forum->type_config_;

			if (!empty($typeConfig['allowed_thread_types']))
			{
				$typeConfig['allowed_thread_types'][] = 'trakt_movies_movie';
			}
			if (isset($movieForums[$forumId]))
			{
				$typeConfig['available_genres'] = @unserialize($movieForums[$forumId]['trakt_genre']);
			}

			$forum->set('type_config', $typeConfig);

			$forum->saveIfChanged();
		}
	}

	public function upgrade2020000Step3()
	{
		/** @var \XF\Entity\Thread[] $threads */
		$threads = $this->app->finder('XF:Thread')->where([
			'node_id' => $this->app->options()->traktthreads_forum,
			'discussion_type' => 'discussion'
		]);
		if (!$threads)
		{
			return;
		}

		foreach ($threads as $thread)
		{
			$thread->discussion_type = 'trakt_movies_movie';
			$thread->saveIfChanged();
		}
	}

	public function upgrade2020000Step4()
	{
		$this->schemaManager()->dropTable('nick97_trakt_movies_forum');
	}

	public function upgrade2020000Step5()
	{
		$db = $this->db();
		$db->query('CREATE TABLE nick97_trakt_movies_ratings__tmp SELECT * FROM nick97_trakt_movies_ratings;');
		$db->query('TRUNCATE TABLE nick97_trakt_movies_ratings;');
		$db->query('ALTER TABLE nick97_trakt_movies_ratings ADD UNIQUE INDEX thread_id_user_id (thread_id, user_id);');
		$db->query('INSERT IGNORE INTO nick97_trakt_movies_ratings SELECT * FROM nick97_trakt_movies_ratings__tmp;');
		$db->query('DROP TABLE nick97_trakt_movies_ratings__tmp;');
	}

	public function upgrade2020012Step1()
	{
		$sm = $this->schemaManager();
		$sm->alterTable('xf_user', function (Alter $table) {
			$table->addColumn('trakt_movies_thread_count', 'int')->setDefault(0);
		});
	}

	public function upgrade2020013Step1()
	{
		$sm = $this->schemaManager();

		$sm->createTable('nick97_trakt_movies_person', function (Create $table) {
			$table->addColumn('person_id', 'INT', 10)->primaryKey();

			$table->addColumn('profile_path', 'VARCHAR', 150)->setDefault('');
			$table->addColumn('imdb_person_id', 'VARCHAR', 32)->setDefault('');

			$table->addColumn('adult', 'TINYINT', 3)->setDefault(0);
			$table->addColumn('name', 'VARCHAR', 150)->setDefault('');
			$table->addColumn('also_known_as', 'TEXT');
			$table->addColumn('gender', 'TINYINT')->setDefault(0);
			$table->addColumn('biography', 'TEXT');

			$table->addColumn('birthday', 'INT', 10)->setDefault(0);
			$table->addColumn('deathday', 'INT', 10)->setDefault(0);

			$table->addColumn('homepage', 'VARCHAR', 150)->setDefault('');
			$table->addColumn('place_of_birth', 'VARCHAR', 150)->setDefault('');
			$table->addColumn('known_for_department', 'VARCHAR', 150)->setDefault('');

			$table->addColumn('popularity')->type('decimal', '19,3')->setDefault(0);
			$table->addKey('imdb_person_id');
		});

		$sm->createTable('nick97_trakt_movies_cast', function (Create $table) {
			$table->addColumn('trakt_id', 'INT', 10);
			$table->addColumn('person_id', 'INT', 10);

			$table->addColumn('cast_id', 'INT', 10)->setDefault(0);

			$table->addColumn('character', 'VARCHAR', 150)->setDefault('');
			$table->addColumn('known_for_department', 'VARCHAR', 150)->setDefault('');

			$table->addColumn('credit_id', 'VARCHAR', 24)->setDefault('');
			$table->addColumn('order', 'INT', 0);

			$table->addUniqueKey(['trakt_id', 'person_id']);
			$table->addKey('trakt_id');
			$table->addKey('person_id');
		});

		$sm->createTable('nick97_trakt_movies_crew', function (Create $table) {
			$table->addColumn('trakt_id', 'INT', 10);
			$table->addColumn('person_id', 'INT', 10);

			$table->addColumn('known_for_department', 'VARCHAR', 150)->setDefault('');
			$table->addColumn('department', 'VARCHAR', 150)->setDefault('');
			$table->addColumn('job', 'VARCHAR', 150)->setDefault('');

			$table->addColumn('credit_id', 'VARCHAR', 24)->setDefault('');
			$table->addColumn('order', 'INT', 0);

			$table->addUniqueKey(['trakt_id', 'person_id']);
			$table->addKey('trakt_id');
			$table->addKey('person_id');
		});
	}

	public function upgrade2020014Step1()
	{
		$sm = $this->schemaManager();

		$sm->alterTable('nick97_trakt_movies_thread', function (Alter $table) {
			$table->addColumn('trakt_popularity')->type('decimal', '19,3')->setDefault(0);
			$table->addColumn('imdb_id', 'VARCHAR', 32)->setDefault(0)->after('trakt_id');
		});
	}

	public function upgrade2020017Step1()
	{
		$sm = $this->schemaManager();

		$sm->alterTable('nick97_trakt_movies_person', function (Alter $table) {
			$table->addColumn('small_image_date', 'INT', 10)->setDefault(0)->after('known_for_department');
			$table->addColumn('large_image_date', 'INT', 10)->setDefault(0)->after('known_for_department');
		});
	}

	public function upgrade2020018Step1()
	{
		$db = $this->db();
		$db->update(
			'nick97_trakt_movies_person',
			['small_image_date' => 0, 'large_image_date' => 0],
			"profile_path = ''"
		);
	}

	public function upgrade2020018Step2()
	{
		$sm = $this->schemaManager();

		$sm->alterTable('nick97_trakt_movies_person', function (Alter $table) {
			$table->changeColumn('homepage', 'VARCHAR', 255)->setDefault('');
		});
	}

	public function upgrade2020020Step1()
	{
		$sm = $this->schemaManager();

		$sm->alterTable('nick97_trakt_movies_thread', function (Alter $table) {
			$table->addColumn('trakt_status', 'VARCHAR', 150)->setDefault('')->after('trakt_trailer');
		});

		$sm->alterTable('nick97_trakt_movies_cast', function (Alter $table) {
			$table->changeColumn('order', 'INT', 0)->setDefault(0);
		});

		$sm->alterTable('nick97_trakt_movies_crew', function (Alter $table) {
			$table->changeColumn('order', 'INT', 0)->setDefault(0);
		});
	}

	public function upgrade2020021Step1()
	{
		$sm = $this->schemaManager();

		$sm->createTable('nick97_trakt_movies_video', function (Create $table) {
			$table->checkExists(true);

			$table->addColumn('trakt_id', 'INT', 10);
			$table->addColumn('video_id', 'VARCHAR', 24);

			$table->addColumn('name', 'VARCHAR', 255)->setDefault('');
			$table->addColumn('key', 'VARCHAR', 100)->setDefault('');
			$table->addColumn('site', 'VARCHAR', 100)->setDefault('');
			$table->addColumn('size', 'INT')->setDefault(0);
			$table->addColumn('type', 'VARCHAR', 100)->setDefault('');
			$table->addColumn('official', 'TINYINT', 3)->setDefault(0);
			$table->addColumn('published_at', 'INT')->setDefault(0);

			$table->addColumn('iso_639_1', 'VARCHAR', 2)->setDefault('');
			$table->addColumn('iso_3166_1', 'VARCHAR', 2)->setDefault('');

			$table->addPrimaryKey(['trakt_id', 'video_id']);
			$table->addKey('trakt_id');
			$table->addKey('published_at');
		});
	}

	public function upgrade2020022Step1()
	{
		$sm = $this->schemaManager();

		$sm->alterTable('nick97_trakt_movies_video', function (Alter $table) {
			$table->changeColumn('iso_639_1', 'VARCHAR', 2)->setDefault('');
			$table->changeColumn('iso_3166_1', 'VARCHAR', 2)->setDefault('');
		});
	}

	public function upgrade2020031Step1()
	{
		$sm = $this->schemaManager();

		$sm->alterTable('nick97_trakt_movies_thread', function (Alter $table) {
			$table->addColumn('trakt_watch_providers', 'MEDIUMBLOB');
		});

		$sm->alterTable('xf_user_option', function (Alter $table) {
			$table->addColumn('nick97_movies_trakt_watch_region', 'CHAR', 2)->setDefault('US');
		});
	}

	public function upgrade2020037Step1()
	{
		$sm = $this->schemaManager();

		$sm->alterTable('nick97_trakt_movies_cast', function (Alter $table) {
			$table->changeColumn('character', 'VARCHAR', 255)->setDefault('');
			$table->changeColumn('known_for_department', 'VARCHAR', 255)->setDefault('');
		});

		$sm->alterTable('nick97_trakt_movies_crew', function (Alter $table) {
			$table->changeColumn('known_for_department', 'VARCHAR', 255)->setDefault('');
			$table->changeColumn('department', 'VARCHAR', 255)->setDefault('');
			$table->changeColumn('job', 'VARCHAR', 255)->setDefault('');
		});

		$sm->alterTable('nick97_trakt_movies_person', function (Alter $table) {
			$table->changeColumn('name', 'VARCHAR', 255)->setDefault('');
			$table->changeColumn('place_of_birth', 'VARCHAR', 255)->setDefault('');
			$table->changeColumn('known_for_department', 'VARCHAR', 255)->setDefault('');
		});
	}

	public function upgrade2020043Step1()
	{
		$sm = $this->schemaManager();

		$sm->createTable('nick97_trakt_movies_company', function (Create $table) {
			$table->addColumn('company_id', 'INT', 10)->primaryKey();

			$table->addColumn('name', 'VARCHAR', 255);
			$table->addColumn('description', 'TEXT')->nullable();
			$table->addColumn('headquarters', 'VARCHAR', 255)->setDefault('');
			$table->addColumn('homepage', 'VARCHAR', 255)->setDefault('');

			$table->addColumn('logo_path', 'VARCHAR', 255)->setDefault('');
			$table->addColumn('origin_country', 'VARCHAR', 2)->setDefault('');

			$table->addColumn('parent_company_id', 'INT', 10)->setDefault(0);

			$table->addColumn('small_image_date', 'INT', 10)->setDefault(0);
			$table->addColumn('large_image_date', 'INT', 10)->setDefault(0);

			$table->addKey('parent_company_id');
		});

		$sm->alterTable('nick97_trakt_movies_thread', function (Alter $table) {
			$table->addColumn('trakt_production_company_ids', 'MEDIUMBLOB')->nullable()->setDefault(null)->after('trakt_watch_providers');
		});
	}

	public function upgrade2020046Step1()
	{
		$this->schemaManager()->alterTable('nick97_trakt_movies_thread', function (Alter $table) {
			$table->addColumn('trakt_last_change_date', 'BIGINT')->setDefault(0)->unsigned(false)->after('trakt_production_company_ids');
		});
	}
	
	public function upgrade2020049Step1()
	{
		$this->schemaManager()->alterTable('nick97_trakt_movies_thread', function (Alter $table) {
			$table->addColumn('trakt_last_change_date', 'BIGINT')->setDefault(0)->unsigned(false)->after('trakt_production_company_ids');
		});
	}

	public function upgrade2020050Step1()
	{
		$this->schemaManager()->alterTable('nick97_trakt_movies_thread', function (Alter $table) {
			$table->addColumn('backdrop_path', 'varchar', 150)->setDefault('')->after('trakt_image');
		});
	}

	public function postUpgrade($previousVersion, array &$stateChanges)
	{
		if ($previousVersion)
		{
			if ($previousVersion < 2020012)
			{
				$this->app->jobManager()->enqueueUnique(
					'trakt_movies_counter',
					'nick97\TraktMovies:UserMovieThreadCountRebuild',
					[],
					false
				);
			}
			if ($previousVersion < 2020014)
			{
				$this->app->jobManager()->enqueueUnique(
					'trakt_movies_imdb',
					'nick97\TraktMovies:Upgrade\MovieImdb2020014',
					[],
					false
				);
			}
		}
	}

	// ################################## HELPERS ###########################################

	public function copyContents($src, $sub = false)
	{
		if ($sub) $basePath = str_ireplace('src/addons/nick97/TraktMovies/defaultdata/', '', $src);
		$dir = opendir($src);

		while (false !== ($file = readdir($dir)))
		{
			if (($file != '.') && ($file != '..'))
			{
				if (is_dir($src . '/' . $file))
				{
					$newSrc = $src . '/' . $file;
					$this->copyContents($newSrc, true);
				}
				else
				{
					$oldPath = $src . '/' . $file;

					if ($sub)
					{
						$newFile = $basePath . '/' . $file;
					}
					else
					{
						$newFile = $file;
					}

					$newPath = sprintf('data://movies/%s', $newFile);
					File::copyFileToAbstractedPath($oldPath, $newPath);
				}
			}
		}

		closedir($dir);
	}

	public function checkRequirements(&$errors = [], &$warnings = [])
	{
		if (\XF::$versionId < 2010031)
		{
			$errors[] = 'This add-on may only be used on XenForo 2.1 or higher';
			return $errors;
		}

		$versionId = $this->addOn->version_id;

		if ($versionId && $versionId < '28')
		{
			$errors[] = 'Upgrades can only be to the XF 1.x Trakt Movie Thread Starter version 2.1.13 or later';
			return $errors;
		}

		return $errors;
	}
}