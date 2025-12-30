<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require __DIR__ . '/pedigreesConfig/dog_include/bulldog_common.php';
require __DIR__ . '/pedigreesConfig/dog_include/bulldog_functions.php';

// echo "<pre>";
// var_dump($visitor);
// exit;

if (!$visitor) {
    \ScriptsPages\Setup::$test = true; // REQUIRED if license check fails

    \ScriptsPages\Setup::set([
        'init'    => true,
        'navigation_id' => 'pedigrees',
        'title'   => 'Add Owner',
        'content' => '<div class="p-body-main"><div class="p-body-content"><div class="p-body-pageContent"><div class="blockMessage blockMessage--error blockMessage--iconic" bis_skin_checked="1">
		You must be logged-in to do that.
	</div></div></div></div>',
        'raw'     => false
    ]);

    $response = $app->run();
    $response->send();
}

// echo "<pre>";
// var_dump($visitor);
// exit;

// $xf = require __DIR__ . '/pedigreesConfig/common.php';

// $app      = $xf['app'];
// $request  = $xf['request'];
// $session  = $xf['session'];
// $db       = $xf['db'];
// $visitor  = $xf['visitor'];
// $sourceDb = $xf['sourceDb'];



// $csrfToken = csrf_token();

// echo "<pre>";
// var_dump($app['csrf.token']);
// exit;

$content = '';

$content = '<div class="block-container">
		<div class="p-body-inner">';

$phrasegroups = array();

// get special data templates from the datastore
$specialtemplates = array();

// pre-cache templates used by all actions
$globaltemplates = array(
    'PEDIGREE_DATABASE',
);

// pre-cache templates used by specific actions
$actiontemplates = array();

// $security_token = $session->getCsrfToken();
$currentUserId = $visitor->user_id;


// #######################################################################
// ######################## START MAIN SCRIPT ############################
// #######################################################################


function getCountryName($country_id, $sourceDb)
{
    global $con;
    $field = "country_name";
    return $sourceDb->fetchOne("SELECT $field FROM countries WHERE country_id=$country_id");
}

function IsOwnerAlreadyIn($owner_name, $sourceDb)
{
    global $con;

    // Does the owner name already exist?
    // $SQL_QRY = "SELECT count(owner_id) as 'count' FROM owners WHERE trim(owner_name)='$owner_name'";

    $count = $sourceDb->fetchOne("SELECT count(owner_id) as 'count' FROM owners WHERE trim(owner_name)='$owner_name'");
    if ($count > 0) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function RetrieveFieldValue($field, $default = "")
{
    global $owner_data;

    if (isset($owner_data[$field])) {
        return MYSQLtoString($owner_data[$field]);
    } else {
        return $default;
    }
}

// function MYSQLtoString($value, $default = '')
// {
//     if ($value === null) {
//         return $default;
//     }

//     return trim((string)$value);
// }

function InvalidChars($string)
{
    global $err;

    if (strlen($string) == 0) {
        return FALSE;
    }
    for ($i = 0; $i < strlen($string); $i++) {
        $char = substr($string, $i, 1);
        $ascii = ord($char);

        // Special attention to the first character
        if ($i == 0) {
            // Is alphanumeric?
            if ((($ascii > 47) and ($ascii < 58)) or (($ascii > 64) and ($ascii < 91)) or (($ascii > 96) and ($ascii < 123))) {
                // move forward. It's alphanumeric
            } else {
                $err = "First character must be alphanumeric.";
            }
        }

        if (($ascii < 32) or ($ascii == 60) or ($ascii == 62) or ($ascii == 34)) {
            $err = "'$char' is an invalid character.";
            return TRUE;
        }
    }
    return FALSE;
}

// function Select_Table_Choices(string $table, string $valueField, string $textField, $selectedValue, $sourceDb): string
// {
//     $options = '';
//     $rows = $sourceDb->fetchAll("SELECT $valueField, $textField FROM $table ORDER BY $textField ASC");

//     foreach ($rows as $row) {
//         $value = htmlspecialchars($row[$valueField], ENT_QUOTES, 'UTF-8');
//         $text = htmlspecialchars($row[$textField], ENT_QUOTES, 'UTF-8');
//         $selected = ($row[$valueField] == $selectedValue) ? ' selected' : '';
//         $options .= "<option value='$value'$selected>$text</option>";
//     }

//     return $options;
// }

// Jquery
$content .= "<link rel='stylesheet' href='//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css'>";
$content .= "<script type='text/javascript' src='./java/jquery-1.11.0.min.js'></script>";
$content .= "<script type='text/javascript' src='./java/jquery-ui-1.10.4.js'></script>";
$content .= "<script type='text/javascript' src='./java/jquery.cookie.js'></script>";
$content .= "<script type='text/javascript' src='./jquery/js_owners_add.js'></script>";

// Key Variables
$pagetitle = 'Add Owner';
// $owner_id = FindFieldValue("owner_id");
$owner_id = $request->filter('owner_id', 'uint');

$url_owners_add = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
if ($owner_id == 1) {
    $owner_id = 0;
}

$owner_name = $request->filter('owner_name', 'str'); // string
$submit = $request->filter('submit_breeding', 'str'); // which submit button was pressed

// $owner_name = FindFieldValue("owner_name");
// $submit = FindFieldValue("submit_breeding");
$table = "owners";

// *************************************************** DATA SUBMISSION ********************************************************
$err = "";
$data = [];
$old_vals = [];

if ($submit === 'Save') {
    // Fetch form values
    $owner_name = trim(strtolower($request->filter('owner_name', 'str')));
    $email      = trim($request->filter('owner_email', 'str'));
    $homepage   = trim($request->filter('owner_homepage', 'str'));
    $country_id = $request->filter('owner_countryid', 'uint');

    // Validate
    if ($owner_id === 0) { // New record
        if ($owner_name === '') {
            $err = "The owner name is blank.";
        } elseif ($owner_name === 'unknown') {
            $err = "'Unknown' is a reserved word. Please choose another name.";
        } elseif (isOwnerAlreadyIn($owner_name, $sourceDb)) {
            $err = "'$owner_name' is already in the database.";
        } elseif (InvalidChars($owner_name)) {
            $err = "Owner: $err";
        } elseif (InvalidChars($email)) {
            $err = "Email: $err";
        } elseif (InvalidChars($homepage)) {
            $err = "Homepage: $err";
        } else {
            // Prepare insert data
            $data = [
                'owner_name'      => $owner_name,
                'owner_createdby' => $visitor->user_id,
                'owner_email'     => $email,
                'owner_homepage'  => $homepage,
                'owner_countryid' => $country_id,
            ];

            // Insert into database
            $sourceDb->insert('owners', $data);
            $owner_id = $sourceDb->lastInsertId();
        }
    } else { // Update existing
        if (InvalidChars($email)) {
            $err = "Email: $err";
        } elseif (InvalidChars($homepage)) {
            $err = "Homepage: $err";
        } else {
            // Load old values for logging
            $old_vals = $sourceDb->fetchRow("SELECT * FROM owners WHERE owner_id = ?", $owner_id);

            // Prepare update data
            $data = [
                'owner_email'     => $email,
                'owner_homepage'  => $homepage,
                'owner_countryid' => $country_id,
            ];

            // Update record
            $sourceDb->update('owners', $data, 'owner_id = ' . $sourceDb->quote($owner_id));

            // Log changes
            // Log_Changes('owners', $owner_id, $old_vals, $data, $visitor->user_id);
        }
    }
}


// if ($submit == "Save") {

//     if (strlen($err) == 0) {

//         // Load the data into the new array
//         $owner_name = trim(strtolower($request->filter('owner_name', 'str')));
//         $email      = trim($request->filter('owner_email', 'str'));
//         $homepage   = trim($request->filter('owner_homepage', 'str'));
//         $country_id = $request->filter('owner_countryid', 'uint');

//         // Insert or Update?
//         if ($owner_id == 0) {

//             // Load the new values
//             $owner_name = trim(strtolower(FindFieldValue("owner_name")));

//             if (strlen($owner_name) == 0) {
//                 $err = "The owner name is blank.";
//             } else if ($owner_name == "unknown") {
//                 $err = "'Unknown' is a reserved word. Please choose another name.";
//             } else if (IsOwnerAlreadyIn($owner_name, $sourceDb) == TRUE) {
//                 $err = "'$owner_name' is already in the database.";
//             } else if (InvalidChars($owner_name)) {
//                 $err = "Owner: $err";
//             } else if (InvalidChars($email)) {
//                 $err = "Email: $err";
//             } else if (InvalidChars($homepage)) {
//                 $err = "Homepage: $err";
//             } else {
//                 $data["owner_name"] = mysql_real_escape_string(trim($owner_name));
//                 $data["owner_createdby"] = $current_user;
//                 $data["owner_email"]         = mysql_real_escape_string($email);
//                 $data["owner_homepage"]     = mysql_real_escape_string($homepage);
//                 $data["owner_countryid"]    = trim(FindFieldValue("owner_countryid"));
//                 $SQL_QRY = PackageInsert($table, $data);
//                 $owner_id = Query_Insert($SQL_QRY, $con);
//             }
//         } else {
//             if (InvalidChars($email)) {
//                 $err = "Email: $err";
//             } else if (InvalidChars($homepage)) {
//                 $err = "Homepage: $err";
//             } else {

//                 // Establish the new data
//                 $data["owner_email"]         = $email;
//                 $data["owner_homepage"]     = $homepage;
//                 $data["owner_countryid"]    = trim(FindFieldValue("owner_countryid"));
//                 $query = PackageUpdate($table, $data, "owner_id", $owner_id);

//                 // Save the old values
//                 $old_vals = array();
//                 Load_Old_Vals($table, $data, "owner_id", $owner_id);

//                 // Update the record
//                 mysql_query($query, $con);

//                 // Log Changes
//                 Log_Changes($table, $owner_id);
//             }
//         }
//     }

//     // Load the data
//     $data = array();
//     $old_vals = array();
// }


// *************************************************** LOAD OWNER INFORMATION ***********************************************
$owner_data = [];
$owner_log = [];
if ($owner_id > 0) {

    // Load the owner table
    $owner_data = $sourceDb->fetchRow("
        SELECT 
            TRIM(owner_name) AS owner_name,
            DATE_FORMAT(owner_createdon,'%m/%d/%Y %h:%i %p') AS created_on,
            TRIM(owner_email) AS owner_email,
            TRIM(owner_homepage) AS owner_homepage,
            owner_countryid AS owner_countryid,
            owner_createdby AS owner_createdby,
            status AS status
        FROM owners
        WHERE owner_id = ?
    ", $owner_id);

    // echo "<pre>";
    // var_dump($owner_data, $owner_id);
    // exit;

    // Load the change log
    $owner_log = $sourceDb->fetchAll("
        SELECT 
            id,
            DATE_FORMAT(changed_on,'%m/%d/%Y %h:%i %p') AS changed_on,
            changed_by,
            field,
            old_val,
            new_val
        FROM log_owners
        WHERE id = ?
        ORDER BY changed_on ASC
    ", $owner_id);
}

// ****************************************** Build Page **********************************
// Establish form
$content .= "<form id='owner_form' name='owner_form' action='$url_owners_add' method='post'>";

// Hidden Fields
$content .= '<input type="hidden" name="_xfToken" value=' . $app['csrf.token'] . '>';
$content .= "<input type='hidden' id='owner_id' name='owner_id' value='$owner_id' /> ";
$content .= "<input type='hidden' id='url_owners_add' value='$url_owners_add' /> ";

$style = "padding: 7px;";
//================================================================  Build Table =========================================================================================		
$content .= "<table width='40%' border='1' align='center'>";

// Caption
if ($owner_id == 0) {
    $caption = "Add Owner";
} else {
    $caption = "Edit Owner";
}
$content .= "<caption id='page_title'>$caption</caption";

// Owner Name
if ($owner_id == 0) {
    $content .= "<tr><td style='$style' colspan=2>Enter the first few letters of the owner's name. See if the owner is already in the database. New owners will be put in the queue for moderator approval. <font color='red'>.Adding duplicate owners, sloppy entries or non-serious entries will result in the removal of your editing capability, so please enter data carefully.</font></td></tr>";
}
$hint = "Begin entering the first few letters of the owner's name. Review the list that appears below.";
$label = "<label class='data_field1' title='$hint'>Owner</label>";
$value = RetrieveFieldValue("owner_name");

// Cannot edit the owner name from edit
if ($owner_id > 0) {
    $textbox = "<a href='$url_owners_profile?owner_id=$owner_id'>$value</a>";
} else {
    $textbox = "<input type='text' id='search_owners' name='owner_name' value='$value' size=50 maxlength=100 autocomplete='off' placeholder='Search for owner' title='$hint'>";
}
$content .= "<tr><td style='$style'>$label</td><td style='$style'>$textbox</td></tr>";

// owner Email
$title = "Email";
$hint = "Enter the email of the owner.";
$field = "owner_email";
$label = "<label class='data_field1' title='$hint'>$title</label>";
$placeholder = "Enter the owner email address.";
$value = RetrieveFieldValue($field);
$textbox = "<input type='text' name='owner_email' value='$value' size=50 maxlength=100 autocomplete='off' placeholder='$placeholder' title='$hint'>";
$content .= "<tr><td style='$style'>$label</td><td style='$style'>$textbox</td></tr>";

// owner Homepage
$title = "Homepage";
$hint = "Enter the url of the owner homepage.";
$field = "owner_homepage";
$placeholder = "Enter the homepage.";
$label = "<label class='data_field1' title='$hint'>$title</label>";
$value = RetrieveFieldValue($field);
$textbox = "<input type='text' name='owner_homepage' value='$value' size=50 maxlength=100 autocomplete='off' placeholder='$placeholder' title='$hint'>";
$content .= "<tr><td style='$style'>$label</td><td style='$style'>$textbox</td></tr>";

// Country ID
$title = "Country";
$hint = "Select the country of the breeeder from the drop-down list provided.";
$field = "owner_countryid";
$label = "<label class='data_field1' title='$hint'>$title</label>";
$value = RetrieveFieldValue($field, 2);
$choices = "";
$choices = Select_Table_Choices("countries", "country_id", "country_name", $value, $sourceDb);
$select = "<select name='$field'>$choices</select>";
$content .= "<tr><td style='$style'>$label</td><td style='$style'>$select</td></tr>";

// Status
$title = "Status";
$hint = "Change the status of this owner.";
$field = "status";
$label = "<label class='data_field1' title='$hint'>$title</label>";
$value = RetrieveFieldValue($field);
$select = getStatus($value);
$content .= "<input type='hidden' name='status' value='$value' /> ";
if ($owner_id > 0) {
    $content .= "<tr><td style='$style'>$label</td><td style='$style'>$select</td></tr>";
}

// The submit button
$content .= "<tr>";
$content .= "<td colspan=2 align='center' style='padding: 5px;' >";
$content .= "<input type='submit' name='submit_breeding' value='Save'  style='margin-right:15px;margin-top:15;margin-bottom:15;'>";
$content .= "<input type='submit' name='submit_breeding' value='Cancel'></td>";
$content .= "</tr>";

// Was there an error?
if ($err) {
    $content .= "<tr><td style='text-align:center; color:red;' colspan=2>$err</td></tr>";
}

$content .= "</table>";


if ($owner_id > 0) {
    $content .= '<table style="margin-top:2em;" width="40%" border="1" align="center">';
    $content .= '<caption class="page_subtitle" NOWRAP>Change Log</caption>';

    // Header row
    $style = "font-weight:bold; padding:5px; font-size:smaller;";
    $content .= '<tr>';
    $content .= "<td style='$style'>On</td>";
    $content .= "<td style='$style'>User</td>";
    $content .= "<td style='$style'>Changed</td>";
    $content .= "<td style='$style'>From</td>";
    $content .= "<td style='$style'>To</td>";
    $content .= '</tr>';

    // Record Created
    $user_id   = $owner_data['owner_createdby'] ?? 0;
    $user_name = strtoupper(GetUser($user_id, $db));
    $user_link = "<a href='$url_member?$user_id'>$user_name</a>";
    $created_on = $owner_data['created_on'] ?? '';

    $style = "padding-left: 4px; padding-right: 4px; padding-top:2px; padding-bottom: 2px; font-size:smaller;";
    $content .= '<tr>';
    $content .= "<td style='$style'>$created_on</td>";
    $content .= "<td style='$style'>$user_link</td>";
    $content .= "<td style='$style' colspan='3'>Created Owner</td>";
    $content .= '</tr>';

    // Change log entries
    foreach ($owner_log as $row) {
        $log_date = $row['changed_on'];
        $user_id  = $row['changed_by'];
        $user_name = strtoupper(GetUser($user_id, $db));
        $user_link = "<a href='$url_member?$user_id'>$user_name</a>";

        $field_name = $row['field'];
        $old_val = $row['old_val'];
        $new_val = $row['new_val'];

        switch ($field_name) {
            case 'status':
                $old_val = getStatus($old_val);
                $new_val = getStatus($new_val);
                break;
            case 'owner_countryid':
                $field_name = 'country';
                $old_val = getCountryName((int)$old_val, $sourceDb);
                $new_val = getCountryName((int)$new_val, $sourceDb);
                break;
            default:
                // do nothing
        }

        $content .= '<tr>';
        $content .= "<td style='$style'>$log_date</td>";
        $content .= "<td style='$style'>$user_link</td>";
        $content .= "<td style='$style'>$field_name</td>";
        $content .= "<td style='$style'>$old_val</td>";
        $content .= "<td style='$style'>$new_val</td>";
        $content .= '</tr>';
    }

    $content .= '</table>';
}



// if ($owner_id > 0) {
//     $content .= "<table style='margin-top:2em;' width='40%' border='1' align='center'>";
//     $content .= "<caption class='page_subtitle' NOWRAP>Change Log</caption>";

//     $content .= "<tr>";
//     $style = "font-weight:bold; padding:5px; font-size:smaller;";
//     $content .= "<td style='$style'>On</td>";
//     $content .= "<td style='$style'>User</td>";
//     $content .= "<td style='$style'>Changed</td>";
//     $content .= "<td style='$style'>From</td>";
//     $content .= "<td style='$style'>To</td>";
//     $content .= "</tr>";


//     // Record Created
//     $user_id = RetrieveFieldValue("owner_createdby");
//     $user_name = strtoupper(GetUser($user_id, $db));
//     $user_link = "<a href='$url_member?$user_id'>$user_name</a>";
//     $created_on = RetrieveFieldValue("created_on");

//     $style = "padding-left: 4px; padding-right: 4px; padding-top:2px; padding-bottom: 2px; font-size:smaller;";
//     $content .= "<tr>";
//     $content .= "<td style='$style'>$created_on</td>";
//     $content .= "<td style='$style'>$user_link</td>";
//     $content .= "<td style='$style' colspan='3'>Created Owner</td>";
//     $content .= "</tr>";

//     while (($owner_log != FALSE) && ($row = mysql_fetch_array($owner_log))) {
//         $log_date = $row["changed_on"];
//         $user_id = $row["changed_by"];
//         $user_name = strtoupper(GetUser($user_id, $db));
//         $user_link = "<a href='$url_member?$user_id'>$user_name</a>";

//         $field_name = $row["field"];
//         $old_val = $row["old_val"];
//         $new_val = $row["new_val"];
//         switch ($field_name) {
//             case "status":
//                 $old_val = getStatus($old_val);
//                 $new_val = getStatus($new_val);
//                 break;
//             case "owner_countryid":
//                 $field_name = "country";
//                 $old_val = getCountryName($old_val,$sourceDb);
//                 $new_val = getCountryName($new_val,$sourceDb);
//             default:
//                 // do nothing;
//         }
//         $content .= "<tr>";
//         $content .= "<td style='$style'>$log_date</td>";
//         $content .= "<td style='$style'>$user_link</td>";
//         $content .= "<td style='$style'>$field_name</td>";
//         $content .= "<td style='$style'>$old_val</td>";
//         $content .= "<td style='$style'>$new_val</td>";
//         $content .= "</tr>";
//     }
//     $content .= "</table>";
// }


$content .= "</form>";


// Search Results		
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
