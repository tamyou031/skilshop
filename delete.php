<!-- サービス削除 -->

<?php
//ヘッダー部分のテンプレート
include __DIR__ . '/inc/header.php';
// ログインチェック
include __DIR__ . '/inc/login_check.php';
?>

<?php
//データベース接続
$dsn = "mysql:host=127.0.0.1:3309; dbname=skilshop";
$u_name = "root";
$p_word = "";
try {
    $dbh = new PDO($dsn,$u_name,$p_word);
    //make_serviceテーブルから該当するサービスのみを削除
    $sql = "DELETE FROM make_service  WHERE service_id = :service_id";
    $stmt = $dbh->prepare($sql);
    //プレースホルダーへ該当idを挿入
    $stmt->execute(array(':service_id' => $_GET['id']));
    echo "サービスを削除しました。";
} catch (PDOException $e) {
    echo 'エラーが発生しました。:' . $e->getMessage();
}
?>
<!-- 削除の完了を表示 -->
<title>削除完了</title>
  <body>          
    <p>
        <a href="user_admin.php">ユーザーメニュー</a>
    </p> 
  </body>
