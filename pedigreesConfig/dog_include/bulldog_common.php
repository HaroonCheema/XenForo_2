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
$url_search				= "https://$baseurl" . "bulldog_dogs_search.php";
$url_search2       		= "https://$baseurl" . "bulldog_dogs_search2.php";
$url_assistant       	= "https://$baseurl" . "bulldog_assistant.php";
$url_details      		= "https://$baseurl" . "bulldog_details.php";
$url_profile      		= "https://$baseurl" . "bulldog_dogs_profile.php";
$url_breeders     		= "https://$baseurl" . "bulldog_breeders.php";
$url_owners       		= "https://$baseurl" . "bulldog_owners.php";
$url_owners2       		= "https://$baseurl" . "bulldog_owners2.php";
$url_addsire      		= "https://$baseurl" . "bulldog_addsire.php";
$url_adddam       		= "https://$baseurl" . "bulldog_adddam.php";
$url_adddog       		= "https://$baseurl" . "bulldog_add.php";
$url_addbreeder   		= "https://$baseurl" . "bulldog_addbreeder.php";
$url_addowner     		= "https://$baseurl" . "bulldog_addowner.php";
$url_upload       		= "https://$baseurl" . "bulldog_upload.php";
$url_log          		= "https://$baseurl" . "bulldog_log.php";
$url_offspring       	= "https://$baseurl" . "bulldog_offspring.php";
$url_relatives    		= "https://$baseurl" . "bulldog_relatives.php";
$url_register     		= "https://$baseurl" . "register.php";
$url_subscribe    		= "https://$baseurl" . "payments.php";
$url_banned       		= "https://$baseurl";
$url_testbreeding 		= "https://$baseurl" . "bulldog_testbreeding.php";
$url_pics         		= "https://$baseurl/pics";
$url_search_breedings 	= "https://$baseurl" . "bulldog_searchbreedings.php";
$url_delete             = "https://$baseurl" . "bulldog_delete.php";
$url_member				= "https://$baseurl" . "member.php";
$url_core				= "https://$baseurl" . "bulldog_core.php";
$url_change_owner		= "https://$baseurl" . "bulldog_change_owner.php";
$url_breeders_profile	= "https://$baseurl" . "bulldog_breeders_profile.php";
$url_breeders_view		= "https://$baseurl" . "bulldog_breeders_view.php";
$url_breeders_add		= "https://$baseurl" . "bulldog_breeders_add.php";
$url_breeders_stats		= "https://$baseurl" . "bulldog_breeders_stats.php";
$url_owners_profile		= "https://$baseurl" . "bulldog_owners_profile.php";
$url_owners_view		= "https://$baseurl" . "bulldog_owners_view.php";
$url_owners_add			= "https://$baseurl" . "bulldog_owners_add.php";
$url_owners_stats		= "https://$baseurl" . "bulldog_owners_stats.php";

$url_breeding_add 		= "https://$baseurl" . "bulldog_breedings_add.php";
$url_breeding_profile 	= "https://$baseurl" . "bulldog_breedings_profile.php";
$url_breedings_profile 	= "https://$baseurl" . "bulldog_breedings_profile.php";
$url_breedings_made 	= "https://$baseurl" . "bulldog_breedings_made.php";
$url_breedings_search 	= "https://$baseurl" . "bulldog_breedings_search.php";
$url_breedings_test 	= "https://$baseurl" . "bulldog_breedings_test.php";
$url_breedings_moderate	= "https://$baseurl" . "bulldog_breedings_moderate.php";
$url_breedings_user		= "https://$baseurl" . "bulldog_breedings_user.php";

$url_dogs_add			= "https://$baseurl" . "bulldog_dogs_add.php";
$url_dogs_profile		= "https://$baseurl" . "bulldog_dogs_profile.php";
$url_dogs_media			= "https://$baseurl" . "bulldog_dogs_media.php";
$url_dogs_offspring		= "https://$baseurl" . "bulldog_dogs_offspring.php";
$url_dogs_relatives		= "https://$baseurl" . "bulldog_dogs_relatives.php";
$url_dogs_breedings		= "https://$baseurl" . "bulldog_dogs_breedings.php";
$url_dogs_log			= "https://$baseurl" . "bulldog_dogs_log.php";
$url_dogs_search		= "https://$baseurl" . "bulldog_dogs_search.php";
$url_dogs_moderate		= "https://$baseurl" . "bulldog_dogs_moderate.php";

$url_stats_dogs			= "https://$baseurl" . "bulldog_statistics_dogs.php";
$url_stats_userdogs  	= "https://$baseurl" . "bulldog_statistics_userdogs.php";
$url_stats_users  =  "https://$baseurl" . "bulldog_statistics_users.php";

$url_utility			= "https://$baseurl" . "bulldog_utility.php";
