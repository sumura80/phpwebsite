<?php
session_start();
require_once('dbconnect.php');
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

//ログインしている時は名前を表示
$login_user = $_SESSION['name'];

//blogのデータを取得し最新の5件だけを表示
try {
  $blogs = $db->query('SELECT * FROM articles ORDER BY id DESC LIMIT 0,5');
  $blogs->execute();
  $potsTop5 = $blogs->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  echo '接続失敗' . $e->getMessage();
  exit();
}

?>
<?php include('header.php'); ?>



<!-- <header>
    <ul>
      <li><a href="">PHP Web</a></li>
      <li><a href="search.php">ブログ</a></li>
      <li><a href="post-board.php">掲示板</a></li>
      <?php if (!isset($login_user)) : ?>
        <li><a href="login.php">ログイン</a></li>
      <?php endif; ?>
      <?php if (isset($login_user)) : ?>
        <li><a href="logout.php">ログアウト</a></li>
      <?php endif; ?> 
      <?php if (!isset($login_user)) : ?>   
        <li><a href="register.php">新規登録</a></li>
      <?php endif; ?>
    </ul>
  </header> -->

<!-- <section class="loginUserActive">
  <?php if (isset($login_user)) : ?>
    <div class="text-right pr-3 pt-2"><?php print($login_user); ?>さんようこそ</div>
  <?php endif; ?>
</section> -->




<section class="top-image">
  <img src="images/firstview_topimage.png" alt="top image" class="topImage img-fluid">
</section>


<!-- ********** container ********** -->
<div class="container">
  <section class="trialBtnWrap">
    <span class="trialBtn" href=""><i class="far fa-envelope-open mr-1"></i>まずは気軽に無料体験</span>
  </section>



  <div class="schoolFeature">
    <div class="featureTitle mb-2">\ Englishラボの<span class="colorCompanyPink">3</span>つの特徴 /</div>
    <div class="featureBoxes">
      <div class="row">

        <div class="col-md-4 my-4">
          <div class="card">
            <div class="card-header featureTitleSize">月々<span class="colorCompanyPink">9,800円! 入会金なし</span></div>
            <div class="card-body">
              <!-- <p class="card-title">Special title treatment</p> -->
              <p class="card-text featureTextSize">
                完全月謝制となっており、とても経済的。入会金もないため無料体験を試していただけます。<br>
                振替制度やレベルも選べるので、気軽に楽しんでいただけます。Englishラボなら、１レッスン2,400円で受講していただけます。
              </p>
            </div>
          </div><!-- end of card -->
        </div><!-- end of col-sm-4 -->

        <div class="col-md-4 my-4">
          <div class="card">
            <div class="card-header featureTitleSize"><span class="colorCompanyPink">イベントが充実</span></div>
            <div class="card-body">
              <!-- <p class="card-title">Special title treatment</p> -->
              <p class="card-text featureTextSize">
                Englishラボでは、毎月盛りだくさんのイベントを用意しております。ハロウィンパーティーや前項の生徒で行われる大規模イベントもあります。
                英語レベレルに問わず参加できるため、友人を作ったりすることもできます。<br>
                (現在は、オフラインイベントも開催中)
              </p>
            </div>
          </div><!-- end of card -->
        </div><!-- end of col-sm-4 -->


        <div class="col-md-4 my-4">
          <div class="card">
            <div class="card-header featureTitleSize"><span class="colorCompanyPink">少人数制レッスン</span></div>
            <div class="card-body">
              <!-- <p class="card-title">Special title treatment</p> -->
              <p class="card-text featureTextSize">
                １クラス3人までの生徒としております。教材もEnlgishラボの専任のチームによって開発されております。
                そのため、これまでの英会話上達のノウハウを活用し、英会話が上達しやすい内容を取り込んでおります。
              </p>
            </div>
          </div><!-- end of card -->
        </div><!-- end of col-sm-4 -->

      </div><!-- end of row -->
    </div>
  </div>


  <section class="blog my-4">
    <h3 class="lead">最近のニュース(ブログ)</h3>
    <div class="card">
      <div class="card-body">
        <dl>
          <?php foreach ($potsTop5 as $post) : ?>
            <dt class="title"><?php echo date('Y年m月d日', strtotime($post['created'])) ?></dt>
            <dd><a href="article_show.php?id=<?php echo $post['id']; ?>"><span class="title"><?php echo $post['title'] ?></span></a></dd>


            <!-- <div class="title"><?php echo date('Y年m月d日', strtotime($post['created'])) ?>
          <a href="article_show.php?id=<?php echo $post['id']; ?>"><span class="title"><?php echo $post['title'] ?></span></a>
        </div> -->
          <?php endforeach; ?>
        </dl>
      </div>
    </div>
  </section>

</div><!-- end of container -->

<section class="studentsFeedback">
  <div class="container">
    <div class="feedbackTitleHead">Englishラボについて教えて♫</div>
    <div class="feedbackTitle"><i class="fas fa-quote-left quoteColor"></i> 受講生の声 <i class="fas fa-quote-right quoteColor"></i></div>
    <div class="feedbackBoxes mt-4">
      <div class="row">

        <div class="col-md-4 mb-4">
          <a href="#" class="studentsCard">
            <div class="card">
              <img class="card-img-top" src="images/students_01.png" alt="Card image cap">
              <div class="card-body studentsCardBody">
                <h4 class="card-title text-center">ともみ <span class="smallSan">さん</span></h4>
                <p class="card-text">日常会話を話せるようになってから、海外の旅行が楽しくなりました。
                  プライベートレッスンが役に立ちました。
                </p>
                <a href="#" class="studentsDetail mt-4">詳しく見る>></a>
              </div>
            </div><!-- end of card -->
          </a>
        </div>


        <div class="col-md-4 mb-4">
          <a href="#" class="studentsCard">
            <div class="card">
              <img class="card-img-top" src="images/students_02.png" alt="Card image cap">
              <div class="card-body studentsCardBody">
                <h4 class="card-title text-center">哲哉 <span class="smallSan">さん</span></h4>
                <p class="card-text">ヨーロッパの出張が多いので、ビジネスコースを羽化ました。ビジネスで使える英語が身に付きました。</p>
                <a href="#" class="studentsDetail mt-4">詳しく見る>></a>
              </div>
            </div><!-- end of card -->
          </a>
        </div>


        <div class="col-md-4 mb-4">
          <a href="#" class="studentsCard">
            <div class="card">
              <img class="card-img-top" src="images/students_03.png" alt="Card image cap">
              <div class="card-body studentsCardBody">
                <h4 class="card-title text-center">かずみ <span class="smallSan">さん</span></h4>
                <p class="card-text">社内の公用語が英語になり、英会話の勉強をはじめました。<br>
                  外部のクライアントとも交渉ができて昇進もできました。
                </p>
                <a href="#" class="studentsDetail mt-4">詳しく見る>></a>
              </div>
            </div><!-- end of card -->
          </a>
        </div>

      </div><!-- end of row -->
      <div class="studentsListBtn">受講生の声一覧はこちら > </div>
    </div>
  </div><!-- end of container -->
</section>

<div class="container">

  <div class="trialBigBtnSection">
    <div class="trialReserve"> \ オンラインでも予約できます /</div>
    <div class="trialBigBtn">まずは気軽に無料体験 <i class="fas fa-chevron-right ml-2"></i></div>
  </div>


  <div class="dottLine"> </div>


  <section class="lessonStyle">
    <div class="lessonStyleTitle">Lesson Style</div>

    <div class="row">
      <div class="col-4 col-sm-4">
        <div class="card border-success mb-3">
          <div class="card-body text-success">
            <p class="card-text text-center">プライベートレッスン <i class="fas fa-chevron-down"></i></p>
          </div>
        </div>
      </div>
      <div class="col-4 col-sm-4">
        <div class="card border-danger mb-3">
          <div class="card-body text-danger">
            <p class="card-text text-center">グループレッスン <i class="fas fa-chevron-down"></i></p>
          </div>
        </div>
      </div>
      <div class="col-4 col-sm-4">
        <div class="card border-info mb-3">
          <div class="card-body text-info">
            <p class="card-text text-center">オンラインレッスン <i class="fas fa-chevron-down"></i></p>
          </div>
        </div>
      </div>
    </div>


    <div class="lessonMember">最大３名の少人数制</div>
    <div class="groupLesson">レッスンの様子</div>
    <div class="lessonIntro">
      <div class="row">
        <div class="col-sm-7">
          <div class="lessonIntroTopline introBold mb-4">少人数だから会話の時間が多く取れ様々な単語を習得できる</div>
          <p>Englishラボでは、グループレッスンでも会話の時間を多く取れるようにプログラミングしております。クラスメートとも仲良くなったり、先生が添削してくれるので、間違った表現を正しく使えるようになります。<br><br>
            リーズナブルな金額でコスパの高いコースとなっております。
          </p>
        </div>
        <div class="col-sm-5">
          <img src="images/lesson_style.jpg" alt="" class="img-fluid">
        </div>

          <div class="introGap col-sm-12"> </div>

          <div class="col-sm-5">
          <img src="images/lesson_online.jpg" alt="" class="img-fluid">
        </div>
        <div class="col-sm-7">
          <div class="lessonIntroTopline introBold mb-4">オンラインレッスンで自宅でも学習</div>
          <p>Englishラボでは、グループレッスンでも会話の時間を多く取れるようにプログラミングしております。クラスメートとも仲良くなったり、先生が添削してくれるので、間違った表現を正しく使えるようになります。<br><br>
            リーズナブルな金額でコスパの高いコースとなっております。
          </p>
        </div>
        
        <div class="col-sm-12  youTubeBanner">
        <div class="youTubeIntro mb-2">\ 動画更新中 /</div>
        <img src="images/youtube_banner.png" alt="you tube image" class="img-fluid">
        </div>


      </div><!-- end of row-->
    </div>


  </section>



  <hr>
  <section class="contact">
    <!-- 確認できるように同じ画面に戻ってくる -->
    <form action="" method="POST">
      <h3>お問い合わせ</h3>
      <br>

      <div class="form-group row">
        <label for="name" class="col-sm-2 col-form-label">お名前</label>
        <div class="col-sm-10">
          <input type="text" name="name" class="form-control" placeholder="東京太郎" id="name">
          <?php if ($error['name'] === 'blank') : ?>
            <p class="error_msg">※お名前をご記入ください</p>
          <?php endif; ?>
        </div>
      </div>



      <div class="form-group row">
        <label for="email" class="col-sm-2 col-form-label">メールアドレス</label>

        <div class="col-sm-10">
          <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($post['email']); ?>" placeholder="tokyo@sample.com">
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
          <textarea name="contact" class="form-control" id="contact" name="contact" cols="30" rows="5" placeholder="内容をご記入ください"><?php echo htmlspecialchars($post['contact']); ?></textarea>
          <?php if ($error['contact'] === 'blank') : ?>
            <p class="error_msg">※お問い合わせ内容をご記入ください</p>
          <?php endif; ?>
        </div>
      </div>

      <!-- 削除して良い
      <label for="name">お名前</label>
      <input type="text" name="name">
      <?php if ($error['name'] === 'blank') : ?>
        <p class="error_msg">※お名前をご記入ください</p>
      <?php endif; ?>
      <br>
      <label for="email">メールアドレス</label>
      <input type="emaiil" name="email" value="<?php echo htmlspecialchars($post['email']); ?>">
      <?php if ($error['email'] === 'blank') : ?>
        <p class="error_msg">※メールアドレスをご記入ください</p>
      <?php endif; ?>
      <?php if ($error['email'] === 'emailFormCheck') : ?>
        <p class="error_msg">※メールアドレスを正しくご記入ください</p>
      <?php endif; ?>

      <label for="contact">お問い合わせ</label><br>
      <textarea name="contact" id="contact" name="contact" cols="30" rows="10" placeholder="内容をご記入ください"><?php echo htmlspecialchars($post['contact']); ?></textarea>
      <?php if ($error['contact'] === 'blank') : ?>
        <p class="error_msg">※お問い合わせ内容をご記入ください</p>
      <?php endif; ?> -->




      <input type="submit" value="確認画面へ" class="btn btn-primary mx-auto d-block">
    </form>
  </section>
</div><!-- end of container -->

<?php include('footer.php'); ?>