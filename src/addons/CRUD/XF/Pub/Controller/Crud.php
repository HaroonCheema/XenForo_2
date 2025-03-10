<?php

namespace CRUD\XF\Pub\Controller;

// require __DIR__ . '/../../../vendor/autoload.php';

// // use FFMpeg\FFMpeg;
// // use FFMpeg\Coordinate\TimeCode;

// require 'vendor/autoload.php';

// use FFMpeg\FFMpeg;
// use FFMpeg\Coordinate\TimeCode;

use XF\Mvc\ParameterBag;
use XF\Pub\Controller\AbstractController;

use XF\Payment\Stripe;

use Doctrine\Common\Cache\CacheProvider;

use ZipArchive;



class Crud extends AbstractController
{
    /**
     * @var \Doctrine\Common\Cache\CacheProvider|null
     */
    protected $cache;

    protected $cacheIdPrefix = 'data_';
    protected $cacheLifeTime = 3600;

    protected $localData = [];

    // public function __construct(\Doctrine\Common\Cache\CacheProvider $cache = null)
    // {
    //     $this->cache = $cache;
    // }


    public function actionAbout(ParameterBag $params)
    {
        $user = $this->assertViewableUser($params->user_id);

        /** @var \XF\Repository\UserFollow $userFollowRepo */
        $userFollowRepo = $this->repository('XF:UserFollow');

        $following = [];
        $followingCount = 0;
        if ($user->Profile->following) {
            $userFollowingFinder = $userFollowRepo->findFollowingForProfile($user);
            $userFollowingFinder->order($userFollowingFinder->expression('RAND()'));

            $following = $userFollowingFinder->fetch(12)->pluckNamed('FollowUser');
            $followingCount = $userFollowingFinder->total();
        }

        $userFollowersFinder = $userFollowRepo->findFollowersForProfile($user);
        $userFollowersFinder->order($userFollowersFinder->expression('RAND()'));

        $followers = $userFollowersFinder->fetch(12)->pluckNamed('User');
        $followersCount = $userFollowersFinder->total();

        if ($this->options()->enableTrophies) {
            /** @var \XF\Repository\Trophy $trophyRepo */
            $trophyRepo = $this->repository('XF:Trophy');
            $trophies = $trophyRepo->findUserTrophies($user->user_id)
                ->with('Trophy')
                ->fetch();
        } else {
            $trophies = null;
        }

        /** @var \XF\Entity\User $user */
        $user = $this->assertRecordExists('XF:User', $params->user_id);

        /** @var \XFMG\ControllerPlugin\MediaList $mediaListPlugin */
        $mediaListPlugin = $this->plugin('XFMG:MediaList');

        $categoryParams = $mediaListPlugin->getCategoryListData();
        $viewableCategoryIds = $categoryParams['viewableCategories']->keys();

        $listParams = $mediaListPlugin->getMediaListData($viewableCategoryIds, $params->page, $user);

        $this->assertValidPage($listParams['page'], $listParams['perPage'], $listParams['totalItems'], 'media/users', $user);
        $this->assertCanonicalUrl($this->buildLink('media/users', $user, ['page' => $listParams['page']]));

        $viewParams = [
            'user' => $user,

            'following' => $following,
            'followingCount' => $followingCount,
            'followers' => $followers,
            'followersCount' => $followersCount,

            'trophies' => $trophies
        ] + $categoryParams + $listParams;
        return $this->view('XF:Member\About', 'member_about', $viewParams);
    }

    // Fatch all records from xf_crud database

    // http://localhost/xenforo/index.php?crud/

    protected function CheckRequestError($statusCode)
    {
        // if ($statusCode == 404) {
        //     throw new \XF\PrintableException(\XF::phrase('fs_bunny_request_not_found'));
        // } elseif ($statusCode == 401) {
        //     throw new \XF\PrintableException(\XF::phrase('fs_bunny_request_unauthorized'));
        // } elseif ($statusCode == 415) {
        //     throw new \XF\PrintableException(\XF::phrase('fs_bunny_request_unsported_media'));
        // } elseif ($statusCode == 400) {
        //     throw new \XF\PrintableException(\XF::phrase('fs_bunny_request_empty_body'));
        // } elseif ($statusCode == 405) {
        //     throw new \XF\PrintableException(\XF::phrase('fs_bunny_request_method_not_allowed'));
        // } elseif ($statusCode == 500) {
        //     throw new \XF\PrintableException(\XF::phrase('fs_bunny_request_server_error1'));
        // }
    }

    protected function convertMinutes($minutes)
    {

        // Convert minutes to hours
        $hours = floor($minutes / 60);
        // $remaining_minutes = $minutes % 60;

        // Convert hours to days
        $days = floor($hours / 24);
        // $remaining_hours = $hours % 24;

        // Convert days to months
        // Assuming 30 days per month (can be adjusted)
        $months = floor($days / 30);
        // $remaining_days = $days % 30;

        $viewParams = [
            'hours' => $hours,
            'days' => $days,
            'months' => $months,
        ];

        return $viewParams;
    }

    public function actionRepost(ParameterBag $params)
    {
        $post = $this->assertViewablePost($params->post_id, ['Thread.Prefix']);
        if (!$post->canEdit($error)) {
            return $this->noPermission($error);
        }

        $visitor = \XF::visitor();

        $secondary_group_ids = $visitor['secondary_group_ids'];
        $secondary_group_ids[] = $visitor['user_group_id'];

        $finder = $this->finder('FS\Limitations:Limitations')->where('user_group_id', $secondary_group_ids)->order('daily_ads', 'DESC')->fetchOne();

        $upgradeUrl = [
            'upgradeUrl' => $this->buildLink('account-upgrade/')
        ];

        if (!$finder) {
            throw $this->exception($this->notFound(\XF::phrase('fs_limitations_repost_not_permission', $upgradeUrl)));
        }

        $nodeIds = explode(",", $finder['node_ids']);

        if (!in_array($post->Thread->Forum->node_id, $nodeIds)) {
            throw $this->exception($this->notFound(\XF::phrase('fs_limitations_repost_not_permission', $upgradeUrl)));
        }

        if ($visitor['daily_ads'] >= $finder['daily_ads']) {
            throw $this->exception($this->notFound(\XF::phrase('fs_limitations_repost_limit_reached', $upgradeUrl)));
        }

        $thread = $post->Thread;

        if ($this->isPost()) {
        }


        if ($this->filter('_xfWithData', 'bool') && $this->filter('_xfInlineEdit', 'bool')) {


            $this->bumpThreadRepo()->bump($thread);
            $this->bumpThreadRepo()->log($thread->thread_id, $visitor->user_id);

            $increment = $visitor->daily_ads + 1;

            $visitor->fastUpdate('daily_ads', $increment);
        }
    }


    public function actionRedirect()
    {
        $visitor = \XF::visitor();
        $auth = $visitor->Auth->getAuthenticationHandler();
        if (!$auth) {
            return $this->noPermission();
        }

        if ($this->isPost()) {
            $visitor->fastUpdate('email', '');

            return $this->redirect($this->buildLink('account/account-details'));
        }

        $viewpParams = [
            'confirmUrl' => $this->buildLink('account/delete-email', $visitor),
            'contentTitle' => $visitor->email,
        ];

        return $this->view('XF\Account', 'fs_email_delete_confirm', $viewpParams);
    }

    function processWithMathJax($content)
    {
        // Generate JavaScript code for processing the math content using MathJax
        $jsCode = <<<EOD
	<script>
		// MathJax processing logic (replace this with your actual MathJax code)
		const formula = "$content";
		const processedFormula = MathJax.tex2chtml(formula);
		// Output the processed formula to the document
		document.write(processedFormula.outerHTML);
	</script>
	EOD;

        // Return the generated JavaScript code
        return $jsCode;
    }

    protected function setInCache($key, $value)
    {
        if ($this->cache) {
            $this->cache->save($this->getCacheId($key), $value, $this->cacheLifeTime);
        }
    }

    protected function getCacheId($key)
    {
        return $this->cacheIdPrefix . $key;
    }

    protected function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    // public function actionIndex(ParameterBag $params)
    // {
    //     // $text = "auction_Ends_At":"Option_1";

    //     // echo "<pre>";
    //     // var_dump($text);
    //     // exit;

    //     // $visitor = \XF::visitor();

    //     // $db = \XF::db();

    //     // // $sql = 'select sum(post_count) as answerCount from xf_thread_user_post where thread_id IN (' . $allQuestionThreadIds . ') AND user_id = ' . $user->user_id;
    //     // $sql = "SELECT * FROM xf_thread WHERE JSON_UNQUOTE(JSON_EXTRACT(custom_fields, '$.timezone')) = 'value1'";

    //     // $postCount = $db->query($sql)->fetchAll();

    //     // //         $qry = "SELECT * FROM xf_thread
    //     // // WHERE JSON_UNQUOTE(JSON_EXTRACT(custom_fields, '$.timezone')) = 'value1'
    //     // //   AND JSON_UNQUOTE(JSON_EXTRACT(custom_fields, '$.ships_via')) = '0'";
    //     // //         // $db->query($qry);

    //     // echo "<pre>";
    //     // var_dump($postCount);
    //     // // var_dump($db->query($qry)->fetch());
    //     // exit;

    //     // $secondaryGroupIds = $visitor['secondary_group_ids'];
    //     // $removeGroup = 10;

    //     // $tempGroup = $this->em()->create('FS\CancelMultipleSubscriptions:SubscriptionUserGroups');

    //     // $tempGroup->user_id = $visitor['user_id'];
    //     // $tempGroup->user_group_id = 10;
    //     // $tempGroup->end_at = time() + (30 * 60);
    //     // $tempGroup->save();

    //     // $newVal = 10;

    //     // array_push($secondaryGroupIds, $newVal);


    //     // $secondaryGroupIds = array_diff($secondaryGroupIds, [$removeGroup]);

    //     // Re-index the array if necessary
    //     // $secondaryGroupIds = array_values($secondaryGroupIds);

    //     // $visitor->fastUpdate('secondary_group_ids', $secondaryGroupIds);


    //     // echo "<pre>";
    //     // var_dump($secondaryGroupIds);
    //     // exit;

    //     // $providerId = "stripe";

    //     // $finder = \XF::finder('XF:PaymentProfile');
    //     // $paymentProfile = $finder
    //     //     ->where('provider_id', $providerId)
    //     //     ->fetchOne();

    //     // /** @var \XF\Entity\PaymentProvider $provider */
    //     // $provider = \XF::em()->find('XF:PaymentProvider', $providerId);

    //     // $handler = $provider->handler;

    //     // // $subscriptionId = "sub_1PQ5nvJcXHnOgcMNePpH0PB7";
    //     // // $subscriptionId = "sub_1PQ5nvJcXHnOgcMNePpH0PB7";
    //     // $subscriptionId = "sub_1PfJFfJcXHnOgcMNPz9DBdLo";

    //     // $cost_amount = 24.99;

    //     // $newAmount = intval(round($cost_amount * 100));

    //     // $handler->cancelDublicatedPaymentSubscription($paymentProfile, $subscriptionId, $newAmount);

    //     // echo "<pre>";
    //     // var_dump("Hello world");
    //     // exit;

    //     // // Variables to specify the length and unit of time
    //     // $length = 4;
    //     // $unit = 'month';

    //     // // Create a dynamic interval string
    //     // $interval = "+$length $unit";

    //     // echo "<pre>";
    //     // var_dump($interval);
    //     // exit;

    //     // // Old file name
    //     // $fileName = "1000_f_93860043_alqx2pxpwduqnwmg0kvfcal8f0mcuwfv";

    //     // $fileName = "ggssx-bg-blur.png";
    //     // // $fileName = "street-fighter.jpg";
    //     // // $fileName = "test3.jpeg";

    //     // // Get the file extension
    //     // $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

    //     // // Generate a new 10-character alphanumeric string
    //     // $newFileName = $this->generateRandomString(10);

    //     // // Replace the old file name with the new one
    //     // $fileName = $newFileName . '.' . $fileExtension;

    //     // echo "Original filename: $fileName\n";
    //     // echo "New random filename: $newFileName\n";

    //     // exit;
    //     $upgradeRepo = $this->repository('XF:UserUpgrade');
    //     list($available, $purchased) = $upgradeRepo->getFilteredUserUpgradesForList();

    //     if (!$available && !$purchased) {
    //         return $this->message(\XF::phrase('no_account_upgrades_can_be_purchased_at_this_time'));
    //     }

    //     if (\XF::visitor()->user_state != 'valid') {
    //         return $this->error(\XF::phrase('account_upgrades_cannot_be_purchased_account_unconfirmed'));
    //     }

    //     $finder = $this->finder('CRUD\XF:Crud');

    //     // ager filter search wala set hai to ye code chaley ga or is k ander wala function or code run ho ga
    //     if ($this->filter('search', 'uint')) {
    //         $finder = $this->getCrudSearchFinder();

    //         if (count($finder->getConditions()) == 0) {
    //             return $this->error(\XF::phrase('please_complete_required_field'));
    //         }
    //     }
    //     // nai to ye wala run ho ga code jo is ka defaul hai or sarey record show kerwaye ga
    //     else {
    //         $finder->order('id', 'DESC');
    //     }

    //     // echo "<pre>";
    //     // var_dump($purchased);
    //     // exit;

    //     $page = $params->page;
    //     $perPage = 1;

    //     $finder->limitByPage($page, $perPage);

    //     $viewParams = [
    //         'data' => $finder->fetch(),

    //         'page' => $page,
    //         'perPage' => $perPage,
    //         'total' => $finder->total(),

    //         'purchased' => $purchased,
    //         'available' => $available,

    //         // ager filter me koch search kia hai to wo is k zareiye hm input tag me show kerwa sakte hain
    //         'conditions' => $this->filterSearchConditions(),
    //     ];

    //     return $this->view('CRUD\XF:Crud\Index', 'crud_record_all', $viewParams);
    // }

    /**
     * @return \XF\Db\AbstractAdapter
     */
    public function db()
    {
        return \XF::em()->getDb();
    }

    // protected function monthlyGetScore()
    // {
    //     $options = \XF::options();

    //     $startDate = strtotime($options->fs_thread_start_date);
    //     $endDate = strtotime($options->fs_thread_end_date);

    //     $currentMonthUnix = strtotime(date("Y-m-01 00:00:00"));
    //     // $currentMonthUnix = '1725167466';

    //     if ($startDate && $endDate && ($endDate > $startDate)) {
    //         $postFinder = \XF::finder('XF:Post')->where('post_date', '>', $startDate)->where('post_date', '<', $endDate);
    //     } else {
    //         $postFinder = \XF::finder('XF:Post')->where('post_date', '>=', $currentMonthUnix);
    //     }

    //     $threadIds = $postFinder->pluckfrom('thread_id')->fetch()->toArray();

    //     $threadIds = array_unique($threadIds);

    //     $userIds = array();

    //     $options = \XF::options();

    //     $totalReplyPoints = intval($options->fs_post_reply_points);
    //     $totalWordsPoints = intval($options->fs_total_words_points);
    //     $totalPointsReactions = intval($options->fs_reply_reaction_points);

    //     $totalPointsThreads = intval($options->fs_thread_starter_points);
    //     $totalPointsSolutions = intval($options->fs_total_solution_points);

    //     $totalCounts = array();
    //     $userCounts = array();

    //     $userTotalCounts = array();

    //     if (count($threadIds)) {

    //         foreach ($threadIds as $key => $thread_id) {

    //             if ($startDate && $endDate && ($endDate > $startDate)) {
    //                 $posts = \XF::finder('XF:Post')->where('thread_id', $thread_id)->where('post_date', '>', $startDate)->where('post_date', '<', $endDate)->fetch();
    //             } else {
    //                 $posts = \XF::finder('XF:Post')->where('thread_id', $thread_id)->where('post_date', '>=', $currentMonthUnix)->fetch();
    //             }

    //             $totalCounts[$key]['Posts'] = 0;
    //             $totalCounts[$key]['Words'] = 0;
    //             $totalCounts[$key]['Reactions'] = 0;


    //             foreach ($posts as $post) {
    //                 if ($post->message_state == 'visible') {
    //                     $userId = $post->user_id;
    //                     $message = $post->message;
    //                     $reactions = $post->reaction_score;

    //                     $wordArray = str_word_count($message, 1);

    //                     $wordCount = count($wordArray);

    //                     $totalCounts[$key]['Posts'] += 1;
    //                     $totalCounts[$key]['Words'] += $wordCount;
    //                     $totalCounts[$key]['Reactions'] += $reactions;

    //                     if (isset($userCounts[$key][$userId])) {

    //                         $userCounts[$key][$userId]['Posts'] += 1;
    //                         $userCounts[$key][$userId]['Words'] += $wordCount;
    //                         $userCounts[$key][$userId]['Reactions'] += $reactions;
    //                     } else {
    //                         $userIds[$key] = $userId;

    //                         $userCounts[$key][$userId]['Posts'] = 1;
    //                         $userCounts[$key][$userId]['Words'] = $wordCount;
    //                         $userCounts[$key][$userId]['Reactions'] = $reactions;
    //                     }
    //                 }
    //             }

    //             foreach ($userCounts[$key] as $userKey => $value) {

    //                 if ($totalCounts[$key]['Posts']) {
    //                     $userPosts = $value['Posts'];

    //                     $percentageReply = ($userPosts / $totalCounts[$key]['Posts']) * 100;

    //                     $pointsFromPercentageReply = ($percentageReply / 100) * $totalReplyPoints;
    //                 } else {
    //                     $pointsFromPercentageReply = 0;
    //                 }

    //                 if ($totalCounts[$key]['Words']) {
    //                     $userWords = $value['Words'];

    //                     $percentageWords = ($userWords / $totalCounts[$key]['Words']) * 100;

    //                     $pointsFromPercentageWords = ($percentageWords / 100) * $totalWordsPoints;
    //                 } else {
    //                     $pointsFromPercentageWords = 0;
    //                 }

    //                 if ($totalCounts[$key]['Reactions']) {
    //                     $userReactions = $value['Reactions'];

    //                     $percentageReactions = ($userReactions / $totalCounts[$key]['Reactions']) * 100;

    //                     $pointsFromPercentageReactions = ($percentageReactions / 100) * $totalPointsReactions;
    //                 } else {
    //                     $pointsFromPercentageReactions = 0;
    //                 }

    //                 if (isset($userTotalCounts[$userKey])) {

    //                     $userTotalCounts[$userKey]['Post'] += $pointsFromPercentageReply;
    //                     $userTotalCounts[$userKey]['Word'] += $pointsFromPercentageWords;
    //                     $userTotalCounts[$userKey]['Reaction'] += $pointsFromPercentageReactions;
    //                 } else {

    //                     $userTotalCounts[$userKey]['Post'] = $pointsFromPercentageReply;
    //                     $userTotalCounts[$userKey]['Word'] = $pointsFromPercentageWords;
    //                     $userTotalCounts[$userKey]['Reaction'] = $pointsFromPercentageReactions;
    //                     $userTotalCounts[$userKey]['Thread'] = 0;
    //                     $userTotalCounts[$userKey]['Solution'] = 0;
    //                 }
    //             }
    //         }
    //     }


    //     if (count($userTotalCounts)) {

    //         $threadFinder = \XF::finder('XF:Thread')->where('thread_id',  $threadIds);

    //         $threadUserIds = $threadFinder->pluckfrom('user_id')->fetch()->toArray();

    //         if (count($threadUserIds)) {

    //             foreach ($threadUserIds as $UserId) {

    //                 $userTotalCounts[$UserId]['Thread'] += $totalPointsThreads;
    //             }
    //         }

    //         $threadSolutionFinder = \XF::finder('XF:ThreadQuestion')->where('thread_id',  $threadIds);

    //         $threadSolutionUserIds = $threadSolutionFinder->pluckfrom('solution_user_id')->fetch()->toArray();

    //         if (count($threadSolutionUserIds)) {

    //             foreach ($threadSolutionUserIds as $UserId) {

    //                 if ($UserId) {

    //                     $userTotalCounts[$UserId]['Solution'] += $totalPointsSolutions;
    //                 }
    //             }
    //         }
    //     }

    //     if (count($userTotalCounts)) {
    //         foreach ($userTotalCounts as $key => $value) {
    //             $userExist = \XF::finder('FS\ThreadScoringSystem:TotalScoringCustom')->where('user_id', $key)->fetchOne();

    //             if (!$userExist) {
    //                 $userExist = \XF::em()->create('FS\ThreadScoringSystem:TotalScoringCustom');
    //             }

    //             $totalScore = $value['Thread'] + $value['Post'] + $value['Word'] + $value['Reaction'] + $value['Solution'];

    //             $userExist->bulkSet([
    //                 'user_id' => $key,
    //                 'threads_score' => $value['Thread'],
    //                 'reply_score' => $value['Post'],
    //                 'worlds_score' => $value['Word'],
    //                 'reactions_score' => $value['Reaction'],
    //                 'solutions_score' => $value['Solution'],
    //                 'total_score' => $totalScore
    //             ]);

    //             $userExist->save();
    //         }

    //         $userIds = array_keys($userTotalCounts);

    //         $anotherUsersExist = \XF::finder('FS\ThreadScoringSystem:TotalScoringCustom')->where('user_id', '!=', $userIds)->fetch();

    //         if (count($anotherUsersExist)) {

    //             foreach ($anotherUsersExist as $value) {

    //                 $value->delete();
    //             }
    //         }
    //     }

    //     echo "<pre>";
    //     var_dump($userTotalCounts);
    //     exit;
    // }


    protected function getThreadsDataInZipFile()
    {

        // $tempDir = sys_get_temp_dir();
        // $zipFile = $tempDir . '/xenforo_exports.zip';
        // $zip = new ZipArchive();
        // $zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        $zipFile = 'xenforo_exports.zip';
        $zip = new ZipArchive();
        $zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        $files = [
            'xf_thread.csv' => [],
            'xf_post.csv' => [],
            'xf_attachments.csv' => [],
            'xf_attachment_data.csv' => []
        ];

        $threadId = 100;

        if ($threadId) {
            $threads = $this->finder('XF:Thread')->where('thread_id', $threadId)->fetch();

            if ($threads) {

                foreach ($threads as $key => $thread) {
                    $files['xf_thread.csv'][] = $thread;

                    $posts = $this->finder('XF:Post')->where('thread_id', $thread->thread_id)->fetch();

                    if ($posts) {
                        foreach ($posts as $key => $post) {
                            $files['xf_post.csv'][] = $post;

                            $attachments = $post['Attachments'];

                            if (count($attachments)) {

                                foreach ($attachments as $key => $attachment) {
                                    $attachmentData = $attachment['Data'];
                                    $files['xf_attachments.csv'][] = $attachment;


                                    $files['xf_attachment_data.csv'][] = $attachmentData;
                                }
                            }
                        }
                    }
                }
            }
        }

        // Create CSV Files
        foreach ($files as $fileName => $data) {
            $this->writeCsvFile($fileName, $data);
        }

        // Close ZIP and prepare download
        $zip->close();

        // Force download ZIP
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="xenforo_exports.zip"');
        header('Pragma: no-cache');
        header('Expires: 0');
        readfile($zipFile);
        exit;
    }

    protected function writeCsvFile($fileName, $data)
    {
        global $tempDir, $zip;

        if (empty($data)) return;

        $filePath = $tempDir . '/' . $fileName;
        $file = fopen($filePath, 'w');

        // Add header row
        fputcsv($file, array_keys($data[0]));

        // Add data rows
        foreach ($data as $row) {
            fputcsv($file, $row);
        }

        fclose($file);
        $zip->addFile($filePath, $fileName);
    }

    public function actionIndex(ParameterBag $params)
    {

        // $options = \XF::options();

        // $userIds = array_filter(array_map('trim', explode(',', $options->fs_random_username_user_ids)));

        // $getUsers = \XF::finder('XF:User')->where('user_id', $userIds)->fetch();


        // echo "<pre>";
        // var_dump($getUsers->count());
        // exit;

        // $user = \XF::finder('XF:User')->where('user_id',  678364405)->fetchOne();

        // $randomUsername = "testUser";

        /** @var \XF\Service\User\UsernameChange $service */
        // $service = \XF::service('XF:User\UsernameChange', $user);

        // $service->setNewUsername($randomUsername);
        // // $service->setChangeReason($reason);

        // if (!$service->validate($errors)) {
        //     return $this->error($errors);
        // }

        // /** @var \XF\Entity\UsernameChange $usernameChange */
        // $usernameChange = $service->save();

        // $usernameChange->change_state = 'approved';
        // $usernameChange->visible = true;

        // $usernameChange->save();

        // $usernameChange->rebuildLastVisibleUsernameChange();

        // $user->bulkSet([
        //     'username' => $randomUsername
        // ]);
        // $user->save();

        // echo "name changed";
        // exit;

        // $passwordChanged = false;

        // // $randomPassword = $reputationdServ->generateRandomPassword();
        // $randomPassword = "*Testing123#";

        // $passwordChange = $this->service('XF:User\PasswordChange', $user, $randomPassword);
        // if (!$passwordChange->isValid($error)) {
        //     echo "No";
        //     exit;
        //     // return $this->error($error);
        // }

        // $passwordChange->setInvalidateRememberKeys(false); // about to handle this
        // $passwordChange->save();

        // exit;

        // return $this->service('XF:User\PasswordChange', $user, $randomPassword);


        // /** @var \XF\Entity\UserAuth $userAuth */
        // $userAuth = $user->getRelationOrDefault('Auth');
        // if ($randomPassword && $user->exists()) {
        //     $userAuth->setPassword($randomPassword);

        //     echo "helo";

        //     $passwordChanged = true;
        // }

        // if ($passwordChanged) {

        //     \XF::repository('XF:UserRemember')->clearUserRememberRecords($user->user_id);
        //     echo "heloassad";
        // }
        // exit;
        // $this->getThreadsDataInZipFile();

        // exit;

        // $zipFile = 'xenforo_exports.zip';
        // $zip = new ZipArchive();
        // $zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        // $app = \XF::app(); // Get XenForo App
        // $db = $app->db();

        // $tables = [
        //     'xf_thread' => 'thread_id > 100',
        //     'xf_post' => 'post_id > 100',
        //     'xf_attachment' => 'attachment_id > 100'
        // ];

        // foreach ($tables as $tableName => $condition) {
        //     $rows = $db->fetchAll("SELECT * FROM {$tableName} WHERE {$condition}");
        //     if (!$rows) continue;

        //     $fileName = "{$tableName}.csv";
        //     $filePath = sys_get_temp_dir() . "/" . $fileName;

        //     $output = fopen($filePath, 'w');
        //     fputcsv($output, array_keys($rows[0]));
        //     foreach ($rows as $row) {
        //         fputcsv($output, $row);
        //     }
        //     fclose($output);

        //     $zip->addFile($filePath, $fileName);
        // }

        // $zip->close();

        // // Force download ZIP
        // header('Content-Type: application/zip');
        // header('Content-Disposition: attachment; filename="xenforo_exports.zip"');
        // header('Pragma: no-cache');
        // header('Expires: 0');
        // readfile($zipFile);
        // exit;

        // $app = \XF::app();
        // $db = $app->db();

        // $tableName = 'xf_thread';
        // $fileName = $tableName . '_filtered.csv';

        // $rows = $db->fetchAll("SELECT * FROM {$tableName} WHERE thread_id > ?", 100);

        // // Check if there are records
        // if (!$rows) {
        //     die('No records found with thread_id > 600.');
        // }

        // // Set headers to force CSV download
        // header('Content-Type: text/csv');
        // header('Content-Disposition: attachment; filename="' . $fileName . '"');
        // header('Pragma: no-cache');
        // header('Expires: 0');

        // $output = fopen('php://output', 'w');

        // // Get column names for CSV header
        // $header = array_keys($rows[0]);
        // fputcsv($output, $header);

        // // Add each row to the CSV
        // foreach ($rows as $row) {
        //     fputcsv($output, $row);
        // }

        // fclose($output);
        // exit; // Stop further execution

        // \XF[addonFlareForumStatsForumStatRepo]->renderForumStats('forum_list_above_nodes');

        // $app->repository('AddonFlare\ForumStats:ForumStat')

        // $app = \XF::app();

        // $app->repository('AddonFlare\ForumStats:ForumStat')->renderForumStats('forum_list_above_nodes');

        // echo "<pre>";
        // var_dump("Hello world");
        // exit;

        // $options = \XF::options();

        // $excludeForumIds = \XF::options()->fs_thread_scoring_system_exc_forms;


        // $conditions = [
        //     ['last_cron_run', 0],
        //     ['last_thread_update', '>', 'last_cron_run'],

        // ];

        // $threads = \XF::finder('XF:Thread')->where('node_id', '!=', $excludeForumIds)->whereOr($conditions)->total();

        // echo "<pre>";
        // var_dump($threads);
        // exit;




        // $pendingthreadsCount = \XF::finder('XF:Thread')->where('points_collected', true)->total();

        // if ($pendingthreadsCount) {

        //     $limit = 50;

        //     $endLimit = round($pendingthreadsCount / $limit) ?: 1;

        //     for ($i = 1; $i <= $endLimit; $i++) {
        //         $threads = \XF::finder('XF:Thread')->where('points_collected', true)->limitByPage($i, $limit)->fetch();

        //         var_dump($i, "ksdjfjkeldfsjewirsdkf;lkseopwrksdl;fkpoeskr");

        //         echo "<pre>";
        //         foreach ($threads as $key => $thread) {
        //             var_dump($key);
        //         }
        //     }
        // }

        // $excludeForumIds = \XF::options()->fs_thread_scoring_system_exc_forms;

        // // if (count($excludeForumIds)) {
        // $pendingthreadsCount = \XF::finder('XF:Thread')->where('points_collected', true)->where('node_id', '!=', $excludeForumIds)->total();
        // // } else {
        // //     $pendingthreadsCount = \XF::finder('XF:Thread')->where('points_collected', true)->total();
        // // }


        // echo "<pre>";
        // var_dump($endLimit, $pendingthreadsCount);
        // exit;


        // $app = \XF::app();
        // $jobID = "notable_member_total_points" . time();

        // $app->jobManager()->enqueueUnique($jobID, 'FS\ThreadScoringSystem:MonthWiseScore', [], true);
        // // // // $app->jobManager()->enqueueUnique($jobID, 'FS\ThreadScoringSystem:NotableMemberTotalPoints', [], true);

        // $app->jobManager()->runUnique($jobID, 120);
        // // $this->monthlyGetScore();

        // echo "<pre>";
        // var_dump("hello world");
        // exit;


        // $finder = \XF::finder('XF:Navigation')->where('navigation_id', 'forums')->fetchOne();

        // $finder->MasterTitle->bulkSet([
        //     'phrase_text' => "Community",
        // ]);
        // $finder->MasterTitle->save();

        // echo "<pre>";
        // var_dump($finder->MasterTitle->phrase_text);
        // exit;

        // $db = $this->db();
        // $db->beginTransaction();

        // $db = \XF::db();


        // $records = $this->finder('FS\ThreadScoringSystem:ScoringSystem')->where('thread_id', 826)->fetch();

        // $totalCounts = array();
        // $recordIds = array();

        // foreach ($records as  $value) {

        //     $userId = $value->user_id;

        //     // $usersPostCounts = array();

        //     if (isset($totalCounts[$userId]['totalPoints'])) {

        //         $totalCounts[$userId]['totalPoints'] += $value['points'];
        //     } else {
        //         $recordIds[] = $value->id;

        //         $totalCounts[$userId]['totalPoints'] = $value['points'];
        //     }

        //     // if ($value['points_type'] == 'reply') {
        //     //     # code...
        //     // }

        //     switch ($value['points_type']) {
        //         case 'reply': {
        //                 if (isset($totalCounts[$userId]['reply'])) {

        //                     $totalCounts[$userId]['reply'] += floatval($value['points']);
        //                 } else {
        //                     // $userIds[] = $userId;

        //                     $totalCounts[$userId]['reply'] = floatval($value['points']);
        //                 }
        //             }
        //             break;
        //         case 'words': {
        //                 if (isset($totalCounts[$userId]['words'])) {

        //                     $totalCounts[$userId]['words'] += $value['points'];
        //                 } else {
        //                     // $userIds[] = $userId;

        //                     $totalCounts[$userId]['words'] = $value['points'];
        //                 }
        //             }
        //             break;
        //         case 'reactions': {
        //                 if (isset($totalCounts[$userId]['reactions'])) {

        //                     $totalCounts[$userId]['reactions'] += $value['points'];
        //                 } else {
        //                     // $userIds[] = $userId;

        //                     $totalCounts[$userId]['reactions'] = $value['points'];
        //                 }
        //             }
        //             break;
        //         case 'thread': {
        //                 if (isset($totalCounts[$userId]['thread'])) {

        //                     $totalCounts[$userId]['thread'] += $value['points'];
        //                 } else {
        //                     // $userIds[] = $userId;

        //                     $totalCounts[$userId]['thread'] = $value['points'];
        //                 }
        //             }
        //             break;
        //             // default:
        //             //     $value = 0;
        //     }
        // }

        // echo "<pre>";
        // var_dump($recordIds, $totalCounts);

        // exit;

        // echo "<pre>";
        // var_dump($records);
        // exit;

        // $records =  $db->fetchAll(
        //     "SELECT thread_id , user_id , SUM(`points`) AS total_sum
        //     FROM fs_thread_scoring_system
        //     WHERE thread_id  = ?
        // ",
        //     [
        //         826,
        //     ]
        // );

        // $records = $db->fetchAll(
        //     "
        // 	SELECT thread_id, user_id, SUM(points) AS total_amount
        //     FROM fs_thread_scoring_system
        //     WHERE thread_id  = ?
        //     GROUP BY user_id
        // ",
        //     [
        //         826,
        //     ]
        // );


        //         SELECT product, SUM(amount) AS total_amount
        // FROM sales
        // GROUP BY product;


        // $records = $db->fetchAllColumn('
        // 		SELECT SUM(points) as total_amount
        // 		FROM fs_thread_scoring_system
        // 		GROUP BY user_id
        // 	');

        // foreach ($records as  $value) {

        //     echo "<pre>";
        //     var_dump($value->User);

        //     exit;
        // }

        // echo "<pre>";
        // var_dump($finder);
        // exit;

        //         SELECT name, SUM(amount) as total_amount
        // FROM your_table
        // GROUP BY name;


        $finder = $this->finder('CRUD\XF:Crud');

        // ager filter search wala set hai to ye code chaley ga or is k ander wala function or code run ho ga
        if ($this->filter('search', 'uint')) {
            $finder = $this->getCrudSearchFinder();

            if (count($finder->getConditions()) == 0) {
                return $this->error(\XF::phrase('please_complete_required_field'));
            }
        }
        // nai to ye wala run ho ga code jo is ka defaul hai or sarey record show kerwaye ga
        else {
            $finder->order('id', 'DESC');
        }

        // echo "<pre>";
        // var_dump($purchased);
        // exit;

        $page = $params->page;
        $perPage = 1;

        $finder->limitByPage($page, $perPage);

        $viewParams = [
            'data' => $finder->fetch(),

            'page' => $page,
            'perPage' => $perPage,
            'total' => $finder->total(),

            'purchased' => '',
            'available' => '',

            // ager filter me koch search kia hai to wo is k zareiye hm input tag me show kerwa sakte hain
            'conditions' => $this->filterSearchConditions(),
        ];

        return $this->view('CRUD\XF:Crud\Index', 'crud_record_all', $viewParams);
    }


    // public function actionIndex(ParameterBag $params)
    // {

    //     return $this->view('CRUD\XF:Crud\Index', 'crud_record_testing_pg_1', []);


    //     $this->app->response()->setCookie(
    //         'fs_lkdsjfklcxmv',
    //         123234434,
    //         \XF::$time + 86400 * 365
    //     );

    //     echo "hello world";

    //     exit;


    //     // $this->app()->response()->setCookie('dbtechEcommerceCartItems', 123, 86400 * 365);



    //     $getCook = $this->app()->response()->getCookie('dbtechEcommerceCartItems');

    //     var_dump($getCook);


    //     exit;

    //     $cache = \XF::app()->cache();

    //     $getValue = $cache->fetch("xf_cacheKey");

    //     echo $getValue;
    //     exit;

    //     // Set a value in the cache
    //     $key = 'testingKey';
    //     $value = 'hello world';
    //     $expiration = 3600; // 1 hour in seconds
    //     $cache->save($key, $value, $expiration);

    //     exit;

    //     // Check if the value was set successfully
    //     // if ($cache->isSuccessful()) {
    //     //     echo "Value was successfully set in the cache.";
    //     // } else {
    //     //     echo "Failed to set value in the cache.";
    //     // }


    //     $this->setInCache("testingValue", "hello world");

    //     // $this->cache->set("testingValue", "hello world");


    //     exit;

    //     return $this->view('CRUD\XF:Crud\Index', 'fs_guest_dialog_box', []);


    //     $request = \XF::app()->request()->getRequestUri();


    //     $parsedUri = parse_url($request);

    //     echo "<pre>";
    //     var_dump($parsedUri);
    //     exit;


    //     $visitor = \XF::visitor();

    //     $threadIds = explode(",", $this->options()->fs_thumbnail_applicable_threads);

    //     $threads = $this->finder('XF:Thread')->where('thread_id', $threadIds)->fetch();

    //     $viewParams = [
    //         'threads' => $threads,
    //     ];

    //     // echo "<pre>";
    //     // var_dump($viewParams);
    //     // exit;

    //     return $this->view('CRUD\XF:Crud\Index', 'crud_record_testing_pg_1', $viewParams);

    //     //         $testing = "[math]\int[/math]



    //     //         hello



    //     //         [math]\begin{align*} \int_a^b f(x) dx &= \lim_{n \to \infty} \sum_{i=1}^n f(a + i \Delta x) \Delta x \\ \frac{d}{dx} \sin(x) &= \cos(x) \end{align*}[/math]";



    //     //         $text = "[imath]\\alpha = \\beta \\gamma + \\delta[/imath]

    //     // [imath]\\alpha = \\beta \\gamma + \\delta \\epsilon[/imath]";

    //     //         // Regular expression to match the text between [imath] and [/imath] tags
    //     //         $regex = '/\[imath\](.*?)\[\/imath\]/s';

    //     //         if (preg_match_all($regex, $text, $matches)) {
    //     //             $innerTextArray = $matches[1]; // Extract the text between the tags
    //     //             foreach ($innerTextArray as $innerText) {
    //     //                 echo $innerText . "\n";
    //     //             }
    //     //         } else {
    //     //             echo "No matches found";
    //     //         }
    //     //         exit;

    //     //         echo "<pre>";
    //     //         var_dump($matches);

    //     //         exit;


    //     $equation = 'This is an equation: [math]\int f(x)[/math]';


    //     $pattern = '/\[math\]([^[]*?)\[\/math\]/';

    //     // Match the pattern in the equation string
    //     if (preg_match($pattern, $equation, $matches)) {
    //         // Extracted content is in $matches[1]
    //         $mathContent = $matches[1];

    //         // Process the math content using MathJax (replace this with your MathJax processing logic)
    //         $processedMathContent = $this->processWithMathJax($mathContent);

    //         // Output the processed math content
    //         echo "Processed math content: " . $processedMathContent;
    //     } else {
    //         // No match found
    //         echo "No math content found.";
    //     }

    //     exit;


    //     //         $testing = "[math]\int[/math]



    //     //         hello



    //     //         [math]\begin{align*} \int_a^b f(x) dx &= \lim_{n \to \infty} \sum_{i=1}^n f(a + i \Delta x) \Delta x \\ \frac{d}{dx} \sin(x) &= \cos(x) \end{align*}[/math]";



    //     //         $text = "[imath]\\alpha = \\beta \\gamma + \\delta[/imath]

    //     // [imath]\\alpha = \\beta \\gamma + \\delta \\epsilon[/imath]";

    //     //         // Regular expression to match the text between [imath] and [/imath] tags
    //     //         $regex = '/\[imath\](.*?)\[\/imath\]/s';

    //     //         if (preg_match_all($regex, $text, $matches)) {
    //     //             $innerTextArray = $matches[1]; // Extract the text between the tags
    //     //             foreach ($innerTextArray as $innerText) {
    //     //                 echo $innerText . "\n";
    //     //             }
    //     //         } else {
    //     //             echo "No matches found";
    //     //         }
    //     //         exit;

    //     //         echo "<pre>";
    //     //         var_dump($matches);

    //     //         exit;


    //     // return $this->view('CRUD\XF:Crud\Index', 'crud_record_testing_pg_1', []);

    //     // $user = \XF::app()->em()->find('XF:User', 1);
    //     // // $upgrade = \XF::app()->em()->find('XF:UserUpgrade', 3);

    //     // $mail = \XF::app()->mailer()->newMail()->setTo($user->email);
    //     // $mail->setTemplate('fs_bitcoin_integ_thanks_redirect_mail');
    //     // // $mail->setTemplate('fs_limitations_send_payment_confirm_male', [
    //     // //     'username' => $user->username,
    //     // //     'title' => $upgrade->title,
    //     // //     'price' => $upgrade->cost_amount,
    //     // // ]);
    //     // $mail->send();

    //     return $this->view('CRUD\XF:Crud\Index', 'crud_record_testing_pg_2', []);

    //     // $string = "members/testinguser.63/";

    //     // $pattern = "/^members\/[a-zA-Z0-9]+?\.\d+\/$/";

    //     // if (preg_match($pattern, $string)) {
    //     //     echo "String matches the pattern.";
    //     // } else {
    //     //     echo "String does not match the pattern.";
    //     // }


    //     // exit;



    //     $url = \xf::app()->request()->getFullRequestUri();

    //     $urI = \xf::app()->request()->getRequestUri();

    //     $parsedUrl = parse_url($url);

    //     $path = isset($parsedUrl['query']) ? $parsedUrl['query'] : '';


    //     echo "<pre>";
    //     var_dump($path);
    //     exit;

    //     // $mail = $this->app->mailer()->newMail()->setTo('software0house@gmail.com');
    //     // $mail->setTemplate('fs_limitations_admirer_mail');
    //     // // $mail->setTemplate('fs_limitations_companion_mail');
    //     // $mail->send();

    //     exit;

    //     $finder = $this->finder('FS\Limitations:Limitations')->fetch();

    //     if (count($finder) > 0) {

    //         $existed = false;

    //         foreach ($finder as $single) {
    //             $nodeIds = explode(",", $single['node_ids']);

    //             if (!in_array($forum->node_id, $nodeIds)) {
    //                 $existed = $single['user_group_id'];
    //             }
    //         }

    //         if ($existed) {
    //             if (!in_array($existed, $secondary_group_ids)) {
    //                 throw $this->exception($this->notFound(\XF::phrase('fs_limitations_daily_ads_not_permission', $upgradeUrl)));
    //             }
    //         }
    //     }


    //     echo '<pre>';
    //     var_dump($finder);
    //     exit;

    //     return $this->view('CRUD\XF:Crud\Index', 'crud_record_testing_pg_2', []);


    //     $params = [
    //         'product'    => 1,
    //         'context'    => "Hello World",
    //         'linkPrefix' => 786
    //     ];
    //     return \XF::app()->templater()->renderTemplate('public:crud_record_testing_pg_2', $params);

    //     // return \XF::app()->templater()->renderTemplate('admin:payment_profile_' . $this->providerId, $data);

    //     // $viewParams = [

    //     //     'customMessage' => isset($tag['children'][0]) ? $tag['children'][0] : 'Default message for media tags'
    //     // ];

    //     // return $renderer->getTemplater()->renderTemplate('public:fs_custom_message', $viewParams);

    //     echo "<pre>";
    //     var_dump((time() + 3600));
    //     exit;


    //     $visitor = \XF::visitor();

    //     // $conditions = [
    //     //     ['user_group_id', $value->current_userGroup],
    //     //     ['secondary_group_ids', 'LIKE', '%' . $value->current_userGroup . '%'],
    //     // ];

    //     // $secondary_group_ids = implode(",", $visitor['secondary_group_ids']);
    //     $secondary_group_ids = $visitor['secondary_group_ids'];
    //     $secondary_group_ids[] = $visitor['user_group_id'];

    //     $finder = $this->finder('FS\Limitations:Limitations')->where('user_group_id', $secondary_group_ids)->order('daily_repost', 'DESC')->fetchOne();

    //     if ($visitor['daily_repost'] >= $finder['daily_repost']) {
    //         throw $this->exception($this->notFound(\XF::phrase('fs_limitations_repost_not_permission', $upgradeUrl)));
    //     }

    //     var_dump($visitor['daily_repost']);
    //     var_dump($finder['daily_repost']);

    //     // if ($finder) {
    //     //     $nodeIds = explode(",", $finder['node_ids']);

    //     //     if (!in_array($post->Thread->Forum->node_id, $nodeIds)) {
    //     //         echo "hello world";
    //     //         exit;
    //     //     }
    //     // }



    //     // $users_names = explode(",", $user_name);

    //     echo "<pre>";
    //     // var_dump($nodeIds);
    //     var_dump($visitor['daily_repost']);
    //     var_dump($finder['daily_repost']);
    //     exit;


    //     // $user = \XF::visitor();
    //     // // $mailer = $this->app->mailer();

    //     // $mail = $this->app->mailer()->newMail()->setTo('software0house@gmail.com');
    //     // $mail->setTemplate('fs_bitcoin_send_approveAccount_mail', [
    //     //     'user' => $user
    //     // ]);
    //     // $mail->send();

    //     // echo "Sent mail to";
    //     // exit;

    //     // $this->app->mailer()->newMail()
    //     //     ->setTemplate('activity_summary')
    //     //     // ->setTemplate('activity_summary', [
    //     //     //     'renderedSections' => $instance->getRenderedSections(),
    //     //     //     'displayValues' => $instance->getDisplayValues()
    //     //     // ])
    //     //     ->setToUser($visitor)
    //     //     ->send();

    //     // $mail = $mailer->newMail();
    //     // $mail->setTo('software0house@gmail.com');
    //     // $mail->setContent(
    //     //     \XF::phrase('outbound_email_test_subject', ['board' => $this->options()->boardTitle])->render('raw'),
    //     //     \XF::phrase('outbound_email_test_body', ['username' => \XF::visitor()->username, 'board' => $this->options()->boardTitle])
    //     // );



    //     return $this->view('CRUD\XF:Crud\Index', 'crud_record_testing_only', []);

    //     $finder = $this->finder('CRUD\XF:Crud');

    //     // ager filter search wala set hai to ye code chaley ga or is k ander wala function or code run ho ga
    //     if ($this->filter('search', 'uint')) {
    //         $finder = $this->getCrudSearchFinder();

    //         if (count($finder->getConditions()) == 0) {
    //             return $this->error(\XF::phrase('please_complete_required_field'));
    //         }
    //     }
    //     // nai to ye wala run ho ga code jo is ka defaul hai or sarey record show kerwaye ga
    //     else {
    //         $finder->order('id', 'DESC');
    //     }

    //     $page = $params->page;
    //     $perPage = 3;

    //     $finder->limitByPage($page, $perPage);

    //     $viewParams = [
    //         'data' => $finder->fetch(),

    //         'page' => $page,
    //         'perPage' => $perPage,
    //         'total' => $finder->total(),

    //         // ager filter me koch search kia hai to wo is k zareiye hm input tag me show kerwa sakte hain
    //         'conditions' => $this->filterSearchConditions(),
    //     ];

    //     return $this->view('CRUD\XF:Crud\Index', 'crud_record_all', $viewParams);
    // }


    public function actionUpload()
    {
        $em = $this->app->em();

        /** @var \XF\Entity\AttachmentData $attachData */
        $attachData = $em->find('XF:AttachmentData', 330);
        $abstractedPath = $attachData->getAbstractedDataPath();

        $abstractedPath = "data://video/0/330-6ad3a94ff07e7210031a24eeb1f11849.mp4";

        $videoFile = $_FILES['bunny_video'];

        $tempFile = $videoFile['tmp_name'];

        $fileDataPath = 'data://CrudTesting/';

        $video = 'data://CrudTesting/Video.mp4';

        // Define the data stream path
        // $videoStreamPath = 'data://CrudTesting/Video.mp4';

        // Read the content of the data stream
        // $videoContents = file_get_contents($videoStreamPath);

        var_dump($videoFile);
        exit;


        $videoExtenion = pathinfo($videoFile['name'], PATHINFO_EXTENSION);

        // $moveVideo = \XF\Util\File::copyFileToAbstractedPath($videoFile['tmp_name'],  $fileDataPath . time() . "." . $videoExtenion);

        $thumbnailPath = $fileDataPath . time() . '_thumbnail.jpg';

        /** @var \XF\Service\Attachment\Preparer $insertService */
        $insertService = \XF::app()->service('XF:Attachment\Preparer');

        $tempThumb = $insertService->generateAttachmentThumbnail($tempFile, $thumbWidth, $thumbHeight);

        var_dump($tempThumb);
        exit;

        $db = $this->app->db();

        if ($tempThumb) {
            $db->beginTransaction();

            // $attachData->thumbnail_width = $thumbWidth;
            // $attachData->thumbnail_height = $thumbHeight;
            // $attachData->save(true, false);

            // $thumbPath = $attachData->getAbstractedThumbnailPath();
            try {
                $thumbIsSave = \XF\Util\File::copyFileToAbstractedPath($tempThumb, $thumbnailPath);
                $db->commit();
            } catch (\Exception $e) {
                $db->rollback();
                $this->app->logException($e, false, "Thumb rebuild for #: ");
            }
        }

        // Generate a video thumbnail using the PHP-FFMpeg library

        var_dump($thumbIsSave);
        exit;


        // Capture the video thumbnail using PHP-FFMpeg (new code)
        // $videoPath = $fileDataPath . basename($moveVideo); // Path to the uploaded video
        // $thumbnailPath = $fileDataPath . time() . '_thumbnail.jpg'; // Path to save the thumbnail

        // if (captureVideoThumbnail($videoPath, $thumbnailPath)) {
        //     // Thumbnail capture successful
        //     echo 'Video and thumbnail uploaded successfully.';
        // } else {
        //     // Thumbnail capture failed
        //     echo 'Error capturing video thumbnail.';
        // }

        // exit;
        // $ffmpegCommand = "ffmpeg -i " . escapeshellarg($videoFile['tmp_name']) . " -ss 00:00:02 -vframes 1 " . escapeshellarg($thumbnailPath);

        // exec($ffmpegCommand);

        // // var_dump(exec($ffmpegCommand));
        // // exit;

        // if (file_exists($thumbnailPath)) {
        //     $videoThumbnail = $thumbnailPath;
        // } else {
        //     $videoThumbnail = null;
        // }

        var_dump("videoThumbnail : " . $videoThumbnail);
        exit;

        $viewParams = [
            'status' => $moveVideo ?  true : false,
            'bunnyVideoId' => $createVideo ? $createVideo['guid'] : ''
        ];

        $this->setResponseType('json');
        $view = $this->view();
        $view->setJsonParam('data', $viewParams);
        return $view;
    }

    public function actionAdd()
    {
        // return $this->view('CRUD\XF:Crud\Index', 'crud_record_testing_pg_2', []);

        $crud = $this->em()->create('CRUD\XF:Crud');
        return $this->crudAddEdit($crud);
    }

    public function actionEdit(ParameterBag $params)
    {
        $crud = $this->assertDataExists($params->id);
        return $this->crudAddEdit($crud);
    }

    protected function crudAddEdit(\CRUD\XF\Entity\Crud $crud)
    {
        $viewParams = [
            'crud' => $crud
        ];

        return $this->view('CRUD\XF:Crud\Add', 'crud_record_insert', $viewParams);
    }

    public function actionSave(ParameterBag $params)
    {
        if ($params->id) {
            $crud = $this->assertDataExists($params->id);
        } else {
            $crud = $this->em()->create('CRUD\XF:Crud');
        }

        $this->crudSaveProcess($crud)->run();

        return $this->redirect($this->buildLink('crud'));
    }

    protected function crudSaveProcess(\CRUD\XF\Entity\Crud $crud)
    {
        $input = $this->filter([
            'name' => 'str',
            'class' => 'str',
            'rollNo' => 'int',
        ]);

        $form = $this->formAction();
        $form->basicEntitySave($crud, $input);

        return $form;
    }

    public function actionDeleteRecord(ParameterBag $params)
    {
        $replyExists = $this->assertDataExists($params->id);

        /** @var \XF\ControllerPlugin\Delete $plugin */
        $plugin = $this->plugin('XF:Delete');
        return $plugin->actionDelete(
            $replyExists,
            $this->buildLink('crud/delete-record', $replyExists),
            null,
            $this->buildLink('crud'),
            "{$replyExists->id} - {$replyExists->name}"
        );
    }

    // plugin for check id exists or not 

    /**
     * @param string $id
     * @param array|string|null $with
     * @param null|string $phraseKey
     *
     * @return \CRUD\XF\Entity\Crud
     */
    protected function assertDataExists($id, array $extraWith = [], $phraseKey = null)
    {
        return $this->assertRecordExists('CRUD\XF:Crud', $id, $extraWith, $phraseKey);
    }

    // filter bar k input tag k ander value ko get or set krney k liye ye method call kr rahey hain

    protected function filterSearchConditions()
    {
        return $this->filter([
            'name' => 'str',
            'rClass' => 'str',
            'rollNo' => 'str',
        ]);
    }

    // filter wala form show kerwaney k liye ye use ho ga

    public function actionRefineSearch()
    {

        $viewParams = [
            'conditions' => $this->filterSearchConditions(),
        ];

        return $this->view('CRUD\XF:Crud\RefineSearch', 'crud_record_search_filter', $viewParams);
    }

    // ider hm condition apply kr rahey hain kr filter me koi ho gi to or wapis index waley function me return kr k result ko show kerwa rahey hain

    protected function getCrudSearchFinder()
    {
        $conditions = $this->filterSearchConditions();

        $finder = $this->finder('CRUD\XF:Crud');

        if ($conditions['name'] != '') {
            $finder->where('name', 'LIKE', '%' . $finder->escapeLike($conditions['name']) . '%');
        }

        if ($conditions['rClass'] != '') {
            $finder->where('class', 'LIKE', '%' . $finder->escapeLike($conditions['rClass']) . '%');
        }

        if ($conditions['rollNo'] != '') {
            $finder->where('rollNo', 'LIKE', '%' . $finder->escapeLike($conditions['rollNo']) . '%');
        }

        return $finder;
    }
}
