<?php

namespace Siropu\AdsManager\Repository;

use XF\Mvc\Entity\Finder;
use XF\Mvc\Entity\Repository;

class Position extends Repository
{
     public function findPositionsForList()
     {
          return $this->finder('Siropu\AdsManager:Position')->order('display_order', 'ASC');
     }
     public function findPositionsForCategory($categoryId)
     {
          return $this->findPositionsForList()->inCategory($categoryId);
     }
     public function getPositionListData($type = '')
     {
          $finder = $this->findPositionsForList();

          switch ($type)
          {
               case 'default':
                    $finder->where('is_default', 1);
                    break;
               case 'custom':
                    $finder->where('is_default', 0);
                    break;
          }

          $positions = $finder->fetch()->filter(function(\Siropu\AdsManager\Entity\Position $position)
          {
               return ($position->isVisible());
          });

          return [
               'positionCategories'  => $this->getPositionCategoryRepo()->findPositionCategoriesForList(),
               'positions'           => $positions->groupBy('category_id'),
               'totalPositions'      => $positions->count()
          ];
     }
     public function changePositionCategory($currentId, $newId = 0)
     {
          $this->db()->update('xf_siropu_ads_manager_position', ['category_id' => $newId], 'category_id = ?', $currentId);
     }
     public function generateCssClass($position)
     {
          return 'sam' . trim(str_replace(' ', '', ucwords(preg_replace('/[_0-9]/', ' ', $position))));
     }
     public function addDefaultPositions()
     {
          $positions = [
               // Global
               [
				'position_id'   => 'header_above',
				'category_id'   => 1,
				'title'         => 'Above header',
				'description'   => '',
				'display_order' => 1
			],
			[
				'position_id'   => 'container_header',
				'category_id'   => 1,
				'title'         => 'Header',
				'description'   => '',
				'display_order' => 2
			],
			[
				'position_id'   => 'container_breadcrumb_top_above',
				'category_id'   => 1,
				'title'         => 'Above top breadcrumb',
				'description'   => '',
				'display_order' => 3
			],
			[
				'position_id'   => 'container_breadcrumb_top_below',
				'category_id'   => 1,
				'title'         => 'Below top breadcrumb',
				'description'   => '',
				'display_order' => 4
			],
			[
				'position_id'   => 'container_content_above',
				'category_id'   => 1,
				'title'         => 'Above content',
				'description'   => '',
				'display_order' => 5
			],
			[
				'position_id'   => 'container_content_below',
				'category_id'   => 1,
				'title'         => 'Below content',
				'description'   => '',
				'display_order' => 6
			],
			[
				'position_id'   => 'container_breadcrumb_bottom_above',
				'category_id'   => 1,
				'title'         => 'Above bottom breadcrumb',
				'description'   => '',
				'display_order' => 7
			],
			[
				'position_id'   => 'container_breadcrumb_bottom_below',
				'category_id'   => 1,
				'title'         => 'Below bottom breadcrumb',
				'description'   => '',
				'display_order' => 8
			],
               [
				'position_id'   => 'footer',
				'category_id'   => 1,
				'title'         => 'Footer',
				'description'   => '',
				'display_order' => 9
			],
               [
				'position_id'   => 'footer_fixed',
				'category_id'   => 1,
				'title'         => 'Footer fixed',
				'description'   => '',
				'display_order' => 10
			],
               [
				'position_id'   => 'footer_below',
				'category_id'   => 1,
				'title'         => 'Below footer',
				'description'   => '',
				'display_order' => 11
			], // Forum list
               [
                   'position_id'   => 'forum_overview_top',
                   'category_id'   => 2,
                   'title'         => 'Forum overview top',
                   'description'   => '',
                   'display_order' => 1
               ],
               [
                   'position_id'   => 'forum_overview_bottom',
                   'category_id'   => 2,
                   'title'         => 'Forum overview bottom',
                   'description'   => '',
                   'display_order' => 2
               ],
               [
                   'position_id'   => 'node_list_below_category_container_',
                   'category_id'   => 2,
                   'title'         => 'Node list below category x container',
                   'description'   => '',
                   'display_order' => 3
               ],
               [
                   'position_id'   => 'node_title_above_',
                   'category_id'   => 2,
                   'title'         => 'Node list above node x title',
                   'description'   => '',
                   'display_order' => 4
               ],
               [
                   'position_id'   => 'node_title_container_',
                   'category_id'   => 2,
                   'title'         => 'Node list below node x title',
                   'description'   => '',
                   'display_order' => 5
               ],
               // Forum view
			[
				'position_id'   => 'forum_view_above_node_list',
				'category_id'   => 3,
				'title'         => 'Above node list',
				'description'   => '',
				'display_order' => 1
			],
			[
				'position_id'   => 'forum_view_below_node_list',
				'category_id'   => 3,
				'title'         => 'Below node list',
				'description'   => '',
				'display_order' => 2
			],
			[
				'position_id'   => 'forum_view_above_thread_list',
				'category_id'   => 3,
				'title'         => 'Above thread list',
				'description'   => '',
				'display_order' => 3
			],
			[
				'position_id'   => 'forum_view_below_thread_list',
				'category_id'   => 3,
				'title'         => 'Below thread list',
				'description'   => '',
				'display_order' => 4
			],
               [
				'position_id'   => 'forum_view_above_stickies',
				'category_id'   => 3,
				'title'         => 'Above stickies',
				'description'   => '',
				'display_order' => 5
			],
			[
				'position_id'   => 'forum_view_below_stickies',
				'category_id'   => 3,
				'title'         => 'Below stickies',
				'description'   => '',
				'display_order' => 6
			],
               [
				'position_id'   => 'thread_list_below_item_container_1',
				'category_id'   => 3,
				'title'         => 'Below first thread list item container',
				'description'   => '',
				'display_order' => 7
			],
			[
				'position_id'   => 'thread_list_below_item_container_l',
				'category_id'   => 3,
				'title'         => 'Below last thread list item container',
				'description'   => '',
				'display_order' => 8
			],
               [
				'position_id'   => 'thread_list_below_item_container_r',
				'category_id'   => 3,
				'title'         => 'Below random thread list item container',
				'description'   => '',
				'display_order' => 9
			],
			[
				'position_id'   => 'thread_list_below_item_container_x3',
				'category_id'   => 3,
				'title'         => 'Below every 3rd thread list item container',
				'description'   => '',
				'display_order' => 10
			],
			[
				'position_id'   => 'thread_list_below_item_container_x5',
				'category_id'   => 3,
				'title'         => 'Below every 5th thread list item container',
				'description'   => '',
				'display_order' => 11
			],
			[
				'position_id'   => 'thread_list_below_item_container_',
				'category_id'   => 3,
				'title'         => 'Below thread list item x container',
				'description'   => '',
				'display_order' => 12
			],
               [
                    'position_id'   => 'thread_list_above_item_container_',
                    'category_id'   => 3,
                    'title'         => 'Above thread list item x container',
                    'description'   => '',
                    'display_order' => 13
               ],  // Thread view
			[
				'position_id'   => 'thread_view_above_messages',
				'category_id'   => 4,
				'title'         => 'Above messages',
				'description'   => '',
				'display_order' => 1
			],
			[
				'position_id'   => 'thread_view_below_messages',
				'category_id'   => 4,
				'title'         => 'Below messages',
				'description'   => '',
				'display_order' => 2
			],
               [
				'position_id'   => 'post_below_container_1',
				'category_id'   => 4,
				'title'         => 'Below first thread post container',
				'description'   => '',
				'display_order' => 3
			],
			[
				'position_id'   => 'post_below_container_l',
				'category_id'   => 4,
				'title'         => 'Below last thread post container',
				'description'   => '',
				'display_order' => 4
			],
               [
				'position_id'   => 'post_below_container_r',
				'category_id'   => 4,
				'title'         => 'Below random thread post container',
				'description'   => '',
				'display_order' => 5
			],
			[
				'position_id'   => 'post_below_container_u',
				'category_id'   => 4,
				'title'         => 'Below first unread thread post container',
				'description'   => '',
				'display_order' => 6
			],
			[
				'position_id'   => 'post_below_container_x3',
				'category_id'   => 4,
				'title'         => 'Below every 3rd thread post container',
				'description'   => '',
				'display_order' => 7
			],
			[
				'position_id'   => 'post_below_container_x5',
				'category_id'   => 4,
				'title'         => 'Below every 5th thread post container',
				'description'   => '',
				'display_order' => 8
			],
               [
				'position_id'   => 'post_above_content_1',
				'category_id'   => 4,
				'title'         => 'Above first thread post content',
				'description'   => '',
				'display_order' => 9
			],
			[
				'position_id'   => 'post_above_content_l',
				'category_id'   => 4,
				'title'         => 'Above last thread post content',
				'description'   => '',
				'display_order' => 10
			],
               [
				'position_id'   => 'post_above_content_r',
				'category_id'   => 4,
				'title'         => 'Above random thread post content',
				'description'   => '',
				'display_order' => 11
			],
			[
				'position_id'   => 'post_above_content_u',
				'category_id'   => 4,
				'title'         => 'Above first unread thread post content',
				'description'   => '',
				'display_order' => 12
			],
			[
				'position_id'   => 'post_above_content_x3',
				'category_id'   => 4,
				'title'         => 'Above every 3rd thread post content',
				'description'   => '',
				'display_order' => 13
			],
			[
				'position_id'   => 'post_above_content_x5',
				'category_id'   => 4,
				'title'         => 'Above every 5th thread post content',
				'description'   => '',
				'display_order' => 14
			],
               [
				'position_id'   => 'post_below_content_1',
				'category_id'   => 4,
				'title'         => 'Below first thread post content',
				'description'   => '',
				'display_order' => 15
			],
			[
				'position_id'   => 'post_below_content_l',
				'category_id'   => 4,
				'title'         => 'Below last thread post content',
				'description'   => '',
				'display_order' => 16
			],
               [
				'position_id'   => 'post_below_content_r',
				'category_id'   => 4,
				'title'         => 'Below random thread post content',
				'description'   => '',
				'display_order' => 17
			],
			[
				'position_id'   => 'post_below_content_u',
				'category_id'   => 4,
				'title'         => 'Below first unread thread post content',
				'description'   => '',
				'display_order' => 18
			],
			[
				'position_id'   => 'post_below_content_x3',
				'category_id'   => 4,
				'title'         => 'Below every 3rd thread post content',
				'description'   => '',
				'display_order' => 19
			],
			[
				'position_id'   => 'post_below_content_x5',
				'category_id'   => 4,
				'title'         => 'Below every 5th thread post content',
				'description'   => '',
				'display_order' => 20
			],
               [
				'position_id'   => 'post_above_signature_1',
				'category_id'   => 4,
				'title'         => 'Above first thread post user signature',
				'description'   => '',
				'display_order' => 21
			],
			[
				'position_id'   => 'post_above_signature_l',
				'category_id'   => 4,
				'title'         => 'Above last thread post user signature',
				'description'   => '',
				'display_order' => 22
			],
               [
				'position_id'   => 'post_above_signature_r',
				'category_id'   => 4,
				'title'         => 'Above random thread post user signature',
				'description'   => '',
				'display_order' => 23
			],
			[
				'position_id'   => 'post_above_signature_u',
				'category_id'   => 4,
				'title'         => 'Above first unread thread post user signature',
				'description'   => '',
				'display_order' => 24
			],
			[
				'position_id'   => 'post_above_signature_x3',
				'category_id'   => 4,
				'title'         => 'Above every 3rd thread post user signature',
				'description'   => '',
				'display_order' => 25
			],
			[
				'position_id'   => 'post_above_signature_x5',
				'category_id'   => 4,
				'title'         => 'Above every 5th thread post user signature',
				'description'   => '',
				'display_order' => 26
			],
               [
				'position_id'   => 'post_below_signature_1',
				'category_id'   => 4,
				'title'         => 'Below first thread post user signature',
				'description'   => '',
				'display_order' => 27
			],
			[
				'position_id'   => 'post_below_signature_l',
				'category_id'   => 4,
				'title'         => 'Below last thread post user signature',
				'description'   => '',
				'display_order' => 28
			],
               [
				'position_id'   => 'post_below_signature_r',
				'category_id'   => 4,
				'title'         => 'Below random thread post user signature',
				'description'   => '',
				'display_order' => 29
			],
			[
				'position_id'   => 'post_below_signature_u',
				'category_id'   => 4,
				'title'         => 'Below first unread thread post user signature',
				'description'   => '',
				'display_order' => 30
			],
			[
				'position_id'   => 'post_below_signature_x3',
				'category_id'   => 4,
				'title'         => 'Below every 3rd thread post user signature',
				'description'   => '',
				'display_order' => 31
			],
			[
				'position_id'   => 'post_below_signature_x5',
				'category_id'   => 4,
				'title'         => 'Below every 5th thread post user signature',
				'description'   => '',
				'display_order' => 32
			],
               [
				'position_id'   => 'post_above_container_',
				'category_id'   => 4,
				'title'         => 'Above thread post x container',
				'description'   => '',
				'display_order' => 33
			],
			[
				'position_id'   => 'post_below_container_',
				'category_id'   => 4,
				'title'         => 'Below thread post x container',
				'description'   => '',
				'display_order' => 34
			],
			[
				'position_id'   => 'post_above_content_',
				'category_id'   => 4,
				'title'         => 'Above thread post x content',
				'description'   => '',
				'display_order' => 35
			],
			[
				'position_id'   => 'post_below_content_',
				'category_id'   => 4,
				'title'         => 'Below thread post x content',
				'description'   => '',
				'display_order' => 36
			],
               [
				'position_id'   => 'post_above_signature_',
				'category_id'   => 4,
				'title'         => 'Above thread post x user signature',
				'description'   => '',
				'display_order' => 37
			],
			[
				'position_id'   => 'post_below_signature_',
				'category_id'   => 4,
				'title'         => 'Below thread post x user signature',
				'description'   => '',
				'display_order' => 38
			],
               [
				'position_id'   => 'above_messages_below_pinned',
				'category_id'   => 4,
				'title'         => 'Above messages below pinned post',
				'description'   => '',
				'display_order' => 39
			],
               [
				'position_id'   => 'above_messages_below_solution',
				'category_id'   => 4,
				'title'         => 'Above messages below solution',
				'description'   => '',
				'display_order' => 40
               ], // Conversation list
               [
                   'position_id'   => 'conv_list_above_item_container_',
                   'category_id'   => 16,
                   'title'         => 'Above conversation list item x container',
                   'description'   => '',
                   'display_order' => 1
			],
               [
                   'position_id'   => 'conv_list_below_item_container_',
                   'category_id'   => 16,
                   'title'         => 'Below conversation list item x container',
                   'description'   => '',
                   'display_order' => 2
			], // Conversation view
               [
                   'position_id'   => 'message_below_container_1',
                   'category_id'   => 5,
                   'title'         => 'Below first conversation message container',
                   'description'   => '',
                   'display_order' => 1
               ],
               [
                   'position_id'   => 'message_below_container_l',
                   'category_id'   => 5,
                   'title'         => 'Below last conversation message container',
                   'description'   => '',
                   'display_order' => 2
               ],
               [
                   'position_id'   => 'message_below_container_r',
                   'category_id'   => 5,
                   'title'         => 'Below random conversation message container',
                   'description'   => '',
                   'display_order' => 3
               ],
               [
                   'position_id'   => 'message_below_container_u',
                   'category_id'   => 5,
                   'title'         => 'Below first unread conversation message container',
                   'description'   => '',
                   'display_order' => 4
               ],
               [
                   'position_id'   => 'message_below_container_x3',
                   'category_id'   => 5,
                   'title'         => 'Below every 3rd conversation message container',
                   'description'   => '',
                   'display_order' => 5
               ],
               [
                   'position_id'   => 'message_below_container_x5',
                   'category_id'   => 5,
                   'title'         => 'Below every 5th conversation message container',
                   'description'   => '',
                   'display_order' => 6
               ],
               [
                   'position_id'   => 'message_above_content_1',
                   'category_id'   => 5,
                   'title'         => 'Above first conversation message content',
                   'description'   => '',
                   'display_order' => 7
               ],
               [
                   'position_id'   => 'message_above_content_l',
                   'category_id'   => 5,
                   'title'         => 'Above last conversation message content',
                   'description'   => '',
                   'display_order' => 8
               ],
               [
                   'position_id'   => 'message_above_content_r',
                   'category_id'   => 5,
                   'title'         => 'Above random conversation message content',
                   'description'   => '',
                   'display_order' => 9
               ],
               [
                   'position_id'   => 'message_above_content_u',
                   'category_id'   => 5,
                   'title'         => 'Above first unread conversation message content',
                   'description'   => '',
                   'display_order' => 10
               ],
               [
                   'position_id'   => 'message_above_content_x3',
                   'category_id'   => 5,
                   'title'         => 'Above every 3rd conversation message content',
                   'description'   => '',
                   'display_order' => 11
               ],
               [
                   'position_id'   => 'message_above_content_x5',
                   'category_id'   => 5,
                   'title'         => 'Above every 5th conversation message content',
                   'description'   => '',
                   'display_order' => 12
               ],
               [
                   'position_id'   => 'message_below_content_1',
                   'category_id'   => 5,
                   'title'         => 'Below first conversation message content',
                   'description'   => '',
                   'display_order' => 13
               ],
               [
                   'position_id'   => 'message_below_content_l',
                   'category_id'   => 5,
                   'title'         => 'Below last conversation message content',
                   'description'   => '',
                   'display_order' => 14
               ],
               [
                   'position_id'   => 'message_below_content_r',
                   'category_id'   => 5,
                   'title'         => 'Below random conversation message content',
                   'description'   => '',
                   'display_order' => 15
               ],
               [
                   'position_id'   => 'message_below_content_u',
                   'category_id'   => 5,
                   'title'         => 'Below first unread conversation message content',
                   'description'   => '',
                   'display_order' => 16
               ],
               [
                   'position_id'   => 'message_below_content_x3',
                   'category_id'   => 5,
                   'title'         => 'Below every 3rd conversation message content',
                   'description'   => '',
                   'display_order' => 17
               ],
               [
                   'position_id'   => 'message_below_content_x5',
                   'category_id'   => 5,
                   'title'         => 'Below every 5th conversation message content',
                   'description'   => '',
                   'display_order' => 18
               ],
               [
                   'position_id'   => 'message_above_signature_1',
                   'category_id'   => 5,
                   'title'         => 'Above first conversation message user signature',
                   'description'   => '',
                   'display_order' => 19
               ],
               [
                   'position_id'   => 'message_above_signature_l',
                   'category_id'   => 5,
                   'title'         => 'Above last conversation message user signature',
                   'description'   => '',
                   'display_order' => 20
               ],
               [
                   'position_id'   => 'message_above_signature_r',
                   'category_id'   => 5,
                   'title'         => 'Above random conversation message user signature',
                   'description'   => '',
                   'display_order' => 21
               ],
               [
                   'position_id'   => 'message_above_signature_u',
                   'category_id'   => 5,
                   'title'         => 'Above first unread conversation message user signature',
                   'description'   => '',
                   'display_order' => 22
               ],
               [
                   'position_id'   => 'message_above_signature_x3',
                   'category_id'   => 5,
                   'title'         => 'Above every 3rd conversation message user signature',
                   'description'   => '',
                   'display_order' => 23
               ],
               [
                   'position_id'   => 'message_above_signature_x5',
                   'category_id'   => 5,
                   'title'         => 'Above every 5th conversation message user signature',
                   'description'   => '',
                   'display_order' => 24
               ],
               [
                   'position_id'   => 'message_below_signature_1',
                   'category_id'   => 5,
                   'title'         => 'Below first conversation message user signature',
                   'description'   => '',
                   'display_order' => 25
               ],
               [
                   'position_id'   => 'message_below_signature_l',
                   'category_id'   => 5,
                   'title'         => 'Below last conversation message user signature',
                   'description'   => '',
                   'display_order' => 26
               ],
               [
                   'position_id'   => 'message_below_signature_r',
                   'category_id'   => 5,
                   'title'         => 'Below random conversation message user signature',
                   'description'   => '',
                   'display_order' => 27
               ],
               [
                   'position_id'   => 'message_below_signature_u',
                   'category_id'   => 5,
                   'title'         => 'Below first unread conversation message user signature',
                   'description'   => '',
                   'display_order' => 28
               ],
               [
                   'position_id'   => 'message_below_signature_x3',
                   'category_id'   => 5,
                   'title'         => 'Below every 3rd conversation message user signature',
                   'description'   => '',
                   'display_order' => 29
               ],
               [
                   'position_id'   => 'message_below_signature_x5',
                   'category_id'   => 5,
                   'title'         => 'Below every 5th conversation message user signature',
                   'description'   => '',
                   'display_order' => 30
               ],
               [
				'position_id'   => 'message_above_container_',
				'category_id'   => 5,
				'title'         => 'Above conversation message x container',
				'description'   => '',
				'display_order' => 31
			],
			[
				'position_id'   => 'message_below_container_',
				'category_id'   => 5,
				'title'         => 'Below conversation message x container',
				'description'   => '',
				'display_order' => 32
			],
               [
				'position_id'   => 'message_above_content_',
				'category_id'   => 5,
				'title'         => 'Above conversation message x content',
				'description'   => '',
				'display_order' => 33
			],
               [
				'position_id'   => 'message_below_content_',
				'category_id'   => 5,
				'title'         => 'Below conversation message x content',
				'description'   => '',
				'display_order' => 34
			],
               [
				'position_id'   => 'message_above_signature_',
				'category_id'   => 5,
				'title'         => 'Above conversation message x user signature',
				'description'   => '',
				'display_order' => 35
			],
			[
				'position_id'   => 'message_below_signature_',
				'category_id'   => 5,
				'title'         => 'Above conversation message x user signature',
				'description'   => '',
				'display_order' => 36
			], // Member view
			[
				'position_id'   => 'member_view_below_tabs',
				'category_id'   => 6,
				'title'         => 'Member view below tabs',
				'description'   => '',
				'display_order' => 1
			],
               [
				'position_id'   => 'profile_post_below_container_1',
				'category_id'   => 6,
				'title'         => 'Below first profile post container',
				'description'   => '',
				'display_order' => 2
			],
			[
				'position_id'   => 'profile_post_below_container_l',
				'category_id'   => 6,
				'title'         => 'Below last profile post container',
				'description'   => '',
				'display_order' => 3
			],
			[
				'position_id'   => 'profile_post_below_container_r',
				'category_id'   => 6,
				'title'         => 'Below random profile post container',
				'description'   => '',
				'display_order' => 4
			],
               [
                    'position_id'   => 'profile_post_below_container_x3',
                    'category_id'   => 6,
                    'title'         => 'Below every 3rd profile post container',
                    'description'   => '',
                    'display_order' => 5
               ],
               [
                    'position_id'   => 'profile_post_below_container_x5',
                    'category_id'   => 6,
                    'title'         => 'Below every 5th profile post container',
                    'description'   => '',
                    'display_order' => 6
               ],
               [
				'position_id'   => 'profile_post_above_container_',
				'category_id'   => 6,
				'title'         => 'Above profile post x container',
				'description'   => '',
				'display_order' => 7
			],
			[
				'position_id'   => 'profile_post_below_container_',
				'category_id'   => 6,
				'title'         => 'Below profile post x container',
				'description'   => '',
				'display_order' => 8
			], // Search results
               [
                   'position_id'   => 'search_results_below_item_container_1',
                   'category_id'   => 7,
                   'title'         => 'Below first search result item container',
                   'description'   => '',
                   'display_order' => 1
               ],
               [
                   'position_id'   => 'search_results_below_item_container_l',
                   'category_id'   => 7,
                   'title'         => 'Below last search result item container',
                   'description'   => '',
                   'display_order' => 2
               ],
               [
                   'position_id'   => 'search_results_below_item_container_r',
                   'category_id'   => 7,
                   'title'         => 'Below random search result item container',
                   'description'   => '',
                   'display_order' => 3
               ],
               [
                   'position_id'   => 'search_results_below_item_container_x3',
                   'category_id'   => 7,
                   'title'         => 'Below every 3rd search result item container',
                   'description'   => '',
                   'display_order' => 4
               ],
               [
                   'position_id'   => 'search_results_below_item_container_x5',
                   'category_id'   => 7,
                   'title'         => 'Below every 5th search result item container',
                   'description'   => '',
                   'display_order' => 5
               ],
               [
				'position_id'   => 'search_results_below_item_container_',
				'category_id'   => 7,
				'title'         => 'Below search results item x container',
				'description'   => '',
				'display_order' => 6
			],
               // Tag view
               [
                   'position_id'   => 'tag_view_below_item_container_1',
                   'category_id'   => 8,
                   'title'         => 'Below first tag result item container',
                   'description'   => '',
                   'display_order' => 1
               ],
               [
                   'position_id'   => 'tag_view_below_item_container_l',
                   'category_id'   => 8,
                   'title'         => 'Below last tag result item container',
                   'description'   => '',
                   'display_order' => 2
               ],
               [
                   'position_id'   => 'tag_view_below_item_container_r',
                   'category_id'   => 8,
                   'title'         => 'Below random tag result item container',
                   'description'   => '',
                   'display_order' => 3
               ],
               [
                   'position_id'   => 'tag_view_below_item_container_x3',
                   'category_id'   => 8,
                   'title'         => 'Below every 3rd tag result item container',
                   'description'   => '',
                   'display_order' => 4
               ],
               [
                   'position_id'   => 'tag_view_below_item_container_x5',
                   'category_id'   => 8,
                   'title'         => 'Below every 5th tag result item container',
                   'description'   => '',
                   'display_order' => 5
               ],
               [
                   'position_id'   => 'tag_view_below_item_container_',
                   'category_id'   => 8,
                   'title'         => 'Below tag results item x container',
                   'description'   => '',
                   'display_order' => 6
               ], // Miscellaneous
               [
                    'position_id'   => 'container_sidebar_above',
                    'category_id'   => 9,
                    'title'         => 'Sidebar above',
                    'description'   => '',
                    'display_order' => 1
               ],
               [
                    'position_id'   => 'container_sidebar_below',
                    'category_id'   => 9,
                    'title'         => 'Sidebar below',
                    'description'   => '',
                    'display_order' => 2
               ],
			[
				'position_id'   => 'container_sidenav_above',
				'category_id'   => 9,
				'title'         => 'Above sidebar navigation',
				'description'   => '',
				'display_order' => 3
			],
			[
				'position_id'   => 'container_sidenav_below',
				'category_id'   => 9,
				'title'         => 'Below sidebar navigation',
				'description'   => '',
				'display_order' => 4
			],
               [
				'position_id'   => 'search_menu',
				'category_id'   => 9,
				'title'         => 'Inside search menu',
				'description'   => '',
				'display_order' => 5
			],
			[
				'position_id'   => 'visitor_menu',
				'category_id'   => 9,
				'title'         => 'Inside visitor menu',
				'description'   => '',
				'display_order' => 6
			],
			[
				'position_id'   => 'whats_new_posts_below_item_container_',
				'category_id'   => 9,
				'title'         => 'What\'s new post list below item x container',
				'description'   => '',
				'display_order' => 7
			],
               [
				'position_id'   => 'whats_new_profile_posts_below_item_container_',
				'category_id'   => 9,
				'title'         => 'What\'s new profile post list below item x container',
				'description'   => '',
				'display_order' => 8
			],
			[
				'position_id'   => 'latest_activity_list_below_item_container_',
				'category_id'   => 9,
				'title'         => 'Latest activity list below item x container',
				'description'   => '',
				'display_order' => 9
			],
               [
				'position_id'   => 'account_alerts_below_item_container_',
				'category_id'   => 9,
				'title'         => 'Account alerts below item x container',
				'description'   => '',
				'display_order' => 10
			],
               [
				'position_id'   => 'above_bb_code_attachment',
				'category_id'   => 9,
				'title'         => 'Above BB Code attachment',
				'description'   => '',
				'display_order' => 11
			],
               [
				'position_id'   => 'below_bb_code_attachment',
				'category_id'   => 9,
				'title'         => 'Below BB Code attachment',
				'description'   => '',
				'display_order' => 12
			],
               [
				'position_id'   => 'over_bb_code_video_attachment',
				'category_id'   => 9,
				'title'         => 'Over BB Code video attachment',
				'description'   => '',
				'display_order' => 13
			],  // Media Gallery
			[
				'position_id'   => 'media_list_item_',
				'category_id'   => 10,
				'title'         => 'Media list after item x',
				'description'   => '',
				'display_order' => 1
			],
               [
                    'position_id'   => 'media_album_list_item_',
                    'category_id'   => 10,
                    'title'         => 'Media album list after item x',
                    'description'   => '',
                    'display_order' => 2
               ],
			[
				'position_id'   => 'media_view_image_container',
				'category_id'   => 10,
				'title'         => 'Media view image container',
				'description'   => '',
				'display_order' => 3
			],
			[
				'position_id'   => 'media_view_video_embed_container',
				'category_id'   => 10,
				'title'         => 'Media view video embed container',
				'description'   => '',
				'display_order' => 4
			],
			[
				'position_id'   => 'media_view_video_container',
				'category_id'   => 10,
				'title'         => 'Media view video container',
				'description'   => '',
				'display_order' => 5
			],
			[
				'position_id'   => 'media_view_above_media_preview',
				'category_id'   => 10,
				'title'         => 'Media view above media preview',
				'description'   => '',
				'display_order' => 6
			],
			[
				'position_id'   => 'media_view_below_media_preview',
				'category_id'   => 10,
				'title'         => 'Media view below media preview',
				'description'   => '',
				'display_order' => 7
			],
			[
				'position_id'   => 'media_view_below_description',
				'category_id'   => 10,
				'title'         => 'Media view below description',
				'description'   => '',
				'display_order' => 8
			],
			[
				'position_id'   => 'album_view_below_description',
				'category_id'   => 10,
				'title'         => 'Album view below description',
				'description'   => '',
				'display_order' => 9
			],
			[
				'position_id'   => 'media_view_above_comments',
				'category_id'   => 10,
				'title'         => 'Media view above comments',
				'description'   => '',
				'display_order' => 10
			],
			[
				'position_id'   => 'media_comment_list_below_item_container_',
				'category_id'   => 10,
				'title'         => 'Comment list below item x container',
				'description'   => '',
				'display_order' => 11
			],
               [
				'position_id'   => 'sidebar_above_media_info_block',
				'category_id'   => 10,
				'title'         => 'Sidebar above media info block',
				'description'   => '',
				'display_order' => 12
			],
			[
				'position_id'   => 'sidebar_below_media_info_block',
				'category_id'   => 10,
				'title'         => 'Sidebar below media info block',
				'description'   => '',
				'display_order' => 13
			],
			[
				'position_id'   => 'sidebar_above_media_share_block',
				'category_id'   => 10,
				'title'         => 'Sidebar above media share block',
				'description'   => '',
				'display_order' => 14
			],
			[
				'position_id'   => 'sidebar_below_media_share_block',
				'category_id'   => 10,
				'title'         => 'Sidebar below media share block',
				'description'   => '',
				'display_order' => 15
			],
			[
				'position_id'   => 'sidebar_above_media_album_info_block',
				'category_id'   => 10,
				'title'         => 'Sidebar above album info block',
				'description'   => '',
				'display_order' => 16
			],
			[
				'position_id'   => 'sidebar_below_media_album_info_block',
				'category_id'   => 10,
				'title'         => 'Sidebar below album info block',
				'description'   => '',
				'display_order' => 17
			],
			[
				'position_id'   => 'sidebar_above_media_album_share_block',
				'category_id'   => 10,
				'title'         => 'Sidebar above album share block',
				'description'   => '',
				'display_order' => 18
			],
			[
				'position_id'   => 'sidebar_below_media_album_share_block',
				'category_id'   => 10,
				'title'         => 'Sidebar below album share block',
				'description'   => '',
				'display_order' => 19
			], // Resource Manager
			[
				'position_id'   => 'resource_list_below_item_container_',
				'category_id'   => 11,
				'title'         => 'Resource list below item x container',
				'description'   => '',
				'display_order' => 1
			],
			[
				'position_id'   => 'resource_view_above_description',
				'category_id'   => 11,
				'title'         => 'Resource view above description',
				'description'   => '',
				'display_order' => 2
			],
			[
				'position_id'   => 'resource_view_below_description',
				'category_id'   => 11,
				'title'         => 'Resource view below description',
				'description'   => '',
				'display_order' => 3
			],
			[
				'position_id'   => 'resource_update_above_description',
				'category_id'   => 11,
				'title'         => 'Resource update above description',
				'description'   => '',
				'display_order' => 4
			],
			[
				'position_id'   => 'resource_update_below_description',
				'category_id'   => 11,
				'title'         => 'Resource update below description',
				'description'   => '',
				'display_order' => 5
			],
			[
				'position_id'   => 'sidebar_above_resource_info_block',
				'category_id'   => 11,
				'title'         => 'Sidebar above resource info block',
				'description'   => '',
				'display_order' => 6
			],
			[
				'position_id'   => 'sidebar_below_resource_share_block',
				'category_id'   => 11,
				'title'         => 'Sidebar below resource share block',
				'description'   => '',
				'display_order' => 7
			],
               [
				'position_id'   => 'resource_review_list_below_item_container_',
				'category_id'   => 11,
				'title'         => 'Review list below item x container',
				'description'   => '',
				'display_order' => 8
			], // AMS Article
               [
                    'position_id'   => 'ams_article_above_content',
				'category_id'   => 12,
				'title'         => 'Above article content.',
				'description'   => 'Position above the article content.',
				'display_order' => 1
               ],
               [
                    'position_id'   => 'ams_article_below_content',
				'category_id'   => 12,
				'title'         => 'Below article content.',
				'description'   => 'Position below the article content.',
				'display_order' => 2
               ],
               [
                    'position_id'   => 'ams_article_before_item_',
				'category_id'   => 12,
				'title'         => 'Before article item x',
				'description'   => 'Position between articles before article item x.',
				'display_order' => 3
               ],
               [
                    'position_id'   => 'ams_article_after_item_',
				'category_id'   => 12,
				'title'         => 'After article item x',
				'description'   => 'Position between articles after article item x.',
				'display_order' => 4
               ], // Showcase
               [
                    'position_id'   => 'sc_item_above_content',
				'category_id'   => 15,
				'title'         => 'Above Showcase item section 1 content',
				'description'   => 'Position above the content of the section 1 of Showcase item.',
				'display_order' => 1
               ],
               [
                    'position_id'   => 'sc_item_below_content',
				'category_id'   => 15,
				'title'         => 'Below Showcase item section 1 content',
				'description'   => 'Position below the content of the section 1 of Showcase item.',
				'display_order' => 2
               ],
               [
                    'position_id'   => 'sc_item_above_s2_content',
				'category_id'   => 15,
				'title'         => 'Above Showcase item section 2 content',
				'description'   => 'Position above the content of the section 2 of Showcase item.',
				'display_order' => 3
               ],
               [
                    'position_id'   => 'sc_item_below_s2_content',
				'category_id'   => 15,
				'title'         => 'Below Showcase item section 2 content',
				'description'   => 'Position below the content of the section 2 of Showcase item.',
				'display_order' => 4
               ],
               [
                    'position_id'   => 'sc_item_above_s3_content',
				'category_id'   => 15,
				'title'         => 'Above Showcase item section 3 content',
				'description'   => 'Position above the content of the section 3 of Showcase item.',
				'display_order' => 5
               ],
               [
                    'position_id'   => 'sc_item_below_s3_content',
				'category_id'   => 15,
				'title'         => 'Below Showcase item section 3 content',
				'description'   => 'Position below the content of the section 3 of Showcase item.',
				'display_order' => 6
               ],
               [
                    'position_id'   => 'sc_item_above_s4_content',
				'category_id'   => 15,
				'title'         => 'Above Showcase item section 4 content',
				'description'   => 'Position above the content of the section 4 of Showcase item.',
				'display_order' => 7
               ],
               [
                    'position_id'   => 'sc_item_below_s4_content',
				'category_id'   => 15,
				'title'         => 'Below Showcase item section 4 content',
				'description'   => 'Position below the content of the section 4 of Showcase item.',
				'display_order' => 8
               ],
               [
                    'position_id'   => 'sc_item_above_s5_content',
				'category_id'   => 15,
				'title'         => 'Above Showcase item section 5 content',
				'description'   => 'Position above the content of the section 5 of Showcase item.',
				'display_order' => 9
               ],
               [
                    'position_id'   => 'sc_item_below_s5_content',
				'category_id'   => 15,
				'title'         => 'Below Showcase item section 5 content',
				'description'   => 'Position below the content of the section 5 of Showcase item.',
				'display_order' => 10
               ],  // No Wrapper
               [
                   'position_id'   => 'no_wrapper_head',
                   'category_id'   => 13,
                   'title'         => 'Between the <head> tag',
                   'description'   => '',
                   'display_order' => 1
               ],
               [
                   'position_id'   => 'no_wrapper_after_body',
                   'category_id'   => 13,
                   'title'         => 'After the open <body> tag',
                   'description'   => '',
                   'display_order' => 2
               ],
               [
                   'position_id'   => 'no_wrapper_before_body',
                   'category_id'   => 13,
                   'title'         => 'Before the closing <\body> tag',
                   'description'   => '',
                   'display_order' => 3
              ],  // Uncategorized
              [
                    'position_id'   => 'javascript',
                    'category_id'   => 0,
                    'title'         => 'JavaScript',
                    'description'   => 'Position used for popup and background ads.',
                    'display_order' => 1
               ],
               [
                   'position_id'   => 'advertisers',
                   'category_id'   => 0,
                   'title'         => 'Advertisers',
                   'description'   => 'Position used for Advertiser list page.',
                   'display_order' => 2
               ],
               [
                   'position_id'   => 'embed',
                   'category_id'   => 0,
                   'title'         => 'Embed',
                   'description'   => 'Position used for statistics purposes in embed mode.',
                   'display_order' => 3
               ],
               [
                   'position_id'   => 'content_thread',
                   'category_id'   => 0,
                   'title'         => 'Thread post content',
                   'description'   => 'Position used for statistics purposes in keyword and affiliate ads in thread view.',
                   'display_order' => 4
               ],
               [
                   'position_id'   => 'content_conversation',
                   'category_id'   => 0,
                   'title'         => 'Conversation message content',
                   'description'   => 'Position used for statistics purposes in keyword and affiliate ads in conversation view.',
                   'display_order' => 5
               ],
               [
                   'position_id'   => 'content_profile',
                   'category_id'   => 4,
                   'title'         => 'Profile post content',
                   'description'   => 'Position used for statistics purposes in keyword and affiliate ads in profile view.',
                   'display_order' => 6
              ], // Email
              [
                   'position_id'   => 'mail_above_content',
                   'category_id'   => 14,
                   'title'         => 'Above email content',
                   'description'   => 'Position used for email ads.',
                   'display_order' => 1
              ],
              [
                   'position_id'   => 'mail_below_content',
                   'category_id'   => 14,
                   'title'         => 'Below email content',
                   'description'   => 'Position used for email ads.',
                   'display_order' => 2
              ]
		];

		foreach ($positions as $position)
		{
			$em = $this->em->create('Siropu\AdsManager:Position');
               $em->is_default = 1;
			$em->bulkSet($position, ['forceSet' => true]);
			$em->saveIfChanged($saved, false);
		}

          $this->rebuildPositionCache();
     }
     public function getPositionFromCache($positionId)
     {
          if (isset($this->getPositionCache()[$positionId]))
          {
               return $this->instantiatePositionEntity($this->getPositionCache()[$positionId]);
          }
     }
     public function getDynamicPosition($positionId)
     {
          $position = $this->getPositionFromCache($positionId);

          if ($position)
          {
               return $position;
          }
          else if (preg_match('/(.*?_)([\d]+)$/', $positionId, $match))
          {
               $position = $this->getPositionFromCache($match[1]);

               if ($position)
               {
                    $this->em->clearEntityCache('Siropu\AdsManager:Position');

                    $position->title = $position->title . " ({$match[2]})";

                    return $position;
               }
          }
     }
     public function instantiatePositionEntity(array $position)
     {
          return $this->em->instantiateEntity('Siropu\AdsManager:Position', $position);
     }
     public function getPositionCache()
     {
          $simpleCache = $this->app()->simpleCache();
          return $simpleCache['Siropu/AdsManager']['positions'];
     }
     public function getPositionsCacheData()
     {
          $cache = [];

          foreach ($this->finder('Siropu\AdsManager:Position')->fetch() AS $position)
          {
               $cache[$position->position_id] = $position->toArray();
          }

          return $cache;
     }
     public function rebuildPositionCache()
     {
          $simpleCache = $this->app()->simpleCache();
          $simpleCache['Siropu/AdsManager']['positions'] = $this->getPositionsCacheData();
     }
     public function resetPositions()
     {
          $this->db()->emptyTable('xf_siropu_ads_manager_position');
          $this->addDefaultPositions();
     }
     protected function getPositionCategoryRepo()
	{
		return $this->repository('Siropu\AdsManager:PositionCategory');
	}
}
