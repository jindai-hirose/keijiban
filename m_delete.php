
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
  $success_message = null;
  $error_message = array();
	$clean = array();
  $th_id = $_GET["th_id"];
  $id = $_GET["id"];


  $delete_sqli = new mysqli('localhost', 'root', 'root', 'board');
  var_dump($_POST);


  if(empty($_POST)) {
    echo "<a href='http://localhost/keijiban/admin_threadtable.php'>スレッド一覧</a>←こちらのページからどうぞ";
    //exit();
  }else{
    //var_dump($_POST);exit;
    if(isset($_POST['submit_delete2'])){
      $delete = $delete_sqli -> prepare("DELETE FROM messages WHERE id = $id");
      if($delete){
        $delete -> execute();
      } 
    }
  }
  $delete_sqli->close();

?>  