<?php

function dd(...$value){
  var_dump(...$value); exit;
}

  $db_host = "localhost";
  $db_user = "root";
  $db_pass = "root";
  $db_mame = "board";

  $timezone = date_default_timezone_set('Asia/Tokyo');

  //$now_date = null;
  $data = null;
  $file_handle = null;
  $split_data = null;
  //$message = array();
  $message_array = array();
  $success_message = null;
  $error_message = array();
  $clean = array();
//  $th_id = $_GET["th_id"];
//  $id = $_GET["id"];

  //データベースへの接続

  function Exec($db_host, $db_user, $db_pass, $db_mame){
      try{
          $pdo = new PDO($db_host, $db_user, $db_pass, $db_mame);
          return($pdo);
      }catch (PDOException $e){
          print($e->getMessage());
          die();
      }
  }
  Exec($db_host,$db_user,$db_pass,$db_mame);
  dd($db_host);

  function dbClose(){
      $pdo = null;
  }