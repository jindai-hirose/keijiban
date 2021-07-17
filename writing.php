<!--
  スレッド情報をデータベースへの書き込み
-->

<?php
ini_set('display_errors', "On");

	// データベースの接続情報
	define( 'DB_HOST', 'localhost');
	define( 'DB_USER', 'root');
	define( 'DB_PASS', 'root');
	define( 'DB_NAME', 'board');

  // タイムゾーン設定
  date_default_timezone_set('Asia/Tokyo');

  // 変数の初期化
  $now_date = null;
  $data = null;
  $file_handle = null;
  $split_data = null;
  $message = array();
  $message_array = array();
  $success_message = null;
  $error_message = array();
  $clean = array();
  $th_name = $_REQUEST['th_name'];
  $th_outline = $_REQUEST['th_outline'];


  //sqlインジェクション対策
//	if($_GET["th_id"] == null){
//		print_r($_GET["th_id"]);
//		//die();
//		header('Location: ./error.php');
//	}
//
//	if(strval($th_id) != strval(intval($th_id))){
//		//die();
//		header('Location: ./error.php');
//	}
//
//	$idcheck = "SELECT MAX(th_id) FROM threads";
//	if($_GET["th_id"]>$idcheck){
//		//die();
//		header('Location: ./error.php');
//	}

  // データベースに接続（書き込み）
  $mysqli = new mysqli('127.0.0.1', 'root', 'root', 'board');
  
  // 接続エラーの確認
  if( $mysqli->connect_errno ) {
    $error_message[] = '書き込みが失敗しました。 エラー番号 '.$mysqli->connect_errno.' : '.$mysqli->connect_error;
  } else {
    // データベースの処理を記述
    // 文字コード設定
    $mysqli->set_charset('utf8');
    
    // 書き込み日時を取得
    $now_date = date("Y/m/d H:i:s");

    $th_name   = $_REQUEST['th_name'];
    $th_outline = $_REQUEST['th_outline'];
    
    // データを登録するSQL作成
    $sql = "INSERT 
    INTO
      threads (
        th_name,
        th_outline,
          th_date
          ) VALUES (
        '$th_name', 
        '$th_outline', 
        '$now_date'
        )";
    
    // データを登録
    $res = $mysqli->query($sql);
  
    if( $res ) {
      $_SESSION['success_message'] = 'メッセージを書き込みました。';
    } else {
      $error_message[] = '書き込みが失敗しました。';
    }



    // データベースの接続を閉じる
    $mysqli->close(); 

    //リダイレクト　
    $url = 'http://localhost/keijiban/table.php';
    header('Location: ' . $url, true, 301);
    exit;
    }

?>  