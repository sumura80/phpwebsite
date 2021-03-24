<?php
session_start();
require_once('dbconnect.php');
$id = $_GET['id'];

//該当IDのデータを取得
$stmt = $db->prepare('SELECT * FROM articles WHERE id=:id');
$stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
$stmt->execute();

$post = $stmt->fetch(PDO::FETCH_ASSOC); //配列と添字を取得できる

//ログインユーザーのみ、編集と削除ができる
$userId = $_SESSION['id'];
$userName = $_SESSION['name'];

include('header.php');
?>

<div class="container">
  <div class="bodyWrap">
    <div class="adminButtons float-right">
    <a href="search.php" class="btn btn-primary">一覧に戻る</a>
      <?php if (isset($userId)) : ?>
        <a class="btn btn-warning" href="article_update.php?id=<?php echo $post['id']; ?>">編集</a>
        <a class="btn btn-danger" href="article_destroy.php?id=<?php echo $post['id']; ?>">削除</a>
      <?php endif; ?>
    </div>
    <h3><?php echo $post['title']; ?></h3>
    <p class="postedTime">投稿日時:<?php echo $post['created']; ?></p>
    <div><?php print(nl2br(htmlspecialchars($post['name'], ENT_QUOTES))); ?>さんが投稿しました</div>
    <div class="card mt-2">
      <div class="card-body">
        <?php print(nl2br(htmlspecialchars($post['content'], ENT_QUOTES))); ?>
      </div>
    </div>
  </div>
</div>



<?php include('footer.php'); ?>