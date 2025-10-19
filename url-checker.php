<?php
$result = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $api_key = "AIzaSyBISQd4V0h4Lyjd-O451YLFQavjtzTSRAs";
    $url_to_check = trim($_POST['url']);

    $fake_malicious_urls = [
        "https://facebook.com-login.com",
        "https://getfreefollowers.in",
        "http://insta.verify-user.info",
        "http://security-alert-check.com",
        "http://malicious-site.test"
    ];

    if (in_array($url_to_check, $fake_malicious_urls)) {
        $result = "<p style='color:#ff4d4d;'>⚠️ This URL is a known malicious (simulated) site.</p>";
    } else {
        $request_body = json_encode([
            "client" => ["clientId" => "cybersiksha", "clientVersion" => "1.0"],
            "threatInfo" => [
                "threatTypes" => ["MALWARE", "SOCIAL_ENGINEERING", "UNWANTED_SOFTWARE", "POTENTIALLY_HARMFUL_APPLICATION"],
                "platformTypes" => ["ANY_PLATFORM"],
                "threatEntryTypes" => ["URL"],
                "threatEntries" => [["url" => $url_to_check]]
            ]
        ]);

        $ch = curl_init("https://safebrowsing.googleapis.com/v4/threatMatches:find?key=$api_key");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request_body);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);
        if (empty($data['matches'])) {
            $result = "<p style='color:#00ff99;'>✅ The URL <strong>$url_to_check</strong> is safe.</p>";
        } else {
            $result = "<p style='color:#ff4d4d;'>🚨 Warning! The URL <strong>$url_to_check</strong> is dangerous.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>URL Safety Checker – Cyber Siksha</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    html, body {
      height: 100%;
      font-family: 'Segoe UI', sans-serif;
      background-color: #000;
      color: white;
      overflow: hidden;
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative;
    }

    body::before {
      content: "";
      position: fixed;
      top: var(--y, 50%);
      left: var(--x, 50%);
      width: 1500px;
      height: 1500px;
      background: radial-gradient(circle at center, #ff00cc, #3333ff, #00ffcc);
      opacity: 0.15;
      transform: translate(-50%, -50%);
      filter: blur(180px);
      transition: 0.1s ease-out;
      z-index: 0;
      pointer-events: none;
    }

    .container {
      max-width: 600px;
      width: 90%;
      background: rgba(20, 20, 40, 0.9);
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(0,255,255,0.2);
      text-align: center;
      z-index: 1;
    }

    h1 {
      font-size: 28px;
      color: #84e8f0;
      margin-bottom: 20px;
    }

    input[type="url"] {
      padding: 12px;
      width: 90%;
      font-size: 16px;
      border: none;
      border-radius: 6px;
      margin-top: 10px;
      outline: none;
    }

    button {
      margin-top: 15px;
      padding: 12px 25px;
      background: #0077cc;
      border: none;
      border-radius: 6px;
      color: white;
      font-size: 16px;
      cursor: pointer;
    }

    button:hover {
      background: #005fa3;
    }

    .result {
      margin-top: 20px;
      font-size: 18px;
    }

    .back-button {
      position: fixed;
      top: 20px;
      left: 20px;
      padding: 10px 14px;
      background: #0077cc;
      color: white;
      text-decoration: none;
      border-radius: 8px;
      z-index: 2;
    }

    .back-button:hover {
      background: #005fa3;
    }

    @media (max-width: 600px) {
      h1 {
        font-size: 22px;
      }

      input[type="url"], button {
        width: 100%;
      }

      .back-button {
        font-size: 14px;
        padding: 8px 12px;
      }
    }
  </style>
</head>
<body onmousemove="moveGradient(event)">

<a class="back-button" href="main.html">← Back</a>

<div class="container">
  <h1>🔐 Cyber Siksha URL Safety Checker</h1>
  <form method="post">
    <input type="url" name="url" placeholder="Enter URL (e.g. https://example.com)" required>
    <br>
    <button type="submit">🔍 Check Now</button>
  </form>
  <div class="result">
    <?php echo $result; ?>
  </div>
</div>

<script>
  function moveGradient(e) {
    const x = e.clientX || window.innerWidth / 2;
    const y = e.clientY || window.innerHeight / 2;
    document.body.style.setProperty('--x', `${x}px`);
    document.body.style.setProperty('--y', `${y}px`);
  }
</script>

</body>
</html>
