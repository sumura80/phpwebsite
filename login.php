<?php
session_start();
include('header.php');
require_once('dbconnect.php');
$error = [];

//ログインフォーム送信時に入力欄が空欄だったら
if (!empty($_POST)) {

  if ($_POST['email'] === '') {
    $error['email'] = 'blank';
  }
  if ($_POST['password'] === '') {
    $error['password'] = 'blank';
  }
 
  //両方入力されていたらDBからどのユーザーか特定
  if ($_POST['email'] !== '' && $_POST['password'] !== '') {
    $login = $db->prepare('SELECT * FROM members WHERE email=? AND password=?');
    $login->execute(array(
      $_POST['email'],
      sha1($_POST['password'])
    ));
    $member = $login->fetch();

    //Userだったらindex.phpに移動 Trueが返ってくる
    if ($member) {
      $_SESSION['id'] = $member['id']; //どのユーザーか
      $_SESSION['name'] = $member['name'];
      header("Location:index.php");
      exit();
    } else {
      //loginできなかったらエラーをだす False
      $error['login'] = 'failed';
    }
  }
}
?>
<div class="row" style="margin: 0 15px;">
  <div class="col-md-6 offset-md-3">
    <section class="inputForm">

      <h3 class="text-center">ログインフォーム</h3>
      <p>次のフォームに必要事項をご記入ください。</p>
      <form action="" method="POST">
        <div class="form-group">
          <label for="email">メールアドレス </label>
          <input class="form-control" type="email" name="email" 　id="email" value="<?php print(htmlspecialchars($_POST['email'], ENT_QUOTES)); ?>">
          <?php if ($error['email'] === 'blank') : ?>
            <div class="error_msg">*メールアドレスを入力してください</div>
          <?php endif; ?>
        </div>
<div class="form-group">
        <label for="password">パスワード</label>
        <input class="form-control" type="password" id="password" name="password" value="<?php print(htmlspecialchars($_POST['password'])); ?>">
        <?php if ($error['password'] === 'blank') : ?>
          <div class="error_msg">*パスワードを入力してください</div>
        <?php endif; ?>
        <!-- ログインに失敗したら -->
        <?php if ($error['login'] === 'failed') : ?>
          <p class="error_msg">ログインに失敗しました。正しくご記入ください。</p>
        <?php endif; ?>
        </div>
        

        <input class="btn btn-primary" type="submit" value="ログインする">
      </form>
      <br>
      <a class="btn btn-secondary" href="index.php">TOPへ戻る</a>
      <a class="btn btn-success" href="register.php">新規登録</a>
    </section>
  </div>
</div>

<?php include('footer.php');