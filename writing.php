<!--
  スレッド情報をデータベースへの書き込み
-->

<?php
ini_set('display_errors', "On");

  // タイムゾーン設定
  date_default_timezone_set('Asia/Tokyo');
  	 
    //書き込み日時を取得
    $now_date = date("Y/m/d H:i:s");
    print $now_date;
	if ($_SERVER['REQUEST_METHOD']==='POST') {
        $th_name = $_REQUEST['th_name'];
        $th_outline = $_REQUEST['th_outline'];
	}
	
	$dsn = 'mysql:dbname=board;host=localhost;port=3306;charset=utf8';
	$user = 'root';
	$password = 'root';
	
	try {
		$dbh = new PDO($dsn, $user, $password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO threads(th_name,th_outline,th_date) VALUES (':th_name',':th_outline',':now_date')";
		$stmt = $dbh->prepare($sql);
		$stmt->bindValue(':th_name', $th_name, PDO::PARAM_STR);
        $stmt->bindValue(':th_outline', $th_outline, PDO::PARAM_STR);
        $stmt->bindValue(':now_date', $now_date, PDO::PARAM_STR);
		$stmt->execute();
	} catch (PDOException $e) {
		echo($e->getMessage());
		die();
	}
	
	//リダイレクト　
    $url = 'http://localhost/keijiban/table.php';
    header('Location: ' . $url, true, 301);
    exit;
 
 
//  // データベースに接続（書き込み）
//  $mysqli = new mysqli('127.0.0.1', 'root', 'root', 'board');
//
//  // 接続エラーの確認
//  if( $mysqli->connect_errno ) {
//    $error_message[] = '書き込みが失敗しました。 エラー番号 '.$mysqli->connect_errno.' : '.$mysqli->connect_error;
//  } else {
//    // データベースの処理を記述
//    // 文字コード設定
//    $mysqli->set_charset('utf8');
//
//    // 書き込み日時を取得
//    $now_date = date("Y/m/d H:i:s");
//
//    $th_name   = $_REQUEST['th_name'];
//    $th_outline = $_REQUEST['th_outline'];
//
//    // データを登録するSQL作成
//    $sql = "INSERT
//    INTO
//      threads (
//        th_name,
//        th_outline,
//          th_date
//          ) VALUES (
//        '$th_name',
//        '$th_outline',
//        '$now_date'
//        )";
//
//    // データを登録
//    $res = $mysqli->query($sql);
//
//    if( $res ) {
//      $_SESSION['success_message'] = 'メッセージを書き込みました。';
//    } else {
//      $error_message[] = '書き込みが失敗しました。';
//    }
//
//
//
//    // データベースの接続を閉じる
//    $mysqli->close();
//
//    //リダイレクト　
//    $url = 'http://localhost/keijiban/table.php';
//    header('Location: ' . $url, true, 301);
//    exit;
//    }

?>  