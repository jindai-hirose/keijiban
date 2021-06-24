<?php
  if(isset($_POST['user'])) {
    $dsn='mysql:dbname=board;charset=utf8';
    $user='ユーザー名';
    $password='パスワード';
    $dbh = new PDO($dsn,$user,$password);

    $stmt = $dbh->prepare("SELECT * FROM users WHERE user_id=:user");
    $stmt->bindParam(':user', $_POST['user']);
    $stmt->execute();
    if($rows = $stmt->fetch()) {
      if($rows["password"] ==  $_POST['password']) {
        print "<p>ログイン成功</p>";
      }else {
        print "<p>ログイン失敗</p>";
      }
        }else {
      print "<p>ログイン失敗</p>";
    }
  }
?>