<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['handle'])) {
    $handle = $_POST['handle'];
    $randomString = $handle . "_" . substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 29);
    echo json_encode(array("randomString" => $randomString));
}
?>
