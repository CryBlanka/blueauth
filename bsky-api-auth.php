<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['handle']) && isset($_POST['randomString'])) {
    $handle = $_POST['handle'];
    $randomString = $_POST['randomString'];
    $token = "YOUR BLUESKY SECRET";
    $postRequest = curl_init('https://bluesky.api.stdlib.com/feed@0.1.0/posts/list/author/');
    curl_setopt($postRequest, CURLOPT_POST, true);
    curl_setopt($postRequest, CURLOPT_POSTFIELDS, json_encode(array("author" => $handle, "limit" => 1)));
    curl_setopt($postRequest, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($postRequest, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $token
    ));

    $postResponse = curl_exec($postRequest);
    $postData = json_decode($postResponse);

    if ($postData && isset($postData->feed) && count($postData->feed) > 0 && isset($postData->feed[0]->post->record->text)) {
        $postText = $postData->feed[0]->post->record->text;
        if ($postText === $randomString) {
            echo json_encode(array("status" => "success"));
        } else {
            echo json_encode(array("status" => "fail"));
        }
    } else {
        echo json_encode(array("status" => "error"));
    }
    curl_close($postRequest);
}
?>
