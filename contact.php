<?php
session_start();
include('header.php');
$error = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') { //POST送信した時
  //POST送信の内容にフィルターでチェックする
  $post = filter_input_array(INPUT_POST, $_POST);

  // フォームの送信時にエラーをチェック(空白ならerror配列に格納)
  if ($post['name'] === '') {
    $error['name'] = 'blank';
  }
  if ($post['email'] === '') {
    $error['email'] = 'blank';
  } else if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
    //メールの書式になっているか確認
    $error['email'] = 'emailFormCheck';
  }
  if ($post['contact'] === '') {
    $error['contact'] = 'blank';
  }

  //項目が正しく入力されていたら確認画面へ遷移する
  if (count($error) === 0) {
    //Sessionグローバル変数にデータを保存
    $_SESSION['form'] = $post;

    header('Location:confirm.php');
    exit();
  }
} else {
  // 戻るボタンのようにGETでアクセスした時の処理
  if (isset($_SESSION['form'])) {
    $post = $_SESSION['form'];
  }
}

?>

<!-- 確認できるように同じ画面に戻ってくる -->
<div class="container">
  <div class="contactWrap">
    <h2 class="lead">お問い合わせ内容編集</h2>
    <form action="" method="POST">

      <div class="form-group row">
        <label for="name" class="col-sm-2 col-form-label">お名前</label>

        <div class="col-sm-10">
          <input type="text" name="name" class="form-control" id="name" value="<?php echo htmlspecialchars($post['name']); ?>">
          <?php if ($error['name'] === 'blank') : ?>
            <p class="error_msg">※お名前をご記入ください</p>
          <?php endif; ?>
        </div>
      </div>


      <div class="form-group row">
        <label for="email" class="col-sm-2 col-form-label">メールアドレス</label>

        <div class="col-sm-10">
          <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($post['email']); ?>">
          <?php if ($error['email'] === 'blank') : ?>
            <p class="error_msg">※メールアドレスをご記入ください</p>
          <?php endif; ?>
          <?php if ($error['email'] === 'emailFormCheck') : ?>
            <p class="error_msg">※メールアドレスを正しくご記入ください</p>
          <?php endif; ?>
        </div>
      </div>


      <div class="form-group row">
        <label for="contact" class="col-sm-2 col-form-label">お問い合わせ</label>
        <div class="col-sm-10">
          <textarea name="contact" class="form-control" id="contact" name="contact" cols="30" rows="10" placeholder="内容をご記入ください"><?php echo htmlspecialchars($post['contact']); ?></textarea>
          <?php if ($error['contact'] === 'blank') : ?>
            <p class="error_msg">※お問い合わせ内容をご記入ください</p>
          <?php endif; ?>
        </div>
      </div>

      <input type="submit" value="確認画面へ" class="btn btn-primary">
    </form>
  </div>
</div><!-- end of container -->

<?php include('footer.php'); ?>