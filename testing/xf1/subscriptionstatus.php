<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$startTime = microtime(true);
$kotomi_indexFile = "./";
$kotomi_container = true;
$fileDir = dirname(__FILE__) . "/{$kotomi_indexFile}";
require "{$fileDir}/library/Dark/Kotomi/KotomiHeader.php";

$db = XenForo_Application::getDb();

$myimage_file = (array_key_exists('do', $_GET)) ? $_GET['do'] : "";

$extra_output = $wrapper_top = $wrapper_bottom = '';

XenForo_Session::startPublicSession();

$visitor = XenForo_Visitor::getInstance();

$tdr_customer_number = (isset($visitor['customFields']['tdr_customer_number'])) ? $visitor['customFields']['tdr_customer_number'] : "";
$issues_remaining = (isset($visitor['customFields']['issues_remaining'])) ? $visitor['customFields']['issues_remaining'] : "";
$last_issue = (isset($visitor['customFields']['last_issue'])) ? $visitor['customFields']['last_issue'] : "";
$last_issue_mailed = (isset($visitor['customFields']['last_issue_mailed'])) ? $visitor['customFields']['last_issue_mailed'] : "";

if ($visitor['user_id'] == 0) {
    echo "<center><b>You must be logged in to see subscription status!</b></center>";
} else {
    echo "<center><b>TDR Magazine Subscription Status</b><br />
	<br />
	<table style=\"border-style: solid; border-width: 1px; border-color: black;\" width=300>
		<tr>
			<td style=\"padding: 10px;\">Forum User Name: </td><td>" . $visitor['username'] . "</td>
		</tr>
	        <tr>
        	        <td style=\"padding: 10px;\">Customer Number: </td><td>" . $tdr_customer_number . "</td>    
	        </tr>
        	<tr>
                	<td style=\"padding: 10px;\">Issues Remaining: </td><td>" . $issues_remaining . "</td>         
	        </tr>
        	<tr>
                	<td style=\"padding: 10px;\">Last Issue # Mailed: </td><td>" . $last_issue . "</td>         
	        </tr>
        	<tr>
                	<td style=\"padding: 10px;\">Last Issue Mailed Date: </td><td>" . $last_issue_mailed . "</td>         
	        </tr>
	</table>
	</center>";
}
echo "<br /><br />
To renew your TDR Magazine subscription, please visit our <a href=\"https://tdr-online.com/shop-1/ols/categories/renew-subscription\">renewal page.</a><br />
To subscribe or give a gift subscription, please visit our <a href=\"https://tdr-online.com/shop-1/ols/categories/new-subscription\">subscription page.</a>
<br /><br />
The purpose of the Turbo Diesel Register is to give Dodge/Cummins owners more satisfaction in the ownership of their pickup. How so? Each quarter we publish a magazine with 25+ columns. 
Since the Fall of '93, the publication has provided an open forum for the exchange of information from the manufacturers to the owners, from members to members and from owners back to manufacturers. 
The quarterly TDR magazine, a 130 - 150 page publication, features technical tips, maintenance basics, product evaluations, owner feature stories, industry news, vehicle history and development and more.
<br /><br /><br />";




require "{$fileDir}/library/Dark/Kotomi/KotomiFooter.php";
