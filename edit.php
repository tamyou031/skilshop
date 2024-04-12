<!-- サービス更新画面 -->
<?php
//ヘッダー部分のテンプレート
include __DIR__ . '/inc/header.php';

// ログインチェック
include __DIR__ . '/inc/login_check.php';

//csrf対策用のトークン生成
$token = bin2hex(random_bytes(20));
$_SESSION['token'] = $token;
?>

<?php
//データベース接続
$dsn = "mysql:host=127.0.0.1:3309; dbname=skilshop";
$u_name = "root";
$p_word = "";
try{
    $dbh = new PDO($dsn,$u_name,$p_word);
    //make_serviceテーブルからデータを取得
    $sql = "SELECT * FROM make_service WHERE service_id = :service_id";
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(':service_id' => $_GET["id"]));

    $result = 0; //初期化
    $result = $stmt->fetch(PDO::FETCH_ASSOC);   //変数resultにsqlのデータを代入

} catch(PDOException $e){
    $msg = $e->getMessage();
}
?>

<title>編集</title>
    <div class="container px-4">
        <h2 class="m-4">編集</h2>
        <!-- 編集用入力フォーム -->
            <form action="update.php" method="post">
                    <input type="hidden" name="id" value="<?php if (!empty($result['service_id'])) echo(htmlspecialchars($result['service_id'], ENT_QUOTES, 'UTF-8'));?>" required>
                <!-- サービス名 -->
                <div class="mb-4">
                    <label class="form-label">サービス名：</label>
                    <input type="text" name="title" value="<?php if (!empty($result['title'])) echo(htmlspecialchars($result['title'], ENT_QUOTES, 'UTF-8'));?>" class="form-control" required>
                </div>
                <!-- サービス内容 -->
                <div class="mb-4">
                    <label class="form-label">サービス内容：</label>
                    <textarea type="text" name="text" class="form-control" rows="5" required><?php if (!empty($result['text'])) echo(htmlspecialchars($result['text'], ENT_QUOTES, 'UTF-8')); ?></textarea>
                </div>
                <!-- 料金 -->
                <div class="mb-4">
                    <label class="form-label">料金：</label>
                    <input type="number" name="price" value="<?php if (!empty($result['price'])) echo(htmlspecialchars($result['price'], ENT_QUOTES, 'UTF-8'));?>" min="1" required>円
                </div>
                <!-- csrf対策用トークン -->
                <input type="hidden" name="token" value="<?php echo $token; ?>">
                <!-- フォームの内容を送信して更新 -->
                <input type="submit" value="編集する" class="btn btn-primary">
            </form>
        <br>
        <a href="index.php" class="mt-5">トップ</a>
    </div>