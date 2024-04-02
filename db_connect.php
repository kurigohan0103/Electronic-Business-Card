<?php
  require_once __DIR__ . '/vendor/autoload.php'; // dotenv ライブラリのオートロードを読み込みます

  $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
  $dotenv->load();

  $dsn = "mysql:host={$_ENV["DB_HOST"]};dbname={$_ENV["DB_NAME"]}";
  $options = array(
    //PDO::MYSQL_ATTR_SSL_CA => "/etc/ssl/certs/ca-certificates.crt",
    PDO::MYSQL_ATTR_SSL_CA => "/etc/ssl/cert.pem",
    //ここは機種によって変わるかも
  );

  $pdo = new PDO($dsn, $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"], $options);
?>