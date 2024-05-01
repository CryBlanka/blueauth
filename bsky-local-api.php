<?php

$isCurl = isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'curl') !== false;

require 'vendor/autoload.php';

use SocialWeb\Atproto\Api\Client;

$client = new Client('https://bsky.social');

$session = $client->login('login', 'password');

if (isset($_GET['handle']) && !empty($_GET['handle'])) {
    $userHandle = $_GET['handle'];
    $accessToken = $session->accessJwt;

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://public.api.bsky.app/xrpc/app.bsky.feed.getAuthorFeed?actor=' . $userHandle . '&limit=1',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Authorization: Bearer ' . $accessToken
        ),
    ));

    $response = curl_exec($curl);

    if ($response === false) {
        $error = curl_error($curl);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Failed to fetch data: ' . $error]);
        exit();
    }

    curl_close($curl);
    header('Content-Type: application/json');
    echo $response;
    exit();
} else {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Missing handle']);
    exit();
}
?>
