<?php

  include("./column.php");

  ini_set('display_errors', "On");

  function dd(...$value){
    var_dump(...$value); exit;
  }

//dd($usersId);
  

  $name = $_POST['name'];
  $mail = $_POST['mail'];
  $username = $_POST['username'];
  $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);

  $dsn = "mysql:host=localhost; dbname=board; charset=utf8";
  $dbUsername = "root";
  $dbPassword = "root";
  try {
      $dbh = new PDO($dsn, $dbUsername, $dbPassword);
  } catch (PDOException $e) {
    //var_dump($e->getMessage()); exit;
      $msg = $e->getMessage();
  }

  //重複チェック
  $overlapCheck = "SELECT * FROM users WHERE $usersMail = :mail";
  $stmt = $dbh->prepare($overlapCheck);
  $stmt->bindValue(':mail', $mail);
  $stmt->execute();
  
  /** @var array|false $member */
  $member = $stmt->fetch();

  //登録されていなければinsert
  if (!$member){
    try{
      $registration = "INSERT INTO users ($usersName, $usersMail, $usersPass) VALUES (:name, :mail, :pass)";
      $stmt = $dbh->prepare($registration);
      $stmt->bindValue(':name', $name);
      $stmt->bindValue(':mail', $mail);
      $stmt->bindValue(':pass', $pass);
      $stmt->execute();
      //dd($stmt);
      $msg = '会員登録が完了しました';
      $link = '<a href="http://localhost/keijiban/user_login.html">ログインページ</a>';
      echo $msg. $link;
      return;
    }catch(Exception $e){
      dd($e->getMessage());
    }
  }

  if ($member[$usersMail] === $mail) {
    //dd($member);
    $msg = '登録済みのメールアドレスです。';
    $link = '<a href="http://localhost/keijiban/user_login.html">戻る</a>';
  }
  echo $msg. $link;

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