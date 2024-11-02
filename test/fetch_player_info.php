<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$DatabaseFile = '../LHSQC-STHS.db';
$db = new SQLite3($DatabaseFile);

if ($db) {
    $tables = ['PlayerInfo', 'TeamProLines', 'TeamProStat', 'TeamProInfo'];
    $columns = [];
    
    foreach ($tables as $table) {
        $query = "PRAGMA table_info($table)";
        $result = $db->query($query);
        
        $tableColumns = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $tableColumns[] = $row['name'];
        }
        $columns[$table] = $tableColumns;
    }
    
    header('Content-Type: application/json');
    echo json_encode($columns);
} else {
    echo "Failed to connect to the database";
}
?>
