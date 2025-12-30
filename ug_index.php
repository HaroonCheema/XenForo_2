<?php
$xf = require __DIR__ . '/pedigreesConfig/common.php';

$app      = $xf['app'];
$request  = $xf['request'];
$session  = $xf['session'];
$db       = $xf['db'];
$visitor  = $xf['visitor'];
$sourceDb = $xf['sourceDb'];

$content = '';

// $threads = $sourceDb->fetchAll("
//     SELECT *
//     FROM xf_thread
//     ORDER BY post_date DESC
//     LIMIT 5
// ");

// echo "<pre>";
// var_dump($threads);
// exit;

$content = '';

$content .= '<br />';
$content .= '<center><font size="6">The Ultimate Pedigree Database</font></center><br />';

$content .= '
This database is designed to become the most complete APBT Resource ever.
Our aim is too become the greatest peer-governed,
<b><i>paperless</i></b> APBT historical and informational resource possible,
offering both convenience and accountability regarding how our dogs are bred
and what they have produced.
<br /><br />
';

$content .= '
<center>
<font color="#33833c" size="5">
How to Add <u>Dogs</u> to the Database
</font><br />
<font size="3" color="#fb4d4d">
Please watch these 4 videos IN FULL before doing anything!
</font>
</center><br />
';

$content .= '
<center>
<iframe width="560" height="315"
src="https://www.youtube.com/embed/CrU5mYwCfHc"
frameborder="0" allowfullscreen></iframe><br />
<font color="#33833c">
Click the bottom right corner of the video to make it full screen
</font>
</center><br />
';

$content .= '<br />';

$content .= '
<center>
We keep our breedings <u>separate</u> from dogs, so please enter your actual
breedings in the
<a href="http://www.thepitbullbible.com/forum/bulldog_addbreeding.php">
Breeding Database</a>,
not the
<a href="http://www.thepitbullbible.com/forum/bulldog_add.php">
Dog Database</a>!
</center><br />
';

$content .= '<br />';


$content .=  '<center><font color="#33833c" size=5>How to Add <u>Breedings</u> to the Database</font><br />
<font color="#fb4d4d">Please watch this video IN FULL before doing anything :)</font><br />
<font color="#fb4d4d">How to tutorial</font></center><br />';

$content .=  '<center><iframe width="560" height="315" src="//www.youtube.com/embed/5mS4xFKEIYs" frameborder="0" allowfullscreen></iframe><br />
<font color="#33833c">Click the bottom right corner of the video to make it full screen</font></center><br />';
$content .=  '<br />';

$content .=  '<center>We also keep our <u>actual</u> breedings separate from our &ldquo;test&rdquo; or &ldquo;theoretical&rdquo; breedings, so please use our <a href="http://www.thepitbullbible.com/forum/bulldog_testbreeding.php">Test Breeding</a> feature for breedings that have <b>not actually happened</b> already.</center><br />';
$content .=  '<br />';

$content .=  '<center><font color="#33833c" size=5>Using the <u>Test</u> Breeding Feature</font><br />
<font color="#fb4d4d">Please watch this video IN FULL before doing anything :)</font><br />
<font color="#fb4d4d">How to tutorial</font></center><br />';

$content .=  '<center><iframe width="560" height="315" src="//www.youtube.com/embed/oDGuNskF4dU" frameborder="0" allowfullscreen></iframe><br />
<font color="#33833c">Click the bottom right corner of the video to make it full screen</font></center><br />';
$content .=  '<br />';

$content .=  '<center>The reason why we ask you to be so meticulous (and complete!) in your data entry is because our *<b>awesome</b>*  <a href="http://www.thepitbullbible.com/forum/bulldog_statistics_dogs.php">Bulldog Statistics</a> feature depends on it, and it ties-in our breedings with the level of how each dog has produced!</center><br />';
$content .=  '<br />';

$content .=  '<center><font color="#33833c" size=5>Bulldog Statistics&#151;Why We ROCK!</font><br />
<font color="#fb4d4d">Please watch this video IN FULL before doing anything :)</font><br />
<font color="#fb4d4d">How to tutorial</font></center><br />';

$content .=  '<center><iframe width="560" height="315" src="//www.youtube.com/embed/jEMYzAHf1Wk" frameborder="0" allowfullscreen></iframe><br />
<font color="#33833c">Click the bottom right corner of the video to make it full screen</font></center><br />';
$content .=  '<br />';

$content .=  '<font size="3">Please watch THE REST of our Database Tutorials <a href="http://www.thepitbullbible.com/forum/content.php?229" target="blank">HERE</a> before you do anything else!</font><br />';
$content .=  '<br />';

$content .=  'Thank you for taking the time to watch these videos IN FULL. Your doing so will not only save me time, but it will save <b>you</b> time as well, simply because you will be able to fully-understand and enjoy the full benefits of this Resource right from the get-go. I thank you sincerely for joining today, and  if you have any questions <i>not</i> covered in this presentation, please post them on <a href="http://www.thepitbullbible.com/forum/showthread.php?1506" target="_blank">this thread</a>. Thanks again! <font size="1">(Or you can also <i>read</i>  the Full Instructions <a href="http://www.thepitbullbible.com/forum/pedigrees2.php" target="blank">here</a>.)</font><br />';

$content .=  '<br />';


/* continue appending the rest exactly the same way */

\ScriptsPages\Setup::$test = true; // REQUIRED if license check fails

\ScriptsPages\Setup::set([
    'init'    => true,
    'navigation_id' => 'pedigrees',
    'title'   => 'Display Image',
    'content' => $content,
    'raw'     => false
]);

$response = $app->run();
$response->send();
