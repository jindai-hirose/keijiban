<!--
	管理者用、スレッド内容、スレッド一覧へのリンク、スレッド投稿へのリンク, 削除
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
	$message_array2 = array();
  $success_message = null;
  $error_message = array();
	$clean = array();
	$th_id = $_GET["th_id"];
  
	// データベースに接続（読み込み）
	$mysqli = new mysqli('localhost', 'root', 'root', 'board');

	// 接続エラーの確認
	if( $mysqli->connect_errno ) {
		$error_message[] = 'データの読み込みが失敗しました。 エラー番号 '.$mysqli->connect_errno.' : '.$mysqli->connect_error;
	} else {
		// データを取得する処理
		$sql = "SELECT view_name, message, post_date FROM messages WHERE th_id = $th_id ORDER BY post_date DESC";
		$res = $mysqli->query($sql);
		
		if( $res ) {
			$message_array = $res->fetch_all(MYSQLI_ASSOC);
		}
		
		$mysqli->close();
	}


	// データベースに接続（読み込み）
	$sqlmy = new mysqli('localhost', 'root', 'root', 'board');

	// 接続エラーの確認
	if( $sqlmy->connect_errno ) {
		$error_message[] = 'データの読み込みが失敗しました。 エラー番号 '.$sqlmy->connect_errno.' : '.$sqlmy->connect_error;
	} else {
		// データを取得する処理
		$name = "SELECT th_name, th_outline FROM threads WHERE th_id = $th_id";
		$res_name = $sqlmy->query($name);
		
    if( $name ) {
      $message_array2 = $res_name->fetch_all(MYSQLI_ASSOC);
    }
		$sqlmy->close();
	}


?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
	<link rel="stylesheet" href="http://localhost/keijiban/css/home.css">
  <title>掲示板-掲示板内</title>
</head>

<body>
  <head>
    <h1>掲示板</h1>
    <nav>
      <ul>
				<li><a href="http://localhost/keijiban/home.html" id="ホーム">ホーム</a></li>
        <li><a href="http://localhost/keijiban/table.php" id="一覧">一覧・検索</a></li>
        <li><a href="http://localhost/keijiban/creating.php" id="作成">掲示板作成</a></li>
        <li><a href="http://localhost/keijiban/admin_logout.php" id="管理者ページ">管理者ログアウト</a></li>
      </ul>
    </nav>
  </head>

  <main>


    <!-- $success_messageに値が入っているか確認 -->
    <?php if( empty($_POST['create_submit']) && !empty($_SESSION['success_message']) ): ?>
			<p class="success_message">
				<?php echo $_SESSION['success_message']; ?>
			</p>
		<?php unset($_SESSION['success_message']); ?>
		<?php endif; ?>
    
    <!-- エラーメッセージ表示 -->
    <?php if( !empty($error_message) ): ?>
      <ul class="error_message">
        <?php foreach( $error_message as $value ): ?>
          <li><?php echo $value; ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    
		<section>
      <?php if( !empty($message_array2) ): ?>
        <?php foreach( $message_array2 as $value2 ): ?>
          <h3>『<?php print_r($value2['th_name']); ?>』</h3>
          <h4>"<?php print_r($value2['th_outline']); ?>"</h4>
        <?php endforeach; ?>
      <?php endif; ?>
		</section>

    <?php $url = "http://localhost/keijiban/th_delete.php?th_id=".$th_id; ?>
    <a href="<?php print_r($url);?>">スレッド削除</a></p>
    <?php $url2 = "http://localhost/keijiban/message_delete.php?th_id=".$th_id; ?>
    <a href="<?php print_r($url2);?>">投稿削除</a></p>
		
    <?php if( !empty($message_array) ): ?>
		<?php foreach( $message_array as $value ): ?>
			<hr>
			<article>
				<div class="info">
					<h3>投稿者：<?= $value['view_name']; ?></h3>
					<time>投稿日：<?= date('Y年m月d日 H:i', strtotime($value['post_date'])); ?></time>
					<p>本文：<?= $value['message']; ?></p>
				</div>
			</article>
			<!-- <?php var_dump($value) ?> -->
		<?php endforeach; ?>
		<?php endif; ?>
  </main>
</body>

</html>