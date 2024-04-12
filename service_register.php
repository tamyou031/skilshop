<!-- サービス登録完了画面 -->

<?php
// ヘッダー部分のテンプレート
include __DIR__ . '/inc/header.php';
// csrf対策用トークンチェック
require_once __DIR__ . '/token_check.php';
?>

<?php
//make_service.phpからPOSTされた情報をそれぞれ変数へ代入
$username = $_SESSION['user_name']; //ユーザー名
$title = $_POST['title'];   //タイトル
$text = $_POST['text']; //サービス内容
$price = $_POST['price'];   //料金
//イメージ画像
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $check = isset($_POST["thumbnail"]) ? $_POST["thumbnail"] : 0;
    $thumbnail = $check;
}

//データベースへ接続
$dsn = "mysql:host=127.0.0.1:3309; dbname=skilshop";
$u_name = "root";
$p_word = "";
try{
    $dbh = new PDO($dsn,$u_name,$p_word);
} catch(PDOException $e){
    $msg = $e->getMessage();
}

?>

<title>登録完了</title>
<!-- 料金が数字で入力されていない場合はエラー表示 -->
<?php if(!(preg_match('/^[0-9]+$/',$price))): ?>
    <p>料金は半角数字で入力してください。</p><br>
    <a href= make_service.php>サービス制作画面へ戻る</a>
<!-- 数字で入力されている場合はデータベースに情報を追加 -->
<?php else: ?>
    <?php
        //データベースへ追加処理
        $sql = "INSERT INTO make_service(username,title, text, price, thumbnail) VALUES (:username,:title, :text, :price, :thumbnail)";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':username', $username);   //ユーザー名
        $stmt->bindValue(':title', $title); //サービスのタイトル
        $stmt->bindValue(':text', $text);   //サービス内容
        $stmt->bindValue(':price', $price); //料金
        $stmt->bindValue(':thumbnail', $thumbnail); //イメージ画像
        $stmt->execute();
        $msg = 'サービスを登録しました';
        $link1 = '<a href="index.php">トップへ戻る</a>';

        //新しいページを作成
        $sql2 = "SELECT service_id FROM make_service order by service_id desc limit 1";
        $stmt2 = $dbh->prepare($sql2);
        $stmt2->execute();
        $id = $stmt2->fetch();
    ?>
    <!-- 追加した内容を表示 -->
    <div class="container px-4">
        <h1 class="mb-4"><?php echo $msg; ?></h1><!--メッセージの出力-->
            <h2 class="mb-4">登録内容</h2>
                <div class="border border-info">
                    <div class="container px-3">
                        <!-- タイトル -->
                        <h3 class="mt-3">サービス名：<?php echo "$title"; ?></h3>   
                        <!-- サービス内容 -->
                        <h3 class="mt-3">サービス内容</h3>  
                        <?php echo "<p>$text</p><br>"; ?>
                        <!-- 料金 -->
                        <?php echo "<h3 class='mt-3'>料金：$price 円</h3><br>"; ?>
                    </div>
                </div>
                <!-- 作ったサービスの詳細画面へ移動するリンクを表示 -->
                <h3 class="my-4">出品したサービスを確認する</h3>
                    <h4><span class="badge text-bg-primary">New</span><a href="http://localhost/skilshop/service.php?id=<?php echo $id[0]; ?>"> <?php echo $title?></a></h4><br>
        <p class="mt-5"><?php echo $link1; ?></p><br>
    </div>
<?php endif ?>
<?php 
// フッター部分のテンプレート
include __DIR__ . '/inc/footer.php'; 
?>