<?php
function log2console($data) {
    $json_data = json_encode($data);
    echo "<script>console.log($json_data);</script>";
}
?>
