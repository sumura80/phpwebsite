<?php
require_once('dbconnect.php');
$id = $_GET['id'];
$updatePost = filter_input_array(INPUT_POST, $_POST);

//該当IDのデータを取得
$stmt = $db->prepare('SELECT * FROM articles WHERE id=:id');
$stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
$stmt->execute();
$post = $stmt->fetch(PDO::FETCH_ASSOC); //配列と添字を取得できる




if (!empty($_POST)) { //編集フォームが送信されたら


  //入力項目に空がないか
  if ($updatePost['title'] === '') {
    $error['title'] = 'blank';
  }
  if ($updatePost['name'] === '') {
    $error['name'] = 'blank';
  }

  if ($updatePost['content'] === '') {
    $error['content'] = 'blank';
  }


  if (count($error) === 0) {
    //投稿処理
    try {

      $stmt = $db->prepare("UPDATE articles SET title =:title, name =:name, content=:content WHERE id =:id");
      $stmt->bindValue(':title', $updatePost['title'], PDO::PARAM_STR);
      $stmt->bindValue(':name', $updatePost['name'], PDO::PARAM_STR);
      $stmt->bindValue(':content', $updatePost['content'], PDO::PARAM_STR);
      $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
      $stmt->execute();
    } catch (PDOException $e) {
      echo '接続に失敗しました' . $e->getMessage();
      exit();
    }


    //更新したら投稿記事に返す
    header("Location: article_show.php?id={$id}");
    exit();
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <title>ブログ編集画面</title>
</head>

<body>
  <nav class="navbar navbar-expand-md navbar-dark bg-dark sticky-top">
    <a class="navbar-brand" href="index.php">Englishラボ</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
      </ul> -->

      <ul class="navbar-nav ml-auto">
        <li class="nav-item"><a class="nav-link" href="index.php">TOP</a></li>
        <li class="nav-item"><a class="nav-link" href="search.php">ブログ</a></li>
        <li class="nav-item"><a class="nav-link" href="post-board.php">掲示板</a></li>

        <?php if (!isset($login_user)) : ?>
          <li class="nav-item"><a class="nav-link" href="login.php">ログイン</a></li>
        <?php endif; ?>
        <?php if (isset($login_user)) : ?>
          <li class="nav-item"><a class="nav-link" href="logout.php">ログアウト</a></li>
        <?php endif; ?>

        <?php if (isset($login_user)) : ?>
          <li class="nav-item"><span class="nav-link disabled" style="color:#CFCFCF"><?php print($login_user); ?>さん</span>
          <?php endif; ?>


          <?php if (!isset($login_user)) : ?>
          <li class="nav-item"><a class="nav-link" href="register.php">新規登録</a></li>
        <?php endif; ?>

        <!-- <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li> -->
      </ul>
    </div>
  </nav>

  <div class="container">
    <div class="bodyWrap">
      <h2 class="lead">ブログ内容編集</h2>

      <form action="" method="POST">


        <div class="form-group row">
          <label for="title" class="col-sm-2 col-form-label">タイトル</label>
          <div class="col-sm-10">
            <input class="form-control" type="text" name="title" id="title" value="<?php print(htmlspecialchars($post['title'], ENT_QUOTES)); ?>">
            <?php if ($error['title'] === 'blank') echo '<div class="error_msg">タイトルを入力してください</div>'; ?>
          </div>
        </div>


        <div class="form-group row">
          <label for="name" class="col-sm-2 col-form-label">お名前</label>
          <div class="col-sm-10">
            <input class="form-control" type="text" name="name" id="name" value="<?php print(htmlspecialchars($post['name'], ENT_QUOTES)); ?>">
            <?php if ($error['name'] === 'blank') echo '<div class="error_msg">※お名前をご記入ください</div>'; ?>
          </div>
        </div>


        <div class="form-group row">
        <label for="content" class="col-sm-2 col-form-label">内容</label>
        <div class="col-sm-10">
          <textarea class="form-control" name="content" id="content" cols="30" rows="10"><?php print(htmlspecialchars($post['content'], ENT_QUOTES)); ?></textarea>
          <?php if ($error['content'] === 'blank') echo '<div class="error_msg">ブログ内容を入力してください</div>'; ?><br>
        </div>
      </div>

        <a class="btn btn-secondary" href="article_show.php?id=<?php echo $post['id']; ?>">戻る</a>
        <input class="btn btn-warning" type="submit" value="更新する">
      </form>
    </div>
  </div>

  <?php include('footer.php'); ?>