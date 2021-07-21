<!-- http://localhost:8000/table.php -->

<!--
  スレッド一覧
-->

<?php
ini_set('display_errors', "On");

  // タイムゾーン設定
  date_default_timezone_set('Asia/Tokyo');
	
//  if ($_SERVER['REQUEST_METHOD']==='POST') {
//	  $search = $_POST['search'];
//  }
//  var_dump($search);
  // データベースに接続（書き込み）
  $dsn = 'mysql:dbname=board;host=localhost;port=3306;charset=utf8';
  $user = 'root';
  $password = 'root';
  $data = [];
  
  try {
      $dbh = new PDO($dsn, $user, $password);
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = "SELECT th_id,th_name,th_outline,th_date FROM threads ORDER BY th_date DESC";
      $stmt = $dbh->prepare($sql);
      $stmt->execute();
      
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $data[] = $row;
      }
      
  } catch (PDOException $e) {
      echo($e->getMessage());
      die();
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

    <form method="post" name="search_form" action="./search.php">
      <h3>関連検索</h3>
      <input type="text" name="search" value=""><br>
      <input type="submit" value="検索" onclick="checkForm3();return false;">
    </form>

      <!-- return checkForm3(); -->
    <script>
      function checkForm3(){
        if(document.search_form.search.value == ""){
          alert("検索ワードを入力して下さい。");
          return true;
        }else{
          window.location("./search.php");
          return false;
        }
      }
    </script>
		
    <section>
      <?php if( !empty($data) ): ?>
      <?php foreach( $data as $value ): ?>
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