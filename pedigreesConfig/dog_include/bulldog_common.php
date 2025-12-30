<?php
define('__XF__', dirname(__DIR__, 2));

// Include the core XenForo file
require __XF__ . '/src/XF.php';

\XF::start(__XF__);

$app = \XF::setupApp('XF\Pub\App');


$request = $app->request();
$session = $app->session();
$db = \XF::db();
$visitor = \XF::em()->find('XF:User', $app->session()->get('userId'));
$sourceDb = \ScriptsPages\Setup::dbConnection('visegrip_database', 'admin', 'admin123');
// $sourceDb = \ScriptsPages\Setup::dbConnection('visegrip_database', 'natebull_forums_user', 'kw%=NJPb+*D7Cc4jGK');

// $baseurl = 'http://localhost/xenforo/';
$baseurl = 'https://www.thepitbullbible.com/xf/';
// Key page URL's
$url_search				= "http://$baseurl" . "bulldog_dogs_search.php";
$url_search2       		= "http://$baseurl" . "bulldog_dogs_search2.php";
$url_assistant       	= "http://$baseurl" . "bulldog_assistant.php";
$url_details      		= "http://$baseurl" . "bulldog_details.php";
$url_profile      		= "http://$baseurl" . "bulldog_dogs_profile.php";
$url_breeders     		= "http://$baseurl" . "bulldog_breeders.php";
$url_owners       		= "http://$baseurl" . "bulldog_owners.php";
$url_owners2       		= "http://$baseurl" . "bulldog_owners2.php";
$url_addsire      		= "http://$baseurl" . "bulldog_addsire.php";
$url_adddam       		= "http://$baseurl" . "bulldog_adddam.php";
$url_adddog       		= "http://$baseurl" . "bulldog_add.php";
$url_addbreeder   		= "http://$baseurl" . "bulldog_addbreeder.php";
$url_addowner     		= "http://$baseurl" . "bulldog_addowner.php";
$url_upload       		= "http://$baseurl" . "bulldog_upload.php";
$url_log          		= "http://$baseurl" . "bulldog_log.php";
$url_offspring       	= "http://$baseurl" . "bulldog_offspring.php";
$url_relatives    		= "http://$baseurl" . "bulldog_relatives.php";
$url_register     		= "http://$baseurl" . "register.php";
$url_subscribe    		= "http://$baseurl" . "payments.php";
$url_banned       		= "http://$baseurl";
$url_testbreeding 		= "http://$baseurl" . "bulldog_testbreeding.php";
$url_pics         		= "http://$baseurl/pics";
$url_search_breedings 	= "http://$baseurl" . "bulldog_searchbreedings.php";
$url_delete             = "http://$baseurl" . "bulldog_delete.php";
$url_member				= "http://$baseurl" . "member.php";
$url_core				= "http://$baseurl" . "bulldog_core.php";
$url_change_owner		= "http://$baseurl" . "bulldog_change_owner.php";
$url_breeders_profile	= "http://$baseurl" . "bulldog_breeders_profile.php";
$url_breeders_view		= "http://$baseurl" . "bulldog_breeders_view.php";
$url_breeders_add		= "http://$baseurl" . "bulldog_breeders_add.php";
$url_breeders_stats		= "http://$baseurl" . "bulldog_breeders_stats.php";
$url_owners_profile		= "http://$baseurl" . "bulldog_owners_profile.php";
$url_owners_view		= "http://$baseurl" . "bulldog_owners_view.php";
$url_owners_add			= "http://$baseurl" . "bulldog_owners_add.php";
$url_owners_stats		= "http://$baseurl" . "bulldog_owners_stats.php";

$url_breeding_add 		= "http://$baseurl" . "bulldog_breedings_add.php";
$url_breeding_profile 	= "http://$baseurl" . "bulldog_breedings_profile.php";
$url_breedings_profile 	= "http://$baseurl" . "bulldog_breedings_profile.php";
$url_breedings_made 	= "http://$baseurl" . "bulldog_breedings_made.php";
$url_breedings_search 	= "http://$baseurl" . "bulldog_breedings_search.php";
$url_breedings_test 	= "http://$baseurl" . "bulldog_breedings_test.php";
$url_breedings_moderate	= "http://$baseurl" . "bulldog_breedings_moderate.php";
$url_breedings_user		= "http://$baseurl" . "bulldog_breedings_user.php";

$url_dogs_add			= "http://$baseurl" . "bulldog_dogs_add.php";
$url_dogs_profile		= "http://$baseurl" . "bulldog_dogs_profile.php";
$url_dogs_media			= "http://$baseurl" . "bulldog_dogs_media.php";
$url_dogs_offspring		= "http://$baseurl" . "bulldog_dogs_offspring.php";
$url_dogs_relatives		= "http://$baseurl" . "bulldog_dogs_relatives.php";
$url_dogs_breedings		= "http://$baseurl" . "bulldog_dogs_breedings.php";
$url_dogs_log			= "http://$baseurl" . "bulldog_dogs_log.php";
$url_dogs_search		= "http://$baseurl" . "bulldog_dogs_search.php";
$url_dogs_moderate		= "http://$baseurl" . "bulldog_dogs_moderate.php";

$url_stats_dogs			= "http://$baseurl" . "bulldog_statistics_dogs.php";
$url_stats_userdogs  	= "http://$baseurl" . "bulldog_statistics_userdogs.php";
$url_stats_users  =  "http://$baseurl" . "bulldog_statistics_users.php";

$url_utility			= "http://$baseurl" . "bulldog_utility.php";
