<!--
  検索欄の処理
-->

<?php
ini_set('display_errors', "On");

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

//var_dump($_POST['search']);
  if ($_SERVER['REQUEST_METHOD']==='POST') {
	  $search = $_POST['search'];
  }
  
//var_dump($search);
  // データベースに接続（書き込み）
  $dsn = 'mysql:dbname=board;host=localhost;port=3306;charset=utf8';
  $user = 'root';
  $password = 'root';
  $data = [];

  try {
      $dbh = new PDO($dsn, $user, $password);
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = "SELECT th_id,th_name,th_outline,th_date FROM threads WHERE th_name LIKE :search OR th_outline LIKE :search ORDER BY th_date DESC";
      $stmt = $dbh->prepare($sql);
      $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
      $stmt->execute();
    
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $data[] = $row;
      }

  } catch (PDOException $e) {
      echo($e->getMessage());
      die();
  }
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
      <a href="http://localhost/keijiban/table.php"><h2>掲示板一覧・検索へ戻る</h2></a>
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
                <h3>題名：<?php echo $row['th_name']; ?></h3>
                <time>作成日：<?php echo date('Y年m月d日 H:i', strtotime($row['th_date'])); ?></time>
                <p>概要：<?php echo $row['th_outline']; ?></p>
            </article>
          </a>
        <?php endforeach; ?>
      <?php endif; ?>
    </section>
  </main>
</body>

</html>