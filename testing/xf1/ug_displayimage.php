<?php

/**************************************************************************
	File:		ug_displayimage.php
    Date:		8/12/2001
	Function:	Display a single image HTML ug_page
	Copyright (c) 2001 Kenneth E. Payne, All Rights Reserved
 **************************************************************************/

global $REMOTE_ADDR;

include_once("ug_page_header.php");

// Include global functions
require("ug_global.php");

print("<br><br><center>");

// For safety's sake....
if (!isset($photoid)) {
    $photoid = 0;
}
if ($photoid < 0 || $photoid > 99999) {
    $photoid = 0;
}
if (!isset($albumid)) {
    $albumid = 0;
}
if ($albumid < 0 || $albumid > 99999) {
    $albumid = 0;
}
if (!isset($voteval)) {
    $voteval = 0;
}
if ($voteval < 0 || $voteval > 99999) {
    $voteval = 0;
}
$photoid = intval($photoid);
$albumid = intval($albumid);
$voteval = intval($voteval);

// Connect to the database server
if (!ConnectDB()) {
    print("error");
} else {
    // Update vote if user voted on this photo.
    if ($voteval > 0) {
        // Don't allow double votes
        $Query = "SELECT * FROM rr_photovote WHERE photoid='$photoid' AND ipaddr=INET_ATON('$REMOTE_ADDR')";
        $dbResult = mysql2i_query($Query, $settings->dbLink);
        DB_Error($settings->dbLink);

        if (!mysql2i_fetch_row($dbResult)) {
            $Query = "INSERT INTO rr_photovote ( albumid, photoid, vote, ipaddr ) values ( '$albumid', '$photoid', $voteval, INET_ATON('$REMOTE_ADDR') )";
            $dbResult = mysql2i_query($Query, $settings->dbLink);
            LogFile("INSERT PHOTOVOTE: $albumid, $photoid");
        }
    }

    // Select current photo information from the database
    $Query = "SELECT photoid, userid, albumid, imgtype, DATE_FORMAT( createdate, '%m-%d-%Y' ), DATE_FORMAT( updatedate, '%m-%d-%Y' ), title, comment, views FROM rr_photo WHERE photoid='$photoid'";
    $dbResult = mysql2i_query($Query, $settings->dbLink);
    DB_Error($settings->dbLink);

    if ($photorow = mysql2i_fetch_row($dbResult)) {
        $photorow = DBDecode($photorow);

        $views = $photorow[8] + 1;

        $filename = "$settings->ImageUrl?&photoid=$photoid&width=$width";

        // Display image and image information
        print("
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
					<table border=0 cellpadding=1 cellspacing=1>
					<tr>
						<td bgcolor=#ffffff align=right colspan=2><font face=\"helvetica, arial\" size=3><a href=\"ug_index.php\">Main Gallery Page</a></font></td>
					</tr>
					<tr><td bgcolor=#7f7f7f colspan=2>
					<table border=0 cellpadding=0 cellspacing=0>
						<tr>
							<td bgcolor=#ffffff><font face=\"helvetica, arial, helvetica, arial\" size=3>Photo: {$photorow[6]}<br>Created {$photorow[4]}, Updated: {$photorow[5]}</font></td>
							<td valign=top align=right bgcolor=#ffffff><font face=\"helvetica, arial, helvetica, arial\" size=3>$views views</font></td>
						</tr>");
        // Select photo vote information from the database
        $Query = "SELECT count(*), AVG( vote ) FROM rr_photovote WHERE photoid='$photoid'";
        $dbResult = mysql2i_query($Query, $settings->dbLink);
        DB_Error($settings->dbLink);

        if ($voterow = mysql2i_fetch_row($dbResult)) {
            $voterow = DBDecode($voterow);
            print("<tr>
							<td bgcolor=#ffffff><font face=\"helvetica, arial, helvetica, arial\" size=3>Rating: {$voterow[1]} ({$voterow[0]} votes)</font></td>
							<td bgcolor=#ffffff>&nbsp;</td>
						</tr>");
        }

        print("	<tr>
							<td colspan=2 bgcolor=#dfdfdf><font face=\"helvetica, arial, helvetica, arial\" size=3>Description: {$photorow[7]}</td>
						</tr>
						<tr>
							<td colspan=2 bgcolor=#ffffff align=center><img src=\"ug_sizeimage.php?&photoid=$photoid&width=$width\" class=\"myimage\"><br><font size=2 face=\"helvetica, arial\"><a href=\"javascript:makeRemote('$settings->main_url/ug_forumcodes.php?&photoid=$photoid')\">[Forum Codes]</a></font></td>
						</tr>");

        // See if user has already voted on this photo
        $Query = "SELECT * FROM rr_photovote WHERE photoid='$photoid' AND ipaddr=INET_ATON('$REMOTE_ADDR')";
        $dbResult = mysql2i_query($Query, $settings->dbLink);
        DB_Error($settings->dbLink);

        if (mysql2i_fetch_row($dbResult)) {
            /*				print( "<tr>
							<td colspan=2 bgcolor=#dfdfdf><font face=\"helvetica, arial, helvetica, arial\" size=3>Please rank this photo:
							<a href=\"ug_displayimage.php?&albumid={$photorow['albumid']}&photoid=$photoid&width=$width&voteval=1\">1</a> 
							<a href=\"ug_displayimage.php?&photoid={$photorow['albumid']}$photoid&width=$width&voteval=2\">2</a>
							<a href=\"ug_displayimage.php?&photoid={$photorow['albumid']}$photoid&width=$width&voteval=3\">3</a>
							<a href=\"ug_displayimage.php?&photoid={$photorow['albumid']}$photoid&width=$width&voteval=4\">4</a>
							<a href=\"ug_displayimage.php?&photoid={$photorow['albumid']}$photoid&width=$width&voteval=5\">5</a>
							<a href=\"ug_displayimage.php?&photoid={$photorow['albumid']}$photoid&width=$width&voteval=6\">6</a>
							<a href=\"ug_displayimage.php?&photoid={$photorow['albumid']}$photoid&width=$width&voteval=7\">7</a>
							<a href=\"ug_displayimage.php?&photoid={$photorow['albumid']}$photoid&width=$width&voteval=8\">8</a>
							<a href=\"ug_displayimage.php?&photoid={$photorow['albumid']}$photoid&width=$width&voteval=9\">9</a>
							<a href=\"ug_displayimage.php?&photoid={$photorow['albumid']}$photoid&width=$width&voteval=10\">10</a>
							</td>
						</tr>" );
*/
        }

        print("</table>
					</td></tr></table>");

        $Query = "UPDATE rr_photo SET views=$views WHERE photoid='$photoid'";
        $dbResult = mysql2i_query($Query, $settings->dbLink);
        DB_Error($settings->dbLink);
        LogFile("UPDATE PHOTO (views): $photoid");
    } else {
        print("No such photo");
    }
}

print("</center><br><br>
			<SCRIPT LANGUAGE=\"javascript\">
			<!--
			function makeRemote(url){
			remote = window.open(url,\"remotewin\",\"width=800,height=500,scrollbars=1\");
			remote.location.href = url;
			if (remote.opener == null) remote.opener = window;
			}
			// -->
			</SCRIPT>");
include_once("ug_page_footer.php");
