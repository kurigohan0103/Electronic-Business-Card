<?php
// ファイルの読み込み
require_once "db_connect.php";
require_once "functions.php";
// セッション開始
session_start();

// URLパラメーターからユーザーIDを取得
$userID = isset($_GET["user_id"]) ? $_GET["user_id"] : '';

// ユーザーIDが空の場合は処理を中止
if(empty($userID)) {
    echo "ユーザーIDが指定されていません。";
    exit;
}

// 友達の情報を取得するSQLクエリ
$sql = "SELECT * FROM user_info WHERE user_id = :userID";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':userID', $userID, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// ユーザーが存在しない場合はエラーメッセージを表示
if(!$row) {
    echo "指定されたユーザーが存在しません。";
    exit;
}

$kanji_name = $row['kanji_name'];
$romaji_name = $row['romaji_name'];
$affiliation = $row['affiliation'];
$position = $row['position'];
$company_address = $row['company_address'];
$phone_number = $row['phone_number'];
$email_address = $row['email_address'];
$photo_url = $row['photo_url'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Friend Information</title>
    <link rel="stylesheet" href="./friendPage.css">
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
      <div class="namecard">
            <ul class="name" style="list-style: none;">
                <li class="position"><?php echo $position; ?></li>
                <li class="kanji_name"><?php echo $kanji_name; ?></li>
                <li class="romaji_name"><?php echo $romaji_name; ?></li>
            </ul>
            

            <p class="affiliation"><?php echo $affiliation; ?></p>
            <p class="company_address"><?php echo $company_address; ?></p>       

            <div class="contact">
                <p class="phone_number"><ion-icon name="call-outline"></ion-icon>：<?php echo $phone_number; ?></p>
                <p class="email_address"><ion-icon name="mail-outline"></ion-icon>：<?php echo $email_address; ?></p>
            </div>
        </div>

    <button class="button2" id="redirectButton2" type="button">Back</button>
</div>


<script>
        document.addEventListener("DOMContentLoaded", function() {
            // ボタン要素を取得
            const button1 = document.getElementById("redirectButton2");

            // ボタンのクリックイベントを処理
            button1.addEventListener("click", function() {
                
                window.location.href = "showData.php";
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
