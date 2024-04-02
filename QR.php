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


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./QR.css">
    <title>QRCODE</title>
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
                    <span class="icon">
                    <ion-icon name="log-out-outline"></ion-icon>
                    </span>
                    <span class="title">SIGNOUT</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="content">
        <div class="around">

            <!-- QRコードを表示するための要素 -->
            <div class="qrcode" id="qrcode"></div>

        </div>

        <div class="qrbutton">
            <div class="download_around">
                <button id="downloadButton"><ion-icon name="download-outline"></ion-icon></button>
            </div>

            <div class="copyLink_around">
                <button id="copyLinkButton"><ion-icon name="link-outline"></ion-icon></button>
            </div>
        </div>
        
        <button class="button1" id="redirectButton1" type="button">Back</button>
    
    </div>


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

    <!-- qrcode.jsのスクリプト -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js" integrity="sha512-CNgIRecGo7nphbeZ04Sc13ka07paqdeTu0WR1IM4kNcpmBAUSHSQX0FslNhTDadL4O5SAGapGt4FodqL8My0mA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>  

    <!-- QRコードのJS -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
        // QRコードを表示する要素を取得
        const qrCodeDiv = document.getElementById("qrcode");

        // PHPで取得したユーザーIDをJavaScriptの変数に代入
        let userID = "<?php echo $userID; ?>";

        // URLを変数に代入
        let URL = userID;

        // QRコードを生成して表示
        const qrCode = new QRCode(qrCodeDiv, URL);

        // ダウンロードボタンのクリックイベントを処理
        document.getElementById("downloadButton").addEventListener("click", function() {
            // 一時的なキャンバス要素を作成
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');

            // キャンバスのサイズを設定
            const width = qrCodeDiv.offsetWidth;
            const height = qrCodeDiv.offsetHeight;
            canvas.width = width;
            canvas.height = height;

            // QRコードをキャンバスに描画
            context.drawImage(qrCodeDiv.querySelector('img'), 0, 0, width, height);

            // キャンバスをPNG画像に変換
            const dataURL = canvas.toDataURL('image/png');

            // 一時的なダウンロードリンクを作成
            const downloadLink = document.createElement('a');
            downloadLink.href = dataURL;
            downloadLink.download = 'qrcode.png';

            // ダウンロードリンクをクリックしたことにする
            downloadLink.click();

            // 後片付け
            canvas.remove();
        });

        // QRコードのリンクをコピーするボタンのクリックイベントを処理
        document.getElementById("copyLinkButton").addEventListener("click", function() {
            // QRコードのURLを取得
            const link = document.createElement('input');
            link.value = URL;
            document.body.appendChild(link);
            link.select();
            document.execCommand('copy');
            document.body.removeChild(link);
            alert('copy!');
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
