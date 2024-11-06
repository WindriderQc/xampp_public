<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read the raw POST data
    $data = json_decode(file_get_contents('php://input'), true);

    // Check if the required fields are provided
    if (isset($data['table'], $data['column'], $data['newValue'], $data['id'], $data['primaryKey'])) {
        $table = $data['table'];
        $column = $data['column'];
        $newValue = $data['newValue'];
        $id = $data['id'];  // ID of the row to update
        $primaryKey = $data['primaryKey'];  // Primary key column (either TeamNumber or Number)

        // Escape inputs to prevent SQL injection
        $newValue = SQLite3::escapeString($newValue);
        $id = (int) $id;  // Ensure 'id' is an integer

        // Connect to the database
        $DatabaseFile = '../LHSQC-STHS.db';
        $db = new SQLite3($DatabaseFile);

        if ($db) {
            // Prepare the query for updating the field using the dynamic primaryKey
            $query = "UPDATE $table SET $column = '$newValue' WHERE $primaryKey = $id"; // Use dynamic primaryKey (either TeamNumber or Number)
            $result = $db->exec($query);

            if ($result) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Database update failed']);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to connect to the database']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid input']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?>
