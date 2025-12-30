<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require __DIR__ . '/pedigreesConfig/dog_include/bulldog_common.php';
require __DIR__ . '/pedigreesConfig/dog_include/bulldog_functions.php';


// #######################################################################
// ######################## START MAIN SCRIPT ############################
// #######################################################################

$content = '';

$content .= '<div class="block-container">
		<div class="p-body-inner">';

// Jquery
$content .= "<link rel='stylesheet' href='//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css'>";
$content .= "<script type='text/javascript' src='./java/jquery-1.11.0.min.js'></script>";
$content .= "<script type='text/javascript' src='./java/jquery-ui-1.10.4.js'></script>";
$content .= "<script type='text/javascript' src='./java/jquery.cookie.js'></script>";
$content .= "<script type='text/javascript' src='./jquery/js_owners_view.js'></script>";

// Basic Variables
$pagetitle = 'owners';
$US_idx = 2;
$rows_page = FindFieldValue("rows_page", 25, FALSE, TRUE, FALSE, TRUE);
$letter = FindFieldValue("letter");
$page = FindFieldValue("page", 0);

$submit = FindFieldValue("submit_type");
$status = FindFieldValue("status");
$owner_id = FindFieldValue("owner_id");
$merge_to = FindFieldValue("merge_to", 0);

$in_queue = strtolower(FindCheckboxValue("in_queue", "", FALSE, TRUE, TRUE));
$in_reject = strtolower(FindCheckboxValue("in_reject", "", FALSE, TRUE, TRUE));
$in_legacy = strtolower(FindCheckboxValue("in_legacy", "on", FALSE, TRUE, TRUE));
$in_accept = strtolower(FindCheckboxValue("in_accept", "on", FALSE, TRUE, TRUE));


// Develop the Where clause
$where_letter = "";
$in_array = [];
if ($in_queue == "on") {
    array_push($in_array, 0);
}
if ($in_reject == "on") {
    array_push($in_array, 1);
}
if ($in_legacy == "on") {
    array_push($in_array, 2);
}
if ($in_accept == "on") {
    array_push($in_array, 3);
}
$sep = "";
$in_where = "";
foreach ($in_array as $key => $value) {
    $in_where .= "$sep$value";
    $sep = ", ";
}
// if (($usergroupid > 4) and ($usergroupid < 8)) {
//     $in_where = " status IN ($in_where)";
// } else {
//     $in_where = " status IN (2,3)";
// }

// ============================================== MODERATOR OPTIONS ==============================================================================
if ($submit == "approve") {

    // Package the update
    $data = [];
    $data["status"] = $status;

    $old_vals = [];
    // Load_Old_Vals("owners", $data, "owner_id", $owner_id);
    // Log_Changes("owners", $owner_id);
    // $query = PackageUpdate("owners", $data, "owner_id", $owner_id);

    // mysql_query($query, $con);

    $sourceDb->update(
        'owners',
        $data,
        'owner_id = ?',
        $owner_id
    );
}

if ($submit == "reject") {

    // Package the update
    $data = [];
    $data["status"] = $status;

    // Load old values
    $old_vals = [];
    Load_Old_Vals("owners", $data, "owner_id", $owner_id);

    // Set the update and log changes
    // $query = PackageUpdate("owners", $data, "owner_id", $owner_id);

    // mysql_query($query, $con);

    $sourceDb->update(
        'owners',
        $data,
        'owner_id = ?',
        $owner_id
    );
    // Log_Changes("owners", $owner_id);

    // Move the dogs attached to the old owner to the new owner
    // if ($merge_to > 0) {
    //     $query = "
    // 			SELECT dog_id
    // 			FROM dogs
    // 			WHERE dog_owner=$owner_id
    // 		";
    //     $dog_id_list = [];
    //     $result = mysql_query($query, $con);
    //     while ($row = mysql_fetch_array($result)) {
    //         $dog_id = $row["dog_id"];

    //         // zlog the change
    //         $data = [];
    //         $data["user_id"] = $current_user;
    //         $data["bulldog_id"] = $dog_id;
    //         $data["new_val"] = $merge_to;
    //         $table = "zlog_dog_owner";
    //         $query = PackageInsert($table, $data);
    //         mysql_query($query, $con);

    //         // Update the record
    //         $table = "dogs";
    //         $data = [];
    //         $data["dog_owner"] = $merge_to;
    //         $index = "dog_id";
    //         $query = PackageUpdate($table, $data, $index, $dog_id);
    //         mysql_query($query, $con);
    //     }
    // }

    if ($merge_to > 0) {
        /** @var \XF\Db\AbstractAdapter $sourceDb */

        // Fetch dog IDs for this owner
        $dogIds = $sourceDb->fetchAllColumn(
            'SELECT dog_id FROM dogs WHERE dog_owner = ?',
            $owner_id
        );

        foreach ($dogIds as $dog_id) {
            // Log the change
            $sourceDb->insert('zlog_dog_owner', [
                'user_id'    => $current_user,
                'bulldog_id' => $dog_id,
                'new_val'    => $merge_to
            ]);

            // Update dog owner
            $sourceDb->update(
                'dogs',
                ['dog_owner' => $merge_to],
                'dog_id = ?',
                $dog_id
            );
        }
    }
}

// Calculate the total number of owners
// $query = "
// 		SELECT
// 			count(owner_id) as 'owner_count'
// 		FROM
// 			owners
// 	";
// $owner_count_total = Query_Database_Value($query, $con, "owner_count") - 1;

$owner_count_total = (int)$sourceDb->fetchOne(
    'SELECT COUNT(owner_id) FROM owners'
) - 1;


// Calculate the total number of owners for the letter	
// if (!empty($letter)) {
//     $where_letter = " AND UPPER(LEFT(TRIM(owner_name),1)) = '$letter' ";
// }
// $query = "
// 		SELECT
// 			count(owner_id) as 'owner_count'
// 		FROM
// 			owners
// 		WHERE
// 			owner_id>1 AND
// 			$in_where
// 			$where_letter
// 		ORDER BY
// 			owner_name ASC
// 	";
// $owner_count = Query_Database_Value($query, $con, "owner_count");
// $max_page = floor(($owner_count - 1) / $rows_page);
// $page = $page > $max_page ? $max_page : $page;

/** @var \XF\Db\AbstractAdapter $sourceDb */

$where = [];
$binds = [];

// owner_id > 1
$where[] = 'owner_id > 1';

// existing IN condition (kept as-is, assumed safe)
if (!empty($in_where)) {
    $where[] = $in_where;
}


// first-letter filter
if (!empty($letter)) {
    $where[] = 'UPPER(LEFT(TRIM(owner_name), 1)) = ?';
    $binds[] = strtoupper($letter);
}

$whereSql = implode(' AND ', $where);

// COUNT query (ORDER BY removed — unnecessary for COUNT)
$owner_count = (int)$sourceDb->fetchOne(
    "
        SELECT COUNT(owner_id)
        FROM owners
        WHERE $whereSql
    ",
    $binds
);

// Pagination logic (unchanged)
$max_page = (int)floor(($owner_count - 1) / $rows_page);
$page = ($page > $max_page) ? $max_page : $page;


// Number of Dogs
// $query = "
// 		Select 
// 			b.owner_id, 
// 			count(d.dog_id) as 'dog_count'
// 		FROM 
// 			owners b
// 		LEFT OUTER JOIN 
// 			dogs d
// 		ON 
// 			d.dog_owner=b.owner_id
// 		WHERE
// 			d.dog_id>1 AND
// 			d.dog_deleted=0 AND 
// 			b.owner_id>1
// 		GROUP BY
// 			b.owner_id
// 		ORDER BY
// 			dog_count DESC,	
// 			owner_name ASC	
// 	";
// $result = mysql_query($query, $con);
// $dog_count = [];
// while ($row = mysql_fetch_array($result)) {
//     $dog_count[$row["owner_id"]] = $row["dog_count"];
// }



$dog_count = [];

$rows = $sourceDb->fetchAll("
    SELECT 
        b.owner_id,
        COUNT(d.dog_id) AS dog_count
    FROM owners AS b
    LEFT JOIN dogs AS d
        ON d.dog_owner = b.owner_id
        AND d.dog_id > 1
        AND d.dog_deleted = 0
    WHERE b.owner_id > 1
    GROUP BY b.owner_id
    ORDER BY dog_count DESC, b.owner_name ASC
");

foreach ($rows as $row) {
    $dog_count[(int)$row['owner_id']] = (int)$row['dog_count'];
}


// Number of Champions
// $query = "
// 		Select 
// 			b.owner_id, 
// 			count(d.dog_id) as 'dog_count'
// 		FROM 
// 			owners b
// 		LEFT OUTER JOIN 
// 			dogs d
// 		ON 
// 			d.dog_owner=b.owner_id
// 		WHERE
// 			d.dog_id>1 AND
// 			d.dog_deleted=0 AND 
// 			d.dog_title_show=2 AND
// 			b.owner_id>1
// 		GROUP BY
// 			b.owner_id
// 		ORDER BY
// 			dog_count DESC,	
// 			owner_name ASC	
// 	";
// $result = mysql_query($query, $con);
// $champ = [];
// while ($row = mysql_fetch_array($result)) {
//     $champ[$row["owner_id"]] = $row["dog_count"];
// }

$champ = [];

$rows = $sourceDb->fetchAll("
    SELECT
        b.owner_id,
        COUNT(d.dog_id) AS dog_count
    FROM owners AS b
    LEFT JOIN dogs AS d
        ON d.dog_owner = b.owner_id
        AND d.dog_id > 1
        AND d.dog_deleted = 0
        AND d.dog_title_show = 2
    WHERE b.owner_id > 1
    GROUP BY b.owner_id
    ORDER BY dog_count DESC, b.owner_name ASC
");

foreach ($rows as $row) {
    $champ[(int)$row['owner_id']] = (int)$row['dog_count'];
}


// Number of Grand Champions
// $query = "
// 		Select 
// 			b.owner_id, 
// 			count(d.dog_id) as 'dog_count'
// 		FROM 
// 			owners b
// 		LEFT OUTER JOIN 
// 			dogs d
// 		ON 
// 			d.dog_owner=b.owner_id
// 		WHERE
// 			d.dog_id>1 AND
// 			d.dog_deleted=0 AND 
// 			d.dog_title_show=3 AND
// 			b.owner_id>1
// 		GROUP BY
// 			b.owner_id
// 		ORDER BY
// 			dog_count DESC,	
// 			owner_name ASC	
// 	";
// $result = mysql_query($query, $con);
// $grand_champ = [];
// while ($row = mysql_fetch_array($result)) {
//     $grand_champ[$row["owner_id"]] = $row["dog_count"];
// }

$grand_champ = [];

$rows = $sourceDb->fetchAll("
    SELECT
        b.owner_id,
        COUNT(d.dog_id) AS dog_count
    FROM owners AS b
    LEFT JOIN dogs AS d
        ON d.dog_owner = b.owner_id
        AND d.dog_id > 1
        AND d.dog_deleted = 0
        AND d.dog_title_show = 3
    WHERE b.owner_id > 1
    GROUP BY b.owner_id
    ORDER BY dog_count DESC, b.owner_name ASC
");

foreach ($rows as $row) {
    $grand_champ[(int)$row['owner_id']] = (int)$row['dog_count'];
}


// The Title
$content .= '<div class="page_title">View Owners</div>';

// The Alphabet
$i = 65;
$content .= "<table style='margin-bottom: 1em;' align='center' border='0'>";
$content .= "<tr>";
$style = "padding-right: 1em;";
$content .= "<td style='$style'><a href='$url_owners_view?rows_page=$rows_page'>All</a></td>";
while ($i <= 90) {
    $content .= "<td style='$style'><a href='$url_owners_view?letter=" . chr($i) . "&rows_page=$rows_page'>" . chr($i) . "</a></td>";
    $i++;
}
$content .= "</tr>";
$content .= "</table>";

// Subtitle
if (!empty($letter)) {
    $content .= "<div class='page_subtitle'>Starting with '$letter'</div>";
} else {
    $content .= "<div class='page_subtitle'>All Owners</div>";
}

// Which records to view
$style = 'padding: 8px;';
$content .= "<form id='view_owners' action='$url_owners_view' method='post'>";
if (true) {
    // if ($usergroupid == 6) {
    $content .= "<table style='margin-top:1em; margin-bottom:1em;' align='center' border='1'>";
    $content .= "<tr>";

    // In Queue
    $checked = "";
    if (strtolower($in_queue) == "on") {
        $checked = "CHECKED";
    }
    $checkbox = "<input type='checkbox' class='status_checkbox' name='in_queue' $checked>In Queue";
    $content .= "<td style='$style'>$checkbox</td>";

    // In reject
    $checked = "";
    if (strtolower($in_reject) == "on") {
        $checked = "CHECKED";
    }
    $checkbox = "<input type='checkbox' class='status_checkbox' name='in_reject' $checked>Rejected";
    $content .= "<td style='$style'>$checkbox</td>";

    // In Legacy
    $checked = "";
    if (strtolower($in_legacy) == "on") {
        $checked = "CHECKED";
    }
    $checkbox = "<input type='checkbox' class='status_checkbox' name='in_legacy' $checked>Legacy";
    $content .= "<td style='$style'>$checkbox</td>";

    // In Accepted
    $checked = "";
    if (strtolower($in_accept) == "on") {
        $checked = "CHECKED";
    }
    $checkbox = "<input type='checkbox' class='status_checkbox' name='in_accept' $checked>Accepted";
    $content .= "<td style='$style'>$checkbox</td>";

    $content .= "</tr>";
    $content .= "</table>";
}

// Store important data for jquery
// $content .= '<input type="hidden" name="securitytoken" value="' . $security_token . '" /> ';
$content .= "<input type='hidden' id='letter' name='letter' value='$letter'/>";
$content .= "<input type='hidden' id='page' name='page' value='$page'/>";
$content .= "<input type='hidden' id='max_page' name='max_page' value='$max_page'/>";
$content .= "<input type='hidden' id='url_owners_view' value='$url_owners_view'/>";

// Moderator options
$content .= "<input type='hidden' id='owner_id' name='owner_id' value=''/>";
$content .= "<input type='hidden' id='submit_type' name='submit_type' value=''/>";
$content .= "<input type='hidden' id='status' name='status' value=''/>";
$content .= "<input type='hidden' id='merge_to' name='merge_to' value='0'/>";

$content .= "</form>";


$start = $page < 0 ? 0 : $page * $rows_page;
$limit = "$start,$rows_page";

// $query = "
// 		SELECT
// 			b.owner_id, 		
// 			UPPER(b.owner_name)		AS 'name',
// 			b.owner_createdby 		AS 'by',
// 			b.owner_email 			AS 'email',
// 			b.owner_homepage 			AS 'web',
// 			c.country_name 				AS 'country',
// 			b.status					AS 'status'
// 		FROM
// 			owners b
// 		INNER JOIN
// 			countries c
// 		ON
// 			b.owner_countryid = c.country_id

// 		ORDER BY
// 			owner_name ASC
// 		LIMIT
// 			$limit			 
// 	";
// $result = mysql_query($query, $con);

// $result = $sourceDb->fetchAll(
//     "
//     SELECT
//         b.owner_id,
//         UPPER(b.owner_name) AS name,
//         b.owner_createdby AS by,
//         b.owner_email AS email,
//         b.owner_homepage AS web,
//         c.country_name AS country,
//         b.status AS status
//     FROM owners AS b
//     INNER JOIN countries AS c
//         ON b.owner_countryid = c.country_id
//     ORDER BY b.owner_name ASC
//     LIMIT ?
//     ",
//     $limit
// );

$start = $page * $rows_page;
$count = $rows_page;

$limit_sql = intval($start) . ', ' . intval($count);

$result = $sourceDb->fetchAll("
    SELECT
        b.owner_id,
        UPPER(b.owner_name) AS name,
        b.owner_createdby AS `by`,
        b.owner_email AS email,
        b.owner_homepage AS web,
        c.country_name AS country,
        b.status AS status
    FROM owners AS b
    INNER JOIN countries AS c
        ON b.owner_countryid = c.country_id
    ORDER BY b.owner_name ASC
    LIMIT $limit_sql
");

// echo "<pre>";
// var_dump($result, $limit);
// exit;


// *************** Table Header *******************************
$content .= "<table border='1' class='pb_table' width='100%' align='center'";
$content .= "<tr>";
$content .= "<th width='3%' class='pb_th' >#</th>";
$content .= "<th width='3%' class='pb_th' >" . captitle("ID") . "</th>";
$content .= "<th width='3%' class='pb_th' >" . captitle("Creator") . "</th>";
if (true) {
    // if ($usergroupid == 6) {
    $content .= "<th width='3%' class='pb_th' >" . captitle("Status") . "</th>";
    $content .= "<th width='3%' class='pb_th' >" . captitle("Approve") . "</th>";
    $content .= "<th class='pb_th' width='20%'>" . captitle("Reject Reason / Merge Dogs Into") . "</th>";
}
$content .= "<th class='pb_th' >" . captitle("Owner") . "</th>";
$content .= "<th width='3%' class='pb_th' >" . captitle("dogs") . "</th>";
$content .= "<th width='3%' class='pb_th' >" . captitle("Ch") . "</th>";
$content .= "<th width='3%' class='pb_th' >" . captitle("GrCh") . "</th>";
$content .= "<th width='3%' class='pb_th' >" . captitle("Breeds") . "</th>";
$content .= "<th class='pb_th' >" . captitle("Email") . "</th>";
$content .= "<th class='pb_th' >" . captitle("Webpage") . "</th>";
$content .= "<th class='pb_th' >" . captitle("Country") . "</th>";
$content .= "</tr>";

$idx = $page * $rows_page;
foreach ($result as $row) {
    $content .= "<tr>";
    $idx++;
    $style = "text-align: center; padding-left: 7px; padding-right: 7px; padding-top:2px; padding-bottom: 2px; font-size:smaller;";
    $owner_id = $row["owner_id"];
    $status = $row["status"];
    $status_name = getStatus($status);
    $createdby = $row["by"];
    $creator_name = GetUser($createdby, $db);


    $creator_link = "<a href='$url_member?$createdby'>$creator_name</a>";
    if (array_key_exists($owner_id, $dog_count)) {
        $dogcount = $dog_count[$owner_id];
    } else {
        $dogcount = "";
    }

    $content .= "<td style='$style' align='center'>$idx</td>";

    // Owner id
    $content .= "<td style='$style' align='center'>$owner_id</td>";

    // Created by
    $content .= "<td style='$style' align='center'>$creator_link</td>";

    // Delete
    if (true) {
        // if ($usergroupid == 6) {

        // Status
        $content .= "<td style='$style' align='center'>$status_name</td>";

        // Approve?
        if ($status != 3) {
            $approve_btn = "<input type='button' class='btn_approve' value='Approve' owner_id=$owner_id >";
        } else {
            $approve_btn = "";
        }
        $content .= "<td style='$style' align='center'>$approve_btn</td>";

        // Reject Reason
        if ($status != 1) {
            $reject_btn = "<input type='button' class='btn_reject' style='margin-right:1em;margin-top:2px; margin-bottom:2px;' value='Reject' owner_id=$owner_id >";
            $hidden_dog_count = "<input type='hidden' id='dog_count_$owner_id' value='$dogcount'/>";
            if ((!empty($dogcount))) {
                $merge_into = "<input type='text' id='merge_$owner_id' owner_id=$owner_id class='merge' value='' size=25 maxlength=100 autocomplete='off' placeholder='Merge Dogs Into Owner...' title='Move the dogs attached to the current owner to the one named here.'>";
            } else {
                $merge_into = "";
            }
            $content .= "<td style='$style text-align:left;' >$hidden_dog_count $reject_btn $merge_into</td>";
        } else {
            $content .= "<td style='$style text-align:left;' >&nbsp;</td>";
        }
    }

    // owner Name
    $name = $row["name"];
    $value = "<a href='$url_owners_profile?owner_id=$owner_id' target='owner'>$name</a>";
    $content .= "<td style='$style text-align:left;'>$value</td>";

    // Dogs
    $content .= "<td style='$style' align='center'>$dogcount</td>";

    // Champions
    if (array_key_exists($owner_id, $champ)) {
        $champ_count = $champ[$owner_id];
    } else {
        $champ_count = "";
    }
    $content .= "<td style='$style' align='center'>$champ_count</td>";

    // Grand Champions
    if (array_key_exists($owner_id, $grand_champ)) {
        $count = $grand_champ[$owner_id];
    } else {
        $count = "";
    }
    $content .= "<td style='style' align='center'>$count</td>";

    // owner email
    $email = $row["email"];
    $content .= "<td style='$style'>$email</td>";

    // owner webpage
    $webpage = $row["web"];
    $content .= "<td style='$style'>$webpage</td>";

    // owner country
    $country = $row["country"];
    $content .= "<td style='$style'>$country</td>";

    $content .= "</tr>";
}
$content .= "</table>";

// Prev Page
$content .= "<table class='pb_table' width='100%' align='center' border='0'>";
$content .= "<tr>";

// Rows per page
$data = [];
$data[10] = "10 Rows";
$data[25] = "25 Rows";
$data[50] = "50 Rows";
$data[100] = "100 Rows";
$choices = MakeSelectChoices($data, $rows_page);
$select = "<select id='rows_page' class='pb_select' name='rows_page'>$choices.</select>";
$content .= "<td align='center' width='10%'>$select</td>";

// Record spread
$owner_count = empty($owner_count) ? 0 : $owner_count;
$end = $start + $rows_page >= $owner_count ? $owner_count : $start + $rows_page;
$content .= "<td align='center' width='20%'>Records $start - $end of $owner_count in Filter</td>";

$prev = "<input id='prev' class='pb_button' type='button' name='page_jump' value='Prev'>";
$next = "<input id='next' class='pb_button' type='button' name='page_jump' value='Next'>";
$content .= "<td width='20%' align='right'>$prev</td>";
$content .= "<td width='20%'>$next</td>";

// Total number of owners
$content .= "<td align='center' width='20%'>Total number of Owners = $owner_count_total</td>";

$cur_page = $page + 1;
$cur_max = $max_page + 1;
$content .= "<td width='10%' nowrap align='center'>Page $cur_page of $cur_max</td>";

$content .= "</tr>";
$content .= "</table>";

// End owners
$content .= "<div id='search_results'></div>";


$content .= "</div></div>";

/* continue appending the rest exactly the same way */

\ScriptsPages\Setup::$test = true; // REQUIRED if license check fails

\ScriptsPages\Setup::set([
    'init'    => true,
    'navigation_id' => 'pedigrees',
    'title'   => $pagetitle,
    'content' => $content,
    'raw'     => false
]);

$response = $app->run();
$response->send();
