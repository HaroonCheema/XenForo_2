<?php

namespace Siropu\AdsManager\Criteria;

class Position extends \XF\Criteria\AbstractCriteria
{
     protected $params = [];

     public function __construct(\XF\App $app, array $criteria, array $params = [])
     {
          parent::__construct($app, $criteria);

          $this->params = $params;
     }
     public function _matchItemId(array $data, \XF\Entity\User $user)
     {
          return true;
     }
     public function _matchThreadPrefixFilter(array $data, \XF\Entity\User $user)
     {
          $prefixId = $this->app->request()->filter('prefix_id', 'uint');

          if (!empty($this->params['forum']) && !in_array($prefixId, $data['prefix_id']))
          {
                return false;
          }

          return true;
     }
     public function _matchThreadPrefixFilterNot(array $data, \XF\Entity\User $user)
     {
          $prefixId = $this->app->request()->filter('prefix_id', 'uint');

          if (!empty($this->params['forum']) && in_array($prefixId, $data['prefix_id']))
          {
                return false;
          }

          return true;
     }
     public function _matchThreadType(array $data, \XF\Entity\User $user)
     {
          if (!empty($this->params['thread']))
          {
                $type = $this->params['thread']['discussion_type'];

                if ($data['type'] != $type)
                {
                     return false;
                }
          }

          return true;
     }
     public function _matchThreadTypeNot(array $data, \XF\Entity\User $user)
     {
          if (!empty($this->params['thread']))
          {
               $type = $this->params['thread']['discussion_type'];

               if ($data['type'] == $type)
               {
                    return false;
               }
          }

          return true;
     }
     public function _matchThreadPrefix(array $data, \XF\Entity\User $user)
     {
          if (!empty($this->params['thread']))
          {
                $prefixId = $this->params['thread']['prefix_id'];

                if (!in_array($prefixId, (array) $data['prefix_id']))
                {
                     return false;
                }
          }

          return true;
     }
     public function _matchThreadPrefixNot(array $data, \XF\Entity\User $user)
     {
          if (!empty($this->params['thread']))
          {
                $prefixId = $this->params['thread']['prefix_id'];

                if (in_array($prefixId, (array) $data['prefix_id']))
                {
                     return false;
                }
          }

          return true;
     }
     public function _matchThreadId(array $data, \XF\Entity\User $user)
     {
          if (!empty($this->params['thread']))
          {
                $id = $this->params['thread']['thread_id'];

                if (!in_array($id, $this->getItemArray($data['id'])))
                {
                     return false;
                }
          }

          return true;
     }
     public function _matchThreadIdNot(array $data, \XF\Entity\User $user)
     {
          if (!empty($this->params['thread']))
          {
                $id = $this->params['thread']['thread_id'];

                if (in_array($id, $this->getItemArray($data['id'])))
                {
                     return false;
                }
          }

          return true;
     }
     public function _matchThreadTag(array $data, \XF\Entity\User $user)
     {
          if (!empty($this->params['thread']))
          {
                $tags = $this->params['thread']['tags'];

                if (!array_intersect($this->prepareTags($tags), $this->getItemArray($data['tag'], true)))
                {
                     return false;
                }
          }

          return true;
     }
     public function _matchThreadTagNot(array $data, \XF\Entity\User $user)
     {
          if (!empty($this->params['thread']))
          {
                $tags = $this->params['thread']['tags'];

                if (array_intersect($this->prepareTags($tags), $this->getItemArray($data['tag'], true)))
                {
                     return false;
                }
          }

          return true;
     }
     public function _matchThreadTitle(array $data, \XF\Entity\User $user)
     {
          if (!empty($this->params['thread']))
          {
               $title = $this->params['thread']['title'];

               if (!preg_match('/\b' . implode('|', $this->getItemArray($data['title'])) . '\b/ui', $title))
               {
                    return false;
               }
          }

          return true;
     }
     public function _matchThreadTitleNot(array $data, \XF\Entity\User $user)
     {
          if (!empty($this->params['thread']))
          {
               $title = $this->params['thread']['title'];

               if (preg_match('/\b' . implode('|', $this->getItemArray($data['title'])) . '\b/ui', $title))
               {
                    return false;
               }
          }

          return true;
     }
     public function _matchThreadAuthor(array $data, \XF\Entity\User $user)
     {
          if (!empty($this->params['thread']))
          {
               $author = $this->params['thread']['username'];

               if (!in_array(utf8_strtolower($author), $this->getItemArray($data['author'], true)))
               {
                    return false;
               }
          }

          return true;
     }
     public function _matchThreadAuthorNot(array $data, \XF\Entity\User $user)
     {
          if (!empty($this->params['thread']))
          {
               $author = $this->params['thread']['username'];

               if (in_array(utf8_strtolower($author), $this->getItemArray($data['author'], true)))
               {
                    return false;
               }
          }

          return true;
     }
     public function _matchThreadAuthorUserGroups(array $data, \XF\Entity\User $user)
     {
          if (!empty($this->params['thread']))
          {
               $user = $this->params['thread']['User'];
               return $user && $user->isMemberOf($data['user_group_ids']);
          }

          return true;
     }
     public function _matchThreadAuthorNotUserGroups(array $data, \XF\Entity\User $user)
     {
          if (!empty($this->params['thread']))
          {
               $user = $this->params['thread']['User'];
               return $user && !$user->isMemberOf($data['user_group_ids']);
          }

          return true;
     }
     public function _matchFirstPost(array $data, \XF\Entity\User $user)
     {
          if (!empty($this->params['thread']['FirstPost']))
          {
               $firstPostMessage = $this->params['thread']['FirstPost']['message'];

               if (!preg_match('/\b' . implode('|', $this->getItemArray($data['message'])) . '\b/ui', $firstPostMessage))
               {
                    return false;
               }
          }

          return true;
     }
     public function _matchFirstPostNot(array $data, \XF\Entity\User $user)
     {
          if (!empty($this->params['thread']['FirstPost']))
          {
               $firstPostMessage = $this->params['thread']['FirstPost']['message'];

               if (preg_match('/\b' . implode('|', $this->getItemArray($data['message'])) . '\b/ui', $firstPostMessage))
               {
                    return false;
               }
          }

          return true;
     }
     public function _matchLastPostOlderThan(array $data, \XF\Entity\User $user)
     {
          if (!empty($this->params['thread']) && \XF::$time - $data['days'] * 86400 >= $this->params['thread']['last_post_date'])
          {
               return true;
          }
     }
     public function _matchLastPostNotOlderThan(array $data, \XF\Entity\User $user)
     {
          if (!empty($this->params['thread']) && $this->params['thread']['last_post_date'] >= \XF::$time - $data['days'] * 86400)
          {
               return true;
          }
     }
     public function _matchIsClosed(array $data, \XF\Entity\User $user)
     {
          if (!empty($this->params['thread']))
          {
               return $this->params['thread']['discussion_open'] == 0;
          }

          return true;
     }
     public function _matchIsNotClosed(array $data, \XF\Entity\User $user)
     {
          if (!empty($this->params['thread']))
          {
               return $this->params['thread']['discussion_open'] == 1;
          }

          return true;
     }
     public function _matchIsSticky(array $data, \XF\Entity\User $user)
     {
          if (!empty($this->params['thread']))
          {
               return $this->params['thread']['sticky'] == 1;
          }

          return true;
     }
     public function _matchIsNotSticky(array $data, \XF\Entity\User $user)
     {
          if (!empty($this->params['thread']))
          {
               return $this->params['thread']['sticky'] == 0;
          }

          return true;
     }
     public function _matchAuthorAdOwner(array $data, \XF\Entity\User $user)
     {
          if (!empty($this->params['thread']) && $this->params['thread']['user_id'] == $this->params['ad']['user_id'])
          {
               return true;
          }
     }
     public function _matchThreadOlderThan(array $data, \XF\Entity\User $user)
     {
          if (!empty($this->params['thread']) && \XF::$time - $data['days'] * 86400 >= $this->params['thread']['post_date'])
          {
               return true;
          }
     }
     public function _matchThreadNotOlderThan(array $data, \XF\Entity\User $user)
     {
          if (!empty($this->params['thread']) && $this->params['thread']['post_date'] >= \XF::$time - $data['days'] * 86400)
          {
               return true;
          }
     }
     public function _matchPostAuthor(array $data, \XF\Entity\User $user)
     {
          if (!empty($this->params['post']))
          {
               $author = $this->params['post']['username'];

               if (!in_array(utf8_strtolower($author), $this->getItemArray($data['author'], true)))
               {
                    return false;
               }
          }

          return true;
     }
     public function _matchPostAuthorNot(array $data, \XF\Entity\User $user)
     {
          if (!empty($this->params['post']))
          {
               $author = $this->params['post']['username'];

               if (in_array(utf8_strtolower($author), $this->getItemArray($data['author'], true)))
               {
                    return false;
               }
          }

          return true;
     }
     public function _matchPostAuthorUserGroups(array $data, \XF\Entity\User $user)
     {
          if (!empty($this->params['post']))
          {
               $user = $this->params['post']['User'];
               return $user && $user->isMemberOf($data['user_group_ids']);
          }

          return true;
     }
     public function _matchPostAuthorNotUserGroups(array $data, \XF\Entity\User $user)
     {
          if (!empty($this->params['post']))
          {
               $user = $this->params['post']['User'];
               return $user && !$user->isMemberOf($data['user_group_ids']);
          }

          return true;
     }
     public function _matchPost(array $data, \XF\Entity\User $user)
     {
          if (!empty($this->params['post']))
          {
               $message = $this->removeBbCode($this->params['post']['message']);

               if (!preg_match('/\b' . implode('|', $this->getItemArray($data['message'])) . '\b/ui', $message))
               {
                    return false;
               }
          }

          return true;
     }
     public function _matchPostNot(array $data, \XF\Entity\User $user)
     {
          if (!empty($this->params['post']))
          {
               $message = $this->removeBbCode($this->params['post']['message']);

               if (preg_match('/\b' . implode('|', $this->getItemArray($data['message'])) . '\b/ui', $message))
               {
                    return false;
               }
          }

          return true;
     }
     public function _matchResourceId(array $data, \XF\Entity\User $user)
     {
          if (!empty($this->params['resource']))
          {
                $id = $this->params['resource']['resource_id'];

                if (!in_array($id, $this->getItemArray($data['id'])))
                {
                     return false;
                }
          }

          return true;
     }
     public function _matchResourceIdNot(array $data, \XF\Entity\User $user)
     {
          if (!empty($this->params['resource']))
          {
                $id = $this->params['resource']['resource_id'];

                if (in_array($id, $this->getItemArray($data['id'])))
                {
                     return false;
                }
          }

          return true;
     }
     public function _matchKeyword(array $data, \XF\Entity\User $user)
     {
          if (!empty($this->params['searchQuery']))
          {
               $query = $this->params['searchQuery'];

               if (!preg_match('/\b' . implode('|', $this->getItemArray($data['keyword'])) . '\b/ui', $query))
               {
                    return false;
               }
          }

          return true;
     }
     public function _matchKeywordNot(array $data, \XF\Entity\User $user)
     {
          if (!empty($this->params['searchQuery']))
          {
               $query = $this->params['searchQuery'];

               if (preg_match('/\b' . implode('|', $this->getItemArray($data['keyword'])) . '\b/ui', $query))
               {
                    return false;
               }
          }

          return true;
     }
     public function _matchMinimumResults(array $data, \XF\Entity\User $user)
     {
          if (isset($this->params['itemCount']))
          {
               return $this->params['itemCount'] >= $data['minimum'];
          }

          return true;
     }
     public function _matchMaximumResults(array $data, \XF\Entity\User $user)
     {
          if (isset($this->params['itemCount']) && $data['maximum'])
          {
               return $this->params['itemCount'] <= $data['maximum'];
          }

          return true;
     }
     public function _matchPageNumber(array $data, \XF\Entity\User $user)
     {
          if (!empty($data['number']))
          {
               $pageNumber = $this->getPageNumber();

               if ($data['number'] != $pageNumber)
               {
                    return false;
               }
          }

          return true;
     }
     public function _matchPageNumberNot(array $data, \XF\Entity\User $user)
     {
          if (!empty($data['number']))
          {
               $pageNumber = $this->getPageNumber();

               if ($data['number'] == $pageNumber)
               {
                    return false;
               }
          }

          return true;
     }
     public function _matchIsLastPage(array $data, \XF\Entity\User $user)
     {
          $options = \XF::options();

          if (!empty($this->params['thread']) || !empty($this->params['conversation']))
          {
               $entity     = $this->params['thread'] ?? $this->params['conversation'];

               $pageNumber = $this->getPageNumber();
     		$maxPage    = ceil(($entity->reply_count + 1) / $options->messagesPerPage);

               if ($pageNumber != $maxPage)
               {
                    return false;
               }
          }

          return true;
     }
     public function _matchThreadCustomFields(array $data, \XF\Entity\User $user)
     {
          $matched = true;

          $threadFileds = $this->params['thread']['custom_fields']->getFieldValues();

          foreach ($data as $key => $val)
          {
               if (!empty($val))
               {
                    $threadValue = $threadFileds[$key] ?? false;

                    if ($threadValue)
                    {
                         if (is_array($threadValue))
                         {
                              $matched = !empty(array_intersect($val, $threadValue));
                         }
                         else
                         {
                              if (is_numeric($threadValue))
                              {
                                   $isStars = \XF::db()->fetchOne('
                                        SELECT COUNT(*)
                                        FROM xf_thread_field
                                        WHERE field_id = ?
                                        AND field_type = "stars"', $key);

                                   if ($isStars)
                                   {
                                        $matched = true;
                                   }
                                   else
                                   {
                                        $matched = $val == $threadValue;
                                   }
                              }
                              else if (is_string($val))
                              {
                                   $matched = stripos($threadValue, $val) !== false;
                              }
                              else
                              {
                                   $matched = in_array($threadValue, $val);
                              }
                         }
                    }
                    else
                    {
                         $matched = false;
                    }
               }
          }

          return $matched;
     }
     public function _matchAmsArticleId(array $data, \XF\Entity\User $user)
     {
          if (!empty($this->params['article']))
          {
                $id = $this->params['article']['article_id'];

                if (!in_array($id, $this->getItemArray($data['id'])))
                {
                     return false;
                }
          }

          return true;
     }
     public function _matchAmsArticleIdNot(array $data, \XF\Entity\User $user)
     {
          if (!empty($this->params['article']))
          {
                $id = $this->params['article']['article_id'];

                if (in_array($id, $this->getItemArray($data['id'])))
                {
                     return false;
                }
          }

          return true;
     }
     public function _matchShowcaseId(array $data, \XF\Entity\User $user)
     {
          if (!empty($this->params['showcase']))
          {
                $id = $this->params['showcase']['item_id'];

                if (!in_array($id, $this->getItemArray($data['id'])))
                {
                     return false;
                }
          }

          return true;
     }
     public function _matchShowcaseIdNot(array $data, \XF\Entity\User $user)
     {
          if (!empty($this->params['showcase']))
          {
                $id = $this->params['showcase']['item_id'];

                if (in_array($id, $this->getItemArray($data['id'])))
                {
                     return false;
                }
          }

          return true;
     }
     public function getExtraTemplateData()
     {
          $prefixes = \XF::finder('XF:ThreadPrefix')
               ->order('materialized_order')
               ->fetch();

          $templateData = [
			'threadPrefixes' => $prefixes->groupBy('prefix_group_id')
		];

          return $templateData;
     }
     protected function getItemArray($items, $strToLower = false)
     {
          return \Siropu\AdsManager\Util\Arr::getItemArray($items, $strToLower);
     }
     protected function prepareTags($tags)
     {
          $list = [];

          foreach ($tags as $tag)
          {
               $list[] = $tag['tag'];
          }

          return $list;
     }
     protected function getPageNumber()
     {
          preg_match('/(\/page-([\d]+)|page=([\d]+))/', $this->app->request()->getFullRequestUri(), $match);
          return $match[2] ?? 1;
     }
     protected function removeBbCode($message)
     {
          return \XF::app()->stringFormatter()->stripBbCode($message);
     }
}
