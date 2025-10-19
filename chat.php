$proxyUrl = "https://your-replit-username.gemini-proxy.repl.co/chat";

$data = array("text" => $userInput);

$options = array(
  'http' => array(
    'header'  => "Content-Type: application/json\r\n",
    'method'  => 'POST',
    'content' => json_encode($data),
  ),
);

$context  = stream_context_create($options);
$response = file_get_contents($proxyUrl, false, $context);
