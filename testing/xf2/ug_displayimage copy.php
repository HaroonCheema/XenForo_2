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

$mediaId = (int) $request->filter('photoid', 'uint');


$content = '';

$content = '
<style>
				.myimage
				{
				  max-width: 100%; height: auto;
				}

				@media(min-width: 240px) 
				{
                               		.myimage
                                	{
                                  	max-width: 240px; height: auto;
                                	}
				}

                                @media(min-width: 320px)
                                {
                                        .myimage
                                        {
                                        max-width: 320px; height: auto;  
                                        }
                                }


                                @media(min-width: 480px)
                                {
                                        .myimage
                                        {
                                        max-width: 480px; height: auto;  
                                        }
                                }


                                @media(min-width: 640px)
                                {
                                        .myimage
                                        {
                                        max-width: 6400px; height: auto;  
                                        }
                                }

                                @media(min-width: 800px)
                                {
                                        .myimage
                                        {
                                        max-width: 800px; height: auto;  
                                        }
                                }

                                @media(min-width: 1024px)
                                {
                                        .myimage
                                        {
                                        max-width: 1024px; height: auto;  
                                        }
                                }

                                @media(min-width: 1280px)
                                {
                                        .myimage
                                        {
                                        max-width: 1280px; height: auto;  
                                        }
                                }
				</style>

					<br><br>
';

if (!$mediaId) {
    $content = '<center><b>No such photo!</b></center>';
} else {


    $mediaItem = \XF::em()->find('XFMG:MediaItem', $mediaId);

    $content .= '<table border=0 cellpadding=1 cellspacing=1>
					<tr>
						<td style="background-color: #ffffff;" align=right colspan=2><font face="helvetica, arial" size=3><a href="ug_index.php">Main Gallery Page</a></font></td>
					</tr>
					<tr><td style="background-color: #7f7f7f;" colspan=2>
					<table border=0 cellpadding=0 cellspacing=0>
						<tr>
							<td style="background-color: #ffffff;" ><font face="helvetica, arial, helvetica, arial" size=3>Photo: ' . $mediaItem->media_id . '<br>Created ' . $mediaItem->media_date . ', Updated: ' . $mediaItem->last_edit_date . '</font></td>
							<td valign=top align=right style="background-color: #ffffff;" ><font face="helvetica, arial, helvetica, arial" size=3>' . $mediaItem->media_id . ' views</font></td>
						</tr>';

    $content .= '<tr>
							<td colspan=2 style="background-color: #dfdfdf;"><font face="helvetica, arial, helvetica, arial" size=3>Description: ' . $mediaItem->description . '</td>
						</tr>
						<tr>
							<td colspan=2 style="background-color: #ffffff;"  align=center><img src="https://xf2dev.turbodieselregister.com/media/img_4825.7059/full?d=1744157449" class="myimage"><br><font size=2 face="helvetica, arial"><a href="">[Forum Codes]</a></font></td>
						</tr>';
    $content .= '</table>
					</td></tr></table>';
    $content .= '';

    // $customFields = $visitor->Profile->custom_fields ?: [];

}


// Use ScriptsPages to render inside XF layout
\ScriptsPages\Setup::set([
    'init' => true,         // initialize context
    //'title' => 'title',
    'content' => $content,
    'raw' => false          //enables full layout
]);

// Render with layout
$app->run()->send($request);
