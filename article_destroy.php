<?php
  session_start();
  require_once('dbconnect.php');
  $postId = $_GET['id'];
  $userId = $_SESSION['id'];
  $userName = $_SESSION['name'];
  if(isset($userId)){
    echo 'ログインユーザーです';
  }else{
    echo 'ゲストユーザーです';
  }

  $delete = $db->prepare('DELETE FROM articles WHERE id=?');
  $delete->execute(array($postId));
  $delete_message = '投稿を削除しました';
  $_SESSION['delete_message'] = $delete_message ;
  header('Location: search.php');
  exit();


?>