<?php
session_start();
require_once('dbconnect.php');
//SESSIONでデータを取得し、表示
//会員登録からのアクセスでなければ強制的に会員登録ページに戻す
if (!isset($_SESSION['registersession'])) {
  header('Location:register.php');
} else {
  //会員登録画面からの正しいアクセスであれば
  $registerinput = $_SESSION['registersession'];
}

// print_r($registerinput['password']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  //登録確定の処理->DBへの保存
  $statement = $db->prepare('INSERT INTO members SET name=?, email=?, password=?, created=NOW()');
  $statement->execute(array(
    $registerinput['name'],
    $registerinput['email'],
    sha1($registerinput['password'])
  ));
  unset($_SESSION['registersession']);
  header('Location:index.php');
  exit();
}
?>
<?php include('header.php'); ?>
<div class="container">
  <div class="register_check_Wrap">
    <h2 class="lead">会員登録確認</h2>
    <p>記入した内容を確認して、よろしければ「登録する」ボタンをクリックしてください</p>
    <form action="" method="POST">

    <div class="form-group row">
        <label for="name" class="col-sm-3 col-md-2 col-form-label">お名前:</label>
        <div class="col-sm-9 col-md-10">
          <span class="form-control">
          <?php print(htmlspecialchars($registerinput['name'], ENT_QUOTES)); ?>
          </span>
        </div>
      </div>

      <div class="form-group row">
        <label for="email" class="col-sm-3 col-md-2 col-form-label">メールアドレス:</label>
        <div class="col-sm-9 col-md-10">
          <span class="form-control">
          <?php print(htmlspecialchars($registerinput['email'], ENT_QUOTES)); ?>
          </span>
        </div>
      </div>

      <div class="form-group row">
        <label for="password" class="col-sm-3 col-md-2 col-form-label">パスワード:</label>
        <div class="col-sm-9 col-md-10">
          <span class="form-control">
          <?php print('表示されません'); ?>
          </span>
        </div>
      </div>

      <!-- <label for="image">写真:</label>
    <?php if (isset($registerinput['picture'])) : ?>
      <?php print(htmlspecialchars($registerinput['picture'], ENT_QUOTES)); ?>
    <?php else : ?>
      <span>登録画像はありません</sapn>
    <?php endif; ?> -->
      <br>
      <a class="btn btn-secondary" href="register.php">戻る</a>
      <input class="btn btn-success" type="submit" value="入力内容を確認する">
    </form>
  </div>
</div>

<?php include('footer.php'); ?>