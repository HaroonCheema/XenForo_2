<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require __DIR__ . '/pedigreesConfig/dog_include/bulldog_common.php';
require __DIR__ . '/pedigreesConfig/dog_include/bulldog_functions.php';


// #######################################################################
// ######################## START MAIN SCRIPT ############################
// #######################################################################

// Database
$count_min = FindFieldValue("count_min", 20);

$sort = FindFieldValue("sort_by", "champs");

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
// 	";
// $result = mysql_query($query, $con);
// while ($row = mysql_fetch_array($result)) {
//     $dogs[$row["owner_id"]] = $row["dog_count"];
// }

$dogs = [];

$rows = $sourceDb->fetchAll("
    SELECT 
        b.owner_id,
        COUNT(d.dog_id) AS dog_count
    FROM owners AS b
    LEFT JOIN dogs AS d
        ON d.dog_owner = b.owner_id
    WHERE
        d.dog_id > 1
        AND d.dog_deleted = 0
        AND b.owner_id > 1
    GROUP BY b.owner_id
");

foreach ($rows as $row) {
    $dogs[(int)$row['owner_id']] = (int)$row['dog_count'];
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
    WHERE
        d.dog_id > 1
        AND d.dog_deleted = 0
        AND d.dog_title_show = 2
        AND b.owner_id > 1
    GROUP BY b.owner_id
    ORDER BY
        dog_count DESC,
        b.owner_name ASC
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
    WHERE
        d.dog_id > 1
        AND d.dog_deleted = 0
        AND d.dog_title_show = 3
        AND b.owner_id > 1
    GROUP BY b.owner_id
    ORDER BY
        dog_count DESC,
        b.owner_name ASC
");

foreach ($rows as $row) {
    $grand_champ[(int)$row['owner_id']] = (int)$row['dog_count'];
}


$content = '';

$content .= '<div class="block-container">
		<div class="p-body-inner">';

$content .= "<form name='owner_form' action='$url_owners_stats' method='post'>";

// *************************************************************** MAIN TABLE ************************************************************************
$content .= "<table width='100%' border='0'>";
$caption = "OWNER STATISTICS";
$content .= "<caption id='page_title'>$caption</caption>";

$style = "padding: 7px; text-align:center;";
$data = [];
$data["grch"] = "By Grand Champions";
$data["champs"] = "By Champs";
$data["dogs"] = "By Dogs";
$choices = MakeSelectChoices($data, $sort);
$select = "<select name='sort_by' onchange='submit()'>$choices</select>";
$content .= "<tr><td colspan='3' style='$style'>Sort By $select</td></tr>";


//================================================================  Dogs Owned =====================================================================
$content .= "<tr>";
$content .= "<td valign='top' width='50%'>";
$content .= "<table border='1' align='center'>";
$style = "margin-top:10px;";
$content .= "<caption class='page_subtitle' style='$style'>DOGS OWNED</caption>";
$content .= "<tr>";
$style = "font-weight:bold; padding: 3px; text-align:center; text-transform: uppercase;";
$content .= "<td style='$style'>#</td>";
$content .= "<td style='$style'>Owner</td>";
$content .= "<td style='$style'># Grand Champs</td>";
$content .= "<td style='$style'># Champions</td>";
$content .= "<td style='$style'># of Dogs</td>";
$content .= "</tr>";
$style = "text-align: center; padding-left: 4px; paddding-right: 4px; padding-top:2px; padding-bottom: 2px;font-size:smaller;";

switch ($sort) {
    case "breeds":
        $array = $breeding_data;
        break;
    case "champs":
        $array = $champ;
        break;
    case "grch":
        $array = $grand_champ;
        break;
    default:
        $array = $dogs;
}
arsort($array);
$i = 0;
foreach ($array as $owner_id => $count) {
    $i++;

    $content .= "<tr>";

    // Index
    $content .= "<td style='$style'>$i</td>";

    // owner
    // $field = "owner_name";
    // $SQL_QRY = "SELECT TRIM($field) as '$field' FROM owners WHERE owner_id=$owner_id";
    // $owner_name = Query_Database_Value($SQL_QRY, $con, $field);
    $owner_name = $sourceDb->fetchOne(
        "SELECT TRIM(owner_name) FROM owners WHERE owner_id = ?",
        $owner_id
    );
    $owner_link = "<a href='$url_owners_profile?owner_id=$owner_id'>$owner_name</a>";
    $content .= "<td style='$style'>$owner_link</td>";

    // Grand Champions
    if (array_key_exists($owner_id, $grand_champ)) {
        $grand_champ_count = $grand_champ[$owner_id];
    } else {
        $grand_champ_count = "";
    }
    $content .= "<td style='$style'>$grand_champ_count</td>";

    // Champions
    if (array_key_exists($owner_id, $champ)) {
        $champ_count = $champ[$owner_id];
    } else {
        $champ_count = "";
    }
    $content .= "<td style='$style'>$champ_count</td>";

    // Dog Count
    if (array_key_exists($owner_id, $dogs)) {
        $dog_count = $dogs[$owner_id];
    } else {
        $dog_count = "";
    }
    $content .= "<td style='$style'>$dog_count</td>";

    $content .= "</tr>";
}

$content .= "</table>";

$content .= "</form>";
$content .= "</td>";

$content .= "</td>";

// *************************************************************** CLOSE MAIN TABLE *******************************************************************
$content .= "</tr>";
$content .= "</table>";

$content .= "</div></div>";

/* continue appending the rest exactly the same way */

\ScriptsPages\Setup::$test = true; // REQUIRED if license check fails

\ScriptsPages\Setup::set([
    'init'    => true,
    'navigation_id' => 'pedigrees',
    'title'   => 'OWNER STATISTICS',
    'content' => $content,
    'raw'     => false
]);

$response = $app->run();
$response->send();
