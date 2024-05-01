<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['handle']) && isset($_POST['randomString'])) {
    $handle = $_POST['handle'];
    $randomString = $_POST['randomString'];

    $apiUrl = 'https://api.clippsly.com/v1/external/bsky-latest-post?handle=' . urlencode($handle);
    $postResponse = file_get_contents($apiUrl);

    if ($postResponse !== false) {
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
    } else {
        echo json_encode(array("status" => "error"));
    }
}
?>
