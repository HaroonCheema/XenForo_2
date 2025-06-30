<?php  



/**************************************************************************
	File:		ug_index.php
    Date:		8/12/2001
	Function:	Main gallery ug_page
	Copyright (c) 2001 Kenneth E. Payne, All Rights Reserved
**************************************************************************/
	include_once( "ug_page_header.php" );

        // Include global functions
        require( "ug_global.php" );



	global $settings;
	global $sorttype;
	global $ug_page;				
	
	print( "<br>" );

	// Connect to the database server
	if ( !ConnectDB() )
	{
		print( "Error connecting to database." );
	}
	else
	{
		// Get a count of photos.
		$Query = "SELECT count(*) FROM rr_photo";
		$dbResult = mysql2i_query( $Query, $settings->dbLink );
		DB_Error( $settings->dbLink );
		$photocount = mysql2i_fetch_array( $dbResult );
		DB_Error( $settings->dbLink );

		// Get a count of albums.
		$Query = "SELECT count(*) FROM rr_album";
		$dbResult = mysql2i_query( $Query, $settings->dbLink );
		DB_Error( $settings->dbLink );
		$albumcount = mysql2i_fetch_array( $dbResult );
		DB_Error( $settings->dbLink );

		// Get a count of galleries.
		$Query = "SELECT count(*) FROM rr_user";
		$dbResult = mysql2i_query( $Query, $settings->dbLink );
		DB_Error( $settings->dbLink );
		$gallerycount = mysql2i_fetch_array( $dbResult );
		DB_Error( $settings->dbLink );

		// Get a count of mileage.
		$Query = "SELECT sum(mileage) FROM rr_album";
		$dbResult = mysql2i_query( $Query, $settings->dbLink );
		DB_Error( $settings->dbLink );
		$mileage = mysql2i_fetch_array( $dbResult );
		DB_Error( $settings->dbLink );


		if ( !isset( $sorttype ) )
		{
			// If no sort type, pick one randomly so no user gets an advantage!
			srand( time() );

			switch( rand( 1, 8 ) )
			{
				case 1:
					$sorttype = "year";
					break;

				case 2:
					$sorttype = "state";
					break;

				case 3:
					$sorttype = "views";
					break;

				case 4:
					$sorttype = "vote";
					break;

				case 5:
					$sorttype = "date";
					break;

				case 6:
					$sorttype = "photos";
					break;

				case 7:
					$sorttype = "name";
					break;

				default:
					$sorttype = "";
					break;
			}
		}

		if ( !isset( $startrow ) )
		{
			$startrow = 0;
		}

		// Build query
		$Query = "SELECT DISTINCT album.albumid, album.userid, DATE_FORMAT( album.createdate, '%m-%d-%Y' ), DATE_FORMAT( album.updatedate, '%m-%d-%Y' ), album.title, album.comment, 
		          album.views, album.year, album.make, album.model, album.drive, 
				  album.mileage, album.photos, album.avgvote, user.state2 FROM rr_album as album, rr_user as user, rr_photo as photo WHERE album.userid=user.userid AND album.albumid=photo.albumid AND album.hide=0";

		// ORDER BY based on sort type
		switch( $sorttype )
		{
			case "year":
				$Query .= " ORDER BY album.year DESC";
				break;

			case "state":
				$Query .= " ORDER BY user.state2";
				break;

			case "views":
				$Query .= " ORDER BY album.views DESC";
				break;

			case "vote":
				$Query .= " ORDER BY album.avgvote DESC";
				break;

			case "date":
				$Query .= " ORDER BY album.createdate DESC";
				break;

			case "photos":
				$Query .= " ORDER BY album.photos DESC";
				break;

			case "name":
				$Query .= " ORDER BY album.title";
				break;
		}

		$Query .= " LIMIT $startrow, 20";

		$dbResult = mysql2i_query( $Query, $settings->dbLink );
		DB_Error( $settings->dbLink );

		$numrows = mysql2i_num_rows( $dbResult );

		$avgmiles = intval( $mileage[0] / $albumcount[0] );
		print( "<center><font face=\"helvetica, arial\" size=4><br><b>The reader's rig gallery has been replaced by the <a href=\"/photopost\">Photo Gallery</a><br>
		to view more current photos or to upload new photos please click <a href=\"/photopost\">here</a></b><br><br><br></font></center>" );

		print( "<center><font face=\"helvetica, arial\" size=3><b>User Galleries</b><br>
				<b>There are currently $photocount[0] photos in $albumcount[0] albums contained in $gallerycount[0] galleries</b><br>" .
				number_format( $mileage[0] ) ." total miles and an average of " . number_format( $avgmiles ) . " miles per vehicle.</font><p>" );

		print( "<font face=\"helvetica, arial\" size=2><b>Sort By:</b> <a href=\"$settings->main_url/ug_index.php?&sorttype=year&startrow=$startrow\">year</a> | <a href=\"$settings->main_url/ug_index.php?&sorttype=state&startrow=$startrow\">state</a> | <a href=\"$settings->main_url/ug_index.php?&sorttype=views&startrow=$startrow\">views</a> | <a href=\"$settings->main_url/ug_index.php?&sorttype=vote&startrow=$startrow\">rank</a> | <a href=\"$settings->main_url/ug_index.php?&sorttype=date&startrow=$startrow\">date</a> | <a href=\"$settings->main_url/ug_index.php?&sorttype=photos&startrow=$startrow\">photos</a> | <a href=\"$settings->main_url/ug_index.php?&sorttype=name&startrow=$startrow\">name</a></font>
				<table border=0 width=468 bgcolor=#7f7f7f>
				<tr>" );

		if ( $settings->boardtype == "VB" )
		{
//			print( "<td bgcolor=#dfdfdf align=right colspan=2><a href=\"login.php\">Manage</a> your gallery.</a></td>" );
//			print( "<td bgcolor=#dfdfdf align=right colspan=2>&nbsp;</td>" );
		}
		else
		{
			print( "<td bgcolor=#dfdfdf align=left colspan=3><a href=\"session.php\">Manage/Create</a> your gallery.</a></td>" );

		}

		print( "	</tr>
					<tr><td bgcolor=#000000 colspan=2>
						<table border=0 width=468 bgcolor=#8f8f8f>
							<tr>
								<td bgcolor=#dfdfdf>&nbsp;</td>
								<td bgcolor=#dfdfdf><font face=\"helvetica, arial\" size=2><b>Album</b></font></td>
								<td bgcolor=#dfdfdf nowrap><font face=\"helvetica, arial\" size=2><b>Year / Model</b></font></td>
								<td bgcolor=#dfdfdf><font face=\"helvetica, arial\" size=2><b>State</b></font></td>
								<td bgcolor=#dfdfdf><font face=\"helvetica, arial\" size=2><b>Photos</b></font></td>
								<td bgcolor=#dfdfdf nowrap><font face=\"helvetica, arial\" size=2><b>Date</b></font></td>
								<td bgcolor=#dfdfdf><font face=\"helvetica, arial\" size=2><b>Rank</b></font></td>
								<td bgcolor=#dfdfdf nowrap><font face=\"helvetica, arial\" size=2><b>Views</b></font></td>
							</tr>" );

		$rowoffset = false;
		for( $icount = 0; $icount < $numrows; $icount++ )
		{
			if ( !$row = mysql2i_fetch_array( $dbResult ) )
				break;

			if ( $rowoffset )
			{
				$rowoffset = false;
				$color = "#ffffff";
			}
			else
			{
				$rowoffset = true;
				$color = "#efefef";
			}

			$row = DBDecode( $row );

			// Select current photo information from the database
			$fileid = "";
			$Query2 = "SELECT * FROM rr_photo WHERE albumid='{$row[0]}'";
			if ( $dbResult2 = mysql2i_query( $Query2, $settings->dbLink ) )
			{
				if ( mysql2i_num_rows( $dbResult2 ) > 0 )
				{
					DB_Error( $settings->dbLink );

					// Display each thumbnail
					$photorow = mysql2i_fetch_array( $dbResult2 );
					$photorow = DBDecode( $photorow );
					$fileid = "?&photoid={$photorow[0]}";
				}
			}

			print( "<tr>
						<td valign=top bgcolor=#ffffff><a href=\"$settings->main_url/ug_displayalbum.php?&albumid={$row[0]}\"><img src=\"ug_displayminithumbnail.php$fileid\" border=0></a></td>
						<td bgcolor=$color><font face=\"helvetica, arial\" size=2><a href=\"$settings->main_url/ug_displayalbum.php?&albumid={$row[0]}\">" . substr( $row[4], 0, 32 ) . "</a>&nbsp;</font></td>
						<td bgcolor=$color nowrap><font face=\"helvetica, arial\" size=2>{$row[7]} {$row[9]}&nbsp;</font></td>
						<td bgcolor=$color><font face=\"helvetica, arial\" size=2>{$row[14]}&nbsp;</font></td>
						<td bgcolor=$color><font face=\"helvetica, arial\" size=2>{$row[12]}&nbsp;</font></td>" );

			// If created within the last 48 hours, flag as NEW!
			if ( date( "m-d-Y" ) == $row[2] || date( "m-d-Y", time() - ( 60 * 60 * 24 ) ) == $row[2])
			{
				print( "<td bgcolor=$color nowrap align=center><font face=\"helvetica, arial\" size=2 color=#ff0000><b>New!</b></font></td>" );
			}
			else
			{
				print( "<td bgcolor=$color nowrap><font face=\"helvetica, arial\" size=2>{$row[2]}&nbsp;</font></td>" );
			}

			print( "	<td bgcolor=$color><font face=\"helvetica, arial\" size=2>{$row[13]}&nbsp;</font></td>
						<td bgcolor=$color nowrap><font face=\"helvetica, arial\" size=2>{$row[6]}&nbsp;</font></td>
					</tr>" );
		
		}

		print( "		
						</table>
					</td></tr>
				</table>" );

		// Build links to additional ug_pages
		$Query = "SELECT DISTINCT album.albumid, album.userid, DATE_FORMAT( album.createdate, '%m-%d-%Y' ), DATE_FORMAT( album.updatedate, '%m-%d-%Y' ), album.title, album.comment, 
		          album.views, album.year, album.make, album.model, album.drive, 
				  album.mileage, album.photos, album.avgvote, user.state2 FROM rr_album as album, rr_user as user, rr_photo as photo WHERE album.userid=user.userid AND photo.albumid=album.albumid AND album.hide=0";

		$dbResult = mysql2i_query( $Query, $settings->dbLink );
		DB_Error( $settings->dbLink );

		$countrow = mysql2i_num_rows( $dbResult );

		print( "Additional Pages: " );

		$ug_pageCount = 1;
		for ( $iCount = 0; $iCount < $countrow; $iCount += 20 )
		{
			if ( $iCount != $startrow )
			{
				print( " <a href=\"$settings->main_url/ug_index.php?&sorttype=$sorttype&startrow=$iCount\">$ug_pageCount</a> |" );
			}
			else
			{
				print( " $ug_pageCount |" );
			}

			$ug_pageCount++;
		}

		// Put list of galleries in drop down box.
		if ( $settings->boardtype == "VB" )
		{
			$Query = "SELECT DISTINCT user.userid, user.username, user.galleryname FROM rr_user as user, rr_album as album WHERE user.userid=album.userid AND album.hide=0 ORDER BY user.username";
			$dbResult = mysql2i_query( $Query, $settings->dbLink );
			DB_Error( $settings->dbLink );

			$numrows = mysql2i_num_rows( $dbResult );

			print( "<p><table border=0><tr><td>Jump To Gallery:</td></tr>
					<tr><td><FORM METHOD=\"post\" ACTION=\"ug_displaygallery.php\"><select name=\"userid\" style=\"font-size : 10; font-family : courier;\">" );

			for( $icount = 0; $icount < $numrows; $icount++ )
			{
				if ( !$galleryrow = mysql2i_fetch_array( $dbResult ) )
					break;
				
				$galleryrow = DBDecode( $galleryrow );
				
				printf( "<option value=\"{$galleryrow['userid']}\">%-15s -- %-20s", $galleryrow["username"], $galleryrow["galleryname"] );
			}
		}
		else
		{
			$Query = "SELECT userid, username, galleryname FROM rr_user ORDER BY username";
			$dbResult = mysql2i_query( $Query, $settings->dbLink );
			DB_Error( $settings->dbLink );

			$numrows = mysql2i_num_rows( $dbResult );

			print( "<p><table border=0><tr><td>Jump To Gallery:</td></tr>
					<tr><td><FORM METHOD=\"post\" ACTION=\"ug_displaygallery.php\"><select name=\"userid\" style=\"font-size : 10; font-family : courier;\">" );

			for( $icount = 0; $icount < $numrows; $icount++ )
			{
				if ( !$galleryrow = mysql2i_fetch_array( $dbResult ) )
					break;
				
				$galleryrow = DBDecode( $galleryrow );
				
				printf( "<option value=\"{$galleryrow[userid]}\">%-15s -- %-20s", $galleryrow["username"], $galleryrow["galleryname"] );
			}
		}
		
		print( "</select><INPUT SRC=\"go.gif\" type=\"image\" name=\"gallery\" valign=\"top\" hspace=4 border=0></form></td></tr></table><br></center>" );
	}

include_once( "ug_page_footer.php" );

