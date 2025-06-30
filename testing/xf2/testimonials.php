<?php
// Define a unique session key BEFORE loading anything else
define('XF_SESSION_KEY', 'sample_php_page_session');

define('__XF__', __DIR__);
require __XF__ . '/src/XF.php';

// Start the XenForo framework
XF::start(__XF__);

// Set up the app manually (required for layout rendering)
$app = \XF::setupApp('XF\Pub\App');

$request = $app->request();
$session = $app->session();

use XF\BbCode\Renderer\Html as HtmlRenderer;
use XF\BbCode\Formatter\Html as HtmlFormatter;
//*****************************************************************************
$extra_output = '';
$content_id = 0;
$db = \XF::db();

$content = '';

$content = '
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
$query_results = \XF::db()->fetchAll('
    SELECT xf_post.post_id AS post_id, xf_post.thread_id AS thread_id,
   xf_post.user_id AS user_id, xf_post.username AS username,
   from_unixtime(xf_post.post_date, "%M %D, %Y") AS post_date,
   xf_post.message AS message
   FROM xf_post
   LEFT JOIN xf_thread ON xf_post.thread_id = xf_thread.thread_id
   WHERE xf_thread.node_id= 241 AND xf_post.post_id = 2565684
   ');


foreach ($query_results as $row) {

    $post = \XF::em()->find('XF:Post', $row['post_id']);

    $row['message_html'] = \XF::app()->bbCode()->render(
        $row['message'],
        'html',
        'post',
        $post
    );


    $content .= '<div class="testimonialD">
            <b>TDR Member: ' . htmlspecialchars($row['username']) . '</b>
            <hr class="testimonialH">
            <div class="testimonialM">' . $row['message_html'] . '</div>
          </div>';
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

    $post = \XF::em()->find('XF:Post', $row['post_id']);

    $row['message_html'] = \XF::app()->bbCode()->render(
        $row['message'],
        'html',
        'post',
        $post
    );


    $content .= '<div class="testimonialD">
            <b>TDR Member: ' . htmlspecialchars($row['username']) . '</b>
            <hr class="testimonialH">
            <div class="testimonialM">' . $row['message_html'] . '</div>
          </div>';
}

//*****************************************************************************
// Use ScriptsPages to render inside XF layout
\ScriptsPages\Setup::set([
    'init' => true,         // initialize context
    'title' => 'Turbo Diesel Register Testimonials',
    'content' => $content,
    'raw' => false          //enables full layout
]);

// Render with layout
$app->run()->send($request);
