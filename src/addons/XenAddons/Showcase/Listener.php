<?php

namespace XenAddons\Showcase;

use function count, in_array, is_array;

class Listener
{
    public static function runCategoryCreation()
    {
        $db = \XF::db();
        $em = \XF::em();

        $db->query("DELETE FROM xf_xa_sc_category");
        
        $nodeRepo = $em->getRepository('XF:Node');
        $nodes = $db->fetchAll("
            SELECT n.node_id, n.parent_node_id, n.title, p.title parent_title, n.display_order, n.lft, n.rgt, n.depth, n.node_type_id
            FROM xf_node n
            LEFT JOIN xf_node p on n.parent_node_id = p.node_id and p.node_type_id = 'Category'
            WHERE n.node_type_id IN ('Category')
            AND n.node_id NOT IN (60,97)
            ORDER BY n.lft
        ");

        foreach ($nodes as $node) 
        {
            $allowPosting = 0;
            $threadNodeId = 0;

            $nodeEntity = $em->find('XF:Node', $node['node_id']);
            if ($nodeEntity) 
            {
                // Find all descendants of this category
                //$descendants = $nodeRepo->findDescendants($nodeEntity, false)->fetch();
                $descendants = $nodeRepo->findChildren($nodeEntity, false)->fetch();
                
                foreach ($descendants as $descendant) 
                {

                    if ($descendant->node_type_id == 'Forum' && stripos($descendant->title, 'Reviews') === 0) 
                    {
                        $allowPosting = 1;
                    }

                    // Check if this descendant is a forum and title starts with "Discussion"
                    if ($descendant->node_type_id == 'Forum' && stripos($descendant->title, 'Discussion') === 0) 
                    {
                        $threadNodeId = $descendant->node_id;
                        //break;
                    }
                }
            }
            
            $db->query("
                REPLACE INTO `xf_xa_sc_category`
                (
                    `category_id`,
                    `title`,
                    `og_title`,
                    `meta_title`, 
                    `description`, 
                    `meta_description`,      
                    `content_image_url`,     
                    `content_message`,       
                    `content_title`,         
                    `content_term`,                  
                    `display_order`,                 
                    `parent_category_id`,            
                    `lft`,                           
                    `rgt`,                           
                    `depth`,                         
                    `item_count`,                    
                    `featured_count`,                
                    `last_item_date`,                
                    `last_item_title`,               
                    `last_item_id`,                  
                    `thread_node_id`,                
                    `thread_prefix_id`,              
                    `thread_set_item_tags`,          
                    `autopost_review`,               
                    `autopost_update`,               
                    `title_s1`,                      
                    `title_s2`,                      
                    `title_s3`,                      
                    `title_s4`,                      
                    `title_s5`,                      
                    `title_s6`,                      
                    `description_s1`,                
                    `description_s2`,                
                    `description_s3`,                
                    `description_s4`,                
                    `description_s5`,                
                    `description_s6`,                
                    `editor_s1`,                     
                    `editor_s2`,                     
                    `editor_s3`,                     
                    `editor_s4`,                     
                    `editor_s5`,                     
                    `editor_s6`,                     
                    `min_message_length_s1`,         
                    `min_message_length_s2`,         
                    `min_message_length_s3`,         
                    `min_message_length_s4`,         
                    `min_message_length_s5`,         
                    `min_message_length_s6`,         
                    `allow_comments`,                
                    `allow_ratings`,                 
                    `review_voting`,                 
                    `require_review`,                
                    `allow_items`,                   
                    `allow_contributors`,            
                    `allow_self_join_contributors`,  
                    `max_allowed_contributors`,      
                    `style_id`,                      
                    `breadcrumb_data`,               
                    `prefix_cache`,                  
                    `default_prefix_id`,             
                    `require_prefix`,                
                    `field_cache`,                   
                    `review_field_cache`,            
                    `update_field_cache`,            
                    `allow_anon_reviews`,            
                    `allow_author_rating`,           
                    `allow_pros_cons`,               
                    `min_tags`,                      
                    `default_tags`,                  
                    `allow_poll`,                    
                    `allow_location`,                
                    `allow_business_hours`,          
                    `require_item_image`,            
                    `layout_type`,                   
                    `item_list_order`,               
                    `map_options`,                   
                    `display_items_on_index`,        
                    `expand_category_nav`,           
                    `display_location_on_list`,      
                    `location_on_list_display_type`, 
                    `allow_index`,                   
                    `index_criteria`                 
                )
                VALUES
                (
                    ?,  -- 1  category_id (node_id)
                    ?,  -- 2  title (title)
                    ?,  -- 3  og_title
                    ?,  -- 4  meta_title
                    ?,  -- 5  description
                    ?,  -- 6  meta_description
                    '', -- 7  content_image_url
                    '', -- 8  content_message
                    '', -- 9  content_title
                    '', -- 10 content_term
                    ?,  -- 11 display_order (display_order)
                    ?,  -- 12 parent_category_id (parent_node_id)
                    ?,  -- 13 lft (lft)
                    ?,  -- 14 rgt (rgt)
                    ?,  -- 15 depth (depth)
                    0,  -- 16 item_count
                    0,  -- 17 featured_count
                    0,  -- 18 last_item_date
                    '', -- 19 last_item_title
                    0,  -- 20 last_item_id
                    ?,  -- 21 thread_node_id (0 or forum ID)
                    0,  -- 22 thread_prefix_id
                    0,  -- 23 thread_set_item_tags
                    0,  -- 24 autopost_review
                    0,  -- 25 autopost_update
                    'Attachments', -- 26 title_s1
                    '', -- 27 title_s2
                    '', -- 28 title_s3
                    '', -- 29 title_s4
                    '', -- 30 title_s5
                    '', -- 31 title_s6
                    '', -- 32 description_s1
                    '', -- 33 description_s2
                    '', -- 34 description_s3
                    '', -- 35 description_s4
                    '', -- 36 description_s5
                    '', -- 37 description_s6
                    0,  -- 38 editor_s1
                    0,  -- 39 editor_s2
                    0,  -- 40 editor_s3
                    0,  -- 41 editor_s4
                    0,  -- 42 editor_s5
                    0,  -- 43 editor_s6
                    0,  -- 44 min_message_length_s1
                    0,  -- 46 min_message_length_s3
                    0,  -- 45 min_message_length_s2
                    0,  -- 47 min_message_length_s4
                    0,  -- 48 min_message_length_s5
                    0,  -- 49 min_message_length_s6
                    1,  -- 50 allow_comments
                    1,  -- 51 allow_ratings
                    '', -- 52 review_voting
                    0,  -- 53 require_review
                    ?,  -- 54 allow_items
                    0,  -- 55 allow_contributors
                    0,  -- 56 allow_self_join_contributors
                    0,  -- 57 max_allowed_contributors
                    0,  -- 58 style_id
                    '[]', -- 59 breadcrumb_data
                    '', -- 60 prefix_cache
                    0,  -- 61 default_prefix_id
                    0,  -- 62 require_prefix
                    '', -- 63 field_cache
                    '', -- 64 review_field_cache
                    '', -- 65 update_field_cache
                    0,  -- 66 allow_anon_reviews
                    0,  -- 67 allow_author_rating
                    1,  -- 68 allow_pros_cons
                    0,  -- 69 min_tags
                    '', -- 70 default_tags
                    0,  -- 71 allow_poll
                    0,  -- 72 allow_location
                    0,  -- 73 allow_business_hours
                    ?,  -- 74 require_item_image
                    '', -- 75 layout_type
                    '', -- 76 item_list_order
                    '', -- 77 map_options
                    1,  -- 78 display_items_on_index
                    0,  -- 79 expand_category_nav
                    0,  -- 80 display_location_on_list
                    '', -- 81 location_on_list_display_type
                    'allow', -- 82 allow_index
                    '[]'  -- 83 index_criteria
                )
            ", [
                $node['node_id'],           // category_id
                $node['title'],             // title
                "Asian Massage Parlor Reviews & Alerts in {$node['title']} | AMC Reviews",  //og_title
                "Asian Massage Parlor Reviews & Alerts in {$node['title']} | AMC Reviews",  // meta title
           
                //description
                $node['parent_node_id']? 
                "Browse reviews, alerts, and discussions from Asian massage parlors across {$node['parent_title']}, {$node['title']}. Stay informed with real user experiences, recommendations, and cautionary posts" : 
                "Browse reviews, alerts, and discussions from Asian massage parlors across {$node['title']}. Stay informed with real user experiences, recommendations, and cautionary posts", 

                //meta description
                $node['parent_node_id']? 
                "Browse reviews, alerts, and discussions from Asian massage parlors across {$node['parent_title']}, {$node['title']}. Stay informed with real user experiences, recommendations, and cautionary posts" : 
                "Browse reviews, alerts, and discussions from Asian massage parlors across {$node['title']}. Stay informed with real user experiences, recommendations, and cautionary posts", 

                $node['display_order'],     // display_order
                $node['parent_node_id'] ?: 0, // parent_category_id
                $node['lft'],               // lft
                $node['rgt'],               // rgt
                $node['depth'],             // depth
                $threadNodeId,              // thread_node_id (0 or forum ID)
                $allowPosting,              // 54 allow_items
                $allowPosting               // 74 require_item_image
            ]);
        }

        $app = \XF::app();
        
        // Rebuild permissions
        $app->jobManager()->enqueueUnique(
            'permissionRebuild',
            'XF:PermissionRebuild',
            [],
            false
        );

        // Rebuild nested set
        $service = \XF::service('XF:RebuildNestedSet', 'XenAddons\Showcase:Category', [
            'parentField' => 'parent_category_id'
        ]);
        $service->rebuildNestedSetInfo();

        // Rebuild caches
        $app->repository('XenAddons\Showcase:ItemPrefix')->rebuildPrefixCache();
        $app->repository('XenAddons\Showcase:ItemField')->rebuildFieldCache();
        $app->repository('XenAddons\Showcase:ReviewField')->rebuildFieldCache();
        $app->repository('XenAddons\Showcase:UpdateField')->rebuildFieldCache();
    }

	public static function runCategoryCreation_old()
	{
	    $db = \XF::db();

	    $nodes = $db->fetchAll("
	        SELECT node_id, parent_node_id, title, display_order, lft, rgt, depth, node_type_id
	        FROM xf_node
	        WHERE node_type_id IN ('Category')
	        ORDER BY lft
	    ");

	    foreach ($nodes as $node) {
			$db->query("
			    REPLACE INTO `xf_xa_sc_category`
			    (
			        `category_id`,
			        `title`,
			        `og_title`,
			        `meta_title`, 
			        `description`, 
			        `meta_description`,      
			        `content_image_url`,     
			        `content_message`,       
			        `content_title`,         
			        `content_term`,                  
			        `display_order`,                 
			        `parent_category_id`,            
			        `lft`,                           
			        `rgt`,                           
			        `depth`,                         
			        `item_count`,                    
			        `featured_count`,                
			        `last_item_date`,                
			        `last_item_title`,               
			        `last_item_id`,                  
			        `thread_node_id`,                
			        `thread_prefix_id`,              
			        `thread_set_item_tags`,          
			        `autopost_review`,               
			        `autopost_update`,               
			        `title_s1`,                      
			        `title_s2`,                      
			        `title_s3`,                      
			        `title_s4`,                      
			        `title_s5`,                      
			        `title_s6`,                      
			        `description_s1`,                
			        `description_s2`,                
			        `description_s3`,                
			        `description_s4`,                
			        `description_s5`,                
			        `description_s6`,                
			        `editor_s1`,                     
			        `editor_s2`,                     
			        `editor_s3`,                     
			        `editor_s4`,                     
			        `editor_s5`,                     
			        `editor_s6`,                     
			        `min_message_length_s1`,         
			        `min_message_length_s2`,         
			        `min_message_length_s3`,         
			        `min_message_length_s4`,         
			        `min_message_length_s5`,         
			        `min_message_length_s6`,         
			        `allow_comments`,                
			        `allow_ratings`,                 
			        `review_voting`,                 
			        `require_review`,                
			        `allow_items`,                   
			        `allow_contributors`,            
			        `allow_self_join_contributors`,  
			        `max_allowed_contributors`,      
			        `style_id`,                      
			        `breadcrumb_data`,               
			        `prefix_cache`,                  
			        `default_prefix_id`,             
			        `require_prefix`,                
			        `field_cache`,                   
			        `review_field_cache`,            
			        `update_field_cache`,            
			        `allow_anon_reviews`,            
			        `allow_author_rating`,           
			        `allow_pros_cons`,               
			        `min_tags`,                      
			        `default_tags`,                  
			        `allow_poll`,                    
			        `allow_location`,                
			        `allow_business_hours`,          
			        `require_item_image`,            
			        `layout_type`,                   
			        `item_list_order`,               
			        `map_options`,                   
			        `display_items_on_index`,        
			        `expand_category_nav`,           
			        `display_location_on_list`,      
			        `location_on_list_display_type`, 
			        `allow_index`,                   
			        `index_criteria`                 
			    )
			    VALUES
			    (
			        ?,  -- category_id (node_id)
			        ?,  -- title (title)
			        '', -- og_title
			        ?,  -- meta_title
			        '', -- description
			        '', -- meta_description
			        '', -- content_image_url
			        '', -- content_message
			        '', -- content_title
			        '', -- content_term
			        ?,  -- display_order (display_order)
			        ?,  -- parent_category_id (parent_node_id)
			        ?,  -- lft (lft)
			        ?,  -- rgt (rgt)
			        ?,  -- depth (depth)
			        0,  -- item_count
			        0,  -- featured_count
			        0,  -- last_item_date
			        '', -- last_item_title
			        0,  -- last_item_id
			        0,  -- thread_node_id
			        0,  -- thread_prefix_id
			        0,  -- thread_set_item_tags
			        0,  -- autopost_review
			        0,  -- autopost_update
			        'General Information', -- title_s1
			        '', -- title_s2
			        '', -- title_s3
			        '', -- title_s4
			        '', -- title_s5
			        '', -- title_s6
			        '', -- description_s1
			        '', -- description_s2
			        '', -- description_s3
			        '', -- description_s4
			        '', -- description_s5
			        '', -- description_s6
			        1,  -- editor_s1
			        0,  -- editor_s2
			        0,  -- editor_s3
			        0,  -- editor_s4
			        0,  -- editor_s5
			        0,  -- editor_s6
			        0,  -- min_message_length_s1
			        0,  -- min_message_length_s2
			        0,  -- min_message_length_s3
			        0,  -- min_message_length_s4
			        0,  -- min_message_length_s5
			        0,  -- min_message_length_s6
			        1,  -- allow_comments
			        1,  -- allow_ratings
			        '', -- review_voting
			        0,  -- require_review
			        1,  -- allow_items
			        0,  -- allow_contributors
			        0,  -- allow_self_join_contributors
			        0,  -- max_allowed_contributors
			        0,  -- style_id
			        '[]', -- breadcrumb_data
			        '', -- prefix_cache
			        0,  -- default_prefix_id
			        0,  -- require_prefix
			        '', -- field_cache
			        '', -- review_field_cache
			        '', -- update_field_cache
			        0,  -- allow_anon_reviews
			        0,  -- allow_author_rating
			        1,  -- allow_pros_cons
			        0,  -- min_tags
			        '', -- default_tags
			        0,  -- allow_poll
			        0,  -- allow_location
			        0,  -- allow_business_hours
			        0,  -- require_item_image
			        '', -- layout_type
			        '', -- item_list_order
			        '', -- map_options
			        1,  -- display_items_on_index
			        0,  -- expand_category_nav
			        0,  -- display_location_on_list
			        '', -- location_on_list_display_type
			        'allow', -- allow_index
			        '[]'  -- index_criteria
			    )
			", [
			    $node['node_id'],           // category_id
			    $node['title'],             // title
			    $node['title'],             // meta title
			    $node['display_order'],     // display_order
			    $node['parent_node_id'] ?: 0, // parent_category_id
			    $node['lft'],               // lft
			    $node['rgt'],               // rgt
			    $node['depth']              // depth
			]);

	    }

	    $app = \XF::app();
	    
	    // Rebuild permissions
	    $app->jobManager()->enqueueUnique(
	        'permissionRebuild',
	        'XF:PermissionRebuild',
	        [],
	        false
	    );

	    // Rebuild nested set
	    $service = \XF::service('XF:RebuildNestedSet', 'XenAddons\Showcase:Category', [
	        'parentField' => 'parent_category_id'
	    ]);
	    $service->rebuildNestedSetInfo();

	    // Rebuild caches
	    $app->repository('XenAddons\Showcase:ItemPrefix')->rebuildPrefixCache();
	    $app->repository('XenAddons\Showcase:ItemField')->rebuildFieldCache();
	    $app->repository('XenAddons\Showcase:ReviewField')->rebuildFieldCache();
	    $app->repository('XenAddons\Showcase:UpdateField')->rebuildFieldCache();
	}

	public static function appSetup(\XF\App $app)
	{
		$container = $app->container();

		$container['prefixes.sc_item'] = $app->fromRegistry('xa_scPrefixes',
			function(\XF\Container $c) { return $c['em']->getRepository('XenAddons\Showcase:ItemPrefix')->rebuildPrefixCache(); }
		);

		$container['customFields.sc_items'] = $app->fromRegistry('xa_scItemFields',
			function(\XF\Container $c) { return $c['em']->getRepository('XenAddons\Showcase:ItemField')->rebuildFieldCache(); },
			function(array $scItemFieldsInfo)
			{
				$definitionSet = new \XF\CustomField\DefinitionSet($scItemFieldsInfo);
				$definitionSet->addFilter('display_on_list', function(array $field)
				{
					return (bool)$field['display_on_list'];
				});
				return $definitionSet;
			}
		);
		
		$container['customFields.sc_reviews'] = $app->fromRegistry('xa_scReviewFields',
			function(\XF\Container $c) { return $c['em']->getRepository('XenAddons\Showcase:ReviewField')->rebuildFieldCache(); },
			function(array $fields)
			{
				return new \XF\CustomField\DefinitionSet($fields);
			}
		);
		
		$container['customFields.sc_updates'] = $app->fromRegistry('xa_scUpdateFields',
			function(\XF\Container $c) { return $c['em']->getRepository('XenAddons\Showcase:UpdateField')->rebuildFieldCache(); },
			function(array $fields)
			{
				return new \XF\CustomField\DefinitionSet($fields);
			}
		);
	}
	
	public static function navigationSetup(\XF\Pub\App $app, array &$navigationFlat, array &$navigationTree)
	{
		$visitor = self::visitor();
		
		if (isset($navigationFlat['xa_showcase']) 
			&& $visitor->canViewShowcaseItems() 
			&& \XF::options()->xaScUnreadCounter)
		{
			$session = $app->session();
	
			$itemsUnread = $session->get('scUnreadItems');
			
			if ($itemsUnread)
			{
				$navigationFlat['xa_showcase']['counter'] = count($itemsUnread['unread']);
			}
		}
	}	

	public static function appPubStartEnd(\XF\Pub\App $app)
	{
		$visitor = self::visitor();
	
		if ($visitor->user_id && $visitor->canViewShowcaseItems() && \XF::options()->xaScUnreadCounter)
		{
			$session = $app->session();
	
			$itemsUnread = array_replace([
				'unread' => [],
				'lastUpdateDate' => 0
			], $session->get('scUnreadItems') ?: []);
	
			if ($itemsUnread['lastUpdateDate']  < (\XF::$time - 5 * 60)) // 5 minutes
			{
				$categoryRepo = \XF::repository('XenAddons\Showcase:Category');
				$categoryList = $categoryRepo->getViewableCategories();
				$categoryIds = $categoryList->keys();
	
				$itemRepo = \XF::repository('XenAddons\Showcase:Item');
				$showcaseItems = $itemRepo->findItemsForItemList($categoryIds)
				->unreadOnly($visitor->user_id)
				->orderByDate()
				->fetch();
	
				if ($showcaseItems->count())
				{
					$itemsUnread['unread'] = array_fill_keys($showcaseItems->keys(), true);
				}
			}
	
			$itemsUnread['lastUpdateDate'] = \XF::$time;
			$session->set('scUnreadItems', $itemsUnread);
		}
	}
	
	public static function criteriaUser($rule, array $data, \XF\Entity\User $user, &$returnValue)
	{
		switch ($rule)
		{
			case 'xa_sc_item_count':
				if (isset($user->xa_sc_item_count) && $user->xa_sc_item_count >= $data['items'])
				{
					$returnValue = true;
				}
				break;
				
			case 'xa_sc_item_count_nmt': 
				if (isset($user->xa_sc_item_count) && $user->xa_sc_item_count <= $data['items'])
				{
					$returnValue = true;
				}
				break;
				
			case 'xa_sc_item_prefix':
				if (isset($user->xa_sc_item_count) && $user->xa_sc_item_count > 0 && $data['prefix_id'] > 0)
				{
					$itemRepo = \XF::repository('XenAddons\Showcase:Item');
					$itemFinder = $itemRepo->findItemsForUserByPrefix($user, $data['prefix_id']);
					$itemCount = $itemFinder->fetch()->count();
					if ($itemCount)
					{
						$returnValue = true;
					}					
				}
				break;				
				
			case 'xa_sc_featured_item_count':
				$itemRepo = \XF::repository('XenAddons\Showcase:Item');
				$itemFinder = $itemRepo->findFeaturedItemsForUser($user);
				$itemCount = $itemFinder->fetch()->count();
				if ($itemCount >= $data['items'])
				{
					$returnValue = true;
				}
				break;
					
			case 'xa_sc_featured_item_count_nmt':
				$itemRepo = \XF::repository('XenAddons\Showcase:Item');
				$itemFinder = $itemRepo->findFeaturedItemsForUser($user);
				$itemCount = $itemFinder->fetch()->count();
				if ($itemCount <= $data['items'])
				{
					$returnValue = true;
				}
				break;	
				
			case 'xa_sc_comment_count':
				if (isset($user->xa_sc_comment_count) && $user->xa_sc_comment_count >= $data['comments'])
				{
					$returnValue = true;
				}
				break;
			
			case 'xa_sc_comment_count_nmt':
				if (isset($user->xa_sc_comment_count) && $user->xa_sc_comment_count <= $data['comments'])
				{
					$returnValue = true;
				}
				break;
					
			case 'xa_sc_review_count':
				$ratingRepo = \XF::repository('XenAddons\Showcase:ItemRating');
				$reviewFinder = $ratingRepo->findReviewsForUser($user);
				$reviewCount = $reviewFinder->fetch()->count();
				if ($reviewCount >= $data['reviews'])
				{
					$returnValue = true;
				}
				break;
					
			case 'xa_sc_review_count_nmt':
				$ratingRepo = \XF::repository('XenAddons\Showcase:ItemRating');
				$reviewFinder = $ratingRepo->findReviewsForUser($user);
				$reviewCount = $reviewFinder->fetch()->count();
				if ($reviewCount <= $data['reviews'])
				{
					$returnValue = true;
				}
				break;				
		}
	}
	
	public static function criteriaPage($rule, array $data, \XF\Entity\User $user, array $params, &$returnValue)
	{
		if ($rule === 'sc_categories')
		{
			$returnValue = false;
			
			if (!empty($data['sc_category_ids']))
			{
				$selectedCategoryIds = $data['sc_category_ids'];
				
				if (isset($params['breadcrumbs']) && is_array($params['breadcrumbs']) && empty($data['sc_category_only']) && isset($params['scCategory']))
				{
					foreach ($params['breadcrumbs'] AS $i => $navItem)
					{
						if (
							isset($navItem['attributes']['category_id']) 
							&& in_array($navItem['attributes']['category_id'], $selectedCategoryIds)
						)
						{
							$returnValue = true;
						}
					}
				}
				
				if (!empty($params['containerKey']))
				{
					list ($type, $id) = explode('-', $params['containerKey'], 2);
		
					if ($type == 'scCategory' && $id && in_array($id, $selectedCategoryIds))
					{
						$returnValue = true;
					}
				}
			}	
		}	
	}
	
	public static function criteriaTemplateData(array &$templateData)
	{
		$categoryRepo = \XF::repository('XenAddons\Showcase:Category');
		$templateData['scCategories'] = $categoryRepo->getCategoryOptionsData(false);
	}

	public static function templaterSetup(\XF\Container $container, \XF\Template\Templater &$templater)
	{
		/** @var \XenAddons\Showcase\Template\TemplaterSetup $templaterSetup */
		$class = \XF::extendClass('XenAddons\Showcase\Template\TemplaterSetup');
		$templaterSetup = new $class();
		
		$templater->addFunction('sc_item_thumbnail', [$templaterSetup, 'fnScItemThumbnail']);
		$templater->addFunction('sc_category_icon', [$templaterSetup, 'fnScCategoryIcon']);
	}

	public static function templaterTemplatePreRenderPublicEditor(\XF\Template\Templater $templater, &$type, &$template, array &$params)
	{
		if (!self::visitor()->canViewShowcaseItems())
		{
			$params['removeButtons'][] = 'xfCustom_showcase';
		}
	}
	
	public static function editorDialog(array &$data, \XF\Pub\Controller\AbstractController $controller)
	{
		$controller->assertRegistrationRequired();
	
		$data['template'] = 'xa_sc_editor_dialog_showcase';
	}
	
	public static function userContentChangeInit(\XF\Service\User\ContentChange $changeService, array &$updates)
	{
		$updates['xf_xa_sc_category_watch'] = ['user_id', 'emptyable' => false];
		
		$updates['xf_xa_sc_comment'] = ['user_id', 'username'];
		$updates['xf_xa_sc_comment_read'] = ['user_id', 'emptyable' => false];
		
		$updates['xf_xa_sc_feed'] = ['user_id', 'emptyable' => false];
		
		$updates['xf_xa_sc_item'] = [
			['user_id', 'username'],
			['last_comment_user_id', 'last_comment_username']
		];
		$updates['xf_xa_sc_item_rating'] = ['user_id', 'username'];
		$updates['xf_xa_sc_item_rating_reply'] = ['user_id', 'username'];
		$updates['xf_xa_sc_item_read'] = ['user_id', 'emptyable' => false];
		$updates['xf_xa_sc_item_reply_ban'] = ['user_id', 'emptyable' => false];
		$updates['xf_xa_sc_item_update'] = ['user_id', 'username'];
		$updates['xf_xa_sc_item_update_reply'] = ['user_id', 'username'];
		$updates['xf_xa_sc_item_watch'] = ['user_id', 'emptyable' => false];
	}

	public static function userDeleteCleanInit(\XF\Service\User\DeleteCleanUp $deleteService, array &$deletes)
	{
		$deletes['xf_xa_sc_category_watch'] = 'user_id = ?';
		$deletes['xf_xa_sc_comment_read'] = 'user_id = ?';
		$deletes['xf_xa_sc_item_watch'] = 'user_id = ?';
		$deletes['xf_xa_sc_item_read'] = 'user_id = ?';
	}

	public static function userMergeCombine(
		\XF\Entity\User $target, \XF\Entity\User $source, \XF\Service\User\Merge $mergeService
	)
	{
		$target->xa_sc_item_count += $source->xa_sc_item_count;
		$target->xa_sc_comment_count += $source->xa_sc_comment_count;
	}

	public static function userSearcherOrders(\XF\Searcher\User $userSearcher, array &$sortOrders)
	{
		$sortOrders['xa_sc_item_count'] = \XF::phrase('xa_sc_showcase_item_count');
		$sortOrders['xa_sc_comment_count'] = \XF::phrase('xa_sc_showcase_comment_count');
	}
	
	public static function memberStatResultPrepare($order, array &$cacheResults)
	{
		switch ($order)
		{
			case 'xa_sc_item_count':
			case 'xa_sc_comment_count':
				$cacheResults = array_map(function($value)
				{
					return \XF::language()->numberFormat($value);
				}, $cacheResults);
				break;
		}
	}
	
	/**
	 * @return \XenAddons\Showcase\XF\Entity\User
	 */
	public static function visitor()
	{
		/** @var \XenAddons\Showcase\XF\Entity\User $visitor */
		$visitor = \XF::visitor();
		return $visitor;
	}	
}