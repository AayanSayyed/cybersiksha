<?php
$feed_url = 'https://news.google.com/rss/search?q=cybersecurity&hl=en-IN&gl=IN&ceid=IN:en';

// Use cURL to fetch feed
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $feed_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
$xml_data = curl_exec($ch);
curl_close($ch);

// Load XML
$feed = simplexml_load_string($xml_data);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Cyber News – Cyber Siksha</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    html, body {
      height: 100%;
      background: #000;
      font-family: 'Segoe UI', sans-serif;
      color: white;
      overflow-x: hidden;
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
      pointer-events: none;
      z-index: 0;
    }

    .container {
      max-width: 1200px;
      margin: auto;
      padding: 40px 20px;
      position: relative;
      z-index: 1;
    }

    h1 {
      text-align: center;
      font-size: 28px;
      color: #84e8f0;
      margin-bottom: 30px;
    }

    .news-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
    }

    .card {
      background: rgba(20, 20, 40, 0.9);
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0, 255, 255, 0.15);
      width: 350px;
      transition: transform 0.3s ease;
    }

    .card:hover {
      transform: scale(1.03);
    }

    .card h3 {
      font-size: 18px;
      color: #00ccff;
      margin-bottom: 10px;
    }

    .card p {
      font-size: 14px;
      color: #ccc;
    }

    .meta {
      font-size: 12px;
      color: #999;
      margin-top: 10px;
    }

    a {
      color: #00ccff;
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }

    .back-button {
      position: fixed;
      top: 20px;
      left: 20px;
      background: #0077cc;
      color: white;
      padding: 10px 14px;
      border-radius: 8px;
      text-decoration: none;
      z-index: 2;
    }

    .back-button:hover {
      background: #005fa3;
    }

    @media (max-width: 768px) {
      .card {
        width: 90%;
      }

      h1 {
        font-size: 22px;
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
  <h1>📰 Live Cybersecurity News</h1>
  <div class="news-container">
    <?php
    if ($feed && isset($feed->channel->item)) {
      $count = 0;
      foreach ($feed->channel->item as $item) {
        if ($count >= 10) break;
        echo "<div class='card'>";
        echo "<h3><a href='{$item->link}' target='_blank'>" . htmlspecialchars($item->title) . "</a></h3>";
        echo "<p>" . htmlspecialchars(strip_tags($item->description)) . "</p>";
        echo "<div class='meta'>Published on: " . date("d M Y", strtotime($item->pubDate)) . "</div>";
        echo "</div>";
        $count++;
      }
    } else {
      echo "<p style='color:red; text-align:center;'>Unable to fetch news. Try again later.</p>";
    }
    ?>
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
