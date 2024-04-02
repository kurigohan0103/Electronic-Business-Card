<?php
session_start();
require_once 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $raw_data = file_get_contents("php://input");
    $data = json_decode($raw_data, true);
    $qr_data = $data['qrData'];

    if (isset($qr_data)) {
        $_SESSION['qrCodeData'] = $qr_data;

        try {
            $pdo = new PDO($dsn, $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"], $options);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare("INSERT INTO friends (user_id, other_user_id) VALUES (?, ?)");

            $my_id = $_SESSION["id"];
            $other_id = (int)$qr_data;
            $stmt->bindParam(1, $my_id);
            $stmt->bindParam(2, $other_id);

            $stmt->execute();

            echo "QR code data saved successfully";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "エラー: QRコードのデータが受信されませんでした。";
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <!-- CSS -->
        <link rel="stylesheet" href="./camera.css"/>
        <!-- JavaScript -->
        <script src="./jsQR.js" defer></script>
        <script src="./main.js" defer></script>
    </head>
    <body>
    <div class="navigation">
      <ul>
        <li class="list">
          <a href="showData.php">
            <span class="icon"><ion-icon name="home-outline"></ion-icon></span>
            <span class="title">HOME</span>
          </a>
        </li>
        <li class="list active">
          <a href="MyPage.php">
            <span class="icon"><ion-icon name="person-circle-outline"></ion-icon></span>
            <span class="title">PROFILE</span>
          </a>
        </li>
        <li class="list">
          <a href="logout.php">
            <span class="icon"
              ><ion-icon name="log-out-outline"></ion-icon
            ></span>
            <span class="title">SIGNOUT</span>
          </a>
        </li>
      </ul>
  </div>


    <div class="content">
        <div id="wrapper">
            <div id="msg"></div>
            <canvas id="canvas"></canvas>

            <button class="button1" id="redirectButton1" type="button">Back</button>
            
        </div>
    </div>

    <!-- <button class="button1" id="redirectButton1" type="button">Back</button> -->

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // ボタン要素を取得
            const button1 = document.getElementById("redirectButton1");

            // ボタンのクリックイベントを処理
            button1.addEventListener("click", function() {
                
                window.location.href = "MyPage.php";
            });
        });
    </script>

    
    <!-- サイドバーのJS -->
    <script>
      const list = document.querySelectorAll(".list");
      console.log(list);
      function activeLink() {
        list.forEach((item) =>
          // console.log(item);
          item.classList.remove("active")
        );
        this.classList.add("active");
      }

      list.forEach((item) => {
        item.addEventListener("click", activeLink);
      });
    </script>

    <!-- アイコンの引用元 -->
    <script
      type="module"
      src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"
    ></script>
    <script
      nomodule
      src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"
    ></script>
    </body>
</html>