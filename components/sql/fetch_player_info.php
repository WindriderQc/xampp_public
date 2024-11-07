<?php    

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

require_once("../../STHSSetting.php");
//echo $DatabaseFile;
$DatabaseFile = '../../LHSQC-STHS.db';

//$path = "../../" . $DatabaseFile . "";


$db = new SQLite3($DatabaseFile);

if($db) {
    $query = "SELECT * FROM PlayerInfo";
    $result = $db->query($query);

    if (!$result) {
        echo json_encode(["error" => $db->lastErrorMsg()]);
    } else {
        $playersInfo = [];

        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $playersInfo[] = $row;
        }

        echo json_encode($playersInfo);
    }
}
else { 
    echo json_encode(["error" => "Error - db not defined when fetching players info"]); 
}
?>