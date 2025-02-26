<?php
$csvFile = "customers.csv"; // Path to CSV file
$recordCount = 0;

// Open the CSV file
if (($handle = fopen($csvFile, "r")) !== FALSE) {
    fgetcsv($handle); // Skip header row

    while (($data = fgetcsv($handle, 100000, ",")) !== FALSE) {
        $recordCount++;
    }

    fclose($handle);
    echo "Total records in CSV file: " . $recordCount;
} else {
    echo "Failed to open the CSV file.";
}
?>
