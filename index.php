<!--　トップページ  -->

<?php
//ヘッダー部分のテンプレートを表示
include __DIR__ . '/inc/header.php';
//フッター部分のテンプレートを表示
require_once 'function.php';
?>

<?php
//データベースに接続

//データベースの指定
$dsn = "mysql:host=127.0.0.1:3309; dbname=skilshop";
//ユーザーネーム
$u_name = "root";
//パスワード（今回は空欄）
$p_word = "";
//例外処理：上記に誤りがあればエラーが表示
try{
    $dbh = new PDO($dsn,$u_name,$p_word);
} catch(PDOException $e){
    $msg = $e->getMessage();
}

//値を取得
// "make_service"テーブルに接続
$sql = "SELECT * FROM make_service";
$result = $dbh->query($sql);
?>

<!-- トップメニューの表示 -->
<title>トップ</title>

<!--ユーザーを表示 -->
<div class="container px-4">
  <!--ログインしている場合にユーザー名を表示 -->
  <?php if(!empty($_SESSION['user_name'])): ?>
    <p>ようこそ 
        <b><?php $user = $_SESSION['user_name']; echo str2html($user); ?></b> さん、ユーザーメニューは<a href="user_admin.php">こちら</a></p>
    <br>
  <?php endif?>

  <!-- 出品サービスを一覧表示 -->
  <h1>出品サービス一覧</h1>
  <div class="conainer">
    <div class="row">
      <!-- データベースから取得したサービスを全て表示 -->
      <?php foreach ($result as $val): ?>
        <div class="col-sm">
          <div class="card" style="width: 18rem;">
            <!-- 該当サービスの詳細ページへ遷移するURL -->
            <a href="http://localhost/skilshop/service.php?id=<?php echo $val['service_id']; ?>"><img src="images/design<?php echo $val['thumbnail'] ?>.jpg" class="card-img-top" alt="..."></a>
          <div class="card-body">
            <h5 class="card-title"><?php echo str2html($val['title']) ?></h5>
            <!-- 該当サービスの詳細ページへ遷移するURL -->
            <a href="http://localhost/skilshop/service.php?id=<?php echo $val['service_id']; ?>" class="btn btn-primary">見る</a>
          </div>
          </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

<!-- 各サービスカードの余白を指定 -->
<style>
    .card{
    margin: 20px;
}
</style>

<!-- 
サービス出品画面への遷移
もし、ログインをしていない場合はログイン画面に移り、
ログインをしている場合はサービス出品画面へ移動する
 -->
<h2 class="m-4"><a href = 
<?php 
//　ログインをしていない場合
if(empty($_SESSION['login'])){
    echo "login_test.php";
//　ログインをしている場合
} else{
    echo "make_service.php";
}
?>>サービスを出品する</a></h2>
</div><br>

<?php 
//フッター部分のテンプレートを表示
include __DIR__ . '/inc/footer.php'; 
?>

