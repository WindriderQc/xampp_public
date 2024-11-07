<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$DatabaseFile = '../LHSQC-STHS.db';
$db = new SQLite3($DatabaseFile);

if ($db) {
    $tables = ['PlayerInfo', 'TeamProLines', 'TeamProStat', 'TeamProInfo', 'PlayerProStat'];
    $columns = [];
    
    foreach ($tables as $table) {
        // Fetch column names
        $query = "PRAGMA table_info($table)";
        $result = $db->query($query);
        
        $tableColumns = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $tableColumns[] = $row['name'];
        }

        // Fetch first row of data
        $query = "SELECT * FROM $table LIMIT 1";
        $result = $db->query($query);
        $firstRow = $result->fetchArray(SQLITE3_ASSOC);

        // Add both column names and first row data to the response
        $columns[$table] = [
            'columns' => $tableColumns,
            'firstRow' => $firstRow
        ];
    }
    
    header('Content-Type: application/json');
    echo json_encode($columns);
} else {
    echo "Failed to connect to the database";
}
?>
