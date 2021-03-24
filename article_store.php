<?php
//投稿を保存して、search.phpに返す
session_start();
require_once('dbconnect.php');

//article.phpからセッションでデータを取得
$blogpost = $_SESSION['blog'];
// var_dump($blogpost);
$success_message = '';

//投稿内容を保存
$db->beginTransaction();
try{
 $post = $db->prepare('INSERT INTO articles(title,content,name,image,created) VALUES (:title, :content,:name, :image, NOW())');
 $post->bindValue(':title', $blogpost['title'], PDO::PARAM_STR);
 $post->bindValue(':content', $blogpost['content'], PDO::PARAM_STR);
 $post->bindValue(':name', $blogpost['author'], PDO::PARAM_STR);
 $post->bindValue(':image', $blogpost['image'], PDO::PARAM_STR);
 $post->execute();
 
 $success_message = '登録が完了しました';
 $_SESSION['success_message'] = $success_message ;
 $db->commit();
}catch(PDOException $e){
  $db->rollBack();
  echo '接続失敗です' . $e->getMessage();
}

header('Location: search.php');
exit()

?>