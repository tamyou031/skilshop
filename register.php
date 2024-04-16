<!-- ユーザー情報登録 -->

<?php
//ヘッダー部分のテンプレート
include __DIR__ . '/inc/header.php';
//トークンチェック
require_once __DIR__ . '/token_check.php';
?>

<?php
//データベース接続
$name = $_POST['username'];
$mail = $_POST['mail'];
//送信されたパスワードをハッシュ化
$pass = password_hash($_POST['password'],PASSWORD_DEFAULT);
$dsn = "mysql:host=127.0.0.1:3309; dbname=skilshop";
$u_name = "root";
$p_word = "";
try{
    $dbh = new PDO($dsn,$u_name,$p_word);
} catch(PDOException $e){
    $msg = $e->getMessage();
}

//同じメールアドレスの登録済みチェック
$sql = "SELECT * FROM users WHERE email = :email";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':email',$mail);
$stmt->execute();
$member = $stmt->fetch();

//データベース内との比較
if($member == false){
    //メールアドレスが異なる場合は送信されたユーザー情報をデータベースへ新しく追加
    $sql = "INSERT INTO users(name, email, password) VALUES (:name, :email, :password)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':email', $mail);
    $stmt->bindValue(':password', $pass);
    $stmt->execute();
    $msg = '会員登録が完了しました';
    $link = '<a href="login_test.php">ログインページ</a>';
}else{
    $msg = '同じメールアドレスが存在します。'; 
    $link = '<a href="signup.php">戻る</a>';
}

?>

<title>ユーザー新規登録完了</title>
<h1 class="alert alert-primary"><?php echo $msg; ?></h1>
<?php echo $link; ?>


<?php 
//フッター部分のテンプレート
include __DIR__ . '/inc/footer.php'; 
?>