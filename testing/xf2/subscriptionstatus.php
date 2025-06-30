<?php
// Define a unique session key BEFORE loading anything else
define('XF_SESSION_KEY', 'sample_php_page_session');

define('__XF__', __DIR__);
require __XF__ . '/src/XF.php';

// Start the XenForo framework
XF::start(__XF__);

// Set up the app manually (required for layout rendering)
$app = \XF::setupApp('XF\Pub\App');

// Request object (needed by run/send)
$request = $app->request();

$session = $app->session();

$visitor = \XF::em()->find('XF:User', $session->get('userId'));

if (!$visitor) {
    $content = '<center><b>You must be logged in to see subscription status!</b></center>';
} else {

    $customFields = $visitor->Profile->custom_fields ?: [];

    $tdr_customer_number = isset($customFields['tdr_customer_number']) ? htmlspecialchars($customFields['tdr_customer_number']) : '';
    $issues_remaining = isset($customFields['issues_remaining']) ? htmlspecialchars($customFields['issues_remaining']) : '';
    $last_issue = isset($customFields['last_issue']) ? htmlspecialchars($customFields['last_issue']) : '';
    $last_issue_mailed = isset($customFields['last_issue_mailed']) ? htmlspecialchars($customFields['last_issue_mailed']) : '';

    $username = htmlspecialchars($visitor->username);

    $content = '
    <center><b>TDR Magazine Subscription Status</b><br /><br />
    <table style="border-style: solid; border-width: 1px; border-color: black;" width="300">
        <tr>
            <td style="padding: 10px;">Forum User Name: </td><td>' . $username . '</td>
        </tr>
        <tr>
            <td style="padding: 10px;">Customer Number: </td><td>' . $tdr_customer_number . '</td>    
        </tr>
        <tr>
            <td style="padding: 10px;">Issues Remaining: </td><td>' . $issues_remaining . '</td>         
        </tr>
        <tr>
            <td style="padding: 10px;">Last Issue # Mailed: </td><td>' . $last_issue . '</td>         
        </tr>
        <tr>
            <td style="padding: 10px;">Last Issue Mailed Date: </td><td>' . $last_issue_mailed . '</td>         
        </tr>
    </table>
    </center>';
}

$content .= '
<br /><br />
To renew your TDR Magazine subscription, please visit our <a href="https://tdr-online.com/shop-1/ols/categories/renew-subscription">renewal page.</a><br />
To subscribe or give a gift subscription, please visit our <a href="https://tdr-online.com/shop-1/ols/categories/new-subscription">subscription page.</a>
<br /><br />
The purpose of the Turbo Diesel Register is to give Dodge/Cummins owners more satisfaction in the ownership of their pickup. How so? Each quarter we publish a magazine with 25+ columns. 
Since the Fall of \'93, the publication has provided an open forum for the exchange of information from the manufacturers to the owners, from members to members and from owners back to manufacturers. 
The quarterly TDR magazine, a 130 - 150 page publication, features technical tips, maintenance basics, product evaluations, owner feature stories, industry news, vehicle history and development and more.
<br /><br /><br />';

// Use ScriptsPages to render inside XF layout
\ScriptsPages\Setup::set([
    'init' => true,         // initialize context
    //'title' => 'title',
    'content' => $content,
    'raw' => false          //enables full layout
]);

// Render with layout
$app->run()->send($request);
