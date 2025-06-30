<?php

define('XF_SESSION_KEY', 'ug_displayimage_session');
define('__XF__', __DIR__);
require __XF__ . '/src/XF.php';

\XF::start(__XF__);
$app = \XF::setupApp('XF\Pub\App');
$request = $app->request();
$session = $app->session();

$db = \XF::db();

// Load $settings if it exists
require_once 'ug_global.php'; // Ensure this file sets $settings

// Sanitize input
$photoId = (int) $request->filter('photoid', 'uint');
$albumId = (int) $request->filter('albumid', 'uint');
$voteVal = (int) $request->filter('voteval', 'uint');
$width = $request->filter('width', 'uint') ?: 640;

$ipAddress = $request->getIp();

$visitor = \XF::em()->find('XF:User', $session->get('userId'));

$content = '<br><br><center>';

if ($photoId === 0) {
    $content .= 'Invalid photo.';
} else {

    // Handle voting
    if ($voteVal > 0) {
        $existingVote = $db->fetchRow("
                SELECT * FROM rr_photovote 
                WHERE photoid = ? AND ipaddr = INET_ATON(?)
            ", [$photoId, $ipAddress]);

        if (!$existingVote) {
            $db->query("
                    INSERT INTO rr_photovote (albumid, photoid, vote, ipaddr)
                    VALUES (?, ?, ?, INET_ATON(?))
                ", [$albumId, $photoId, $voteVal, $ipAddress]);
        }
    }

    // Load photo data
    $photo = $db->fetchRow("
            SELECT photoid, userid, albumid, imgtype,
                   DATE_FORMAT(createdate, '%m-%d-%Y') AS create_date,
                   DATE_FORMAT(updatedate, '%m-%d-%Y') AS update_date,
                   title, comment, views
            FROM rr_photo
            WHERE photoid = ?
        ", [$photoId]);

    if (!$photo) {
        $content .= 'No such photo.';
    } else {
        // Update views
        $photo['views'] += 1;
        $db->query("UPDATE rr_photo SET views = ? WHERE photoid = ?", [$photo['views'], $photoId]);

        $imageUrl = "ug_sizeimage.php?photoid=$photoId&width=$width";

        $voteInfo = $db->fetchRow("
                SELECT COUNT(*) AS count, AVG(vote) AS avg_vote
                FROM rr_photovote
                WHERE photoid = ?
            ", [$photoId]);

        $ratingText = $voteInfo && $voteInfo['count']
            ? "Rating: " . round($voteInfo['avg_vote'], 1) . " ({$voteInfo['count']} votes)"
            : "No ratings yet";

        $description = htmlspecialchars($photo['comment']);

        $content .= <<<HTML
<style>
.myimage {
    max-width: 100%; height: auto;
}
@media (min-width: 240px) {.myimage { max-width: 240px; }}
@media (min-width: 320px) {.myimage { max-width: 320px; }}
@media (min-width: 480px) {.myimage { max-width: 480px; }}
@media (min-width: 640px) {.myimage { max-width: 640px; }}
@media (min-width: 800px) {.myimage { max-width: 800px; }}
@media (min-width: 1024px) {.myimage { max-width: 1024px; }}
@media (min-width: 1280px) {.myimage { max-width: 1280px; }}
</style>

<table border="0" cellpadding="1" cellspacing="1">
<tr>
    <td bgcolor="#ffffff" align="right" colspan="2">
        <a href="ug_index.php">Main Gallery Page</a>
    </td>
</tr>
<tr><td colspan="2" bgcolor="#7f7f7f">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
    <td bgcolor="#ffffff">
        Photo: {$photo['title']}<br>
        Created: {$photo['create_date']}, Updated: {$photo['update_date']}
    </td>
    <td align="right" bgcolor="#ffffff">
        {$photo['views']} views
    </td>
</tr>
<tr>
    <td bgcolor="#ffffff">$ratingText</td>
    <td bgcolor="#ffffff">&nbsp;</td>
</tr>
<tr>
    <td colspan="2" bgcolor="#dfdfdf">Description: $description</td>
</tr>
<tr>
    <td colspan="2" bgcolor="#ffffff" align="center">
        <img src="$imageUrl" class="myimage"><br>
        <a href="javascript:makeRemote('{$settings->main_url}/ug_forumcodes.php?photoid=$photoId')">[Forum Codes]</a>
    </td>
</tr>
</table>
</td></tr>
</table>
<script>
function makeRemote(url){
    let remote = window.open(url, "remotewin", "width=800,height=500,scrollbars=1");
    if (remote) {
        remote.location.href = url;
        if (!remote.opener) remote.opener = window;
    }
}
</script>
HTML;
    }
}

$content .= '</center><br><br>';

// Use ScriptsPages to render inside XF layout
\ScriptsPages\Setup::set([
    'init' => true,
    'title' => 'Display Image',
    'content' => $content,
    'raw' => false
]);

$app->run()->send($request);
