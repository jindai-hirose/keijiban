<!-- http://localhost/keijiban/mypage.php -->
<?php

	// データベースの接続情報
  define( 'PASSWORD', 'adminass');

  define( 'DB_HOST', 'localhost');
  define( 'DB_USER', 'root');
  define( 'DB_PASS', 'password');
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

  if( !empty($_GET['btn_logout']) ) {
    unset($_SESSION['admin_login']);
  }

	// データベースに接続（読み込み）
	$mysqli = new mysqli('DB_HOST', 'DB_USER', 'DB_PASS', 'DB_NAME');

	

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="http://localhost/keijiban/css/home.css">
  <title>掲示板-管理者ログイン</title>
</head>

<body>
  <head>
    <h1>掲示板</h1>
    <nav>
      <ul>
        <li><a href="http://localhost/keijiban/home.html" id="ホーム">ホーム</a></li>
        <li><a href="http://localhost/keijiban/table.php" id="一覧">一覧・検索</a></li>
        <li><a href="http://localhost/keijiban/creating.php" id="作成">掲示板作成</a></li>
        <li><a href="http://localhost/keijiban/admin_login.php" id="管理者ページ">管理者ログイン</a></li>
      </ul>
    </nav>
  </head>
  <main>
    <h3>管理者ページログアウト</h3>
    <!-- エラーメッセージ表示 -->
    <?php if( !empty($error_message) ): ?>
      <ul class="error_message">
        <?php foreach( $error_message as $value ): ?>
          <li>・<?php echo $value; ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <section>

      <?php if( !empty($_SESSION['admin_login']) && $_SESSION['admin_login'] === true ): ?>
        <p>ページエラー</p>
      <?php else: ?>
        <form method="get" action="http://localhost/keijiban/admin_login.php">
          <input type="submit" name="btn_logout" value="ログアウト">
        </form>
      <?php endif; ?>

    </section>
  </main>
</body>
</html>