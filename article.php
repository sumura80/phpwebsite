<?php
session_start();
include('header.php');
$error = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') { //POST送信した時
  $blogpost = filter_input_array(INPUT_POST, $_POST);
  //入力項目に空がないか
  if ($blogpost['title'] === '') {
    $error['title'] = 'blank';
  }
  if ($blogpost['author'] === '') {
    $error['author'] = 'blank';
  }

  if ($blogpost['content'] === '') {
    $error['content'] = 'blank';
  }

  //全ての項目が入力されてフォームが送信された時
  if (count($error) === 0) {
    //SESSEIONにデータを代入
    $_SESSION['blog'] = $blogpost;
    header('Location: article_store.php');
    exit();
  }
}
?>

<div class="container">
  <div class="articleWrap">

    <h2 class="lead">ブログ記事作成</h2>
    <form action="" method="POST">

      <div class="form-group row">
        <label for="title" class="col-sm-2 col-form-label">タイトル</label>
        <div class="col-sm-10">
          <input class="form-control" type="text" name="title" id="title">
          <?php if ($error['title'] === 'blank') echo '<div class="error_msg">※タイトルを入力してください</div>'; ?>
        </div>
      </div>


      <div class="form-group row">
        <label for="author" class="col-sm-2 col-form-label">お名前</label>
        <div class="col-sm-10">
          <input class="form-control" type="text" name="author" id="author">
          <?php if ($error['author'] === 'blank') echo '<div class="error_msg">※お名前をご記入ください</div>'; ?>
        </div>
      </div>

      <div class="form-group row">
        <label for="content" class="col-sm-2 col-form-label">内容</label>
        <div class="col-sm-10">
          <textarea class="form-control" name="content" id="content" cols="30" rows="10"></textarea>
          <?php if ($error['content'] === 'blank') echo '<div class="error_msg">※ブログ内容を入力してください</div>'; ?><br>
        </div>
      </div>


      <input class="btn btn-primary mx-auto d-block" type="submit" value="記事作成">
    </form>
  </div>
</div><!-- end of container -->

<?php include('footer.php'); ?>