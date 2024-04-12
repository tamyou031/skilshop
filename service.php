<!-- 各サービスの詳細画面 -->

<?php
//ヘッダー部分のテンプレートを表示
include __DIR__ . '/inc/header.php';
//
require_once 'function.php';
?>

<?php
//セッションでサービスのid番号を取得、それぞれのページに該当するサービスを表示させるため
if(isset($_GET['id'])){
    $id = $_GET['id'];
}

//データベースの接続
$dsn = "mysql:host=127.0.0.1:3309; dbname=skilshop";
$u_name = "root";
$p_word = "";
try{
    $dbh = new PDO($dsn,$u_name,$p_word);
} catch(PDOException $e){
    $msg = $e->getMessage();
}

//サービス用の"make_service"テーブルから該当idのデータを取得
$stmt = $dbh->prepare("SELECT * FROM make_service WHERE service_id = :service_id;");
$stmt->bindParam(':service_id', $id, PDO::PARAM_INT);
$res = $stmt->execute();
if ($res) {
  $data = $stmt->fetch();
}

//口コミ用の"reviews"テーブルから該当サービスに対する全ての口コミを取得
$sql2 = "SELECT * FROM reviews WHERE service_id=$id";
$stmt2 = $dbh->query($sql2);
$result2 = $stmt2->fetchAll();
?>


<!-- 該当するサービスのタイトルを挿入 -->
<title><?php echo str2html($data[2]); ?></title>
<body>
  <div class="container px-4">
    <!-- サービス名を表示 -->
    <h1 class="mb-4">サービス名：<?php echo str2html($data["title"]);  ?></h1>
      <!-- サービス内容と料金を表示 -->
      <div class="border border-info">
        <h3 class="m-3">・サービス内容</h3>
          <p class="m-3"><?php echo str2html($data["text"]); ?></p>
        <h3 class="m-3">・料金（税込み）</h3>
          <p class="m-3"><b><?php echo $data["price"] ?></b>円</p>
      </div>
    <br>
    <!-- すでにログインしていて、閲覧しているサービスが自身で作ったサービスであれば、サービスの変更・削除のリンクを表示 -->
    <?php if(!empty($_SESSION['user_name']) && $_SESSION['user_name'] == $data['username']):?>
      <div class="m-2 container border-top border-primary"></div>
        <!-- サービス変更のリンクを表示 -->
        <h4 class="m-2 fs-4">サービス内容を変更する</h4>
          <a href="edit.php?id=<?php echo $id ?>" class="btn btn-info">変更</a><br>
          <!-- サービス削除のリンクを表示 -->
        <h4 class="m-2 fs-4">このサービスを削除する</h4>
          <a href="delete.php?id=<?php echo $id ?>" class="btn btn-danger">削除</a><br>
      <div class="m-2 container border-bottom border-primary"></div>
    <?php endif ?>
    <br>

    <!-- 口コミを一覧表示 -->
    <h2 class="m-4">口コミ</h2>
      <!-- 該当サービスに対する口コミをすべて表示 -->
      <?php foreach ($result2 as $val) :?>
        <h3>・<?php echo $val['title']; ?></h3> <!-- 口コミタイトル -->
        <p><?php echo $val['text']; ?></p>  <!-- 口コミ内容 -->
        <!-- 星評価 -->
        <p><?php if($val['star'] == 5){ //変数starが5なら星5つ
            echo '<span class="star5_rating" data-rate="5"></span>';
          }elseif ($val['star'] == 4) { //変数starが4なら星4つ
          echo '<span class="star5_rating" data-rate="4"></span>';
          }elseif ($val['star'] == 3) { //変数starが3なら星3つ
              echo '<span class="star5_rating" data-rate="3"></span>';
          }elseif ($val['star'] == 2) { //変数starが2なら星2つ
            echo '<span class="star5_rating" data-rate="2"></span>';
          }elseif ($val['star'] == 1) { //変数starが1なら星1つ
              echo '<span class="star5_rating" data-rate="1"></span>';
          }?>
        </p>
        <p class="border-bottom border-success"></p>
      <?php endforeach ?>
    <br>
    <!-- 口コミ記入に関する処理 -->
    <h4>
      <!-- ログイン済みであり、かつサービス制作者自身でなければ口コミ制作画面へ移動するリンクを表示 -->
      <?php if(!empty($_SESSION['login']) && !($_SESSION['user_name'] == $data['username'])): ?>
        <a href="make_review.php?id=<?php echo $id ?>" class="alert alert-info">口コミを書く</a>
      <!-- ログインしていなければ、ログインを促すメッセージとログイン画面へ移動するリンクを表示 -->
      <?php elseif(empty($_SESSION['login'])):?>
        <div class="alert alert-info" role="alert">
          <a href="login_test.php" class="m-4">口コミを記入するにはログインが必要です</a>
        </div>
      <!-- サービス制作者自身である場合は口コミを書くことはできないというメッセージのみを表示 -->
      <?php elseif ($_SESSION['user_name'] == $data['username']) : ?>
        <div class="alert alert-danger" role="alert">
          <p>出品者が自サービスに口コミを書くことはできません</p>
        </div>
      <?php endif ?>
    </h4>
    <br>
    <a href="index.php">トップへ戻る</a>
  </div>

  <style>
    /* 星評価の実装：（https://kinocolog.com/css_star_rating/）を利用 */
      .star5_rating{
      position: relative;
      z-index: 0;
      display: inline-block;
      white-space: nowrap;
      color: #CCCCCC; /* グレーカラー 自由に設定化 */
      /*font-size: 30px; フォントサイズ 自由に設定化 */
  }

  .star5_rating:before, .star5_rating:after{
      content: '★★★★★';
  }

  .star5_rating:after{
      position: absolute;
      z-index: 1;
      top: 0;
      left: 0;
      overflow: hidden;
      white-space: nowrap;
      color: #ffcf32; /* イエローカラー 自由に設定化 */
  }

  .star5_rating[data-rate="5"]:after{ width: 100%; } /* 星5 */
  .star5_rating[data-rate="4"]:after{ width: 80%; } /* 星4 */
  .star5_rating[data-rate="3"]:after{ width: 60%; } /* 星3 */
  .star5_rating[data-rate="2"]:after{ width: 40%; } /* 星2 */
  .star5_rating[data-rate="1"]:after{ width: 20%; } /* 星1 */
  </style>
  <br>
</body>
</html>