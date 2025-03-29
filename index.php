<?php
$result = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone = htmlspecialchars($_POST['phone']);
    $api_url = "https://legendxdata.site/Api/simdata.php?phone=" . urlencode($phone);

    $response = file_get_contents($api_url);
    $data = json_decode($response, true);

    if (!empty($data) && is_array($data) && isset($data[0])) {
        $user = $data[0]; // Extract first object from array

        $result = '
            <div class="result-box">
                <p><strong>📞 Mobile:</strong> ' . ($user['Number'] ?? "Not found") . '</p>
                <p><strong>👤 Name:</strong> ' . ($user['Name'] ?? "Not found") . '</p>
                <p><strong>🆔 CNIC:</strong> ' . ($user['CNIC'] ?? "Not found") . '</p>
                <p><strong>📍 Address:</strong> ' . ($user['Address'] ?? "Not found") . '</p>
                <p><strong>📶 Operator:</strong> ' . ($user['Operator'] ?? "Not found") . '</p>
                <button class="copy-btn" onclick="copyData()">📋 Copy All Data</button>
            </div>';
    } else {
        $result = '<div class="result-box error">No data found for this number.</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIM Data Lookup</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 50px;
            background-color: #121212;
            color: #fff;
        }
        .container {
            background: #1e1e1e;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px cyan;
            width: 350px;
            margin: auto;
        }
        .container h2 {
            color: cyan;
        }
        input {
            width: 90%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #00ffff;
            background: #2a2a2a;
            color: white;
        }
        .btn {
            width: 100%;
            padding: 10px;
            background: linear-gradient(to right, cyan, blue);
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            color: white;
        }
        .btn:hover {
            background: linear-gradient(to right, blue, cyan);
        }
        .result-box {
            background: #111;
            padding: 15px;
            margin-top: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px cyan;
            text-align: left;
        }
        .copy-btn, .tg-btn {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            color: black;
        }
        .copy-btn {
            background: gold;
        }
        .tg-btn {
            background: #0088cc; /* Telegram Blue */
            color: white;
        }
        .tg-btn:hover {
            background: #0077b5;
        }
        .error {
            background: #ff4444;
            box-shadow: 0px 0px 10px red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>🔍 Search SIM Details</h2>
        <form method="POST">
            <input type="text" name="phone" placeholder="Enter phone number" required>
            <button type="submit" class="btn">🔎 Get Details</button>
        </form>
        <div id="response">
            <?php echo $result; ?>
        </div>
        <a href="https://t.me/MaybeCyropes" target="_blank">
            <button class="tg-btn">💬 Contact Developer</button>
        </a>
    </div>

    <script>
        function copyData() {
            let text = document.querySelector(".result-box").innerText;
            navigator.clipboard.writeText(text).then(() => {
                alert("Data copied to clipboard!");
            });
        }
    </script>
</body>
</html>
