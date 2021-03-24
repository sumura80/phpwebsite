<?php
session_start();
$error = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') { //POST送信した時
  //$Post の内容をフィルターする
  $registerinput = filter_input_array(INPUT_POST, $_POST);

  //入力欄が空白になってないかの確認
  if ($registerinput['name'] === '') {
    $error['name'] = 'blank';
  }
  if ($registerinput['email'] === '') {
    $error['email'] = 'blank';
  } else if (!filter_var($registerinput['email'], FILTER_VALIDATE_EMAIL)) {
    //メールの書式になっていなかったら
    $error['email'] = 'emailFormCheck';
  }
  if ($registerinput['password'] === '') {
    $error['password'] = 'blank';
  }

  //全て入力されていたら確認画面へ遷移
  if (count($error) === 0) {
    //sesseionにデータを保存
    $_SESSION['registersession'] = $registerinput;
    header('Location:register_check.php');
    exit();
  }
} else {
  // 戻るボタンのようにGETでアクセスした時の処理
  if (isset($_SESSION['registersession'])) {
    $registerinput = $_SESSION['registersession'];
  }
}
?>
<?php include('header.php'); ?>




<div class="row" style="margin: 0 15px;">
  <div class="col-md-6 offset-md-3">
    <section class="inputForm">
      <h3 class="text-center">会員登録</h3>
      <p>次のフォームに必要事項をご記入ください。</p>
      <form action="" method="POST">
        <div class="form-group">
          <label for="name">お名前</label>
          <input class="form-control" type="text" name="name" id="name" value="<?php print(htmlspecialchars($registerinput['name'], ENT_QUOTES)); ?>">
          <?php if ($error['name'] === 'blank') : ?>
            <div class="error_msg">*お名前を入力してください</div>
          <?php endif; ?>
        </div>


        <div class="form-group">
          <label for="email">メールアドレス <span class="requiredColor">*必須</span> </label>
          <input class="form-control" type="email" name="email" 　id="email" value="<?php print(htmlspecialchars($registerinput['email'], ENT_QUOTES)); ?>">
          <?php if ($error['email'] === 'blank') : ?>
            <div class="error_msg">*メールアドレスを入力してください</div>
          <?php endif; ?>
        </div>

        <div class="form-group">
          <label for="password">パスワード</label>
          <input class="form-control" type="text" id="password" name="password">
          <?php if ($error['password'] === 'blank') : ?>
            <div class="error_msg">*パスワードを入力してください</div>
          <?php endif; ?>
        </div>


        <input class="btn btn-primary" type="submit" value="入力内容を確認する">
      </form>
      <br>
      <a class="btn btn-secondary" href="index.php">TOPへ戻る</a>
      <a class="btn btn-warning" href="login.php">ログイン</a></button>
    
  </div><!-- end of col -->
</div><!-- end of row -->


<?php include('footer.php'); ?>