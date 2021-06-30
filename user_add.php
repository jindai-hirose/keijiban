<?php

  ini_set('display_errors', "On");

  $name = $_POST['name'];
  $mail = $_POST['mail'];
  $username = $_POST['username'];
  $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);

  $dsn = "mysql:host=localhost; dbname=users; charset=utf8";
  $dbUsername = "root";
  $dbPassword = "root";
  try {
      $dbh = new PDO($dsn, $dbUsername, $dbPassword);
  } catch (PDOException $e) {
      $msg = $e->getMessage();
  }

  //重複チェック
  $overlapCheck = "SELECT * FROM users WHERE mail = $mail";
  $stmt = $dbh->prepare($overlapCheck);
  $stmt->bindValue(':mail', $mail);
  $stmt->execute();
  $member = $stmt->fetch();
  if ($member['mail'] === $mail) {
    $msg = '同じメールアドレスが存在します。';
    $link = '<a href="http://localhost/keijiban/user_login.html">戻る</a>';
  } else {
    //登録されていなければinsert 
    $registration = "INSERT INTO users(name, mail, pass) VALUES (:name, :mail, :pass)";
    $stmt = $dbh->prepare($registration);
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':mail', $mail);
    $stmt->bindValue(':pass', $pass);
    $stmt->execute();
    $msg = '会員登録が完了しました';
    $link = '<a href="login.php">ログインページ</a>';
  }


  

  // if(isset($_POST['user'])) {
  //   $dsn='mysql:dbname=board;charset=utf8';
  //   $user='ユーザー名';
  //   $password='パスワード';
  //   $dbh = new PDO($dsn,$user,$password);
  //   $stmt = $dbh->prepare("INSERT INTO users VALUES(:user,:password,:name,//:address,:tel)");
  //   $stmt->bindParam(':user', $_POST['user']);
  //   $stmt->bindParam(':password', $_POST['password']);
  //   $stmt->bindParam(':name', $_POST['name']);
  //   $stmt->bindParam(':address', $_POST['address']);
  //   $stmt->bindParam(':tel', $_POST['tel']);
  //   $stmt->execute();
  // }
?>