<?php
require_once('./env.php');
//env.phpよりDB情報の定数を取得
$host = DB_HOST;
$dbname =DB_NAME;
$user = DB_USER;
$pass = DB_PASS;

  try{
    $db = new PDO("mysql:dbname=$dbname;host=$host;port=8889;charset=utf8",
  "$user","$pass",[
    PDO::ATTR_ERRMODE =>PDO::ERRMODE_EXCEPTION,//エラーを表示するための記述 
    PDO::ATTR_EMULATE_PREPARES => false 
    //prepare構文でSQLインジェクションを防ぐ(配列をkeyとvalueで返す)
  ]);  
  }catch(PDOException $e){
    print('接続エラーです: ' . $e->getMessage());
  }


  //DBに接続するfunction
  function connectDb(){
    try{
      $db = new PDO('mysql:dbname=$dbname;host=$host;port=8889;charset=utf8',
    '$user','$pass',[
      PDO::ATTR_ERRMODE =>PDO::ERRMODE_EXCEPTION, //prepare構文でSQLインジェクションを防ぐ
      PDO::ATTR_EMULATE_PREPARES => false //エラーを表示するための記述
    ]);
    }catch(PDOException $e){
      print('接続エラーです: ' . $e->getMessage());
    }
  }

?>