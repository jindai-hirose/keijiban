<!-- http://localhost:8000/creating.php -->

<!--
  スレッド作成、スレッド一覧へのリンク
-->

<?php
ini_set('display_errors', "On");
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
	<link rel="stylesheet" href="./css/home.css">
  <title>掲示板-掲示板作成</title>
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
    <a href="./creating.php"><h2>掲示板作成</h2></a>
    
    <!-- エラーメッセージ表示 -->
    <?php if( !empty($error_message) ): ?>
      <ul class="error_message">
        <?php foreach( $error_message as $value ): ?>
          <li><?php echo $value; ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <?php if( !empty($error_message) ): ?>
      <ul class="error_message">
        <?php foreach( $error_message as $value ): ?>
          <li>・<?php echo $value; ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <form action="./writing.php" method="post" name="submission1">
        <div>
            <label for="th_name">題名</label>
            <input type="text" id="th_name" name="th_name" value="スレッドテスト">
        </div>
        <div>
            <label for="th_outline">概要</label>
            <input type="text" id="th_outline" name="th_outline" value="概要テスト">
        </div>
      <input type="submit" name="create_submit" value="作成" onclick="return checkForm1();">
    </form>

    <script>
      function checkForm1(){
        if(document.submission1.th_name.value == "" || document.submission1.th_outline.value == ""){
          alert("題名と概要を入力して下さい。");
          return false;
        }else{
          return true;
        }
      }
    </script>
    <a href="./table.php"><h2>掲示板一覧・検索</h2></a>
    <?php if( !empty($message_array) ): ?>
      <?php foreach( $message_array as $value ): ?>
      <hr>
          <?php $url = "./threadtable.php?th_id=".$value["th_id"]; ?>
          <?php print_r($url);?>
        <a href="<?php print_r($url);?>" id="スレッド">
          <article>
            <div class="info">
              <h3>題名：<?php echo $value['th_name']; ?></h3>
              <time>作成日：<?php echo date('Y年m月d日 H:i', strtotime($value['th_date'])); ?></time>
            </div>
            <p>概要：<?php echo $value['th_outline']; ?></p>
          </article>
        </a>
      <?php endforeach; ?>
    <?php endif; ?>
  </main>
</body>

</html>