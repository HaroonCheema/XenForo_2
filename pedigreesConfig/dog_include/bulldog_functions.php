<?php

// require __DIR__ . '/bulldog_common.php';

function Delete_Breeding_Pic($pic_id)
{
	global $con;
	$query = "
			SELECT
				CONCAT( 'pics/breedings/', breeding_id, '/', file ) 
					AS 'file'
			FROM
				visegrip_database.pics_breedings
			WHERE
				pic_id=$pic_id
		";
	$filename = Query_Database_Value($query, $con, "file");
	if (file_exists($filename)) {
		if (unlink($filename)) {
			$query = "
					DELETE FROM
						visegrip_database.pics_breedings
					WHERE
						pic_id=$pic_id;
				";
			mysql_query($query, $con);
		}
	}
}

function Breeding_TypeToStr($breeding_type)
{
	switch ($breeding_type) {
		case 1:
			return "ARTIFICIAL INSEMINATION";
		case 2:
			return "FROZEN SEMEN";
		case 3:
			return "NATURAL BREEDING";
		default:
			return "";
	}
}

function AddWhere_Checkbox($field)
{
	if (isset($_POST[$field])) {
		$value = $_POST[$field];
		return " AND b.$field=1 ";
	} else {
		return "";
	}
	if (empty($value)) {
		return "";
	} else {
	}
}
function AddWhere_Select($field)
{
	if (isset($_POST[$field])) {
		$value = $_POST[$field];
		if ($value == 1) {
			return "";
		} else {
			return " AND b.$field=$value ";
		}
	} else {
		return "";
	}
}
function Select_Value($field)
{
	global $dog_data;
	$value = FindFieldValue($field);
	if (empty($value)) {
		return 1;
	} else {
		return $value;
	}
}

function list_choices($table, $table_id, $table_name, $default)
{
	global $database, $con;
	$SQL_QRY = "SELECT $table_id,$table_name FROM $database.$table ORDER BY $table_name";
	$result = Query_Database($SQL_QRY, $con);
	$choices = "";
	while ($row = mysql_fetch_array($result)) {
		if (intval($row[$table_id]) == intval($default)) {
			$choices .= "<option value='$row[$table_id]' selected='SELECTED'>$row[$table_name]</option>";
		} else {
			$choices .= "<option value='$row[$table_id]'>$row[$table_name]</option>";
		}
	}
	return $choices;
}

function favlist_choices()
{
	global $database, $current_user, $con;
	$SQL_QRY = "SELECT fav_dogid, dogs.dog_regname FROM visegrip_database.favs LEFT JOIN visegrip_database.dogs ON fav_dogid=dog_id WHERE fav_userid=$current_user";
	$result = Query_Database($SQL_QRY, $con);

	$choices = "";
	while ($row = mysql_fetch_array($result)) {
		$table_id = $row["fav_dogid"];
		$table_name = $row["dog_regname"];
		$choices .= "<option value='$table_id'>$table_name</option>";
	}
	return $choices;
}

function IsAlreadyIn($dog_name)
{
	global $con;
	$dog_name = strtoupper(trim($dog_name));
	// Does the breeder name already exist?
	$SQL_QRY = "SELECT count(dog_id) as 'count' FROM visegrip_database.dogs WHERE trim(upper(dog_regname))='$dog_name'";
	$count = Query_Database_Value($SQL_QRY, $con, 'count');
	if ($count > 0) {
		return TRUE;
	} else {
		return FALSE;
	}
}

function IsAlreadyIn2($dog_name, $dog_id)
{
	global $con;
	$dog_name = strtoupper(trim($dog_name));
	// Does the breeder name already exist?
	$SQL_QRY = "SELECT count(dog_id) as 'count' FROM visegrip_database.dogs WHERE trim(upper(dog_regname))='$dog_name' and dog_id!=$dog_id";
	$count = Query_Database_Value($SQL_QRY, $con, 'count');
	if ($count > 0) {
		return TRUE;
	} else {
		return FALSE;
	}
}


function RelativesTable($title, $where_clause, $showdata = FALSE)
{
	global $con, $url_dogs_profile, $dog_list;

	// Output the table of Littermates
	$SQL_QRY = "
			SELECT 
				dog_id														as 'dog_id' 
				, dog_sire													as 'sire_id'
				, dog_dam 													as 'dam_id' 
				, sex.sex_long												as 'gender' 
				, IF(ISNULL(dog_dob), '', DATE_FORMAT(dog_dob, '%m/%d/%Y')) as 'birth_date'
				, dog_regname 
			FROM 
				visegrip_database.dogs 
			INNER JOIN visegrip_database.sex ON dog_sex=sex.sex_id 
			WHERE 
				$where_clause 
			ORDER BY dog_regname
		";
	$result = mysql_query($SQL_QRY, $con);

	OutputTxt("<div class='page_title'>$title</div>");
	OutputTxt("<table class='pb_table' width='90%' align='center' border='0'");
	OutputTxt("<tr>");
	$title = captitle($title);
	OutputTxt("<th class='pb_th' align='left'>$title</th>");
	$title = captitle('Sex');
	OutputTxt("<th class='pb_th' align='left' width='5%'>$title</th>");
	$title = captitle('Date of Birth');
	OutputTxt("<th class='pb_th' align='left' width='10%'>$title</th>");
	$title = captitle('Sire');
	OutputTxt("<th class='pb_th' align='left' width='28%'>$title</th>");
	$title = captitle('Dam');
	OutputTxt("<th class='pb_th' align='left' width='28%'>$title</th>");
	OutputTxt("<tr>");
	$dog_list = array();
	while ($row = mysql_fetch_array($result)) {
		OutputTxt("<tr>");

		// Offspring
		$dog_id = $row['dog_id'];
		$fullname = GetFullName($dog_id);
		$dog_link = "<a href='$url_dogs_profile?dog_id=$dog_id'>$fullname</a>";
		OutputTxt("<td class='pb_td'>$dog_link</td>");

		// Load the dog into the results array
		array_push($dog_list, $dog_id);

		// Sex
		$value = $row["gender"];
		OutputTxt("<td class='pb_td'>$value</td>");

		// Date of Birth
		$date = $row["birth_date"];
		OutputTxt("<td class='pb_td'>$date</td>");

		// Sire
		$dog_id = $row['sire_id'];
		$fullname = GetFullName($dog_id);
		$dog_link = "<a href='$url_dogs_profile?dog_id=$dog_id'>$fullname</a>";
		OutputTxt("<td class='pb_td'>$dog_link</td>");

		// Dam
		$dog_id = $row['dam_id'];
		$fullname = GetFullName($dog_id);
		$dog_link = "<a href='$url_dogs_profile?dog_id=$dog_id'>$fullname</a>";
		OutputTxt("<td class='pb_td'>$dog_link</td>");

		OutputTxt("</tr>");
	}
	OutputTxt("</table>");
}

function Analyze_Ancestors($max_gen_level)
{
	global $ancestors, $dog_repeats;


	$dog_list = array();
	foreach ($ancestors[$max_gen_level] as $key => $dog_id) {
		echo "$key $dog_id<br>";
	}
}

function Load_Repeats($table)
{
	global $con;

	$query = "
			SELECT
				dog_id, count(dog_id) AS 'count'
			FROM 
				visegrip_database.$table
			GROUP BY
				dog_id
			HAVING
				count>1
			ORDER BY
				count desc		
		";
	$result = mysql_query($query, $con);
	$dog_list = array();
	while ($row = mysql_fetch_array($result)) {
		array_push($dog_list, $row["dog_id"]);
	}
	return $dog_list;
}

function Load_zlog_tables()
{
	global $con;
	$query = "SELECT table_name FROM INFORMATION_SCHEMA.TABLES WHERE table_schema = 'visegrip_database' AND table_name LIKE 'zlog_%' ORDER BY table_name ASC";
	$result = mysql_query($query, $con);
	$tables = array();
	while ($row = mysql_fetch_array($result)) {
		array_push($tables, $row["table_name"]);
	}
	return $tables;
}

function Delete_Breeding($breeding_id)
{
	global $con, $usergroupid;

	if ($usergroupid == 6) {

		// Update any dogs that may be attached to this breeding
		$data = array();
		$data["breeding_id"] = 0;
		$query = PackageUpdate("dogs", $data, "breeding_id", $breeding_id);
		mysql_query($query, $con);

		// Delete the breeding
		$keys = array();
		$keys["breeding_id"] = $breeding_id;
		$SQL_QRY = PackageDelete("breedings", $keys, TRUE);
		if ($SQL_QRY != FALSE) {
			mysql_query($SQL_QRY, $con);
		}
	}
}

function formatSizeUnits($bytes)
{
	if ($bytes >= 1073741824) {
		$bytes = number_format($bytes / 1073741824, 2) . ' GB';
	} elseif ($bytes >= 1048576) {
		$bytes = number_format($bytes / 1048576, 2) . ' MB';
	} elseif ($bytes >= 1024) {
		$bytes = number_format($bytes / 1024, 2) . ' KB';
	} elseif ($bytes > 1) {
		$bytes = $bytes . ' bytes';
	} elseif ($bytes == 1) {
		$bytes = $bytes . ' byte';
	} else {
		$bytes = '0 bytes';
	}

	return $bytes;
}

function UploadErrorToStr($error, $max_size)
{
	switch ($error) {
		case UPLOAD_ERR_OK:			// 0
			return "There is no error, the file uploaded with success.";
		case UPLOAD_ERR_INI_SIZE:	// 1
			return "The file size exceeds " . formatSizeUnits($max_size);
		case UPLOAD_ERR_FORM_SIZE: 	// 2
			return "FileSize > " . formatSizeUnits($max_size);
		case UPLOAD_ERR_PARTIAL:	// 3
			return "The uploaded file was only partially uploaded.";
		case UPLOAD_ERR_NO_FILE:	// 4
			return "No file chosen";
		case UPLOAD_ERR_NO_TMP_DIR:	// 6
			return "Missing a temporary folder. Introduced in PHP 4.3.10 and PHP 5.0.3.";
		case UPLOAD_ERR_CANT_WRITE:	// 7
			return "Failed to write file to disk. Introduced in PHP 5.1.0.";
		case UPLOAD_ERR_EXTENSION:	// 8
			return "A PHP extension stopped the file upload. PHP does not provide a way to ascertain which extension caused the file upload to stop; examining the list of loaded extensions with phpinfo() may help. Introduced in PHP 5.2.0.";
		default:
			if (isset($error)) {
				return "File upload Error Message value is not set.";
			} else {
				return "Unknown error: Code $error";
			}
	}
}

function GetBreederName($id)
{
	global $database, $con;

	// Fetch the sire data
	$SQL_QRY = "SELECT TRIM(breeder_name) as 'breeder_name' FROM $database.breeders WHERE breeder_id=$id";
	$result = mysql_query($SQL_QRY, $con);
	if (($result == FALSE) or (mysql_num_rows($result) == 0)) {
		return "(NOT FOUND)";
	} else {
		$row = mysql_fetch_array($result);
		return strtoupper(MYSQLtoString(trim($row["breeder_name"])));
	}
}

function GetOwnerName($owner_id)
{
	global $database, $con;

	// Fetch the sire data
	if (!empty($owner_id)) {
		$SQL_QRY = "SELECT TRIM(owner_name) as 'owner_name' FROM $database.owners WHERE owner_id=$owner_id";
		$result = mysql_query($SQL_QRY, $con);
		if (($result == FALSE) or (mysql_num_rows($result) == 0)) {
			return "(NOT FOUND)";
		} else {
			$row = mysql_fetch_array($result);
			return strtoupper(MYSQLtoString($row["owner_name"]));
		}
	} else {
		return "";
	}
}

function getRejectReason($reason_id)
{
	switch ($reason_id) {
		case 0:
			return "";
		case 1:
			return "Duplicate";
		case 2:
			return "Sloppy Entry";
		case 3:
			return "Sabotage";
	}
}

function getStatus($status_id)
{
	switch ($status_id) {
		case 0:
			return "In Queue";
		case 1:
			return "Rejected";
		case 3:
			return "Approved";
		default:
			return "Legacy";
	}
}

function Load_Old_Vals($table, $data, $index, $index_val)
{
	global $old_vals, $con;

	$fields = "";
	$sep = "";
	foreach ($data as $field => $new_val) {
		$fields .= "$sep$field";
		$sep = ", ";
	}
	$query = "SELECT $fields FROM visegrip_database.$table WHERE $index=$index_val";
	$result = mysql_query($query, $con);
	$row = mysql_fetch_array($result);
	foreach ($data as $field => $new_val) {
		$old_vals[$field] = mysql_real_escape_string($row[$field]);
	}
}

function Log_Dog_Changes($dog_id)
{
	global $con, $data, $old_vals, $current_user;

	foreach ($data as $field => $new_val) {
		if ($old_vals[$field] != trim($new_val)) {

			// Notes use zlog for data
			if ($field == "dog_notes") {				// Load the log record
				$query = "SELECT log_id FROM visegrip_database.zlog_dog_notes WHERE bulldog_id=$dog_id order by log_id DESC LIMIT 0,1";
				$result = mysql_query($query, $con);
				if (($result == FALSE) or (mysql_num_rows($result) == 0)) {
					$old_val = 0;
				} else {
					$row = mysql_fetch_array($result);
					$old_val = $row["log_id"];
				}
				$old_vals[$field] = $old_val;
				$log_record = array();
				$log_record["user_id"] = $current_user;
				$log_record["bulldog_id"] = $dog_id;
				$log_record["new_val"] = mysql_real_escape_string($new_val);
				$query = PackageInsert("zlog_dog_notes", $log_record);
				$new_val = Query_Insert($query, $con);
			}


			// Load the log record
			$log_record = array();
			$log_record["dog_id"] = $dog_id;
			$log_record["changed_by"] = $current_user;
			$log_record["field"] = $field;
			$log_record["old_val"] = $old_vals[$field];
			$log_record["new_val"] = $new_val;

			// Log the data for the record change
			$query = PackageInsert("log_dogs", $log_record);
			mysql_query($query, $con);
		}
	}
}

function Log_Changes($table, $id)
{
	global $con, $data, $old_vals, $current_user;

	foreach ($data as $field => $new_val) {
		if (trim($old_vals[$field]) != trim($new_val)) {

			// Load the log record
			$log_record = array();
			$log_record["id"] = $id;
			$log_record["changed_on"] = "NOW()";
			$log_record["changed_by"] = $current_user;
			$log_record["field"] = $field;
			$log_record["old_val"] = trim($old_vals[$field]);
			$log_record["new_val"] = trim($new_val);

			// Log the data for the record change
			$query = PackageInsert("log_$table", $log_record);
			mysql_query($query, $con);
		}
	}
}

function MakeSelectChoices($array_data, $default = "")
{

	$choices = "";
	foreach ($array_data as $key => $value) {
		if ($key == $default) {
			$choices .= "<option value='$key' selected='selected'>$value</option>";
		} else {
			$choices .= "<option value='$key'>$value</option>";
		}
	}

	return $choices;
}

// function Select_Table_Choices($table, $table_id, $table_name, $default, $sourceDb)
// {
// 	global $con;

// 	$query = "SELECT $table_id,$table_name FROM $table ORDER BY $table_name";
// 	$result = mysql_query($query, $con);
// 	$choices = "";
// 	while ($row = mysql_fetch_array($result)) {
// 		if (intval($row[$table_id]) == intval($default)) {
// 			$choices .= "<option value='$row[$table_id]' selected='SELECTED'>$row[$table_name]</option>";
// 		} else {
// 			$choices .= "<option value='$row[$table_id]'>$row[$table_name]</option>";
// 		}
// 	}
// 	return $choices;
// }

function Select_Table_Choices(string $table, string $valueField, string $textField, $selectedValue, $sourceDb): string
{
	$options = '';
	$rows = $sourceDb->fetchAll("SELECT $valueField, $textField FROM $table ORDER BY $textField ASC");

	foreach ($rows as $row) {
		$value = htmlspecialchars($row[$valueField], ENT_QUOTES, 'UTF-8');
		$text = htmlspecialchars($row[$textField], ENT_QUOTES, 'UTF-8');
		$selected = ($row[$valueField] == $selectedValue) ? ' selected' : '';
		$options .= "<option value='$value'$selected>$text</option>";
	}

	return $options;
}

function LoadPedPath($gen_level, $idx)
{
	global $ancestors;

	$ped_path = "";
	$sep = "";
	$i = $gen_level - 1;
	while ($i >= 0) {
		$idx = floor($idx / 2);
		$ped_path = $ancestors[$i][$idx] . $sep . $ped_path;
		$sep = "|";
		$i--;
	}
	return $ped_path;
}

function MakeAddParentLink($generation, $ancestor_idx)
{
	global $dog_id, $ancestors, $url_dogs_profile;

	$offspring_id = $ancestors[$generation - 1][floor($ancestor_idx / 2)];

	if ($offspring_id == 1) {
		return "UNKNOWN";
	} else {

		$sex = $ancestor_idx % 2;
		$pedpath = LoadPedPath($generation, $ancestor_idx);
		if ($ancestor_idx % 2 == 0) {
			return "<label class='add_dog' gender='2' dog_id=$dog_id offspring=$offspring_id pedpath='$pedpath'>Add Sire</label>";
		} else {
			return "<label class='add_dog' gender='3' dog_id=$dog_id offspring=$offspring_id pedpath='$pedpath'>Add Dam</label>";
		}
	}
}

// Common functions
function AddAncestorTD($gen_level)
{
	global $max_gen_level, $ancestors, $full_names, $ancestor_index, $dog_profile;

	$generation = $max_gen_level - $gen_level; 	// Grab the first index of ancestors[][] 
	$ancestor = $ancestor_index[$generation];	// Grab the second index of ancestors[][]
	$ancestor_id = $ancestors[$generation][$ancestor];	// Grab the dog in question

	// Increment the ancestor index to keep track of where we are at a genreation level
	$ancestor_index[$generation] = $ancestor_index[$generation] + 1;

	// Calculate the hyperlink or label to be displayed in the cell
	if (($ancestor_id > 1) or (!$dog_profile)) {

		// Display the hyperlinked dog name
		$fullname = $full_names[$ancestor_id];
	} else {

		$fullname = MakeAddParentLink($generation, $ancestor);
	}

	return "<td class='pb_td' valign='middle' align='center' rowspan='" . pow(2, $gen_level) . "'>$fullname</td>";
}

function LoadPedigreeRows($gen_level, $row_idx)
{
	global $ancestors, $full_names, $max_gen_level, $pedigree_rows, $ancestor_index, $dog_profile;

	if ($gen_level == 0) {
		$pedigree_rows[$row_idx] .= AddAncestorTD($gen_level);
	} else {

		if ($gen_level < $max_gen_level) {
			$pedigree_rows[$row_idx] .= AddAncestorTD($gen_level);
		}
		LoadPedigreeRows($gen_level - 1, $row_idx);
		LoadPedigreeRows($gen_level - 1, $row_idx + pow(2, $gen_level - 1));
	}
}

function GetParents($ancestor_id)
{
	global $con;
	if ($ancestor_id == 1) {
		return array(1, 1);
	} else {
		$SQL_QRY = "SELECT dog_sire, dog_dam, dog_deleted FROM visegrip_database.dogs WHERE dog_id=$ancestor_id";
		$result = Query_Database($SQL_QRY, $con);
		if (!($result == FALSE)) {
			$row = mysql_fetch_array($result);
			return array($row["dog_sire"], $row["dog_dam"]);
		} else {
			return array(1, 1);
		}
	}
}


function LoadAncestors($dog_id, $sire_id, $dam_id, $max_gen_level)
{
	global $ancestors;

	// Initialize the root animal		
	$ancestors[0] = array($dog_id);

	// Load the Sire/Dam as generation 1
	$dog_list = array($sire_id, $dam_id);

	// Add the sires and dams to the various generations
	for ($gen_level = 1; $gen_level <= $max_gen_level; $gen_level++) {

		// Load the list of dogs into the main arrays
		$ancestors[$gen_level] = $dog_list;

		// clear the lists
		$dog_list = array();

		// If we have more generations to compute, load the sires and dams			
		if ($gen_level < $max_gen_level) {
			// Load the parents of the Sires
			foreach ($ancestors[$gen_level] as $ancestor_id) {
				// Load the sires and dams from the sire list
				list($sire, $dam) = GetParents($ancestor_id);
				array_push($dog_list, $sire);
				array_push($dog_list, $dam);
			}
		}
	}
}

function LoadPedStats($max_gen_level)
{
	global $ancestors, $ped_stats, $in_ped_count, $url_dogs_profile, $full_names;

	// Initialize the maximum dogs per generation and the percent
	$max = 1;
	$perc = 100;

	for ($gen_level = 1; $gen_level <= $max_gen_level; $gen_level++) {
		$max = 2 * $max;
		$perc /= 2;
		$gen_list = array();
		for ($i = 0; $i < $max; $i++) {				// Grab a dog in the pedigree
			$dog_id = $ancestors[$gen_level][$i];
			// If that dog hasn't been recorded at the gen level, inc the percent
			if (isset($ped_stats[$dog_id])) {
				$ped_stats[$dog_id] = $ped_stats[$dog_id] + $perc;
			} else {
				$ped_stats[$dog_id] = $perc;
			}
			if (!in_array($dog_id, $gen_list)) {
				array_push($gen_list, $dog_id);
			}
			// Load the number of times in the array
			if (!isset($in_ped_count[$dog_id])) {
				$in_ped_count[$dog_id] = 1;
			} else {
				$in_ped_count[$dog_id] = $in_ped_count[$dog_id] + 1;
			}
		}
	}
	// Eliminate the Unknown Dog from the pedigree statistics
	if (isset($ped_stats[1])) {
		unset($ped_stats[1]);
	}
	// sort the pedigree stats in descending order
	arsort($ped_stats);

	// Load the hyperlinked full names
	foreach ($in_ped_count as $dog_id => $value) {
		if ($dog_id != 1) {
			$fullname = GetFullName($dog_id, TRUE);
			$full_names[$dog_id] = "<a href='$url_dogs_profile?dog_id=$dog_id'>$fullname</a>";
		} else {
			$full_names[$dog_id] = "UNKNOWN";
		}
	}
}


function Query_Database($SQL_QRY, $con, $debug = FALSE)
{
	// Debug Mode
	if ($debug) {
		echo "<br>$SQL_QRY<br>";
	}

	// Query the Database
	$result = mysql_query($SQL_QRY, $con);

	// return the result
	return 	$result;
}

function Query_Database_Value($SQL_QRY, $con, $field, $debug = FALSE)
{

	$value_result = Query_Database($SQL_QRY, $con, $debug);

	if ($value_result != NULL) {
		$row = mysql_fetch_array($value_result);
		return $row[$field];
	} else {
		return "";
	}
}

function Query_Insert($SQL_QRY, $con, $debug = FALSE)
{

	$result = Query_Database($SQL_QRY, $con, $debug);

	if ($result != NULL) {

		return mysql_insert_id($con);
	} else {

		return FALSE;
	}
}

// This function converts a mysql string to an html compatible string
function MYSQLtoString($value)
{
	$replace = "";
	for ($i = 0; $i < strlen($value); $i++) {
		$character = substr($value, $i, 1);
		switch ($character) {
			case "'":
				$character = "&#39;";
				break;
			case '"':
				$character = "&quot;";
				break;
			case '&bsol;':
				$character = '&bsol;' . $character;
				break;
			default:
				$character = $character;
		}
		$replace .= $character;
	}
	return $replace;
}

function FindCheckboxValue($field, $default = "", $debug = FALSE, $use_cookies = FALSE, $write_cookie = TRUE)
{

	// Is the data in a Post statement?
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if ($debug) {
			OutputTxt("$field: POST=" . $_POST[$field] . "<br>");
		}
		if (isset($_POST[$field])) {
			if (($use_cookies == TRUE) and ($write_cookie == TRUE)) {
				SetCookieV($field, "on", $debug);
			}
			return "on";
		} else {
			if (($use_cookies == TRUE) and ($write_cookie == TRUE)) {
				SetCookieV($field, "off", $debug);
			}
			return "";
		}
	} else if (isset($_COOKIE[$field])) {
		$cookie = $_COOKIE[$field];
		if ($cookie == "on") {
			return "on";
		} else {
			return "";
		}
	} else {
		if (isset($_GET[$field])) {
			if (($use_cookies == TRUE) and ($write_cookie == TRUE)) {
				SetCookieV($field, "on", $debug);
			}
			return "on";
		}
	}
}

function FindFieldValue($field, $default = "", $debug = FALSE, $use_cookies = FALSE, $checkbox = FALSE, $write_cookie = FALSE)
{

	// Is the data in a Post statement?
	if (isset($_POST[$field])) {
		if ($debug) {
			OutputTxt("$field: POST=" . $_POST[$field] . "<br>");
		}
		if (($use_cookies == TRUE) and ($write_cookie == TRUE)) {
			SetCookieV($field, $_POST[$field], $debug);
		}
		return $_POST[$field];
		// Checkbox with cookies

		// Checkbox exception for non-existent negative reply
	} else if ($checkbox) {
		if ($debug) {
			OutputTxt("$field CHECKBOX=$default<br>");
		}
		if (($use_cookies == TRUE) and ($write_cookie == TRUE)) {
			SetCookieV($field, $default, $debug);
		}
		return $default;
	}

	// GET data?
	elseif (isset($_GET[$field])) {
		if ($debug) {
			OutputTxt("$field: GET=" . $_GET[$field] . "<br>");
		}
		if (($use_cookies == TRUE) and ($write_cookie == TRUE)) {
			SetCookieV($field, $_GET[$field], $debug);
		}
		return $_GET[$field];

		// COOKIE? 
	} elseif ((isset($_COOKIE[$field])) && ($use_cookies == TRUE)) {
		if ($debug) {
			OutputTxt("$field: Cookie=" . $_COOKIE[$field] . "<br>");
		}
		return $_COOKIE[$field];

		// Return the default when all else fails 
	} else {
		if ($debug) {
			OutputTxt("$field: default=$default<br>");
		}
		return $default;
	}
}

function OutputTxt($output_line)
{
	global $output_html;
	$output_html .= $output_line;
}

function getDateFormatList()
{
	return array('YYYY/MM/DD', 'YYYY-MM-DD', 'YYYY/DD/MM', 'YYYY-DD-MM', 'DD-MM-YYYY', 'DD/MM/YYYY', 'MM-DD-YYYY', 'MM/DD/YYYY', 'YYYYMMDD', 'YYYYDDMM');
}

function SetCookieV($field, $value)
{
	$expire = 60 * 60 * 24 * 365 + time();
	setcookie($field, $value, $expire);
}

function GetCookieV($field, $default)
{
	if (isset($_COOKIE[$field])) {
		return $_COOKIE[$field];
	} else {
		return $default;
	}
}

function getDateFormatID($debug = FALSE)
{
	$field = "date_format_id";
	$value = FindFieldValue($field);
	if (strlen(trim($value)) > 0) {
		$date_format_id = $value;
		SetCookieV($field, $value);
	} else {
		$date_format_id = GetCookieV($field, 0);
		if ($debug == TRUE) {
			OutputTxt("Cookie($field)=$date_format_id");
		}
	}
	return $date_format_id;
}

function getDateFormat($debug = FALSE)
{
	$format_list = getDateFormatList();
	$date_format_id = getDateFormatID();
	$date_format = $format_list[$date_format_id];
	if ($debug == TRUE) {
		OutputTxt("date_format=$date_format");
	}
	return $date_format;
}

function GetFullName($dog_id, $show_gifs = FALSE)
{
	global $con;

	// Has the unknown dog been requested?
	if (empty($dog_id)) {
		return "";
	}

	if ($dog_id == 1) {
		return "UNKNOWN";
	}

	// Make sure the record exists
	$query = "SELECT count(dog_id) as 'count' FROM visegrip_database.dogs WHERE dog_id=$dog_id";
	$count = Query_Database_Value($query, $con, "count");
	if ($count == 0) {
		return "(Not Found)";
	}

	$fields = "";
	$fullname = "";
	$database = "visegrip_database";

	// sort the titles
	$fields .= "upper(dog_regname)   as 'regname', ";
	$fields .= "dog_title_con        as 'con', ";
	$fields .= "dog_title_lbs        as 'lbs', ";
	$fields .= "dog_title_obd        as 'obd', ";
	$fields .= "dog_title_show       as 'show', ";
	$fields .= "titles_con.con_short as 'title1', ";
	$fields .= "titles_lbs.lbs_short as 'title2', ";
	$fields .= "titles_obd.obd_short as 'title3', ";
	$fields .= "titles_show.show_short  as 'title4', ";
	$fields .= "dog_bis              as 'BIS', ";
	$fields .= "dog_doy              as 'DOY', ";
	$fields .= "dog_doy_year         as 'DOY_year', ";
	$fields .= "dog_gis              as 'GIS', ";
	$fields .= "dog_por              as 'POR', ";
	$fields .= "dog_rom              as 'ROM', ";
	$fields .= "dog_suffix           as 'suffix', ";
	$fields .= "dog_win              as 'win', ";
	$fields .= "dog_loss             as 'loss', ";
	$fields .= "dog_draw             as 'draw', ";
	$fields .= "dog_dna              as 'DNA' , ";
	$fields .= "dog_youtube_file     as 'youtube' ";

	$tables = "$database.dogs ";
	$tables .= "INNER JOIN $database.titles_con ";
	$tables .= "ON dog_title_con=titles_con.con_id ";
	$tables .= "INNER JOIN $database.titles_lbs ";
	$tables .= "ON dog_title_lbs=titles_lbs.lbs_id ";
	$tables .= "INNER JOIN $database.titles_obd ";
	$tables .= "ON dog_title_obd=titles_obd.obd_id ";
	$tables .= "INNER JOIN $database.titles_show ";
	$tables .= "ON dog_title_show=titles_show.show_id ";
	$where =  " dog_id='$dog_id' ";
	$SQL_QRY  = "SELECT $fields FROM $tables WHERE $where";
	$result = Query_Database($SQL_QRY, $con);
	$dog_data = mysql_fetch_array($result);

	$youtube = $dog_data["youtube"];



	// Establish the suffix
	$suffix = $dog_data["suffix"];
	$regname = $dog_data["regname"];
	$DNA = $dog_data['DNA'];
	if ($DNA == '1') {
		$regname = " ^$regname";
	}

	$win = $dog_data["win"];
	$loss = $dog_data["loss"];
	$draw = $dog_data["draw"];
	$sep = "";
	if ($win + $loss + $draw == 0) {
		$suffix = "";
	} else {
		$suffix = "(";
		if ($win > 0) {
			$suffix .= "$win" . "xW";
			$sep = ", ";
		}
		if ($loss > 0) {
			$suffix .= "$sep$loss" . "xL";
			$sep = ", ";
		}
		if ($draw > 0) {
			$suffix .= "$sep$draw" . "xD";
		}
		$suffix .= ")";
	}

	// Get and sort the titles 
	$titles = array($dog_data['title1'], $dog_data['title2'], $dog_data['title3'], $dog_data['title4']);
	$BIS = $dog_data['BIS'];
	$DOY = $dog_data['DOY'];
	$GIS = $dog_data['GIS'];
	$POR = $dog_data['POR'];
	$ROM = $dog_data['ROM'];
	sort($titles);

	// output them
	$sep = "";
	foreach ($titles as $value) {
		if (strlen(trim($value)) > 0) {
			$fullname .= "$sep$value";
			$sep = ", ";
		}
	}
	// Add the Regname
	$fullname .= " $regname $suffix ";

	$sep = "";
	// Add the suffixes
	if ($BIS == '1') {
		$fullname .= "$sep" . "BIS";
		$sep = ", ";
	}
	// Add the suffixes
	if ($DOY == '1') {
		$fullname .= "$sep" . "DOY " . $dog_data["DOY_year"];
		$sep = ", ";
	}
	if ($GIS == '1') {
		$fullname .= "$sep" . "GIS";
		$sep = ", ";
	}
	if ($POR == '1') {
		$fullname .= "$sep" . "POR";
		$sep = ", ";
	}
	if ($ROM == '1') {
		$fullname .= "$sep" . "ROM";
		$sep = ", ";
	}

	// Determine color
	// 1. All dogs with Titles (Show/Conf/Obedience/Weight) have their entire names displayed in red (#ff0000);
	// 3. If any dog has both a Title (Ch/Gr CH, etc.) and a Suffix, the color red dominates.      
	if (($dog_data['con'] > 1) or ($dog_data['lbs'] > 1) or ($dog_data['obd'] > 1) or ($dog_data['show'] > 1) or ($DOY == 1) or ($BIS == 1)) {
		$dog_name = "<font color='red'>" . $fullname . "</font>";
	} else if (($win == 1) or ($win == 2) or ($GIS == 1) or ($POR == 1) or ($ROM == 1)) {
		$dog_name = "<font color='green2'>" . $fullname . "</font>";
	} else {
		$dog_name = $fullname;
	}

	// Does this dog have pictures?
	$query = "
				SELECT
					pic_id 
					, CONCAT('pics/dogs/$dog_id/', file) as 'file'
					, width
					, height
				FROM
					visegrip_database.pics_dogs
				WHERE
					dog_id=$dog_id
				ORDER BY
					idx
				LIMIT
					0,1
			";
	$result = mysql_query($query, $con);
	$pic = "";
	$style = "padding: 2px 5px;height:15px;";
	if (($result == FALSE) || (mysql_num_rows($result) == 0) || ($show_gifs == FALSE)) {
		$pic = "";
	} else {
		$row = mysql_fetch_array($result);
		$dog_thumb = $row["file"];
		$width = $row["width"];
		$height = $row["height"];
		$pic = "<img class='dog_thumb' pic_width='$width' pic_height='$height' style='$style' img='$dog_thumb' src='pics/camera.png' ></img>";
	}

	// Is there a video?
	if ((strlen($youtube) > 0) and ($show_gifs == TRUE)) {
		$vid = "<img class='dog_video' style='$style' src='pics/video_camera.gif' vid='$youtube' ></img>";
	} else {
		$vid = "";
	}

	return "$dog_name$pic$vid";
}

function MakeHyperlink($baseurl, $text, $data)
{
	$sep = "";
	$myargs = "";
	foreach ($data as $key => $value) {
		$myargs .= "$sep$key=$value";
		$sep = "&";
	}
	return "<a href='$baseurl?$myargs'>$text</a>";
}


function Make_Link($mypage, $text, $names, $values)
{

	$sep = "";
	$myargs = "";
	for ($i = 0; $i < sizeof($names); $i++) {
		// Process array data
		if (!empty($values[$i]) or $values[$i] == 0) {
			$sep = "?";
			if (!empty($myargs)) {
				$myargs .= "&";
			}
			$myargs .= $names[$i];
			$myargs .= "=";
			$myargs .= $values[$i];
		}
	}
	return "<a href='$mypage$sep$myargs'>$text</a>";
}

function captitle($title, $capit = TRUE)
{
	if ($capit == TRUE) {
		return strtoupper($title);
	} else {
		return $title;
	}
}

function capdata($value, $capit = TRUE)
{
	if ($capit == TRUE) {
		return strtoupper($value);
	} else {
		return $value;
	}
}

function WrightsCOI($sire_id, $dam_id, $max_gen_level)
{
	global $con;

	if (($sire_id == 1) || ($dam_id == 1)) {
		return 0;
	}

	$database = "visegrip_database";
	// =============== Calculate the seed data =============================== 
	if ($sire_id == 1) {
		$sire_data = array();
	} else {
		$sire_data[1] = array($sire_id);
	}
	if ($dam_id == 1) {
		$dam_data = array();
	} else {
		$dam_data[1] = array($dam_id);
	}

	// ===============  Load the Sires Data ==================================
	for ($gen_level = 2; $gen_level <= $max_gen_level; $gen_level++) {
		$sire_data[$gen_level] = array();
		for ($dog_count = 0; $dog_count < count($sire_data[$gen_level - 1]); $dog_count++) {
			// ------------------- Load Sires
			$dog_id = $sire_data[$gen_level - 1][$dog_count];
			$row = mysql_fetch_array(Query_Database("SELECT dog_sire, dog_dam FROM $database.dogs WHERE dog_id=$dog_id", $con));
			$sire_id = $row['dog_sire'];
			$dam_id = $row['dog_dam'];
			if ($sire_id > 1) {
				array_push($sire_data[$gen_level], $sire_id);
			}
			if ($dam_id > 1) {
				array_push($sire_data[$gen_level], $dam_id);
			}
		}
	}

	// ===============  Load the Dams ==================================
	for ($gen_level = 2; $gen_level <= $max_gen_level; $gen_level++) {
		$dam_data[$gen_level] = array();
		for ($dog_count = 0; $dog_count < count($dam_data[$gen_level - 1]); $dog_count++) {
			// ------------------- Load Sires
			$dog_id = $dam_data[$gen_level - 1][$dog_count];
			$row = mysql_fetch_array(Query_Database("SELECT dog_sire, dog_dam FROM $database.dogs WHERE dog_id=$dog_id", $con));
			$sire_id = $row['dog_sire'];
			$dam_id = $row['dog_dam'];
			if ($sire_id > 1) {
				array_push($dam_data[$gen_level], $sire_id);
			}
			if ($dam_id > 1) {
				array_push($dam_data[$gen_level], $dam_id);
			}
		}
	}

	// ================ Load the COI Data ====================================
	$COI_Data = array();
	for ($i = 1; $i <= $max_gen_level; $i++) {
		for ($j = 1; $j <= $max_gen_level; $j++) {
			foreach (array_intersect($sire_data[$i], $dam_data[$j]) as $dog_id) {
				array_push($COI_Data, array($dog_id, $i, $j, 0));
			}
		}
	}

	// ----------- Load Each repeat animal's inbreeding coefficient
	for ($i = 0; $i < count($COI_Data); $i++) {
		// $COI_Data[$i][3] = WrightsCOI($COI_Data[$i][$max_gen_level], 5);
	}

	// ----------- Calculate COI Array -------------------
	for ($i = 0; $i < count($COI_Data); $i++) {
		$COI_Data[$i][4] = pow(0.5, $COI_Data[$i][1] + $COI_Data[$i][2] - 1) * (1 + $COI_Data[$i][3]);
	}

	// Add up to the inbreeding coefficient
	$WIC = 0;
	for ($i = 0; $i < count($COI_Data); $i++) {
		$WIC = $WIC + $COI_Data[$i][4];
	}

	// Make a percent
	$WIC = 100 * $WIC;

	return $WIC;
}

function gen_choices($default, $min = 4, $max = 15)
{
	$choices = "";
	for ($i = $min; $i <= $max; $i++) {
		if ($i == $default) {
			$choices .= "<option value='$i' selected='SELECTED'>$i" . " Generations</option>";
		} else {
			$choices .= "<option value='$i'>$i" . " Generations</option>";
		}
	}
	return $choices;
}

function StdDateToDate($date, $format, $debug = FALSE)
{
	if (strlen($date) == 0) {
		$date = "0000-00-00";
	}
	list($y, $m, $d) = preg_split('/[-\.\/ ]/', $date);
	if ($debug == TRUE) {
		OutputTxt("StdDateToDate   m=$m d=$d y=$y format=$format");
	}
	switch ($format) {
		case 'YYYY/MM/DD':
			$std_date = $y . '/' . $m . '/' . $d;
			break;
		case 'YYYY-MM-DD':
			$std_date = $date;
			break;
		case 'YYYY/DD/MM':
			$std_date = $y . '/' . $d . '/' . $m;
			break;
		case 'YYYY-DD-MM':
			$std_date = $y . '-' . $d . '-' . $m;
			break;
		case 'DD-MM-YYYY':
			$std_date = $d . '-' . $m . '-' . $y;
			break;
		case 'DD/MM/YYYY':
			$std_date = $d . '/' . $m . '/' . $y;
			break;
		case 'MM-DD-YYYY':
			$std_date = $m . '-' . $d . '-' . $y;
			break;
		case 'MM/DD/YYYY':
			$std_date = $m . '/' . $d . '/' . $y;
			break;
		case 'YYYYMMDD':
			$std_date = "$y$m$d";
			break;
		case 'YYYYDDMM':
			$std_date = "$y$d$m";
			break;
	}
	return $std_date;
}

// function GetUser($user_id)
// {
// 	global $con_user;

// 	$field = "username";
// 	$SQL_QRY = "SELECT $field FROM forum.vbuser WHERE userid=$user_id";
// 	return strtoupper(Query_Database_Value($SQL_QRY, $con_user, $field));
// }

function GetUser(int $user_id, $db): string
{
	$field = 'username';

	// $SQL_QRY = "SELECT $field FROM forum.vbuser WHERE userid=$user_id";

	$username = $db->fetchOne(
		"SELECT $field FROM xf_user WHERE user_id = ?",
		$user_id
	);

	return strtoupper((string)$username);
}

function Profile_Data_Row($title, $value)
{
	global $title_align, $value_align;

	OutputTxt("<tr>");
	OutputTxt("<td class='profile_data_title' align='$title_align' valign='top' width='50%'>&nbsp;&nbsp;$title</td>");
	OutputTxt("<td class='profile_data_value' align='$value_align'>$value&nbsp;</td>");
	OutputTxt("</tr>");
}


function PackageInsert($table, $data)
{
	$fields = "";
	$values = "";
	$sep = "";
	foreach ($data as $key => $value) {
		if ((!empty($value)) or ($value == '0')) {
			$fields .= "$sep$key";
			if ($value == 'NOW()') {
				$values .= "$sep $value";
			} else {
				$values .= "$sep '$value'";
			}
			$sep = ",";
		} else {
			$fields .= "$sep$key";
			$values .= "$sep NULL";
			$sep = ",";
		}
	}
	return "INSERT INTO visegrip_database.$table ($fields) VALUES ($values)";
}

function PackageUpdate($table, $data, $index, $index_value, $debug = FALSE)
{

	$fields = "";
	$values = "";
	$sep = "";
	foreach ($data as $key => $value) {
		if ((!empty($value)) or ($value == '0')) {
			if ($value == "NOW()") {
				$fields .= "$sep$key=$value";
			} else {
				$fields .= "$sep$key='$value'";
			}
			$sep = ", ";
		} else {
			$fields .= "$sep$key=null";
			$sep = ", ";
		}
	}
	$SQL_QRY = "UPDATE visegrip_database.$table SET $fields WHERE $index=$index_value";
	if ($debug) {
		echo $SQL_QRY;
	};
	return $SQL_QRY;
}

function PackageDelete($table, $keys, $safe)
{
	global $con;

	$join = "";
	$delete_condition = "";
	if (sizeof($keys) > 0) {

		// load the delete condition
		foreach ($keys as $key => $value) {
			$delete_condition .= "$join$key='$value'";
			$join = " AND ";
		}

		// Safe Delete?
		if ($safe == TRUE) {
			$SQL_QRY = "SELECT COUNT(*) as 'count' from visegrip_database.$table WHERE $delete_condition";
			$count = Query_Database_Value($SQL_QRY, $con, "count");
			if ($count > 1) {
				return false;
			}
		}

		// Delete the data
		return "DELETE FROM visegrip_database.$table WHERE $delete_condition";
	} else {
		return false;
	}
}

function PicPath($dog_id, $i)
{
	$filename = "pics/dog_" . str_pad($dog_id, 6, "0", STR_PAD_LEFT) . "_" . str_pad($i, 2, "0", STR_PAD_LEFT) . ".jpg";
	$default_file = "pics/placeholder.gif";
	if (file_exists($filename)) {
		return $filename;
	} else {
		return $default_file;
	}
}

function IsFavorite($dog_id, $userid)
{
	global $con;
	$row = mysql_fetch_array(Query_Database("SELECT count(fav_dogid) as 'count' FROM visegrip_database.favs WHERE fav_dogid=$dog_id AND fav_userid=$userid", $con));
	if ($row['count'] == 1) {
		return TRUE;
	} else {
		return FALSE;
	}
	return false;
}

function CountOffspring($dog_id, $sex_id, $showdata = FALSE)
{
	switch ($sex_id) {
		case 2: // male
			$where_clause = "dog_sire=$dog_id ";
			break;
		case 3:
			$where_clause = "dog_dam=$dog_id ";
			break;
		default:
			return 0;
	}
	return CountDogs($where_clause);
}

function CountDogs($where_clause, $showdata = FALSE)
{
	global $con;
	$SQL_QRY = "SELECT count(dog_id) as 'count' FROM visegrip_database.dogs WHERE $where_clause ";
	$result = Query_Database($SQL_QRY, $con);
	$row = mysql_fetch_array($result);
	return $row["count"];
}

function FillUp($mystring)
{
	if (empty($mystring) or ($mystring == " ")) {
		return "&nbsp;";
	} else {
		return $mystring;
	}
}
function IDToValue($id, $field, $showdata = FALSE)
{

	if ($showdata == TRUE) {
		OutputTxt("IDToValue    id=$id  field=$field<BR>");
	}
	if (strlen($id) == 0) {
		$title = "";
	} else {
		switch ($field) {
			case "dog_regbody":
				$title = FieldIDtoVal("regbodies", "regbody_abbr", "regbody_id", $id);
				break;
			case "dog_breeder":
				$title = FieldIDtoVal("breeders", "breeder_name", "breeder_id", $id);
				break;
			case "dog_owner":
				$title = FieldIDtoVal("owners", "owner_name", "owner_id", $id);
				break;
			case "dog_sire":
			case "dog_dam":
				$title = GetFullName($id);
				break;
			case "dog_sex":
				$title = FieldIDtoVal("sex", "sex_long", "sex_id", $id);
				break;
			case "dog_lob":
			case "dog_los":
				$title = FieldIDtoVal("countries", "country_name", "country_id", $id);
				break;
			case "dog_nosecolor":
				$title = FieldIDtoVal("noses", "nose_name", "nose_id", $id);
				break;
			case "dog_por":
				if ($id == 1) {
					$title = "POR";
				} else {
					$title = "";
				}
				break;
			case "dog_rom":
				if ($id == 1) {
					$title = "ROM";
				} else {
					$title = "";
				}
				break;
			case "dog_bis":
				if ($id == 1) {
					$title = "BIS";
				} else {
					$title = "";
				}
				break;
			case "dog_gis":
				if ($id == 1) {
					$title = "GIS";
				} else {
					$title = "";
				}
				break;
			case "dog_title_con":
				$title = FieldIDtoVal("titles_con", "con_long", "con_id", $id);
				break;
			case "dog_title_lbs":
				$title = FieldIDtoVal("titles_lbs", "lbs_long", "lbs_id", $id);
				break;
			case "dog_title_obd":
				$title = FieldIDtoVal("titles_obd", "obd_long", "obd_id", $id);
				break;
			case "dog_title_show":
				$title = FieldIDtoVal("titles_show", "show_long", "show_id", $id);
				break;
			default:
				$title = $id;
		} // Switch
	} // If
	return $title;
}

function FieldIDtoVal($table, $field, $IdxField, $id, $showdata = FALSE)
{
	global $con;

	$SQL_QRY = "SELECT $field FROM visegrip_database.$table WHERE $IdxField=$id";
	$result = Query_Database($SQL_QRY, $con, $showdata);
	if (($result == FALSE) or (mysql_numrows($result) == 0)) {
		return "";
	} else {
		$row = mysql_fetch_array($result);
		return $row[$field];
	}
}

function SwapRows($my_array, $idx1, $data_index)
{

	// Grab the data to compare
	$data1 = $my_array[$idx1][$data_index];
	$idx2 = $idx1 - 1;
	$data2 = $my_array[$idx2][$data_index];

	// Swqp Small to Big?
	if ($data1 < $data2) {

		$temp_row = $my_array[$idx1];
		$my_array[$idx1] = $my_array[$idx2];
		$my_array[$idx2] = $temp_row;
	}

	return $my_array;
}

function SortArray($my_array, $index)
{

	for ($i = 1; $i < sizeof($my_array); $i++) {
		for ($j = $i; $j > 0; $j--) {
			$my_array = SwapRows($my_array, $j, $index);
		}
	}

	return $my_array;
}

function favbreedings_choices()
{
	global $database, $current_user, $con;
	$SQL_QRY = "SELECT user_id, fav.breeding_id as 'breeding_id', breedings.breeding_sire as 'sire_id', breedings.breeding_dam as 'dam_id' ";
	$SQL_QRY .= "FROM $database.fav_breedings fav ";
	$SQL_QRY .= "LEFT JOIN $database.breedings breedings ON fav.breeding_id=breedings.breeding_id ";
	$SQL_QRY .= "WHERE fav.user_id=$current_user";
	$result = mysql_query($SQL_QRY, $con);

	$choices = "";
	while ($row = mysql_fetch_array($result)) {
		$table_id = $row["breeding_id"];
		$sire_id = $row['sire_id'];
		$dam_id = $row['dam_id'];
		$table_name = GetFullName($sire_id) . " || " . GetFullName($dam_id);
		$choices .= "<option value='$table_id'>$table_name</option>";
	}
	return $choices;
}

function Checkbox_value($field)
{
	if (empty($_POST[$field])) {
		return "";
	} else {
		return "checked='yes' ";
	}
}

function CountPups($sire_id, $dam_id, $breeder_id, $litter_date, $for_sale = FALSE, $show_data = FALSE)
{
	global $database, $con;

	// For Sale: Additional clause
	if ($for_sale == TRUE) {
		$for_sale = " AND dog_forsale=1";
	}

	$SQL_QRY = "SELECT count(dog_id) as 'count' FROM $database.dogs WHERE dog_sire=$sire_id and dog_dam=$dam_id and dog_breeder=$breeder_id AND dog_dob='$litter_date' $for_sale";
	$result = mysql_query($SQL_QRY, $con);
	$row = mysql_fetch_array($result);
	return $row['count'];
}
function perpage_choices($default)
{
	$choices  = perpage_choice(10, $default);
	$choices .= perpage_choice(25, $default);
	$choices .= perpage_choice(50, $default);
	$choices .= perpage_choice(100, $default);
	return $choices;
}
function perpage_choice($i, $default)
{
	if ($i == $default) {
		return "<option value='$i' selected='SELECTED'>$i" . " Rows/Page</option>";
	} else {
		return "<option value='$i'>$i" . " Rows/Page</option>";
	}
}

function GenerateList($table, $primary, $field, $value)
{
	global $database, $con;

	$SQL_QRY = "SELECT $primary FROM $database.$table WHERE $field LIKE '%" . mysql_real_escape_string($value) . "%' LIMIT 0,20";
	$result = mysql_query($SQL_QRY, $con);
	$mylist = "";
	$sep = "";
	if (mysql_num_rows($result) == 0) {
		$mylist = 0;
	} else {
		while ($row = mysql_fetch_array($result)) {
			$mylist .= "$sep$row[$primary]";
			$sep = ",";
		}
	}
	return $mylist;
}

function Translate_Log_Dog($field, $old_val, $new_val)
{
	global $con;
	switch ($field) {
		case "dog_createdby":
			$field = "Created By";
			$old_val = GetUser($old_val);
			$new_val = GetUser($new_val);
			break;
		case "dog_sex":
			$old_val = FieldIDtoVal("sex", "sex_long", "sex_id", $old_val);
			$new_val = FieldIDtoVal("sex", "sex_long", "sex_id", $new_val);
			$field = "SEX";
			break;
		case "dog_regname":
			$field = "REGISTERED NAME";
			break;
		case "dog_sire":
			if (strlen($old_val) > 0) {
				$old_val = GetFullName($old_val);
			}
			$new_val = GetFullName($new_val);
			$field = "SIRE";
			break;
		case "dog_dam":
			if (strlen($old_val) > 0) {
				$old_val = GetFullName($old_val);
			}
			$new_val = GetFullName($new_val);
			$field = "DAM";
			break;
		case "dog_breeder":
			$old_val = GetBreederName($old_val);
			$new_val = GetBreederName($new_val);
			$field = "BREEDER";
			break;
		case "dog_owner":
			$old_val = GetOwnerName($old_val);
			$new_val = GetOwnerName($new_val);
			$field = "OWNER";
			break;
		case "dog_title_show":
			$old_val = FieldIDtoVal("titles_show", "show_long", "show_id", $old_val);
			$new_val = FieldIDtoVal("titles_show", "show_long", "show_id", $new_val);
			$field = "PERFORMANCE";
			break;
		case "dog_title_con":
			$old_val = FieldIDtoVal("titles_con", "con_long", "con_id", $old_val);
			$new_val = FieldIDtoVal("titles_con", "con_long", "con_id", $new_val);
			$field = "conformation";
			break;
		case "dog_title_lbs":
			$old_val = FieldIDtoVal("titles_lbs", "lbs_long", "lbs_id", $old_val);
			$new_val = FieldIDtoVal("titles_lbs", "lbs_long", "lbs_id", $new_val);
			$field = "weight pulling";
			break;
		case "dog_title_obd":
			$old_val = FieldIDtoVal("titles_obd", "obd_long", "obd_id", $old_val);
			$new_val = FieldIDtoVal("titles_obd", "obd_long", "obd_id", $new_val);
			$field = "obedience";
			break;
		case "dog_bis":
			$old_val = YesNoNull($old_val);
			$new_val = YesNoNull($new_val);
			$field = "Best in show";
			break;
		case "dog_gis":
			$old_val = YesNoNull($old_val);
			$new_val = YesNoNull($new_val);
			$field = "Gamest in show";
			break;
		case "dog_por":
			$old_val = YesNoNull($old_val);
			$new_val = YesNoNull($new_val);
			$field = "Producer of Record";
			break;
		case "dog_rom":
			$old_val = YesNoNull($old_val);
			$new_val = YesNoNull($new_val);
			$field = "register of merit";
			break;
		case "dog_doy":
			$old_val = YesNoNull($old_val);
			$new_val = YesNoNull($new_val);
			$field = "dog of the year";
			break;
		case "dog_doy_year":
			$field = "dog of year - year#";
			break;
		case "dog_win":
			$field = "wins";
			break;
		case "dog_loss":
			$field = "losses";
			break;
		case "dog_draw":
			$field = "draws";
			break;
		case "dog_coatcolor":
			$old_val = FieldIDtoVal("coats", "coat_name", "coat_id", $old_val);
			$new_val = FieldIDtoVal("coats", "coat_name", "coat_id", $new_val);
			$field = "coat color";
			break;
		case "dog_nosecolor":
			$old_val = FieldIDtoVal("noses", "nose_name", "nose_id", $old_val);
			$new_val = FieldIDtoVal("noses", "nose_name", "nose_id", $new_val);
			$field = "nose color";
			break;
		case "dog_height":
			$field = "height at shoulder";
			break;
		case "dog_cm":
			$old_val = YesNoNull($old_val);
			$new_val = YesNoNull($new_val);
			$field = "In Centimeters?";
			break;
		case "dog_kg":
			$old_val = YesNoNull($old_val);
			$new_val = YesNoNull($new_val);
			$field = "In Kilograms?";
			break;
		case "dog_weightshow":
			$field = "Show Weight";
			break;
		case "dog_weightchain":
			$field = "Chain Weight";
			break;
		case "dog_features":
			$field = "features";
			break;
		case "dog_notes":
			$old_val = FieldIDtoVal("zlog_dog_notes", "new_val", "log_id", $old_val);
			$new_val = FieldIDtoVal("zlog_dog_notes", "new_val", "log_id", $new_val);
			$field = "notes";
			break;
		case "dog_callname":
			$field = "call name";
			break;
		case "dog_regnum":
			$field = "registration #";
			break;
		case "dog_regbody":
			$old_val = FieldIDtoVal("regbodies", "regbody_name", "regbody_id", $old_val);
			$new_val = FieldIDtoVal("regbodies", "regbody_name", "regbody_id", $new_val);
			$field = "Registration Body";
			break;
		case "dog_lob":
			$old_val = FieldIDtoVal("countries", "country_name", "country_id", $old_val);
			$new_val = FieldIDtoVal("countries", "country_name", "country_id", $new_val);
			$field = "land of birth";
			break;
		case "dog_los":
			$old_val = FieldIDtoVal("countries", "country_name", "country_id", $old_val);
			$new_val = FieldIDtoVal("countries", "country_name", "country_id", $new_val);
			$field = "land of standing";
			break;
		case "dog_dob":
			$old_val = date('m/d/Y', strtotime($old_val));
			$new_val = date('m/d/Y', strtotime($new_val));
			$field = "date of birth";
			break;
		case "dog_deceased":
			$field = "Is Deceased?";
			$old_val = YesNoNull($old_val);
			$new_val = YesNoNull($new_val);
			break;
		case "dog_forsale":
			$old_val = YesNoNull($old_val);
			$new_val = YesNoNull($new_val);
			$field = "For sale";
			break;
		case "dog_deleted":
			$old_val = YesNoNull($old_val);
			$new_val = YesNoNull($new_val);
			$field = "Deleted";
		case "dog_core":
			$old_val = YesNoNull($old_val);
			$new_val = YesNoNull($new_val);
			$field = "Core Dog";
		case "dog_dna":
			$old_val = YesNoNull($old_val);
			$new_val = YesNoNull($new_val);
			$field = "DNA Tested";
		case "dog_stud":
			$old_val = YesNoNull($old_val);
			$new_val = YesNoNull($new_val);
			$field = "At Stud";
		case "dog_youtube_file":
			break;
		case "dog_breeding":
			break;
		case "dog_status":
			break;
	}
	return array($field, $old_val, $new_val);
}

function YesNoNull($val)
{
	if (strlen($val) == 0) {
		return "";
	} else if ($val == 0) {
		return "NO";
	} else {
		return "YES";
	}
}
