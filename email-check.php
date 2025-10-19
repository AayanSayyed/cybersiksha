<?php
if (!isset($_POST['email'])) {
    echo json_encode(['error' => 'Email not provided']);
    exit;
}

$email = urlencode(trim($_POST['email']));
$url = "https://emailrep.io/$email";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'CyberSiksha/1.0'); // required
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Accept: application/json"
]);

$response = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if (curl_errno($ch)) {
    echo json_encode(['error' => 'Curl error: ' . curl_error($ch)]);
    curl_close($ch);
    exit;
}
curl_close($ch);

// Check if EmailRep.io blocked your request
if ($httpcode !== 200) {
    echo json_encode(['error' => "API responded with status $httpcode"]);
    exit;
}

echo $response;
?>
