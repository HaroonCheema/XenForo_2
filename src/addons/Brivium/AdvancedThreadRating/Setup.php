<?php

namespace Brivium\AdvancedThreadRating;

use MJCore\AbstractSetup;
use XF\Db\Schema\Create;
use XF\Db\Schema\Alter;

class Setup extends AbstractSetup
{

	protected function getTables()
	{
		$tables = [];

		$tables['xf_brivium_style_rating'] = function(Create $table) {
			$table->checkExists(true);
			$table->addColumn('style_rating_id', 'int')->autoIncrement();
			$table->addColumn('image_width', 'int');
			$table->addColumn('image_height', 'int');
			$table->addColumn('icon_width', 'int');
			$table->addColumn('icon_height', 'int');
			$table->addColumn('icon_second_position', 'int');
			$table->addColumn('style_date', 'int')->setDefault(0);
			$table->addColumn('status', 'tinyint')->setDefault(0);
			$table->addPrimaryKey('style_rating_id');
			$table->addKey('style_date', 'style_date');
			$table->addKey('status', 'status');
		};

		$tables['xf_brivium_thread_rating'] = function(Create $table) {
			$table->checkExists(true);
			$table->addColumn('thread_rating_id', 'int', 11)->unsigned(false)->autoIncrement();
			$table->addColumn('thread_id', 'int')->setDefault(0);
			$table->addColumn('user_id', 'int')->setDefault(0);
			$table->addColumn('username', 'varchar', 50)->setDefault('');
			$table->addColumn('email', 'varchar', 200);
			$table->addColumn('rating', 'tinyint')->setDefault(0);
			$table->addColumn('rating_date', 'int')->setDefault(0);
			$table->addColumn('rating_status', 'tinyint')->setDefault(0);
			$table->addColumn('message', 'mediumtext');
			$table->addColumn('warning_id', 'int')->setDefault(0);
			$table->addColumn('warning_message', 'varchar', 255);
			$table->addColumn('is_anonymous', 'tinyint')->setDefault(0);
			$table->addColumn('encode', 'varchar', 36);
			$table->addColumn('likes', 'int')->setDefault(0);
			$table->addColumn('like_users', 'blob');
			$table->addPrimaryKey('thread_rating_id');
			$table->addKey('thread_id', 'thread_id');
			$table->addKey('user_id', 'user_id');
			$table->addKey('username', 'username');
			$table->addKey('rating_date', 'rating_date');
		};

		return $tables;
	}

	protected function getAlters()
	{
		$alters = [];

		$alters['xf_post'] = function(Alter $table) {
			$table->addColumn('bratr_star', 'tinyint')->setDefault(0);
			$table->addColumn('thread_rating_id', 'tinyint')->setDefault(0);
		};

		$alters['xf_thread'] = function(Alter $table) {
			$table->addColumn('brivium_review_count', 'int')->setDefault(0);
			$table->addColumn('brivium_rating_count', 'int')->setDefault(0);
			$table->addColumn('brivium_rating_sum', 'int')->setDefault(0);
			$table->addColumn('brivium_rating_weighted', 'float')->setDefault('0');
		};

		$alters['xf_user'] = function(Alter $table) {
			$table->addColumn('bratr_receive_ratings', 'int')->setDefault(0);
			$table->addColumn('bratr_be_donated_ratings', 'int')->setDefault(0);
			$table->addColumn('bratr_ratings', 'int')->setDefault(0);
			$table->addColumn('bratr_receive_rating_count', 'int')->setDefault(0);
		};

		return $alters;
	}

	protected function getDropAlters()
	{
		$alters = [];

		$alters['xf_post'] = function(Alter $table) {
			$table->dropColumns(['bratr_star', 'thread_rating_id']);
		};

		$alters['xf_thread'] = function(Alter $table) {
			$table->dropColumns(['brivium_review_count', 'brivium_rating_count', 'brivium_rating_sum', 'brivium_rating_weighted']);
		};

		$alters['xf_user'] = function(Alter $table) {
			$table->dropColumns(['bratr_receive_ratings', 'bratr_receive_rating_count', 'bratr_be_donated_ratings', 'bratr_ratings']);
		};

		return $alters;
	}

	protected function upgrade2000090Step1()
	{
		$sm = $this->schemaManager();

		$sm->alterTable('xf_user', function(Alter $table){
			$table->addColumn('bratr_receive_rating_count', 'int')->setDefault(0);
		});
	}

	protected function upgrade2000090Step2()
	{
		$this->app->jobManager()->enqueueUnique('BRATR_rebuildThreadRating', 'Brivium\AdvancedThreadRating:ThreadRating', [], false);

		$filters = [
			['Thread.thread_id', '=', null]
		];
		$this->app->jobManager()->enqueueUnique('BRATR_removeThreadRating', 'Brivium\AdvancedThreadRating:ThreadRating', ['filters' => $filters], false);
	}

	protected function upgrade2000170Step1()
	{
		$sm = $this->schemaManager();

		$sm->alterTable('xf_brivium_thread_rating', function(Alter $table){
			$table->dropIndexes('thread_rating_user_id');
		});
	}

	protected function upgrade2000171Step1()
	{
		$sm = $this->schemaManager();

		$sm->alterTable('xf_brivium_thread_rating', function(Alter $table){
			$table->dropIndexes('email');
		});
	}
}