<?php

namespace XenBulletins\BrandHub\Install\Data;

use XF\Db\Schema\Create;

class MySql {

    public function getTables() {
        $tables = [];

        $tables['bh_category'] = function (Create $table) {
            $table->addColumn('category_id', 'int')->autoIncrement();
            $table->addColumn('category_title', 'varchar', 100);
            $table->addPrimaryKey('category_id');
        };

        $tables['bh_brand'] = function (Create $table) {
            $table->addColumn('brand_id', 'int')->autoIncrement();
            $table->addColumn('brand_title', 'varchar', 100)->setDefault('');
            $table->addColumn('discussion_count', 'int')->setDefault(0);
            $table->addColumn('view_count', 'int')->setDefault(0);
            $table->addColumn('owner_count', 'int')->setDefault(0);
            $table->addColumn('rating_count', 'int')->setDefault(0);
            $table->addColumn('rating_sum', 'int')->setDefault(0);
            $table->addColumn('rating_avg', 'float', '')->setDefault(0);
            $table->addColumn('rating_weighted', 'float', '')->setDefault(0);
            $table->addColumn('review_count', 'int')->setDefault(0);
            $table->addColumn('node_ids', 'mediumblob');
            $table->addColumn('forums_link', 'varchar', 100)->setDefault('');
            $table->addColumn('website_link', 'varchar', 100)->setDefault('');
            $table->addColumn('for_sale_link', 'varchar', 100)->setDefault('');
            $table->addColumn('intro_link', 'varchar', 100)->setDefault('');
            $table->addColumn('create_date', 'int');
            $table->addPrimaryKey('brand_id');
        };

        $tables['bh_brand_view'] = function (Create $table) {
            $table->engine('MEMORY');

            $table->addColumn('brand_id', 'int');
            $table->addColumn('total', 'int');
            $table->addPrimaryKey('brand_id');
        };
        
        $tables['bh_item_view'] = function (Create $table) {
            $table->engine('MEMORY');

            $table->addColumn('item_id', 'int');
            $table->addColumn('total', 'int');
            $table->addPrimaryKey('item_id');
        };

        $tables['bh_brand_rating'] = function (Create $table) {
            $table->addColumn('brand_rating_id', 'int')->autoIncrement();
            $table->addColumn('user_id', 'int');
            $table->addColumn('rating', 'tinyint');
            $table->addColumn('rating_date', 'int');
            $table->addColumn('message', 'mediumtext');
            $table->addColumn('brand_id', 'int');
            $table->addColumn('is_review', 'tinyint')->setDefault(0);
            $table->addColumn('count_rating', 'tinyint')->setDefault(1)->comment('Whether this counts towards the global resource rating.');
            $table->addColumn('rating_state', 'enum')->values(['visible', 'deleted'])->setDefault('visible');
            $table->addUniqueKey('user_id');
            $table->addPrimaryKey('brand_rating_id');
        };

        $tables['bh_brand_description'] = function (Create $table) {
            $table->addColumn('desc_id', 'int')->autoIncrement()->primaryKey();
            $table->addColumn('brand_id', 'int');
            $table->addColumn('description', 'mediumtext');
            $table->addKey('brand_id');
        };

        //+++++++++++++++++++++++++++++++++++++++++++++++++++++

        $tables['bh_item_field'] = function (Create $table) {

            $table->addColumn('field_id', 'varbinary', 25);
            $table->addColumn('display_group', 'varchar', 25)->setDefault('below_recordbook');
            $table->addColumn('display_order', 'int')->setDefault(1);
            $table->addColumn('field_type', 'varbinary', 25)->setDefault('textbox');
            $table->addColumn('field_choices', 'blob');
            $table->addColumn('match_type', 'varbinary', 25)->setDefault('none');
            $table->addColumn('match_params', 'blob')->after('match_type');
            $table->addColumn('max_length', 'int')->setDefault(0);
            $table->addColumn('display_template', 'text');
            $table->addColumn('display_add_recordbook', 'tinyint')->setDefault(0);
            $table->addColumn('required', 'tinyint')->setDefault(0);
            $table->addPrimaryKey('field_id');
            $table->addKey(['display_group', 'display_order'], 'display_group_order');
        };

        $tables['bh_field_choice'] = function (Create $table) {

            $table->addColumn('choice_id', 'int')->autoIncrement()->primaryKey();
            $table->addColumn('field_id', 'varbinary', 25);
            $table->addColumn('item_id', 'varbinary', 25);
            $table->addColumn('field_choices', 'blob');
            $table->addColumn('showdefault', 'int')->setDefault(1);
        };

        $tables['bh_category_field'] = function (Create $table) {

            $table->addColumn('field_id', 'varbinary', 25);
            $table->addColumn('category_id', 'int', 10)->unsigned();
            $table->addPrimaryKey(['field_id', 'category_id']);
            $table->addKey('category_id');
        };

        $tables['bh_item_field_value'] = function (Create $table) {

            $table->addColumn('item_id', 'int');
            $table->addColumn('field_id', 'varbinary', 25);
            $table->addColumn('field_value', 'mediumtext');
            $table->addPrimaryKey(['item_id', 'field_id']);
            $table->addKey('field_id');
        };

        $tables['bh_item'] = function (Create $table) {

            $table->addColumn('item_id', 'int')->autoIncrement();
            $table->addColumn('brand_id', 'int');
            $table->addColumn('category_id', 'int');
            $table->addColumn('item_title', 'varchar', 100)->setDefault('');
            $table->addColumn('make', 'varchar', 100)->setDefault('');
            $table->addColumn('model', 'varchar', 100)->setDefault('');
            $table->addColumn('custom_fields', 'mediumblob');
            $table->addColumn('item_state', 'enum')->values(['visible', 'moderated', 'deleted'])->setDefault('visible');
            $table->addColumn('discussion_count', 'int')->setDefault(0);
            $table->addColumn('view_count', 'int')->setDefault(0);
            $table->addColumn('owner_count', 'int')->setDefault(0);
            $table->addColumn('rating_count', 'int')->setDefault(0);
            $table->addColumn('rating_sum', 'int')->setDefault(0);
            $table->addColumn('rating_avg', 'float', '')->setDefault(0);
            $table->addColumn('rating_weighted', 'float', '')->setDefault(0);
            $table->addColumn('review_count', 'int')->setDefault(0);
            $table->addColumn('reaction_score', 'int');
            $table->addColumn('reaction_users', 'mediumblob');
            $table->addColumn('reactions', 'mediumblob');
            $table->addColumn('user_id', 'int');
            $table->addColumn('create_date', 'int');
            $table->addColumn('brand_title', 'varchar', 100)->setDefault('');

            $table->addPrimaryKey('item_id');
            $table->addKey('brand_id');
        };
        
        $tables['bh_item_description'] = function (Create $table) {
            $table->addColumn('desc_id', 'int')->autoIncrement()->primaryKey();
            $table->addColumn('item_id', 'int');
            $table->addColumn('description', 'mediumtext');
            $table->addKey('item_id');
        };
        
        $tables['bh_item_rating'] = function (Create $table) {
            $table->addColumn('item_rating_id', 'int')->autoIncrement();
            $table->addColumn('user_id', 'int');
            $table->addColumn('item_id', 'int');
            $table->addColumn('rating', 'tinyint');
            $table->addColumn('rating_date', 'int');
            $table->addColumn('message', 'mediumtext');
            $table->addColumn('is_review', 'tinyint')->setDefault(0);
            $table->addColumn('count_rating', 'tinyint')->setDefault(1)->comment('Whether this counts towards the global resource rating.');
            $table->addColumn('rating_state', 'enum')->values(['visible', 'deleted'])->setDefault('visible');
            $this->addColumn('reaction_score', 'int')->setDefault(0);
            $this->addColumn('reactions', 'blob');
            $this->addColumn('reaction_users', 'blob');
//            $table->addUniqueKey('user_id');
            $table->addPrimaryKey('item_rating_id');
            $table->addKey('item_id');
            $table->addKey('user_id');
        };
        
        
        $tables['bh_owner_page'] = function (Create $table) {
  

            $table->addColumn('page_id', 'int')->autoIncrement();
            $table->addColumn('title', 'varchar', 255)->nullable(true);
            $table->addColumn('page_state', 'enum')->values(['visible', 'moderated', 'deleted'])->setDefault('visible');
            $table->addColumn('discussion_count', 'int')->setDefault(0);
            $table->addColumn('view_count', 'int')->setDefault(0);
            $table->addColumn('rating_count', 'int')->setDefault(0);
            $table->addColumn('rating_sum', 'int')->setDefault(0);
            $table->addColumn('rating_avg', 'float', '')->setDefault(0);
            $table->addColumn('rating_weighted', 'float', '')->setDefault(0);
            $table->addColumn('review_count', 'int')->setDefault(0);
            $table->addColumn('create_date', 'int');
            $table->addColumn('item_id', 'int')->setDefault(0);
            $table->addColumn('user_id', 'int')->setDefault(0);
            $table->addColumn('reaction_score', 'int');
            $table->addColumn('reaction_users', 'mediumblob');
            $table->addColumn('reactions', 'mediumblob');
         
            $table->addPrimaryKey('page_id');
            $table->addKey('item_id');
            $table->addKey('user_id');
        };
        
        
        $tables['bh_owner_page_detail'] = function (Create $table) {

            $table->addColumn('detail_id', 'int')->autoIncrement()->primaryKey();
            $table->addColumn('page_id', 'int');
            $table->addColumn('about', 'mediumtext');
            $table->addColumn('attachment', 'mediumtext');
            $table->addColumn('customizations', 'mediumtext');
            $table->addKey('page_id');
        };
        
        
        $tables['bh_item_subscribe'] = function (Create $table) {

            $table->addColumn('sub_id', 'int')->autoIncrement()->primaryKey();
            $table->addColumn('user_id', 'int');
            $table->addColumn('item_id', 'int');
            $table->addColumn('create_date', 'int');
            $table->addKey('item_id');
        };
        
        
        $tables['bh_page_subscribe'] = function (Create $table) {

            $table->addColumn('sub_id', 'int')->autoIncrement()->primaryKey();
            $table->addColumn('user_id', 'int');
            $table->addColumn('page_id', 'int');
            $table->addKey('page_id');
        };
        
        $tables['bh_page_count'] = function (Create $table) {

               $table->addColumn('count_id', 'int')->autoIncrement()->primaryKey();
               $table->addColumn('page_id', 'int');
               $table->addColumn('follow_count', 'int')->setDefault(0);
               $table->addColumn('attachment_count', 'int')->setDefault(0);;
               $table->addPrimaryKey('count_id');
                $table->addKey('page_id');
               }; 
               
               
        $this->getTables3010000($tables);
              
        return $tables;
    }
    
    
    
    
    public function getTables3010000(array &$tables=[])
    {
        $tables['bh_owner_page_post'] = function(Create $table)
        {
                $table->addColumn('post_id', 'int')->autoIncrement();
                $table->addColumn('owner_page_id', 'int');
                $table->addColumn('user_id', 'int');
                $table->addColumn('username', 'varchar', 50);
                $table->addColumn('post_date', 'int');
                $table->addColumn('message', 'mediumtext');
                $table->addColumn('ip_id', 'int')->setDefault(0);
                $table->addColumn('message_state', 'enum')->values(['visible','moderated','deleted'])->setDefault('visible');
                $table->addColumn('attach_count', 'smallint', 5)->setDefault(0);
                $table->addColumn('reaction_score', 'int')->unsigned(false)->setDefault(0);
                $table->addColumn('reactions', 'blob')->nullable();
                $table->addColumn('reaction_users', 'blob');
                $table->addColumn('comment_count', 'int')->setDefault(0);
                $table->addColumn('first_comment_date', 'int')->setDefault(0);
                $table->addColumn('last_comment_date', 'int')->setDefault(0);
                $table->addColumn('latest_comment_ids', 'blob');
                $table->addColumn('warning_id', 'int')->setDefault(0);
                $table->addColumn('warning_message', 'varchar', 255)->setDefault('');
                $table->addColumn('embed_metadata', 'blob')->nullable();
                $table->addKey(['owner_page_id', 'post_date']);
                $table->addKey('user_id');
                $table->addKey('post_date');
        };

        $tables['bh_owner_page_post_comment'] = function(Create $table)
        {
                $table->addColumn('post_comment_id', 'int')->autoIncrement();
                $table->addColumn('post_id', 'int');
                $table->addColumn('user_id', 'int');
                $table->addColumn('username', 'varchar', 50);
                $table->addColumn('comment_date', 'int');
                $table->addColumn('message', 'mediumtext');
                $table->addColumn('ip_id', 'int')->setDefault(0);
                $table->addColumn('message_state', 'enum')->values(['visible','moderated','deleted'])->setDefault('visible');
                $table->addColumn('attach_count', 'smallint', 5)->setDefault(0);
                $table->addColumn('reaction_score', 'int')->unsigned(false)->setDefault(0);
                $table->addColumn('reactions', 'blob')->nullable();
                $table->addColumn('reaction_users', 'blob');
                $table->addColumn('warning_id', 'int')->setDefault(0);
                $table->addColumn('warning_message', 'varchar', 255)->setDefault('');
                $table->addColumn('embed_metadata', 'blob')->nullable();
                $table->addKey(['post_id', 'comment_date']);
                $table->addKey('user_id');
                $table->addKey('comment_date');
        };
        
        return $tables;
    }

}
