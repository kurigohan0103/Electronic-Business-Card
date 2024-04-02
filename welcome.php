<?php
session_start();

// サインアウトがクリックされた場合
if(isset($_GET["logout"]) && $_GET["logout"] == true){
    // セッションを破棄
    session_destroy();
    // ログインページにリダイレクト
    header("location: login.php");
    exit;
}

// セッション変数 $_SESSION["loggedin"]を確認。ログイン済だったらウェルカムページへリダイレクト
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ 
            font: 14px sans-serif;
            text-align: center; 
        }
    </style>
</head>
<body>
    <h1 class="my-5">Hi,<b><?php echo htmlspecialchars($_SESSION["name"]); ?></b>. Welcome to our site.</h1>
    <p>
        <a href="?logout=true" class="btn btn-danger ml-3">Sign Out of Your Account</a>
    </p>
    <a href="MyPage.php" class="btn btn-primary">マイページへ</a>
</body>
</html>
