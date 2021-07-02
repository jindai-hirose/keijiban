<!--
  検索結果表示ページ(放置中)
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
    <a href="../keijiban/table.php"><h2>掲示板一覧・検索</h2></a>
		
    <section>
      <?php if( !empty($message_array) ): ?>
      <?php foreach( $res as $value ): ?>
      <hr>
      <!-- <?php print_r($value); ?> -->

      <?php $url = "http://localhost/keijiban/threadtable.php?th_id=".$value["th_id"]; ?>
      <!-- <?php print_r($url);?> -->

      <a href="<?php print_r($url);?>" id="読み込み">
        <article>
          <div class="info">
            <h3>題名：<?php echo $value['th_name']; ?></h3>
            <time>作成日：<?php echo date('Y年m月d日 H:i', strtotime($value['th_date'])); ?></time>
            <p>概要：<?php echo $value['th_outline']; ?></p>
          </div>
        </article>
      </a>
      <?php endforeach; ?>
      <?php endif; ?>
    </section>
  </main>
</body>

</html>