<!-- http://localhost:8000/table.php -->

<!--
  スレッド一覧
-->

<?php
//ini_set('display_errors', "On");

	// データベースの接続情報
//	define( 'DB_HOST', 'localhost');
//	define( 'DB_USER', 'root');
//	define( 'DB_PASS', 'root');
//	define( 'DB_NAME', 'board');

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

  // データベースに接続（読み込み）
//include("dbConnection.php");

	$mysqli = new mysqli('127.0.0.1', 'root', 'root', 'board');

	// 接続エラーの確認
	if( $mysqli->connect_errno ) {
		$error_message[] = 'データの読み込みが失敗しました。 エラー番号 '.$mysqli->connect_errno.' : '.$mysqli->connect_error;
	} else {
		// データを取得する処理
		$sql = "SELECT th_id,th_name,th_outline,th_date FROM threads ORDER BY th_date DESC";
		$res = $mysqli->query($sql);

		if( $res ) {
			$message_array = $res->fetch_all(MYSQLI_ASSOC);
		}

		$mysqli->close();
	}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="./css/home.css">
  <title>掲示板-一覧・検索</title>
</head>

<body>
  <head>
    <h1>掲示板</h1>
    <nav>
      <ul>
        <li><a href="./home.html" id="ホーム">ホーム</a></li>
        <li><a href="./table.php" id="一覧">一覧・検索</a></li>
        <li><a href="./creating.php" id="作成">掲示板作成</a></li>
        <li><a href="./user_login.html" id="ログインページ">ログイン</a></li>
      </ul>
    </nav>
  </head>

  <main>
    <a href="./table.php"><h2>掲示板一覧・検索</h2></a>

    <form method="get" name="search_form" action="./search.php">
      <h3>関連検索</h3>
      <input type="text" name="search" value=""><br>
      <input type="submit" value="検索" onclick="return checkForm3();">
    </form>

    <script>
      function checkForm3(){
        if(document.search_form.search.value == ""){
          alert("検索ワードを入力して下さい。");
          return false;
        }else{
          window.location.href("./search.php")
          return true;
        }
      }
    </script>
		
    <section>
      <?php if( !empty($message_array) ): ?>
      <?php foreach( $message_array as $value ): ?>
      <hr>
      <!-- <?php print_r($value); ?> -->
				<?php $url = "./threadtable.php?th_id=".$value["th_id"]; ?>
			<!-- <?php print_r($url);?> -->
      <a href="<?php print_r($url);?>" id="読み込み">
        <article>
          <div class="info">
            <h3>題名：<?php echo $value['th_name']; ?></h3>
            <h4>概要：<?php echo $value['th_outline']; ?></h4>
            <time>作成日：<?php echo date('Y年m月d日 H:i', strtotime($value['th_date'])); ?></time>
          </div>
        </article>
      </a>
      <?php endforeach; ?>
      <?php endif; ?>
    </section>
  </main>
</body>

</html>