<?php
session_start();
include('header.php');
require_once('dbconnect.php');
$error = [];
//messageを投稿
if (!empty($_POST)) { //フォームが送信された時
  $postBoard = filter_input_array(INPUT_POST, $_POST);
  if ($postBoard['message'] !== '') { //コメントが空でなかったら

    //DBにデータを保存
    $postData = $db->prepare('INSERT INTO board SET postmessage=?,created_at=NOW()');
    $postData->execute(array(
      $postBoard['message']
    ));
    $message = $postData->fetch();
    header('Location: post-board.php');
    exit();
    //コメントが空白だったら
  } else { 
    $error['post-board'] = 'blank';
  }
}

//投稿内容の抽出
$posts = $db->query('SELECT * FROM board ORDER BY id DESC');
?>
<div class="row" style="margin: 0 15px;">
  <div class="col-md-8 offset-md-2">
  <div class="postBoardFeature">\ <span class="colorCompanyPink">Englishラボ</span>へのご意見をお待ちしております。 /
</div>
    <div class="post-board-wrap">
    
      <h2 class="lead">お好きなコメントをご記入ください</h2>
      <form action="" method="POST">
        <textarea name="message" id="message" cols="50" rows="4" placeholder="こちらにコメントをどうぞ"></textarea>
        <?php if ($error['post-board'] === 'blank') : ?>
          <div class="alert alert-danger">＊コメントをご記入ください</div>
        <?php endif; ?>
        <br>
        <input class="btn btn-primary" type="submit" value="投稿する">
      </form>

      <section class="postsBoard mt-4">
        <?php foreach ($posts as $post) : ?>


          <div class="card mt-4 shadow-sm">
            <div class="card-body">
              <p class="card-text">
              <?php print(nl2br(htmlspecialchars($post['postmessage'], ENT_QUOTES))); ?>
              </p>
            </div>
            <div class="card-footer text-muted">
            <?php print(nl2br(htmlspecialchars($post['created_at'], ENT_QUOTES))); ?> に投稿されました
            </div>
          </div>
        <?php endforeach; ?>
      </section>
    </div>
  </div>
</div>




<?php include('footer.php'); ?>