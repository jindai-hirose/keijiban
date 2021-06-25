
<?php
//ini_set('display_errors', "On");

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
  $th_id = $_GET["th_id"];

  // データベースに接続（読み込み）
	$mysqli = new mysqli('localhost', 'root', 'root', 'board');

	// 接続エラーの確認
	if( $mysqli->connect_errno ) {
		$error_message[] = 'データの読み込みが失敗しました。 エラー番号 '.$mysqli->connect_errno.' : '.$mysqli->connect_error;
	} else {
		// データを取得する処理
		$sql = "SELECT th_id,th_name,th_outline,th_date FROM threads WHERE th_id = $th_id";
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
  <link rel="stylesheet" href="http://localhost/keijiban/css/home.css">
  <title>掲示板-ホーム</title>
</head>
<body>
  <h1>掲示板 管理者ページ（投稿の削除）</h1>
  <nav>
    <ul>
      <li><a href="http://localhost/keijiban/home.html" id="ホーム">ホーム</a></li>
      <li><a href="http://localhost/keijiban/table.php" id="一覧">一覧・検索</a></li>
      <li><a href="http://localhost/keijiban/creating.php" id="作成">掲示板作成</a></li>
      <li><a href="http://localhost/keijiban/user_login.html" id="ログインページ">ログイン</a></li>
    </ul>
  </nav>
  <p class="text-confirm">以下の投稿を削除します。<br>よろしければ「削除」ボタンを押してください。</p>
  <?php if( !empty($message_array) ): ?>
    <?php foreach( $message_array as $value ): ?>
      <hr>
      <article>
        <div class="info">
          <h3>題名：<?php echo $value['th_name']; ?></h3>
          <p>作成日：<time><?php echo date('Y年m月d日 H:i', strtotime($value['th_date'])); ?></time></p>
          <p>概要：<?php echo $value['th_outline']; ?></p>
        </div>
      </article>
      <hr>
      <?php $url ="http://localhost/keijiban/delete.php?id=".$id."&th_id=".$th_id; ?>

      <form method="POST" name="th_delete" action="<?php print_r($url) ?>">
        <input type="button" name="delete_cancel" onclick="window.history.back();" value="キャンセル">
        <input type="submit" name="submit_delete1" value="削除" onclick="deleteMessage(<?php print_r($th_id);?>,'<?php print_r($url);?>')">　
      </form>
    <?php endforeach ?>

    <script language="javascript" type="text/javascript">

      function deleteMessage(threadId,url) {
        console.log(threadId,url)
        if(!window.confirm('本当に削除してよろしいですか？')) {
          return;
        }
        
        let fd = new FormData();

        fd.append("submit_delete1",messageId);

        fetch(url, {
          method : "post",
          body: fd
        })
        .then((res) => {
          if(res.status !== 200) {
            throw new Error("system error.");
          }
          return res.text();
          })
          .then((text) => {
            console.log(text);
          })
          .catch((e) => {
            console.log(e.message);
          })
          .finally(() => {
            location.reload();
          });
        }
    </script>

  <?php endif ?>
</body>
</html>