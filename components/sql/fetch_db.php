<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$DatabaseFile = '../../LHSQC-STHS.db';
$db = new SQLite3($DatabaseFile);

if ($db) {
    $table = $_GET['table'] ?? null;
    $field = $_GET['field'] ?? null;
    $value = $_GET['value'] ?? null;

    if ($table && $field && $value) {
        // Fetch column names
        $query = "PRAGMA table_info($table)";
        $result = $db->query($query);
        
        $tableColumns = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $tableColumns[] = $row['name'];
        }

        // Fetch row data based on specified field and value
        $stmt = $db->prepare("SELECT * FROM $table WHERE $field = :value LIMIT 1");
        $stmt->bindValue(':value', $value, SQLITE3_TEXT);
        $result = $stmt->execute();
        $rowData = $result->fetchArray(SQLITE3_ASSOC);

        header('Content-Type: application/json');
        echo json_encode([
            'columns' => $tableColumns,
            'rowData' => $rowData ? $rowData : []
        ]);
    } else {
        // Default: Fetch first row of each table
       // $tables = ['PlayerInfo', 'TeamProLines', 'TeamProStat', 'TeamProInfo', 'PlayerProStat'];

        $query = "SELECT name FROM sqlite_master WHERE type='table'";
        $result = $db->query($query);

        $tables = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $tables[] = $row['name'];
        }

        $columns = [];

        foreach ($tables as $table) {
            $query = "PRAGMA table_info($table)";
            $result = $db->query($query);
            
            $tableColumns = [];
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $tableColumns[] = $row['name'];
            }

            $query = "SELECT * FROM $table LIMIT 1";
            $result = $db->query($query);
            $firstRow = $result->fetchArray(SQLITE3_ASSOC);

            $columns[$table] = [
                'columns' => $tableColumns,
                'firstRow' => $firstRow
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($columns);
    }
} else {
    echo "Failed to connect to the database";
}
?>
