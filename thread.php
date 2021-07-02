<!-- http://localhost/keijiban/writing.php -->

<!--
	スレッドへの投稿書き込み
-->

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
	<link rel="stylesheet" href="http://localhost/keijiban/css/home.css">
  <title>掲示板-掲示板投稿</title>
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
    <h2>掲示板投稿</h2>

    <!-- $success_messageに値が入っているか確認 -->
    <?php if( empty($_POST['btn_submit']) && !empty($_SESSION['success_message']) ): ?>
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

		<?php $url = "http://localhost/keijiban/th_writing.php?th_id=".$_GET["th_id"]; ?>
		<!-- <?php print_r($url);?> -->

		<form action = "<?php print_r($url);?>" method = "POST" name="submission2">
			<div>
				<label for="view_name">投稿者名</label>
				<input type="text" id="view_name" name="view_name" value="テスト名">
			</div>
			<div>
				<label for="message">本文</label>
				<input type="text" name="message" value="テスト">
			</div>
			<input type="submit" name="btn_submit" value="投稿" onclick="return checkForm2()"> 
		</form>

		<script>
      function checkForm2(){
        if(document.submission2.view_name.value == "" || document.submission2.message.value == ""){
          alert("投稿者名と本文を入力して下さい。");
          return false;
        }else{
          return true;
        }
      }
    </script>
    
  </main>
  
</body>

</html>