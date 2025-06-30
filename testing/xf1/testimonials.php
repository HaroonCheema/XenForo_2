<?php

$startTime = microtime(true);
$kotomi_indexFile = "./";
$kotomi_container = true;
$fileDir = dirname(__FILE__) . "/{$kotomi_indexFile}";
require "{$fileDir}/library/Dark/Kotomi/KotomiHeader.php";

$db = XenForo_Application::getDb();

$myimage_file = (array_key_exists('do', $_GET)) ? $_GET['do'] : "";

$extra_output = '';

$content_id = 0;

echo '<title>Turbo Diesel Register Testimonials</title>
<style>
.testimonialD
{
	float: left;
	padding: 6px;
	margin: 8px;
	border: rgb(174,0,14) 1px solid;
	width: 320px;
	height: 340px;
}
.testimonialH
{
    overflow: visible; /* For IE */
    height: 30px;
    border-style: solid;
    border-color: rgb(174,0,14);
    border-width: 1px 0 0 0;
    border-radius: 20px;
}
.testimonialM
{
    overflow: auto;
    height: 260px;
}
</style>
<br />
<span style="font: 16px !important;font-weight: bold !important;">To subscribe to the TDR Magazine, available in both print and digital forms, 
as well as gain additional privileges and access to member only content on our site, please 
<a href="https://www.tdr-online.com/"><img src="https://www.turbodieselregister.com/images/tdr-red-subscribe.png" style="max-width: 140px; height: auto;"></a></span><br /><br />
';

/* First on always the same */
$query_results = $db->fetchAll('SELECT xf_post.post_id AS post_id, xf_post.thread_id AS thread_id,
                                       xf_post.user_id AS user_id, xf_post.username AS username,
                                       from_unixtime(xf_post.post_date, "%M %D, %Y") AS post_date,
                                       xf_post.message AS message
                                       FROM xf_post
                                       LEFT JOIN xf_thread ON xf_post.thread_id = xf_thread.thread_id
                                       WHERE xf_thread.node_id=241 AND xf_post.post_id = 2565684');

foreach ($query_results as $row) {
    $formatter = XenForo_BbCode_Formatter_Base::create();
    $parser = new XenForo_BbCode_Parser($formatter);
    $row['message_html'] = str_replace("\n", '', $parser->render($row['message']));

    echo '<div class="testimonialD"><b>TDR Member: ' . $row['username'] . '</b><hr class="testimonialH">' .
        '<div class="testimonialM">' . $row['message_html'] . '</div></div>';
}



/* Grab the other 11 random testimonials from the database */
$query_results = $db->fetchAll('SELECT xf_post.post_id AS post_id, xf_post.thread_id AS thread_id, 
				       xf_post.user_id AS user_id, xf_post.username AS username, 
				       from_unixtime(xf_post.post_date, "%M %D, %Y") AS post_date, 
				       xf_post.message AS message 
				       FROM xf_post 
				       LEFT JOIN xf_thread ON xf_post.thread_id = xf_thread.thread_id
				       WHERE xf_thread.node_id=241 AND xf_post.post_id != 2565684 ORDER BY RAND() LIMIT 11');

foreach ($query_results as $row) {
    $formatter = XenForo_BbCode_Formatter_Base::create();
    $parser = new XenForo_BbCode_Parser($formatter);
    $row['message_html'] = str_replace("\n", '', $parser->render($row['message']));

    echo '<div class="testimonialD"><b>TDR Member: ' . $row['username'] . '</b><hr class="testimonialH">' .
        '<div class="testimonialM">' . $row['message_html'] . '</div></div>';
}


require "{$fileDir}/library/Dark/Kotomi/KotomiFooter.php";
