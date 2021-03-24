<?php
session_start();
include('header.php');
require_once('dbconnect.php');
$error = [];

if (!empty($_POST)) {
  if ($_POST['search'] === '') {
    $error['search'] = 'blank';
  }
}

try {
  //SQL文を実行し、$stmtに代入する
  $stmt = $db->prepare("SELECT * FROM articles WHERE
   content LIKE '%" . $_POST["search"] . "%' OR title LIKE '%" . $_POST["search"] . "%' ORDER BY id DESC");
  //実行
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
  //接続を閉じる
  $db = null;
} catch (PDOException $e) {
  echo 'DBに接続していません';
  exit();
}
//登録完了のセッションを表示した後、更新などでSESSIONの削除
// if (isset($_SESSION['flash'])) { echo $_SESSION['flash']; unset($_SESSION['flash']); } 
if (isset($_SESSION['success_message'])) {
  $succes_message = $_SESSION['success_message'];
  unset($_SESSION['success_message']);
}

if (isset($_SESSION['delete_message'])) {
  $delete_message = $_SESSION['delete_message'];
  unset($_SESSION['delete_message']);
}

if(empty($results)){
  $error['sql'] = 'nodata';
}

?>

<div class="container">
  <a class="btn btn-warning float-right mr-2" href="article.php">記事投稿</a>
  <h3 class="mt-4">ブログ一覧</h3>
  <?php if (!empty($succes_message)) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert"><?php print($succes_message); ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  </div>
  <?php endif; ?>

  <?php if (!empty($delete_message)) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert"><?php print($delete_message); ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  </div>
  <?php endif; ?>




  <form action="" method="POST" class="search-form">
    <div class="form-group row ml-1">
      <input class="form-control col-sm-6" type="text" name="search">

      <div class="col-sm-2">
        <input class="btn btn-success" type="submit" name="submit" value="検索する">
       
      </div>
      <div class="col-sm-6" style="margin-left: -15px; margin-top:15px; margin-bottom:-15px;">
      <?php if ($error['search'] === 'blank') : ?>
          <p class="alert alert-danger">検索ワードを入力してください</p>
        <?php endif; ?>
      </div>
    </div>

    <!-- <div class="form-inline row">
    <div class="form-group col-sm-8">
      <input class="form-control" type="text" name="search">
    </div>
    <input class="btn btn-success col-sm-2" type="submit" name="submit" value="検索する">
    <?php if ($error['search'] === 'blank') : ?>
      <p class="error_msg">検索ワードを入力してください</p>
    <?php endif; ?>
    </div> -->
  </form>

  <?php foreach ($results as $result) : ?>
    <div class="card mb-3 searchCard shadow-sm">
      <div class="card-body">
        <div class="blogTitle lead">
          <a href="article_show.php?id=<?php echo $result['id']; ?>"> <?php print(htmlspecialchars($result['title'], ENT_QUOTES));  ?></a>
        </div>
        <div class="blogBody">
          <?php print(mb_substr(htmlspecialchars($result['content'], ENT_QUOTES),0,50).'...');  ?>
        </div>
        <div class="blogInfo mt-1">
          <span style="font-size: 14px;"><?php print(htmlspecialchars($result['name'], ENT_QUOTES)) ?>さんが投稿</span>
          <span class="postedTime">
            <?php print(htmlspecialchars($result['created'], ENT_QUOTES));  ?>
          </span>
        </div>
      </div>
    </div>
   
    <!-- 
    <p><a href="article_show.php?id=<?php echo $result['id']; ?>"> <?php print(htmlspecialchars($result['title'], ENT_QUOTES));  ?></a>
      <span class="postedTime" style="margin-left: 15px;"><?php print(htmlspecialchars($result['created'], ENT_QUOTES));  ?></span>
      <span><?php print(htmlspecialchars($result['name'], ENT_QUOTES)) ?>さんが投稿</span>
    </p>
    <p><?php print(htmlspecialchars($result['content'], ENT_QUOTES));  ?></p> -->
  <?php endforeach; ?>
  <?php if($error['sql'] === 'nodata'):?>
    <p class="alert alert-secondary w-50" >該当するデータはありません</p>
    <a class="btn btn-primary" href="search.php">一覧を表示する</a>
    <?php endif;?>
</div>

<?php include('footer.php'); ?>