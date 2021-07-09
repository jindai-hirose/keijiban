<!--
  検索欄の処理
-->

<?php
ini_set('display_errors', "On");

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
  $thid = null;
  
  if ($_SERVER['REQUEST_METHOD']==='POST'){
    $search = $_REQUEST['search'];
  }

  // データベースに接続（書き込み）
  $dsn = 'mysql:dbname=board;host=localhost:3306;charset=utf8';
  $user = 'root';
  $password = 'root';
  $data = [];
  
  try {
    $dbh = new PDO($dsn,$user,$password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT th_id,th_name,th_outline,th_date FROM threads WHERE th_name LIKE :search OR th_outline LIKE :search ORDER BY th_date DESC";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':search','%'.$search.'%',PDO::PARAM_STR);
    $stmt->execute();
    
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $data[] = $row;
    }
    
  }catch (PDOException $e){
      echo ($e->getMessage());
      die();
  }
  
//  $mysqli = new mysqli('localhost', 'root', 'root', 'board');
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
//    // データを登録するSQL作成
//    $search = $_REQUEST['search'];
//
//    $sql = "ELECT th_id,th_name,th_outline,th_date FROM threads WHERE th_name LIKE '%$search%' OR th_outline LIKE '%$search%' ORDER BY th_date DESC" ;
//
//    // データを登録
//    $res = $mysqli->query($sql);
//
//    if( $res ) {
//			$message_array = $res->fetch_all(MYSQLI_ASSOC);
//		}
//
//    // データベースの接続を閉じる
//    $mysqli->close();
//
//  }

?>  

<!--
  検索結果表示ページ
-->

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="http://localhost/keijiban/css/home.css">
  <title>掲示板-一覧</title>
</head>

<body>
  <head>
    <h1>掲示板</h1>
    <nav>
      <ul>
        <li><a href="http://localhost/keijiban/home.html" id="ホーム">ホーム</a></li>
        <li><a href="http://localhost/keijiban/table.php" id="一覧">一覧・検索</a></li>
        <li><a href="http://localhost/keijiban/creating.php" id="作成">掲示板作成</a></li>
        <li><a href="http://localhost/keijiban/user_login.html" id="ログインページ">ログイン</a></li>
      </ul>
    </nav>
  </head>

  <main>
  <?php ini_set('display_errors', "On"); ?>
    <a href="http://localhost/keijiban/table.php"><h2>掲示板一覧・検索</h2></a>

    <form action="http://localhost/keijiban/search.php" method="get" name="search_form">
      <h3>関連検索</h3>
      <input type="text" name="search" value=""><br>
      <input type="submit" value="検索" onclick="return checkForm3()">
    </form>

    <script>
      function checkForm3(){
        if(document.search_form.search.value == ""){
          alert("検索ワードを入力して下さい。");
          return false;
        }else{
          window.location.href("http://localhost/keijiban/search.php")
          return true;
        }
      }
    </script>

		<section>
      <?php if( empty($data) ): ?>
        <p>スレッドがありません。</p>
      <?php endif; ?>
    </section>

    <section>
      <?php if( !empty($data) ): ?>
      <?php foreach( $data as $row ): ?>
      <hr>
      <!-- <?php print_r($row); ?> -->

      <?php $url = "http://localhost/keijiban/threadtable.php?th_id=".$row["th_id"]; ?>
      <!-- <?php print_r($url);?> -->

      <a href="<?php print_r($url);?>" id="読み込み">
        <article>
          <div class="info">
            <h3>題名：<?php echo $row['th_name']; ?></h3>
            <time>作成日：<?php echo date('Y年m月d日 H:i', strtotime($row['th_date'])); ?></time>
            <p>概要：<?php echo $row['th_outline']; ?></p>
          </div>
        </article>
      </a>
      <?php endforeach; ?>
      <?php endif; ?>
    </section>
  </main>
</body>

</html>