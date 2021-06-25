
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
  $maxId = $message_array3[0][ "MAX(id)" ];

  $mysqli2 = new mysqli('localhost', 'root', 'root', 'board');
	// 接続エラーの確認
	if( $mysqli2->connect_errno ) {
		$error_message[] = 'データの読み込みが失敗しました。 エラー番号 '.$mysqli2->connect_errno.' : '.$mysqli2->connect_error;
	} else {
		// データを取得する処理
		$idcheck = "SELECT MAX(id) FROM messages";
		$res2 = $mysqli2->query($idcheck);
		if( $res2 ) {
			$message_array3 = $res2->fetch_all(MYSQLI_ASSOC);
		}
	}
	$mysqli2->close();
  var_dump($message_array3[0][ "MAX(id)" ]);
  

  // データベースに接続（読み込み）
	$mysqli = new mysqli('localhost', 'root', 'root', 'board');

	// 接続エラーの確認
	if( $mysqli->connect_errno ) {
		$error_message[] = 'データの読み込みが失敗しました。 エラー番号 '.$mysqli->connect_errno.' : '.$mysqli->connect_error;
	} else {
		// データを取得する処理
		$sql = "SELECT * FROM messages WHERE th_id = $th_id";
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
  <head>
    <nav>
      <ul>
        <li><a href="http://localhost/keijiban/home.html" id="ホーム">ホーム</a></li>
        <li><a href="http://localhost/keijiban/table.php" id="一覧">一覧・検索</a></li>
        <li><a href="http://localhost/keijiban/creating.php" id="作成">掲示板作成</a></li>
        <li><a href="http://localhost/keijiban/admin_login.php" id="管理者ページ">管理者ログイン</a></li>
      </ul>
    </nav>
  </head>
  <p class="text-confirm">以下の投稿を削除します。<br>よろしければ「削除」ボタンを押してください。</p>
  <hr>
  <?php if( !empty($message_array) ): ?>
    <?php foreach( $message_array as $value ): ?>

    <article>
      <div class="info">
        <h3>投稿者：<?php echo $value['view_name']; ?></h3>
        <p>投稿日：<?php echo date('Y年m月d日 H:i', strtotime($value['post_date'])); ?></p>
        <p>本文：<?php echo $value['message']; ?></p>
      </div>
    </article>
    <?php $id = $value["id"]; ?>
    <?php print_r($id); ?>
    <?php $url ="http://localhost/keijiban/m_delete.php?id=".$id."&th_id=".$th_id; ?>

    <form　method="POST" id="<?php print_r($id);?>"　name="meassage_delete"　action="<?php print_r($url);?>">
      <!--<input type="button" name="delete_cancel" onclick="window.history.back();" value="キャンセル">-->
      <button class="button" name="submit_delete2" onclick="deleteMessage(<?php print_r($id);?>,'<?php print_r($url);?>')">削除</button>
    </form>
    <hr>

    <?php endforeach ?>

    <script language="javascript" type="text/javascript">

      function deleteMessage(messageId,url) {
        console.log(messageId,url)
          if(!window.confirm('本当に削除してよろしいですか？')) {
            return;
          }

          let fd = new FormData();

          fd.append("submit_delete2",messageId);

          fetch(url, {
            method : "post",
            body: fd
          }).then((res) => {
            if(res.status !== 200) {
              throw new Error("system error.");
            }
            return res.text();
            }).then((text) => {
              console.log(text);
            }).catch((e) => {
              console.log(e.message);
            }).finally(() => {
              location.reload();
            });
                
          }

      // function OnButtonClick2(){
      //   const message_delete = document.getElementsByName('message_delete');
      //   if(window.confirm('本当に削除してよろしいですか？')){
      //     document.message_delete.submit();
      //     return ture;
      //   }else{
      //     return false;
      //   }
      // };


      /*document.querySelector('.button').addEventListener('click',() => {
        const formElement = document.querySelector('form');
        formElement.addEventListener('submit',handleSubmit);

        function handleSubmit(event){
          const isYes = confirm('削除してよろしいですか？');
          if(isYes===false){
            event.preventDefault();
          }
        }


      });*/

      /*function OnButtonClick2(ele){
        var id = ele.id;
        var message_delete = ele.name;
        alert(id);
        if(id === ele.id){
          if(window.confirm('本当に削除してよろしいですか？')){
            document.message_delete.submit();
            return ture;
          }else{
            return false;
          }
        }else{
          alert("エラー");
        }
      };*/
    </script>

  <?php endif ?>
</body>
</html>