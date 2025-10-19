<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$input = $data['message'] ?? '';

if (!$input) {
    echo json_encode(['reply' => 'No message received.']);
    exit;
}

// Replace this with your Gemini API Key
$geminiApiKey = "AIzaSyBmLYeBSgrlhqLaCOBkQ5lX-1Xn2kg6Ul8";
$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-pro:generateContent?key=" . $geminiApiKey;

$payload = json_encode([
    "contents" => [
        [
            "parts" => [
                ["text" => $input]
            ]
        ]
    ]
]);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

$response = curl_exec($ch);
curl_close($ch);

$respData = json_decode($response, true);

// Check for API error
if (isset($respData['error'])) {
    echo json_encode(['reply' => "❌ Gemini API Error: " . $respData['error']['message']]);
    exit;
}

// Extract the reply
$reply = $respData['candidates'][0]['content']['parts'][0]['text'] ?? "⚠️ No reply found.";
echo json_encode(['reply' => $reply]);
?>
