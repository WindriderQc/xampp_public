<?php 
echo "YO2!!  <br>";
$DatabaseFile = '../LHSQC-STHS.db';
// Open the SQLite database
$db = new SQLite3($DatabaseFile);



$query = "CREATE TABLE IF NOT EXISTS TestTable (ID INTEGER PRIMARY KEY, Name TEXT)";
$result = $db->exec($query);
if ($result) {
    echo "Write successful!\n";
} else {
    echo "Error Create: " . $db->lastErrorMsg() . "</br>";
}

$result = $db->querySingle("PRAGMA foreign_keys;");
echo "Foreign keys enabled: " . $result . "<br>";


// Check if the database is opened
if ($db) {
    // Run the PRAGMA table_info query to get the structure of the PlayerInfo table
    $query = "PRAGMA table_info(PlayerInfo);";
    $result = $db->query($query);
    echo "Sending Query  <br>";
    // Check if we have results
    if ($result) {
        echo "Table Structure of PlayerInfo:<br>"; // Use <br> for line breaks in HTML output
       /* while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            // Output the column name and other details
            echo "Column: " . $row['name'] . "<br>";  // Use <br> instead of \n
            echo "Type: " . $row['type'] . "<br>";
            echo "Not Null: " . ($row['notnull'] ? 'Yes' : 'No') . "<br>";
            echo "Default: " . $row['dflt_value'] . "<br>";
            echo "Primary Key: " . ($row['pk'] ? 'Yes' : 'No') . "<br>";
            echo "------------------------<br>";
        }*/
    } else {
        echo "Error fetching table information: " . $db->lastErrorMsg() . "<br>";
    }
} else {
    echo "Failed to open database: " . $db->lastErrorMsg() . "<br>";
}


$query = "INSERT INTO TeamProLines (TeamNumber) VALUES (45)";

$result = $db->exec($query);
if ($result) {
    echo "Write successful!\n";
} else {
    echo "Error: " . $db->lastErrorMsg() . "</br>";
}


$query = "INSERT INTO PlayerInfo (Name) VALUES ('Test')";
$result = $db->exec($query);
if ($result) {
    echo "Write successful!\n";
} else {
    echo "Error: " . $db->lastErrorMsg() . "\n";
}

// Close the database connection
$db->close();

?>