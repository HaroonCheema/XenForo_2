<?php

return function($__templater, $__selectedNav, array $__vars)
{
	$__tree = [];
	$__flat = [];

	\XF\Navigation\NodeType::configureDisplayExtended(11, "fs_questionAnswer_nav", [
		'title' => null,
		'with_children' => false,
		'attributes' => [],
	]);

	$__navTemp = [
		'title' => \XF::phrase('nav._default'),
		'href' => '',
		'attributes' => [],
	];
	if ($__navTemp) {
		$__tree['_default'] = $__navTemp;
		$__flat['_default'] =& $__tree['_default'];
		if (empty($__tree['_default']['children'])) { $__tree['_default']['children'] = []; }

		$__navTemp = [
		'title' => \XF::phrase('nav.defaultLatestActivity'),
		'href' => $__templater->func('link', array('whats-new/latest-activity', ), false),
		'attributes' => [],
	];
		if ($__navTemp) {
			$__tree['_default']['children']['defaultLatestActivity'] = $__navTemp;
			$__flat['defaultLatestActivity'] =& $__tree['_default']['children']['defaultLatestActivity'];
		}

		if ($__vars['xf']['visitor']['user_id']) {
			$__navTemp = [
		'title' => \XF::phrase('nav.defaultNewsFeed'),
		'href' => $__templater->func('link', array('whats-new/news-feed', ), false),
		'attributes' => [],
	];
			if ($__navTemp) {
				$__tree['_default']['children']['defaultNewsFeed'] = $__navTemp;
				$__flat['defaultNewsFeed'] =& $__tree['_default']['children']['defaultNewsFeed'];
			}
		}

		if ($__vars['xf']['visitor']['user_id']) {
			$__navTemp = [
		'title' => \XF::phrase('nav.defaultYourProfile'),
		'href' => $__templater->func('link', array('members', $__vars['xf']['visitor'], ), false),
		'attributes' => [],
	];
			if ($__navTemp) {
				$__tree['_default']['children']['defaultYourProfile'] = $__navTemp;
				$__flat['defaultYourProfile'] =& $__tree['_default']['children']['defaultYourProfile'];
			}
		}

		if ($__vars['xf']['visitor']['user_id']) {
			$__navTemp = [
		'title' => \XF::phrase('nav.defaultYourAccount'),
		'href' => $__templater->func('link', array('account', ), false),
		'attributes' => [],
	];
			if ($__navTemp) {
				$__tree['_default']['children']['defaultYourAccount'] = $__navTemp;
				$__flat['defaultYourAccount'] =& $__tree['_default']['children']['defaultYourAccount'];
			}
		}

		if (((!$__vars['xf']['visitor']['user_id']) AND $__vars['xf']['options']['registrationSetup']['enabled'])) {
			$__navTemp = [
		'title' => \XF::phrase('nav.defaultRegister'),
		'href' => $__templater->func('link', array('register', ), false),
		'attributes' => [],
	];
			if ($__navTemp) {
				$__tree['_default']['children']['defaultRegister'] = $__navTemp;
				$__flat['defaultRegister'] =& $__tree['_default']['children']['defaultRegister'];
			}
		}

		if ($__vars['xf']['visitor']['user_id']) {
			$__navTemp = [
		'title' => \XF::phrase('nav.defaultLogOut'),
		'href' => $__templater->func('link', array('logout', null, array('t' => $__templater->func('csrf_token', array(), false), ), ), false),
		'attributes' => [],
	];
			if ($__navTemp) {
				$__tree['_default']['children']['defaultLogOut'] = $__navTemp;
				$__flat['defaultLogOut'] =& $__tree['_default']['children']['defaultLogOut'];
			}
		}

	}

	$__navTemp = [
		'title' => \XF::phrase('nav.fsGameReviews'),
		'href' => $__templater->func('link', array('game-rating', ), false),
		'attributes' => [],
	];
	if ($__navTemp) {
		$__tree['fsGameReviews'] = $__navTemp;
		$__flat['fsGameReviews'] =& $__tree['fsGameReviews'];
		if (empty($__tree['fsGameReviews']['children'])) { $__tree['fsGameReviews']['children'] = []; }

		$__navTemp = [
		'title' => \XF::phrase('nav.fsPackageReview'),
		'href' => $__templater->func('link', array('package-rating/', ), false),
		'attributes' => [],
	];
		if ($__navTemp) {
			$__tree['fsGameReviews']['children']['fsPackageReview'] = $__navTemp;
			$__flat['fsPackageReview'] =& $__tree['fsGameReviews']['children']['fsPackageReview'];
		}

	}

	if ($__vars['xf']['homePageUrl']) {
		$__navTemp = [
		'title' => \XF::phrase('nav.home'),
		'href' => $__vars['xf']['homePageUrl'],
		'attributes' => [],
	];
		if ($__navTemp) {
			$__tree['home'] = $__navTemp;
			$__flat['home'] =& $__tree['home'];
		}
	}

	if (($__templater->method($__vars['xf']['visitor'], 'hasOption', array('hasDbEcommerce', )) AND $__templater->method($__vars['xf']['visitor'], 'canViewDbtechEcommerceProducts', array()))) {
		$__navTemp = [
		'title' => \XF::phrase('nav.dbtechEcommerce'),
		'href' => $__templater->func('link', array('dbtech-ecommerce', ), false),
		'attributes' => [],
	];
		if ($__navTemp) {
			$__tree['dbtechEcommerce'] = $__navTemp;
			$__flat['dbtechEcommerce'] =& $__tree['dbtechEcommerce'];
			if (empty($__tree['dbtechEcommerce']['children'])) { $__tree['dbtechEcommerce']['children'] = []; }

			if ($__vars['xf']['options']['dbtechEcommerceEnableRate']) {
				$__navTemp = [
		'title' => \XF::phrase('nav.dbtechEcommerceLatestReviews'),
		'href' => $__templater->func('link', array('dbtech-ecommerce/latest-reviews', ), false),
		'attributes' => [],
	];
				if ($__navTemp) {
					$__tree['dbtechEcommerce']['children']['dbtechEcommerceLatestReviews'] = $__navTemp;
					$__flat['dbtechEcommerceLatestReviews'] =& $__tree['dbtechEcommerce']['children']['dbtechEcommerceLatestReviews'];
				}
			}

			if ($__vars['xf']['visitor']['user_id']) {
				$__navTemp = [
		'title' => \XF::phrase('nav.dbtechEcommerceYourAccount'),
		'href' => $__templater->func('link', array('dbtech-ecommerce/account', $__vars['xf']['visitor'], ), false),
		'attributes' => [],
	];
				if ($__navTemp) {
					$__tree['dbtechEcommerce']['children']['dbtechEcommerceYourAccount'] = $__navTemp;
					$__flat['dbtechEcommerceYourAccount'] =& $__tree['dbtechEcommerce']['children']['dbtechEcommerceYourAccount'];
				}
			}

			if ($__vars['xf']['visitor']['user_id']) {
				$__navTemp = [
		'title' => \XF::phrase('nav.dbtechEcommerceYourPurchasedLicenses'),
		'href' => $__templater->func('link', array('dbtech-ecommerce/licenses', $__vars['xf']['visitor'], ), false),
		'attributes' => [],
	];
				if ($__navTemp) {
					$__tree['dbtechEcommerce']['children']['dbtechEcommerceYourPurchasedLicenses'] = $__navTemp;
					$__flat['dbtechEcommerceYourPurchasedLicenses'] =& $__tree['dbtechEcommerce']['children']['dbtechEcommerceYourPurchasedLicenses'];
				}
			}

			if ($__vars['xf']['visitor']['user_id']) {
				$__navTemp = [
		'title' => \XF::phrase('nav.dbtechEcommerceYourAddresses'),
		'href' => $__templater->func('link', array('dbtech-ecommerce/account/address-book', $__vars['xf']['visitor'], ), false),
		'attributes' => [],
	];
				if ($__navTemp) {
					$__tree['dbtechEcommerce']['children']['dbtechEcommerceYourAddresses'] = $__navTemp;
					$__flat['dbtechEcommerceYourAddresses'] =& $__tree['dbtechEcommerce']['children']['dbtechEcommerceYourAddresses'];
				}
			}

			if (($__vars['xf']['visitor']['user_id'] AND $__templater->method($__vars['xf']['visitor'], 'canAddDbtechEcommerceProduct', array()))) {
				$__navTemp = [
		'title' => \XF::phrase('nav.dbtechEcommerceYourCreatedProducts'),
		'href' => $__templater->func('link', array('dbtech-ecommerce/authors', $__vars['xf']['visitor'], ), false),
		'attributes' => [],
	];
				if ($__navTemp) {
					$__tree['dbtechEcommerce']['children']['dbtechEcommerceYourCreatedProducts'] = $__navTemp;
					$__flat['dbtechEcommerceYourCreatedProducts'] =& $__tree['dbtechEcommerce']['children']['dbtechEcommerceYourCreatedProducts'];
				}
			}

			if ($__vars['xf']['visitor']['user_id']) {
				$__navTemp = [
		'title' => \XF::phrase('nav.dbtechEcommerceWatched'),
		'href' => '',
		'attributes' => [],
	];
				if ($__navTemp) {
					$__tree['dbtechEcommerce']['children']['dbtechEcommerceWatched'] = $__navTemp;
					$__flat['dbtechEcommerceWatched'] =& $__tree['dbtechEcommerce']['children']['dbtechEcommerceWatched'];
					if (empty($__tree['dbtechEcommerce']['children']['dbtechEcommerceWatched']['children'])) { $__tree['dbtechEcommerce']['children']['dbtechEcommerceWatched']['children'] = []; }

					if ($__vars['xf']['visitor']['user_id']) {
						$__navTemp = [
		'title' => \XF::phrase('nav.dbtechEcommerceWatchedProducts'),
		'href' => $__templater->func('link', array('watched/ecommerce-products', ), false),
		'attributes' => [],
	];
						if ($__navTemp) {
							$__tree['dbtechEcommerce']['children']['dbtechEcommerceWatched']['children']['dbtechEcommerceWatchedProducts'] = $__navTemp;
							$__flat['dbtechEcommerceWatchedProducts'] =& $__tree['dbtechEcommerce']['children']['dbtechEcommerceWatched']['children']['dbtechEcommerceWatchedProducts'];
						}
					}

					if ($__vars['xf']['visitor']['user_id']) {
						$__navTemp = [
		'title' => \XF::phrase('nav.dbtechEcommerceWatchedCategories'),
		'href' => $__templater->func('link', array('watched/ecommerce-categories', ), false),
		'attributes' => [],
	];
						if ($__navTemp) {
							$__tree['dbtechEcommerce']['children']['dbtechEcommerceWatched']['children']['dbtechEcommerceWatchedCategories'] = $__navTemp;
							$__flat['dbtechEcommerceWatchedCategories'] =& $__tree['dbtechEcommerce']['children']['dbtechEcommerceWatched']['children']['dbtechEcommerceWatchedCategories'];
						}
					}

				}
			}

			if ($__templater->method($__vars['xf']['visitor'], 'canSearch', array())) {
				$__navTemp = [
		'title' => \XF::phrase('nav.dbtechEcommerceSearchProducts'),
		'href' => $__templater->func('link', array('search', null, array('type' => 'dbtech_ecommerce_product', ), ), false),
		'attributes' => [],
	];
				if ($__navTemp) {
					$__tree['dbtechEcommerce']['children']['dbtechEcommerceSearchProducts'] = $__navTemp;
					$__flat['dbtechEcommerceSearchProducts'] =& $__tree['dbtechEcommerce']['children']['dbtechEcommerceSearchProducts'];
				}
			}

		}
	}

	$__navTemp = [
		'title' => \XF::phrase('nav.forums'),
		'href' => $__templater->func('link', array('forums', ), false),
		'attributes' => [],
	];
	if ($__navTemp) {
		$__tree['forums'] = $__navTemp;
		$__flat['forums'] =& $__tree['forums'];
		if (empty($__tree['forums']['children'])) { $__tree['forums']['children'] = []; }

		if (($__vars['xf']['reply']['containerKey'] == ('node-' . $__vars['xf']['options']['fs_questionAnswerForum']))) {
			$__navTemp = [
		'title' => \XF::phrase('nav.fs_question_answers_newPosts'),
		'href' => $__templater->func('link', array('whats-new/questions', ), false),
		'attributes' => [],
	];
			if ($__navTemp) {
				$__tree['forums']['children']['fs_question_answers_newPosts'] = $__navTemp;
				$__flat['fs_question_answers_newPosts'] =& $__tree['forums']['children']['fs_question_answers_newPosts'];
			}
		}

		if (($__vars['xf']['options']['forumsDefaultPage'] != 'new_posts')) {
			$__navTemp = [
		'title' => \XF::phrase('nav.newPosts'),
		'href' => $__templater->func('link', array('whats-new/posts', ), false),
		'attributes' => [],
	];
			if ($__navTemp) {
				$__tree['forums']['children']['newPosts'] = $__navTemp;
				$__flat['newPosts'] =& $__tree['forums']['children']['newPosts'];
			}
		}

		if (($__vars['xf']['options']['forumsDefaultPage'] != 'forums')) {
			$__navTemp = [
		'title' => \XF::phrase('nav.forumList'),
		'href' => $__templater->func('link', array('forums/list', ), false),
		'attributes' => [],
	];
			if ($__navTemp) {
				$__tree['forums']['children']['forumList'] = $__navTemp;
				$__flat['forumList'] =& $__tree['forums']['children']['forumList'];
			}
		}

		if (($__vars['xf']['visitor']['user_id'] AND ($__vars['xf']['reply']['containerKey'] == ('node-' . $__vars['xf']['options']['fs_questionAnswerForum'])))) {
			$__navTemp = [
		'title' => \XF::phrase('nav.fs_question_answers_findThreads'),
		'href' => $__templater->func('link', array('forums/', ), false) . $__vars['xf']['options']['fs_questionAnswerForum'] . '&your_questions=1',
		'attributes' => [],
	];
			if ($__navTemp) {
				$__tree['forums']['children']['fs_question_answers_findThreads'] = $__navTemp;
				$__flat['fs_question_answers_findThreads'] =& $__tree['forums']['children']['fs_question_answers_findThreads'];
				if (empty($__tree['forums']['children']['fs_question_answers_findThreads']['children'])) { $__tree['forums']['children']['fs_question_answers_findThreads']['children'] = []; }

				if (($__vars['xf']['visitor']['user_id'] AND ($__vars['xf']['reply']['containerKey'] == ('node-' . $__vars['xf']['options']['fs_questionAnswerForum'])))) {
					$__navTemp = [
		'title' => \XF::phrase('nav.fs_question_answers_yourThreads'),
		'href' => $__templater->func('link', array('forums/', ), false) . $__vars['xf']['options']['fs_questionAnswerForum'] . '&your_questions=1',
		'attributes' => [],
	];
					if ($__navTemp) {
						$__tree['forums']['children']['fs_question_answers_findThreads']['children']['fs_question_answers_yourThreads'] = $__navTemp;
						$__flat['fs_question_answers_yourThreads'] =& $__tree['forums']['children']['fs_question_answers_findThreads']['children']['fs_question_answers_yourThreads'];
					}
				}

				if (($__vars['xf']['visitor']['user_id'] AND ($__vars['xf']['reply']['containerKey'] == ('node-' . $__vars['xf']['options']['fs_questionAnswerForum'])))) {
					$__navTemp = [
		'title' => \XF::phrase('nav.fs_question_answers_contributedQuestions'),
		'href' => $__templater->func('link', array('forums/', ), false) . $__vars['xf']['options']['fs_questionAnswerForum'] . '&your_answers=1',
		'attributes' => [],
	];
					if ($__navTemp) {
						$__tree['forums']['children']['fs_question_answers_findThreads']['children']['fs_question_answers_contributedQuestions'] = $__navTemp;
						$__flat['fs_question_answers_contributedQuestions'] =& $__tree['forums']['children']['fs_question_answers_findThreads']['children']['fs_question_answers_contributedQuestions'];
					}
				}

				if (($__vars['xf']['reply']['containerKey'] == ('node-' . $__vars['xf']['options']['fs_questionAnswerForum']))) {
					$__navTemp = [
		'title' => \XF::phrase('nav.fs_question_answers_unanswered'),
		'href' => $__templater->func('link', array('forums/', ), false) . $__vars['xf']['options']['fs_questionAnswerForum'] . '&unanswered=1',
		'attributes' => [],
	];
					if ($__navTemp) {
						$__tree['forums']['children']['fs_question_answers_findThreads']['children']['fs_question_answers_unanswered'] = $__navTemp;
						$__flat['fs_question_answers_unanswered'] =& $__tree['forums']['children']['fs_question_answers_findThreads']['children']['fs_question_answers_unanswered'];
					}
				}

			}
		}

		if ($__vars['xf']['visitor']['user_id']) {
			$__navTemp = [
		'title' => \XF::phrase('nav.findThreads'),
		'href' => $__templater->func('link', array('find-threads/started', ), false),
		'attributes' => [],
	];
			if ($__navTemp) {
				$__tree['forums']['children']['findThreads'] = $__navTemp;
				$__flat['findThreads'] =& $__tree['forums']['children']['findThreads'];
				if (empty($__tree['forums']['children']['findThreads']['children'])) { $__tree['forums']['children']['findThreads']['children'] = []; }

				if ($__vars['xf']['visitor']['user_id']) {
					$__navTemp = [
		'title' => \XF::phrase('nav.yourThreads'),
		'href' => $__templater->func('link', array('find-threads/started', ), false),
		'attributes' => [],
	];
					if ($__navTemp) {
						$__tree['forums']['children']['findThreads']['children']['yourThreads'] = $__navTemp;
						$__flat['yourThreads'] =& $__tree['forums']['children']['findThreads']['children']['yourThreads'];
					}
				}

				if ($__vars['xf']['visitor']['user_id']) {
					$__navTemp = [
		'title' => \XF::phrase('nav.contributedThreads'),
		'href' => $__templater->func('link', array('find-threads/contributed', ), false),
		'attributes' => [],
	];
					if ($__navTemp) {
						$__tree['forums']['children']['findThreads']['children']['contributedThreads'] = $__navTemp;
						$__flat['contributedThreads'] =& $__tree['forums']['children']['findThreads']['children']['contributedThreads'];
					}
				}

				$__navTemp = [
		'title' => \XF::phrase('nav.unansweredThreads'),
		'href' => $__templater->func('link', array('find-threads/unanswered', ), false),
		'attributes' => [],
	];
				if ($__navTemp) {
					$__tree['forums']['children']['findThreads']['children']['unansweredThreads'] = $__navTemp;
					$__flat['unansweredThreads'] =& $__tree['forums']['children']['findThreads']['children']['unansweredThreads'];
				}

			}
		}

		if ($__vars['xf']['visitor']['user_id']) {
			$__navTemp = [
		'title' => \XF::phrase('nav.watched'),
		'href' => $__templater->func('link', array('watched/threads', ), false),
		'attributes' => [],
	];
			if ($__navTemp) {
				$__tree['forums']['children']['watched'] = $__navTemp;
				$__flat['watched'] =& $__tree['forums']['children']['watched'];
				if (empty($__tree['forums']['children']['watched']['children'])) { $__tree['forums']['children']['watched']['children'] = []; }

				if ($__vars['xf']['visitor']['user_id']) {
					$__navTemp = [
		'title' => \XF::phrase('nav.watchedThreads'),
		'href' => $__templater->func('link', array('watched/threads', ), false),
		'attributes' => [],
	];
					if ($__navTemp) {
						$__tree['forums']['children']['watched']['children']['watchedThreads'] = $__navTemp;
						$__flat['watchedThreads'] =& $__tree['forums']['children']['watched']['children']['watchedThreads'];
					}
				}

				if ($__vars['xf']['visitor']['user_id']) {
					$__navTemp = [
		'title' => \XF::phrase('nav.watchedForums'),
		'href' => $__templater->func('link', array('watched/forums', ), false),
		'attributes' => [],
	];
					if ($__navTemp) {
						$__tree['forums']['children']['watched']['children']['watchedForums'] = $__navTemp;
						$__flat['watchedForums'] =& $__tree['forums']['children']['watched']['children']['watchedForums'];
					}
				}

				if ($__templater->method($__vars['xf']['visitor'], 'canWatchTag', array())) {
					$__navTemp = [
		'title' => \XF::phrase('nav.watchedTags'),
		'href' => $__templater->func('link', array('watched/tags', ), false),
		'attributes' => [],
	];
					if ($__navTemp) {
						$__tree['forums']['children']['watched']['children']['watchedTags'] = $__navTemp;
						$__flat['watchedTags'] =& $__tree['forums']['children']['watched']['children']['watchedTags'];
					}
				}

			}
		}

		if (($__vars['xf']['reply']['containerKey'] == ('node-' . $__vars['xf']['options']['fs_questionAnswerForum']))) {
			$__navTemp = [
		'title' => \XF::phrase('nav.fs_question_answers_searchForums'),
		'href' => $__templater->func('link', array('search', null, array('type' => 'questionAnswer', ), ), false),
		'attributes' => [],
	];
			if ($__navTemp) {
				$__tree['forums']['children']['fs_question_answers_searchForums'] = $__navTemp;
				$__flat['fs_question_answers_searchForums'] =& $__tree['forums']['children']['fs_question_answers_searchForums'];
			}
		}

		if ($__templater->method($__vars['xf']['visitor'], 'canSearch', array())) {
			$__navTemp = [
		'title' => \XF::phrase('nav.searchForums'),
		'href' => $__templater->func('link', array('search', null, array('type' => 'post', ), ), false),
		'attributes' => [],
	];
			if ($__navTemp) {
				$__tree['forums']['children']['searchForums'] = $__navTemp;
				$__flat['searchForums'] =& $__tree['forums']['children']['searchForums'];
			}
		}

		if ($__vars['xf']['visitor']['user_id']) {
			$__navTemp = [
		'title' => \XF::phrase('nav.markForumsRead'),
		'href' => $__templater->func('link', array('forums/mark-read', '-', array('date' => $__vars['xf']['time'], ), ), false),
		'attributes' => [
			'data-xf-click' => 'overlay',
		],
	];
			if ($__navTemp) {
				$__tree['forums']['children']['markForumsRead'] = $__navTemp;
				$__flat['markForumsRead'] =& $__tree['forums']['children']['markForumsRead'];
			}
		}

		if (($__vars['xf']['reply']['containerKey'] == ('node-' . $__vars['xf']['options']['fs_questionAnswerForum']))) {
			$__navTemp = [
		'title' => \XF::phrase('nav.fs_question_answers_markForumsRead'),
		'href' => $__templater->func('link', array('forums/', ), false) . $__vars['xf']['options']['fs_questionAnswerForum'] . '/mark-read&date=$xf.time',
		'attributes' => [
			'data-xf-click' => 'overlay',
		],
	];
			if ($__navTemp) {
				$__tree['forums']['children']['fs_question_answers_markForumsRead'] = $__navTemp;
				$__flat['fs_question_answers_markForumsRead'] =& $__tree['forums']['children']['fs_question_answers_markForumsRead'];
			}
		}

	}

	$__navTemp = [
		'title' => \XF::phrase('nav.whatsNew'),
		'href' => $__templater->func('link', array('whats-new', ), false),
		'attributes' => [],
	];
	if ($__navTemp) {
		$__tree['whatsNew'] = $__navTemp;
		$__flat['whatsNew'] =& $__tree['whatsNew'];
		if (empty($__tree['whatsNew']['children'])) { $__tree['whatsNew']['children'] = []; }

		$__navTemp = [
		'title' => \XF::phrase('nav.whatsNewPosts'),
		'href' => $__templater->func('link', array('whats-new/posts', ), false),
		'attributes' => [
			'rel' => 'nofollow',
		],
	];
		if ($__navTemp) {
			$__tree['whatsNew']['children']['whatsNewPosts'] = $__navTemp;
			$__flat['whatsNewPosts'] =& $__tree['whatsNew']['children']['whatsNewPosts'];
		}

		if ($__templater->method($__vars['xf']['visitor'], 'canViewMedia', array())) {
			$__navTemp = [
		'title' => \XF::phrase('nav.xfmgWhatsNewNewMedia'),
		'href' => $__templater->func('link', array('whats-new/media', ), false),
		'attributes' => [
			'rel' => 'nofollow',
		],
	];
			if ($__navTemp) {
				$__tree['whatsNew']['children']['xfmgWhatsNewNewMedia'] = $__navTemp;
				$__flat['xfmgWhatsNewNewMedia'] =& $__tree['whatsNew']['children']['xfmgWhatsNewNewMedia'];
			}
		}

		if ($__templater->method($__vars['xf']['visitor'], 'canViewMedia', array())) {
			$__navTemp = [
		'title' => \XF::phrase('nav.xfmgWhatsNewMediaComments'),
		'href' => $__templater->func('link', array('whats-new/media-comments', ), false),
		'attributes' => [
			'rel' => 'nofollow',
		],
	];
			if ($__navTemp) {
				$__tree['whatsNew']['children']['xfmgWhatsNewMediaComments'] = $__navTemp;
				$__flat['xfmgWhatsNewMediaComments'] =& $__tree['whatsNew']['children']['xfmgWhatsNewMediaComments'];
			}
		}

		$__navTemp = [
		'title' => \XF::phrase('nav.fs_new_questions'),
		'href' => $__templater->func('link', array('whats-new/questions', ), false),
		'attributes' => [],
	];
		if ($__navTemp) {
			$__tree['whatsNew']['children']['fs_new_questions'] = $__navTemp;
			$__flat['fs_new_questions'] =& $__tree['whatsNew']['children']['fs_new_questions'];
		}

		$__navTemp = [
		'title' => \XF::phrase('nav.fs_new_answers'),
		'href' => $__templater->func('link', array('whats-new/answers', ), false),
		'attributes' => [],
	];
		if ($__navTemp) {
			$__tree['whatsNew']['children']['fs_new_answers'] = $__navTemp;
			$__flat['fs_new_answers'] =& $__tree['whatsNew']['children']['fs_new_answers'];
		}

		if ($__templater->method($__vars['xf']['visitor'], 'canViewDbtechEcommerceProducts', array())) {
			$__navTemp = [
		'title' => \XF::phrase('nav.dbtEcomNewProducts'),
		'href' => $__templater->func('link', array('whats-new/ecommerce-products', ), false),
		'attributes' => [
			'rel' => 'nofollow',
		],
	];
			if ($__navTemp) {
				$__tree['whatsNew']['children']['dbtEcomNewProducts'] = $__navTemp;
				$__flat['dbtEcomNewProducts'] =& $__tree['whatsNew']['children']['dbtEcomNewProducts'];
			}
		}

		if ($__templater->method($__vars['xf']['visitor'], 'canViewResources', array())) {
			$__navTemp = [
		'title' => \XF::phrase('nav.xfrmNewResources'),
		'href' => $__templater->func('link', array('whats-new/resources', ), false),
		'attributes' => [
			'rel' => 'nofollow',
		],
	];
			if ($__navTemp) {
				$__tree['whatsNew']['children']['xfrmNewResources'] = $__navTemp;
				$__flat['xfrmNewResources'] =& $__tree['whatsNew']['children']['xfrmNewResources'];
			}
		}

		if ($__templater->method($__vars['xf']['visitor'], 'canViewProfilePosts', array())) {
			$__navTemp = [
		'title' => \XF::phrase('nav.whatsNewProfilePosts'),
		'href' => $__templater->func('link', array('whats-new/profile-posts', ), false),
		'attributes' => [
			'rel' => 'nofollow',
		],
	];
			if ($__navTemp) {
				$__tree['whatsNew']['children']['whatsNewProfilePosts'] = $__navTemp;
				$__flat['whatsNewProfilePosts'] =& $__tree['whatsNew']['children']['whatsNewProfilePosts'];
			}
		}

		if (($__vars['xf']['options']['enableNewsFeed'] AND $__vars['xf']['visitor']['user_id'])) {
			$__navTemp = [
		'title' => \XF::phrase('nav.whatsNewNewsFeed'),
		'href' => $__templater->func('link', array('whats-new/news-feed', ), false),
		'attributes' => [
			'rel' => 'nofollow',
		],
	];
			if ($__navTemp) {
				$__tree['whatsNew']['children']['whatsNewNewsFeed'] = $__navTemp;
				$__flat['whatsNewNewsFeed'] =& $__tree['whatsNew']['children']['whatsNewNewsFeed'];
			}
		}

		if ($__vars['xf']['options']['enableNewsFeed']) {
			$__navTemp = [
		'title' => \XF::phrase('nav.latestActivity'),
		'href' => $__templater->func('link', array('whats-new/latest-activity', ), false),
		'attributes' => [
			'rel' => 'nofollow',
		],
	];
			if ($__navTemp) {
				$__tree['whatsNew']['children']['latestActivity'] = $__navTemp;
				$__flat['latestActivity'] =& $__tree['whatsNew']['children']['latestActivity'];
			}
		}

		$__navTemp = [
		'title' => \XF::phrase('nav.BRATR_newThreadRatings'),
		'href' => $__templater->func('link', array('whats-new/thread-ratings', ), false),
		'attributes' => [
			'rel' => 'nofollow',
		],
	];
		if ($__navTemp) {
			$__tree['whatsNew']['children']['BRATR_newThreadRatings'] = $__navTemp;
			$__flat['BRATR_newThreadRatings'] =& $__tree['whatsNew']['children']['BRATR_newThreadRatings'];
		}

	}

	$__navTemp = [
		'title' => \XF::phrase('nav.fs_quiz'),
		'href' => $__templater->func('link', array('quiz', ), false),
		'attributes' => [],
	];
	if ($__navTemp) {
		$__tree['fs_quiz'] = $__navTemp;
		$__flat['fs_quiz'] =& $__tree['fs_quiz'];
	}

	if ($__templater->method($__vars['xf']['visitor'], 'canViewMedia', array())) {
		$__navTemp = [
		'title' => \XF::phrase('nav.xfmg'),
		'href' => $__templater->func('link', array('media', ), false),
		'attributes' => [],
	];
		if ($__navTemp) {
			$__tree['xfmg'] = $__navTemp;
			$__flat['xfmg'] =& $__tree['xfmg'];
			if (empty($__tree['xfmg']['children'])) { $__tree['xfmg']['children'] = []; }

			$__navTemp = [
		'title' => \XF::phrase('nav.xfmgNewMedia'),
		'href' => $__templater->func('link', array('whats-new/media', ), false),
		'attributes' => [
			'rel' => 'nofollow',
		],
	];
			if ($__navTemp) {
				$__tree['xfmg']['children']['xfmgNewMedia'] = $__navTemp;
				$__flat['xfmgNewMedia'] =& $__tree['xfmg']['children']['xfmgNewMedia'];
			}

			$__navTemp = [
		'title' => \XF::phrase('nav.xfmgNewComments'),
		'href' => $__templater->func('link', array('whats-new/media-comments', ), false),
		'attributes' => [
			'rel' => 'nofollow',
		],
	];
			if ($__navTemp) {
				$__tree['xfmg']['children']['xfmgNewComments'] = $__navTemp;
				$__flat['xfmgNewComments'] =& $__tree['xfmg']['children']['xfmgNewComments'];
			}

			if ($__templater->method($__vars['xf']['visitor'], 'canAddMedia', array())) {
				$__navTemp = [
		'title' => \XF::phrase('nav.xfmgAddMedia'),
		'href' => $__templater->func('link', array('media/add', ), false),
		'attributes' => [
			'data-xf-click' => 'overlay',
		],
	];
				if ($__navTemp) {
					$__tree['xfmg']['children']['xfmgAddMedia'] = $__navTemp;
					$__flat['xfmgAddMedia'] =& $__tree['xfmg']['children']['xfmgAddMedia'];
				}
			}

			if ($__vars['xf']['visitor']['user_id']) {
				$__navTemp = [
		'title' => \XF::phrase('nav.xfmgYourContent'),
		'href' => $__templater->func('link', array('media/users', $__vars['xf']['visitor'], ), false),
		'attributes' => [],
	];
				if ($__navTemp) {
					$__tree['xfmg']['children']['xfmgYourContent'] = $__navTemp;
					$__flat['xfmgYourContent'] =& $__tree['xfmg']['children']['xfmgYourContent'];
					if (empty($__tree['xfmg']['children']['xfmgYourContent']['children'])) { $__tree['xfmg']['children']['xfmgYourContent']['children'] = []; }

					if ($__vars['xf']['visitor']['user_id']) {
						$__navTemp = [
		'title' => \XF::phrase('nav.xfmgYourMedia'),
		'href' => $__templater->func('link', array('media/users', $__vars['xf']['visitor'], ), false),
		'attributes' => [],
	];
						if ($__navTemp) {
							$__tree['xfmg']['children']['xfmgYourContent']['children']['xfmgYourMedia'] = $__navTemp;
							$__flat['xfmgYourMedia'] =& $__tree['xfmg']['children']['xfmgYourContent']['children']['xfmgYourMedia'];
						}
					}

					if ($__vars['xf']['visitor']['user_id']) {
						$__navTemp = [
		'title' => \XF::phrase('nav.xfmgYourAlbums'),
		'href' => $__templater->func('link', array('media/albums/users', $__vars['xf']['visitor'], ), false),
		'attributes' => [],
	];
						if ($__navTemp) {
							$__tree['xfmg']['children']['xfmgYourContent']['children']['xfmgYourAlbums'] = $__navTemp;
							$__flat['xfmgYourAlbums'] =& $__tree['xfmg']['children']['xfmgYourContent']['children']['xfmgYourAlbums'];
						}
					}

				}
			}

			if ($__vars['xf']['visitor']['user_id']) {
				$__navTemp = [
		'title' => \XF::phrase('nav.xfmgWatchedContent'),
		'href' => $__templater->func('link', array('watched/media', ), false),
		'attributes' => [],
	];
				if ($__navTemp) {
					$__tree['xfmg']['children']['xfmgWatchedContent'] = $__navTemp;
					$__flat['xfmgWatchedContent'] =& $__tree['xfmg']['children']['xfmgWatchedContent'];
					if (empty($__tree['xfmg']['children']['xfmgWatchedContent']['children'])) { $__tree['xfmg']['children']['xfmgWatchedContent']['children'] = []; }

					if ($__vars['xf']['visitor']['user_id']) {
						$__navTemp = [
		'title' => \XF::phrase('nav.xfmgWatchedMedia'),
		'href' => $__templater->func('link', array('watched/media', ), false),
		'attributes' => [],
	];
						if ($__navTemp) {
							$__tree['xfmg']['children']['xfmgWatchedContent']['children']['xfmgWatchedMedia'] = $__navTemp;
							$__flat['xfmgWatchedMedia'] =& $__tree['xfmg']['children']['xfmgWatchedContent']['children']['xfmgWatchedMedia'];
						}
					}

					if ($__vars['xf']['visitor']['user_id']) {
						$__navTemp = [
		'title' => \XF::phrase('nav.xfmgWatchedAlbums'),
		'href' => $__templater->func('link', array('watched/media-albums', ), false),
		'attributes' => [],
	];
						if ($__navTemp) {
							$__tree['xfmg']['children']['xfmgWatchedContent']['children']['xfmgWatchedAlbums'] = $__navTemp;
							$__flat['xfmgWatchedAlbums'] =& $__tree['xfmg']['children']['xfmgWatchedContent']['children']['xfmgWatchedAlbums'];
						}
					}

					if ($__vars['xf']['visitor']['user_id']) {
						$__navTemp = [
		'title' => \XF::phrase('nav.xfmgWatchedCategories'),
		'href' => $__templater->func('link', array('watched/media-categories', ), false),
		'attributes' => [],
	];
						if ($__navTemp) {
							$__tree['xfmg']['children']['xfmgWatchedContent']['children']['xfmgWatchedCategories'] = $__navTemp;
							$__flat['xfmgWatchedCategories'] =& $__tree['xfmg']['children']['xfmgWatchedContent']['children']['xfmgWatchedCategories'];
						}
					}

				}
			}

			if ($__templater->method($__vars['xf']['visitor'], 'canSearch', array())) {
				$__navTemp = [
		'title' => \XF::phrase('nav.xfmgSearchMedia'),
		'href' => $__templater->func('link', array('search', null, array('type' => 'xfmg_media', ), ), false),
		'attributes' => [],
	];
				if ($__navTemp) {
					$__tree['xfmg']['children']['xfmgSearchMedia'] = $__navTemp;
					$__flat['xfmgSearchMedia'] =& $__tree['xfmg']['children']['xfmgSearchMedia'];
				}
			}

			if ($__vars['xf']['visitor']['user_id']) {
				$__navTemp = [
		'title' => \XF::phrase('nav.xfmgMarkViewed'),
		'href' => $__templater->func('link', array('media/mark-viewed', null, array('date' => $__vars['xf']['time'], ), ), false),
		'attributes' => [
			'data-xf-click' => 'overlay',
		],
	];
				if ($__navTemp) {
					$__tree['xfmg']['children']['xfmgMarkViewed'] = $__navTemp;
					$__flat['xfmgMarkViewed'] =& $__tree['xfmg']['children']['xfmgMarkViewed'];
				}
			}

		}
	}

	$__navTemp = [
		'title' => \XF::phrase('nav.fs_auction_category'),
		'href' => $__templater->func('link', array('auction', ), false),
		'attributes' => [],
	];
	if ($__navTemp) {
		$__tree['fs_auction_category'] = $__navTemp;
		$__flat['fs_auction_category'] =& $__tree['fs_auction_category'];
		if (empty($__tree['fs_auction_category']['children'])) { $__tree['fs_auction_category']['children'] = []; }

		$__navTemp = [
		'title' => \XF::phrase('nav.auctionAddListing'),
		'href' => $__templater->func('link', array('auction/add', ), false),
		'attributes' => [
			'data-xf-click' => 'overlay',
		],
	];
		if ($__navTemp) {
			$__tree['fs_auction_category']['children']['auctionAddListing'] = $__navTemp;
			$__flat['auctionAddListing'] =& $__tree['fs_auction_category']['children']['auctionAddListing'];
		}

	}

	$__navTemp = [
		'title' => \XF::phrase('nav.fs_escrow'),
		'href' => $__templater->func('link', array('escrow', ), false),
		'attributes' => [],
	];
	if ($__navTemp) {
		$__tree['fs_escrow'] = $__navTemp;
		$__flat['fs_escrow'] =& $__tree['fs_escrow'];
		if (empty($__tree['fs_escrow']['children'])) { $__tree['fs_escrow']['children'] = []; }

		$__navTemp = [
		'title' => \XF::phrase('nav.fs_escrow_add'),
		'href' => $__templater->func('link', array('escrow/add', ), false),
		'attributes' => [],
	];
		if ($__navTemp) {
			$__tree['fs_escrow']['children']['fs_escrow_add'] = $__navTemp;
			$__flat['fs_escrow_add'] =& $__tree['fs_escrow']['children']['fs_escrow_add'];
		}

	}

	if ($__templater->method($__vars['xf']['visitor'], 'canViewResources', array())) {
		$__navTemp = [
		'title' => \XF::phrase('nav.xfrm'),
		'href' => $__templater->func('link', array('resources', ), false),
		'attributes' => [],
	];
		if ($__navTemp) {
			$__tree['xfrm'] = $__navTemp;
			$__flat['xfrm'] =& $__tree['xfrm'];
			if (empty($__tree['xfrm']['children'])) { $__tree['xfrm']['children'] = []; }

			$__navTemp = [
		'title' => \XF::phrase('nav.xfrmLatestReviews'),
		'href' => $__templater->func('link', array('resources/latest-reviews', ), false),
		'attributes' => [],
	];
			if ($__navTemp) {
				$__tree['xfrm']['children']['xfrmLatestReviews'] = $__navTemp;
				$__flat['xfrmLatestReviews'] =& $__tree['xfrm']['children']['xfrmLatestReviews'];
			}

			if ($__vars['xf']['visitor']['user_id']) {
				$__navTemp = [
		'title' => \XF::phrase('nav.xfrmYourResources'),
		'href' => $__templater->func('link', array('resources/authors', $__vars['xf']['visitor'], ), false),
		'attributes' => [],
	];
				if ($__navTemp) {
					$__tree['xfrm']['children']['xfrmYourResources'] = $__navTemp;
					$__flat['xfrmYourResources'] =& $__tree['xfrm']['children']['xfrmYourResources'];
				}
			}

			if ($__vars['xf']['visitor']['user_id']) {
				$__navTemp = [
		'title' => \XF::phrase('nav.xfrmWatched'),
		'href' => $__templater->func('link', array('watched/resources', ), false),
		'attributes' => [],
	];
				if ($__navTemp) {
					$__tree['xfrm']['children']['xfrmWatched'] = $__navTemp;
					$__flat['xfrmWatched'] =& $__tree['xfrm']['children']['xfrmWatched'];
					if (empty($__tree['xfrm']['children']['xfrmWatched']['children'])) { $__tree['xfrm']['children']['xfrmWatched']['children'] = []; }

					if (($__vars['xf']['reply']['containerKey'] == ('node-' . $__vars['xf']['options']['fs_questionAnswerForum']))) {
						$__navTemp = [
		'title' => \XF::phrase('nav.fs_question_answers_watchedForums'),
		'href' => $__templater->func('link', array('watched/forums', ), false),
		'attributes' => [],
	];
						if ($__navTemp) {
							$__tree['xfrm']['children']['xfrmWatched']['children']['fs_question_answers_watchedForums'] = $__navTemp;
							$__flat['fs_question_answers_watchedForums'] =& $__tree['xfrm']['children']['xfrmWatched']['children']['fs_question_answers_watchedForums'];
						}
					}

					if ($__vars['xf']['visitor']['user_id']) {
						$__navTemp = [
		'title' => \XF::phrase('nav.xfrmWatchedResources'),
		'href' => $__templater->func('link', array('watched/resources', ), false),
		'attributes' => [],
	];
						if ($__navTemp) {
							$__tree['xfrm']['children']['xfrmWatched']['children']['xfrmWatchedResources'] = $__navTemp;
							$__flat['xfrmWatchedResources'] =& $__tree['xfrm']['children']['xfrmWatched']['children']['xfrmWatchedResources'];
						}
					}

					if ($__vars['xf']['visitor']['user_id']) {
						$__navTemp = [
		'title' => \XF::phrase('nav.xfrmWatchedCategories'),
		'href' => $__templater->func('link', array('watched/resource-categories', ), false),
		'attributes' => [],
	];
						if ($__navTemp) {
							$__tree['xfrm']['children']['xfrmWatched']['children']['xfrmWatchedCategories'] = $__navTemp;
							$__flat['xfrmWatchedCategories'] =& $__tree['xfrm']['children']['xfrmWatched']['children']['xfrmWatchedCategories'];
						}
					}

				}
			}

			if ($__templater->method($__vars['xf']['visitor'], 'canSearch', array())) {
				$__navTemp = [
		'title' => \XF::phrase('nav.xfrmSearchResources'),
		'href' => $__templater->func('link', array('search', null, array('type' => 'resource', ), ), false),
		'attributes' => [],
	];
				if ($__navTemp) {
					$__tree['xfrm']['children']['xfrmSearchResources'] = $__navTemp;
					$__flat['xfrmSearchResources'] =& $__tree['xfrm']['children']['xfrmSearchResources'];
				}
			}

		}
	}

	if ($__templater->method($__vars['xf']['visitor'], 'canViewMemberList', array())) {
		$__navTemp = [
		'title' => \XF::phrase('nav.members'),
		'href' => $__templater->func('link', array('members', ), false),
		'attributes' => [],
	];
		if ($__navTemp) {
			$__tree['members'] = $__navTemp;
			$__flat['members'] =& $__tree['members'];
			if (empty($__tree['members']['children'])) { $__tree['members']['children'] = []; }

			if ($__vars['xf']['options']['enableMemberList']) {
				$__navTemp = [
		'title' => \XF::phrase('nav.registeredMembers'),
		'href' => $__templater->func('link', array('members/list', ), false),
		'attributes' => [],
	];
				if ($__navTemp) {
					$__tree['members']['children']['registeredMembers'] = $__navTemp;
					$__flat['registeredMembers'] =& $__tree['members']['children']['registeredMembers'];
				}
			}

			$__navTemp = [
		'title' => \XF::phrase('nav.currentVisitors'),
		'href' => $__templater->func('link', array('online', ), false),
		'attributes' => [],
	];
			if ($__navTemp) {
				$__tree['members']['children']['currentVisitors'] = $__navTemp;
				$__flat['currentVisitors'] =& $__tree['members']['children']['currentVisitors'];
			}

			if ($__templater->method($__vars['xf']['visitor'], 'canViewProfilePosts', array())) {
				$__navTemp = [
		'title' => \XF::phrase('nav.newProfilePosts'),
		'href' => $__templater->func('link', array('whats-new/profile-posts', ), false),
		'attributes' => [
			'rel' => 'nofollow',
		],
	];
				if ($__navTemp) {
					$__tree['members']['children']['newProfilePosts'] = $__navTemp;
					$__flat['newProfilePosts'] =& $__tree['members']['children']['newProfilePosts'];
				}
			}

			if (($__templater->method($__vars['xf']['visitor'], 'canSearch', array()) AND $__templater->method($__vars['xf']['visitor'], 'canViewProfilePosts', array()))) {
				$__navTemp = [
		'title' => \XF::phrase('nav.searchProfilePosts'),
		'href' => $__templater->func('link', array('search', null, array('type' => 'profile_post', ), ), false),
		'attributes' => [],
	];
				if ($__navTemp) {
					$__tree['members']['children']['searchProfilePosts'] = $__navTemp;
					$__flat['searchProfilePosts'] =& $__tree['members']['children']['searchProfilePosts'];
				}
			}

		}
	}

	if ($__templater->method($__vars['xf']['visitor'], 'canViewDbtechCredits', array())) {
		$__navTemp = [
		'title' => \XF::phrase('nav.dbtechCredits'),
		'href' => $__templater->func('link', array('dbtech-credits', ), false),
		'attributes' => [],
	];
		if ($__navTemp) {
			$__tree['dbtechCredits'] = $__navTemp;
			$__flat['dbtechCredits'] =& $__tree['dbtechCredits'];
			if (empty($__tree['dbtechCredits']['children'])) { $__tree['dbtechCredits']['children'] = []; }

			$__navTemp = [
		'title' => \XF::phrase('nav.dbtechCreditsTransactions'),
		'href' => $__templater->func('link', array('dbtech-credits', ), false),
		'attributes' => [],
	];
			if ($__navTemp) {
				$__tree['dbtechCredits']['children']['dbtechCreditsTransactions'] = $__navTemp;
				$__flat['dbtechCreditsTransactions'] =& $__tree['dbtechCredits']['children']['dbtechCreditsTransactions'];
			}

		}
	}

	$__navTemp = [
		'title' => \XF::phrase('nav.createCrud'),
		'href' => $__templater->func('link', array('crud', ), false),
		'attributes' => [],
	];
	if ($__navTemp) {
		$__tree['createCrud'] = $__navTemp;
		$__flat['createCrud'] =& $__tree['createCrud'];
		if (empty($__tree['createCrud']['children'])) { $__tree['createCrud']['children'] = []; }

		$__navTemp = [
		'title' => \XF::phrase('nav.addRecord'),
		'href' => $__templater->func('link', array('crud/add', ), false),
		'attributes' => [],
	];
		if ($__navTemp) {
			$__tree['createCrud']['children']['addRecord'] = $__navTemp;
			$__flat['addRecord'] =& $__tree['createCrud']['children']['addRecord'];
		}

	}

	if ($__templater->method($__vars['xf']['visitor'], 'canViewMeeting', array())) {
		$__navTemp = [
		'title' => \XF::phrase('nav.fs_zoom_meetings'),
		'href' => $__templater->func('link', array('video-chat', ), false),
		'attributes' => [
			'target' => '"_blank"',
		],
	];
		if ($__navTemp) {
			$__tree['fs_zoom_meetings'] = $__navTemp;
			$__flat['fs_zoom_meetings'] =& $__tree['fs_zoom_meetings'];
		}
	}

	$__navTemp = \XF\Navigation\NodeType::displayNodeExtended(11, "fs_questionAnswer_nav");
	if ($__navTemp) {
		$__tree['fs_questionAnswer_nav'] = $__navTemp;
		$__flat['fs_questionAnswer_nav'] =& $__tree['fs_questionAnswer_nav'];
	}

	$__navTemp = [
		'title' => \XF::phrase('nav.xb_videos'),
		'href' => $__templater->func('link', array('videos', ), false),
		'attributes' => [],
	];
	if ($__navTemp) {
		$__tree['xb_videos'] = $__navTemp;
		$__flat['xb_videos'] =& $__tree['xb_videos'];
	}



	return [
		'tree' => $__tree,
		'flat' => $__flat
	];
};