<?php

namespace FS\ArticleSearch\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Search extends XFCP_Search
{

	public function actionArticleSearch()
	{

		$this->assertNotEmbeddedImageRequest();

		$visitor = \XF::visitor();
		if (!$visitor->canSearch($error)) {
			return $this->noPermission($error);
		}

		$filters = [
			'search_type' => 'str',
			'keywords' => 'str',
			'c' => 'array',
			'grouped' => 'bool',
			'order' => 'str'
		];

		$input = $this->filter($filters);

		$input['order'] = 'date';

		$constraintInput = $this->filter('constraints', 'json-array');
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

		return $this->runArticleSearch($query, $constraints);
	}

	protected function runArticleSearch(\XF\Search\Query\KeywordQuery $query, array $constraints, $allowCached = true)
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

		return $this->redirect($this->buildLink('search/article-search-result', $search), '');
	}

	public function actionArticleSearchResult(ParameterBag $params)
	{

		if ($params->search_id && !$this->filter('searchform', 'bool')) {
			return $this->rerouteController(__CLASS__, 'article-results', $params);
		}

		$this->assertNotEmbeddedImageRequest();

		$visitor = \XF::visitor();
		if (!$visitor->canSearch($error)) {
			return $this->noPermission($error);
		}

		$input = $this->convertShortSearchInputNames();

		$searcher = $this->app->search();
		$type = $input['search_type'] ?: $this->filter('type', 'str');

		$viewParams = [
			'tabs' => $searcher->getSearchTypeTabs(),
			'type' => $type,
			'isRelevanceSupported' => $searcher->isRelevanceSupported(),
			'input' => $input
		];

		// echo "<pre>";
		// var_dump($viewParams);
		// exit;

		$typeHandler = null;
		if ($type && $searcher->isValidContentType($type)) {
			$typeHandler = $searcher->handler($type);
			if (!$typeHandler->getSearchFormTab()) {
				$typeHandler = null;
			}
		}

		if ($typeHandler) {
			if ($sectionContext = $typeHandler->getSectionContext()) {
				$this->setSectionContext($sectionContext);
			}

			$viewParams = array_merge($viewParams, $typeHandler->getSearchFormData());
			$templateName = $typeHandler->getTypeFormTemplate();
		} else {
			$viewParams['type'] = '';
			$templateName = 'search_form_all';
		}

		$viewParams['formTemplateName'] = $templateName;

		return $this->view('XF:Search\Form', 'search_form', $viewParams);
	}

	public function actionArticleResults(ParameterBag $params)
	{
		$this->assertNotEmbeddedImageRequest();

		/** @var \XF\Entity\Search $search */
		$search = $this->em()->find('XF:Search', $params->search_id);
		if (!$search || $search->user_id != \XF::visitor()->user_id) {
			if (!$this->filter('q', 'str')) {
				return $this->notFound();
			}

			$searchData = $this->convertShortSearchInputNames();
			$query = $this->prepareSearchQuery($searchData, $constraints);
			if ($query->getErrors()) {
				return $this->notFound();
			}

			return $this->runSearch($query, $constraints);
		}

		$page = $this->filterPage();
		$perPage = $this->options()->searchResultsPerPage;

		$this->assertValidPage($page, $perPage, $search->result_count, 'search', $search);

		$searcher = $this->app()->search();
		$resultSet = $searcher->getResultSet($search->search_results);

		$resultSet->sliceResultsToPage($page, $perPage);

		if (!$resultSet->countResults()) {
			return $this->message(\XF::phrase('no_results_found'));
		}

		$maxPage = ceil($search->result_count / $perPage);

		if (
			$search->search_order == 'date'
			&& $search->result_count > $perPage
			&& $page == $maxPage
		) {
			$lastResult = $resultSet->getLastResultData($lastResultType);
			$getOlderResultsDate = $searcher->handler($lastResultType)->getResultDate($lastResult);
		} else {
			$getOlderResultsDate = null;
		}

		$resultOptions = [
			'search' => $search,
			'term' => $search->search_query
		];
		$resultsWrapped = $searcher->wrapResultsForRender($resultSet, $resultOptions);

		$modTypes = [];
		foreach ($resultsWrapped as $wrapper) {
			$handler = $wrapper->getHandler();
			$entity = $wrapper->getResult();
			if ($handler->canUseInlineModeration($entity)) {
				$type = $handler->getContentType();
				if (!isset($modTypes[$type])) {
					$modTypes[$type] = $this->app->getContentTypePhrase($type);
				}
			}
		}

		$mod = $this->filter('mod', 'str');
		if ($mod && !isset($modTypes[$mod])) {
			$mod = '';
		}

		$viewParams = [
			'search' => $search,
			'results' => $resultsWrapped,

			'page' => $page,
			'perPage' => $perPage,

			'modTypes' => $modTypes,
			'activeModType' => $mod,

			'getOlderResultsDate' => $getOlderResultsDate
		];
		return $this->view('XF:Search\Results', 'fs_article_search_results', $viewParams);
	}
}
