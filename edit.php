<?php
//ファイルの読み込み
require_once "db_connect.php";
require_once "functions.php";
//セッション開始
session_start();
// セッションからユーザーIDを取得
$userID = isset($_SESSION["id"]) ? $_SESSION["id"] : "";

// ユーザーIDに基づいてuser_infoテーブルから情報を取得
$stmt = $pdo->prepare("SELECT * FROM user_info WHERE user_id = ?");
$stmt->execute([$userID]);
$userInfo = $stmt->fetch(PDO::FETCH_ASSOC);

// 各要素を変数に格納
$kanji_name = $userInfo['kanji_name'];
$romaji_name = $userInfo['romaji_name'];
$affiliation = $userInfo['affiliation'];
$position = $userInfo['position'];
$company_address = $userInfo['company_address'];
$phone_number = $userInfo['phone_number'];
$email_address = $userInfo['email_address'];
$photo_url = $userInfo['photo_url'];


// POSTリクエストを処理
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // フォームから送信されたデータを取得
    $kanji_name = $_POST["kanji_name"];
    $romaji_name = $_POST["romaji_name"];
    $affiliation = $_POST["affiliation"];
    $position = $_POST["position"];
    $company_address = $_POST["company_address"];
    $phone_number = $_POST["phone_number"];
    $email_address = $_POST["email_address"];
    $photo_url = $_POST["photo_url"];

    // データベースの情報を更新
    $stmt = $pdo->prepare("UPDATE user_info SET kanji_name=?, romaji_name=?, affiliation=?, position=?, company_address=?, phone_number=?, email_address=?, photo_url=? WHERE user_id=?");
    $stmt->execute([$kanji_name, $romaji_name, $affiliation, $position, $company_address, $phone_number, $email_address, $photo_url, $userID]);

    // MyPage.phpにリダイレクト
    header("Location: edit.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./edit.css"/>
    <title>Edit</title>
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
            <span class="title">PLOFILE</span>
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
        <form action="" method="POST">
            <div class="namecard"> 
                <ul class="name" style="list-style: none;">
                    <li class="position">
                        <input type="text" name="position" value="<?php echo $position; ?>">
                    </li>
                    <li class="kanji_name">
                        <input type="text" name="kanji_name" value="<?php echo $kanji_name; ?>">
                    </li>
                    <li class="romaji_name">
                        <input type="text" name="romaji_name" value="<?php echo $romaji_name; ?>">
                    </li>
                </ul>

                <p class="affiliation">
                    <input type="text" name="affiliation" value="<?php echo $affiliation; ?>">
                </p>
                <p class="company_address">
                    <input type="text" name="company_address" value="<?php echo $company_address; ?>">
                </p>

                <div class="contact">
                    <p class="phone_number"><ion-icon name="call-outline"></ion-icon>：
                        <input type="tel" name="phone_number" value="<?php echo $phone_number; ?>">
                    </p>
                    <p class="email_address"><ion-icon name="mail-outline"></ion-icon>：
                        <input type="email" name="email_address" value="<?php echo $email_address; ?>">
                    </p>
                </div>
              </div>    

              <input class="updateButton" type="submit" value="Update">
          </form>
        

        <button class="button2" id="redirectButton2" type="button">Back</button>
    </div>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // ボタン要素を取得
            const button1 = document.getElementById("redirectButton2");

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
