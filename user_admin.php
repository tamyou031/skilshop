<!-- ユーザーメニュー -->
<?php
//ヘッダー部分のテンプレート
include __DIR__ . '/inc/header.php';
//XSS対策用の関数を読み込む
require_once 'function.php';
//セッションで保持されているuser_nameを変数user_nameへ代入
$user_name = $_SESSION['user_name'];
?>

<?php
//データベースへ接続
$dsn = "mysql:host=127.0.0.1:3309; dbname=skilshop";
$u_name = "root";
$p_word = "";
try{
    $dbh = new PDO($dsn,$u_name,$p_word);
} catch(PDOException $e){
    $msg = $e->getMessage();
}

//make_serviceテーブルからデータ取得
$sql_service = "SELECT * FROM make_service WHERE username='$user_name' ";
$stmt_service = $dbh->query($sql_service);
$result_service = $stmt_service->fetchAll();

//reviewsテーブルから口コミのデータを取得
$sql_review = "SELECT *FROM reviews WHERE username='$user_name' ";
$result_review = $dbh->query($sql_review);

//試作
$sql = "SELECT * FROM reviews AS r  JOIN make_service AS s ON r.service_id = s.service_id WHERE r.username = '$user_name' ";
$stmt = $dbh -> query($sql);
$result = $stmt->fetchAll();

?>

<title>ユーザー管理画面</title>
<div class="container px-4">
<h1>ユーザーメニュー</h1>
<br>
    <!-- ユーザー名を表示 -->
    <p>ようこそ <b><?php echo str2html($user_name);  ?></b> さん</p>

    <!-- 自分が出品したサービスの一覧を表示 -->
    <h2 class="m-4">・<?php echo $user_name ?>さんが出品したサービス</h2>
        <div class="border border-info">
            <!-- サービスのタイトルとそれを編集・削除する画面へ移動するリンクを表示 -->
            <?php foreach($result_service as $r_val): ?>
                <li class="m-3"><a href="http://localhost/skilshop/service.php?id=<?php echo $r_val['service_id'] ?>"><?php echo str2html($r_val['title']);  ?></a>　<!-- サービスのタイトル -->
                    [<a href="edit.php?id=<?php echo $r_val['service_id'] ?>">編集</a>]<!-- サービスの編集リンク -->　
                    [<a href="delete.php?id=<?php echo $r_val['service_id'] ?>">削除</a>]<!-- サービスの削除リンク -->
                </li>
            <?php endforeach ?>
        </div>
    <!-- 自分が投稿した口コミの一覧を表示 -->
    <h2 class="m-4">・<?php echo $user_name?>さんの口コミ</h2>
        <div class="border border-success">
            <!-- 口コミとそれを編集・削除する画面へ移動するリンクを表示 -->
            <?php foreach($result as $val): ?>
                <li class="m-3"><a href="http://localhost/skilshop/review.php?id=<?php echo $val['review_id'] ?>"><?php echo $val[3] ?></a>：<!-- 口コミのタイトル -->
                    <?php echo str2html($val['title']); ?> より　
                    [<a href="edit_review.php?id=<?php echo $val['review_id'] ?>">編集</a>]<!-- 口コミの編集リンク -->　
                    [<a href="delete_review.php?id=<?php echo $val['review_id'] ?>">削除</a>]<!-- 口コミの削除リンク -->
                </li>
            <?php endforeach ?>
        </div>
</div>
<br>
