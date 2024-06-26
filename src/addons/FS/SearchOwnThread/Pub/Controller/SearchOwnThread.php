<?php

namespace FS\SearchOwnThread\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Pub\Controller\AbstractController;

use XF\Util\Arr;

class SearchOwnThread extends AbstractController
{
    public function actionIndex(ParameterBag $params)
    {
        if (!(\XF::visitor()->user_id)) {
            return $this->noPermission();
        }

        $searchExist = $this->assertDataExists($params->id);

        if (!$searchExist) {
            return $this->notFound();
        }

        $this->assertNotEmbeddedImageRequest();

        $visitor = \XF::visitor();

        $filters = [
            'search_type' => 'str',
            'keywords' => 'str',
            'c' => 'array',
            'grouped' => 'bool',
            'order' => 'str'
        ];

        $input = [
            "search_type" => "post",
            "keywords" => "",
            "c" => [
                "users" => $visitor->username . ",",
                "newer_than" => $searchExist['newer_than'],
                "older_than" => $searchExist['older_than'],
                "min_reply_count" => $searchExist['min_reply_count'],
                "prefixes" => $searchExist['prefixes'],
                "nodes" => $searchExist['nodes'],
                "child_nodes" => "1"
            ],
            "grouped" => true,
            "order" => $searchExist['order']
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

    protected function prepareSearchQuery(array $data, &$urlConstraints = [])
    {
        $searchRequest = new \XF\Http\Request($this->app->inputFilterer(), $data, [], []);
        $input = $searchRequest->filter([
            'search_type' => 'str',
            'keywords' => 'str',
            'c' => 'array',
            'c.title_only' => 'uint',
            'c.newer_than' => 'datetime',
            'c.older_than' => 'datetime',
            'c.users' => 'str',
            'c.content' => 'str',
            'c.type' => 'str',
            'c.thread_type' => 'str',
            'grouped' => 'bool',
            'order' => 'str'
        ]);

        $urlConstraints = $input['c'];

        $searcher = $this->app()->search();
        $query = $searcher->getQuery();

        if ($input['search_type'] && $searcher->isValidContentType($input['search_type'])) {
            $typeHandler = $searcher->handler($input['search_type']);
            $query->forTypeHandler($typeHandler, $searchRequest, $urlConstraints);
        }

        if ($input['grouped']) {
            $query->withGroupedResults();
        }

        $input['keywords'] = $this->app->stringFormatter()->censorText($input['keywords'], '');
        if ($input['keywords']) {
            $query->withKeywords($input['keywords'], $input['c.title_only']);
        }

        if ($input['c.newer_than']) {
            $query->newerThan($input['c.newer_than']);
        } else {
            unset($urlConstraints['newer_than']);
        }
        if ($input['c.older_than']) {
            $query->olderThan($input['c.older_than']);
        } else {
            unset($urlConstraints['older_than']);
        }

        if ($input['c.users']) {
            $users = Arr::stringToArray($input['c.users'], '/,\s*/');
            if ($users) {
                /** @var \XF\Repository\User $userRepo */
                $userRepo = $this->repository('XF:User');
                $matchedUsers = $userRepo->getUsersByNames($users, $notFound);
                if ($notFound) {
                    $query->error(
                        'users',
                        \XF::phrase('following_members_not_found_x', ['members' => implode(', ', $notFound)])
                    );
                } else {
                    $query->byUserIds($matchedUsers->keys());
                    $urlConstraints['users'] = implode(', ', $users);
                }
            }
        }

        if ($input['c.content']) {
            $query->inType($input['c.content']);
        } else if ($input['c.type']) {
            $query->inType($input['c.content']);
        }

        if ($input['c.thread_type'] && $query->getTypes() == ['thread']) {
            $query->withMetadata('thread_type', $input['c.thread_type']);
        }

        if ($input['order']) {
            $query->orderedBy($input['order']);
        }

        return $query;
    }

    protected function runSearch(\XF\Search\Query\KeywordQuery $query, array $constraints, $allowCached = true)
    {
        $visitor = \XF::visitor();
        if (!$visitor->canSearch($error)) {
            return $this->noPermission($error);
        }

        /** @var \XF\Repository\Search $searchRepo */
        $searchRepo = $this->repository('XF:Search');
        $search = $searchRepo->runSearch($query, $constraints, $allowCached);

        if (!$search) {
            return $this->message(\XF::phrase('no_results_found'));
        }

        return $this->redirect($this->buildLink('search', $search), '');
    }

    /**
     * @param string $id
     * @param array|string|null $with
     * @param null|string $phraseKey
     *
     * @return \FS\SearchOwnThread\Entity\SearchOwnThread
     */
    protected function assertDataExists($id, array $extraWith = [], $phraseKey = null)
    {
        return $this->assertRecordExists('FS\SearchOwnThread:SearchOwnThread', $id, $extraWith, $phraseKey);
    }
}
