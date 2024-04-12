<!-- 口コミの削除画面 -->
<?php
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
    //変数sqlに口コミの削除のsql文を格納
    $sql = "DELETE FROM reviews  WHERE review_id = :review_id";
    $stmt = $dbh->prepare($sql);
    //該当する口コミidを指定して削除を実行
    $stmt->execute(array(':review_id' => $_GET['id']));

     echo "サービスを削除しました。";
} catch (PDOException $e) {
    echo 'エラーが発生しました。:' . $e->getMessage();
}
?>

<!-- 削除の完了を表示 -->
<!DOCTYPE html>
<html>
    <head>
      <meta charset="utf-8">
      <title>削除完了</title>
    </head>
  <body>          
    <p>
        <a href="user_admin.php">ユーザーメニュー</a>
    </p> 
  </body>
</html>