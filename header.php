<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <link rel="icon" href="images/favicon.ico">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
  <title>

    <?php
    //URLによりtitleを変更
    $url = $_SERVER["REQUEST_URI"];
    if ($url === '/phpwebsite/index.php') {
      echo 'PHPウェブサイト';
    } else if ($url === '/phpwebsite/search.php') {
      echo 'ブログ一覧';
    } else if ($url === '/phpwebsite/article.php') {
      echo 'ブログ投稿画面';
    } else if ($url === '/phpwebsite/post-board.php') {
      echo '掲示板ページ';
    } else if ($url === '/phpwebsite/login.php') {
      echo 'ログインフォーム';
    } else if ($url === '/phpwebsite/register.php') {
      echo '新規会員登録フォーム';
    }else if ($url === '/phpwebsite/confirm.php') {
      echo 'お問い合わせ確認画面';
    }else if ($url === '/phpwebsite/contact.php') {
      echo 'お問い合わせフォーム編集';
    }
    ?>
  </title>
</head>
<body>
  <nav class="navbar navbar-expand-md navbar-dark bg-dark sticky-top">
    <a class="navbar-brand" href="index.php">Englishラボ <i class="fas fa-graduation-cap" style="color:#FF6D6D"></i></a>
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
      <li class="nav-item"><a  class="nav-link"  href="index.php">TOP</a></li> 
      <li class="nav-item"><a  class="nav-link"  href="search.php">ブログ</a></li> 
      <li class="nav-item"><a  class="nav-link"  href="post-board.php">掲示板</a></li> 
     
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
        <li class="nav-item"><a class="nav-link"  href="register.php">新規登録</a></li>
      <?php endif; ?>
        
        <!-- <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li> -->
      </ul>
    </div>
  </nav>