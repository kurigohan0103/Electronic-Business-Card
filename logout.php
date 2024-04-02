<?php
// セッション開始
session_start();

// セッション変数を空にする
$_SESSION = array();

// セッションを破棄する
session_destroy();

// ログアウト後、ログインページにリダイレクトする
header("location: login.php");
exit;
?>
