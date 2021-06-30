<?php
  if(isset($_POST['user'],$_POST['password'])) {
    $dsn='mysql:dbname=board;charset=utf8';
    $user=$_POST['user'];
    $password=$_POST['password'];
    $dbh = new PDO($dsn,$user,$password);

    $stmt = $dbh->prepare("SELECT * FROM users WHERE user_id = $user");
    $stmt->execute();
    if($rows = $stmt->fetch()) {
      if($stmt ===  $_POST['password']) {
        print "<p>ログイン成功</p>";
      }else {
        print "<p>ログイン失敗</p>";
      }
        }else {
      print "<p>ログイン失敗</p>";
    }
  }
?>