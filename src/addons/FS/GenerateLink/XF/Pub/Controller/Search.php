<?php

namespace FS\GenerateLink\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Search extends XFCP_Search
{

    public function actionMember()
    {
        $this->assertNotEmbeddedImageRequest();

        $route = "search/member";

        $finder = $this->finder('XF:Navigation');

        $navExists = $finder->where("forum_ids", "!=", '')->where('enabled', 1)->where('route', 'LIKE', '%' . $finder->escapeLike($route) . '%')->fetchOne();

        $request = $this->app->request();

        $userIdGet = $request->get('user_id');

        if (!empty($userIdGet && $navExists)) {
            $user = $this->em()->find('XF:User', $userIdGet);

            $filters = [
                'search_type' => 'str',
                'c' => 'array',
            ];

            $input = [
                'search_type' => 'post',
                'c' => [
                    'users' => $user['username'],
                    'nodes' => count($navExists["forum_ids"]) ? $navExists["forum_ids"] : [],
                ],
            ];

            $constraintInput = [];

            foreach ($filters as $k => $type) {
                if (isset($constraintInput[$k])) {
                    $cleaned = $this->app->inputFilterer()->filter($constraintInput[$k], $type);
                    if (is_array($cleaned)) {
                        $input[$k] = array_merge($input[$k], $cleaned);
                    } else {
                        $input[$k] = $cleaned;
                    }
                }
            }

            $query = $this->prepareSearchQuery($input, $constraints);

            if ($query->getErrors()) {
                return $this->error($query->getErrors());
            }

            $searcher = $this->app->search();
            if ($searcher->isQueryEmpty($query, $error)) {
                return $this->error($error);
            }

            return $this->runSearch($query, $constraints);
        }

        return parent::actionMember();
    }
}
