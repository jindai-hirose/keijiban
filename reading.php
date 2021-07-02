<!-- 
  読み込み(放置中)
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

  if( !empty($_POST['create_submit']) ) {
    // 投稿者名の入力チェック
	  if( empty($_POST['th_name']) ) {
		  $error_message[] = '題名を入力してください。';
	  } else {
			$clean['th_name'] = htmlspecialchars( $_POST['th_name'], ENT_QUOTES);
			$clean['th_name'] = preg_replace( '/\\r\\n|\\n|\\r/', '', $clean['th_name']);
		}

    // 本文の入力チェック
    if( empty($_POST['th_outline']) ) {
      $error_message[] = '概要を入力してください。';
		} else {
			$clean['th_outline'] = htmlspecialchars( $_POST['th_outline'], ENT_QUOTES);
			$clean['th_outline'] = preg_replace( '/\\r\\n|\\n|\\r/', '<br>', $clean['th_outline']);
		}
    	// データベースに接続（読み込み）
    $mysqli = new mysqli('localhost', 'root', 'root', 'board');

    // 接続エラーの確認
    if( $mysqli->connect_errno ) {
      $error_message[] = 'データの読み込みが失敗しました。 エラー番号 '.$mysqli->connect_errno.' : '.$mysqli->connect_error;
    } else {
      // データを取得する処理
      $sql = "SELECT th_id, th_name, th_outline, th_date FROM threads ORDER BY th_date DESC";
      $res = $mysqli->query($sql);
      
      if( $res ) {
        $message_array = $res->fetch_all(MYSQLI_ASSOC);
      }
      
      $mysqli->close();
    }
  }