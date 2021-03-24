<?php
session_start();
include('header.php');
//入力画面からのアクセスでなければ強制的に入力画面に戻す
if (!isset($_SESSION['form'])) {
  header('Location:index.php');
} else {
  $post = $_SESSION['form']; //Session内容を$postに格納し、使えるようにする
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  //メール送信
  $to = '';
  $from = $post['email'];
  $subject = 'お問い合わせがきました';
  // お問い合わせ内容
  $body = <<<EOT
  名前: {$post['name']}
  メールアドレス: {$post['email']}
  お問い合わせ内容: {$post['contact']}
  EOT;
  // var_dump($body);
  // exit();
  //送信方法記述
  // mb_send_mail($to, $subject, $body, "From: {$from}");
  unset($_SESSION['form']); //Session内容の破棄
  header('Location:thanks.php'); //thanksページへ遷移
  exit();
}
?>
<div class="container">
  <div class="contactConfirmWrap">
    <h2 class="lead">お問い合わせ内容確認</h2>
    <form action="" method="POST">


      <div class="form-group row">
        <label for="name" class="col-sm-3 col-md-2 col-form-label">お名前:</label>
        <div class="col-sm-9 col-md-10">
          <span class="form-control"><?php echo htmlspecialchars($post['name'], ENT_QUOTES); ?></span>
        </div>
      </div>


      <div class="form-group row">
        <label for="email" class="col-sm-3 col-md-2 col-form-label">メールアドレス:</label>
        <div class="col-sm-9  col-md-10">
          <span class="form-control"><?php echo htmlspecialchars($post['email'], ENT_QUOTES); ?></span>
        </div>
      </div>

      <div class="form-group row">
        <label for="contact" class="col-sm-3  col-md-2 col-form-label">お問い合わせ内容:</label>
        <div class="col-sm-9  col-md-10">
          <textarea class="form-control" 　name="contact" id="contact" name="contact" cols="30" rows="10" placeholder="内容をご記入ください"><?php echo htmlspecialchars($post['contact']); ?></textarea>
        </div>
      </div>


      <a class="btn btn-secondary" href="contact.php">編集する</a>
      <input type="submit" value="送信" class="btn btn-primary">
    </form>
  </div>
</div><!-- end of container -->


<?php include('footer.php');?>