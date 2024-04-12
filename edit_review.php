<!-- 口コミ編集画面 -->

<?php
//ヘッダー部分のテンプレート
include __DIR__ . '/inc/header.php';

// ログインチェック
include __DIR__ . '/inc/login_check.php';

//csrf対策用トークン生成
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
    //reviewsからデータを取得
    $sql = "SELECT * FROM reviews WHERE review_id = :review_id";
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(':review_id' => $_GET["id"]));
    //初期化
    $result = 0;
    $result = $stmt->fetch();
} catch(PDOException $e){
    $msg = $e->getMessage();
}
?>

<title>口コミ編集</title>
    <div class="container px-4">
        <h2>編集</h2>
            <!-- 口コミ編集用入力フォーム -->
            <form action="update_review.php" method="post">
                <input type="hidden" name="id" value="<?php if (!empty($result['review_id'])) echo(htmlspecialchars($result['review_id'], ENT_QUOTES, 'UTF-8'));?>">
                <!-- 口コミタイトル -->
                <div class="mt-4">
                    <label class="form-label"><p class="fs-4">口コミタイトル</p></label>
                    <input type="text" name="title" value="<?php if (!empty($result['title'])) echo(htmlspecialchars($result['title'], ENT_QUOTES, 'UTF-8'));?>" class="form-control">
                </div>
                <!-- 口コミ内容 -->
                <div class="mt-4">
                    <label class="form-label"><p class="fs-4">口コミ内容</p></label>
                    <input type="text" name="text" value="<?php if (!empty($result['text'])) echo(htmlspecialchars($result['text'], ENT_QUOTES, 'UTF-8'));?>" class="form-control" rows="5">
                </div>
                <!-- 星評価 -->
                <div class="mt-4">        
                    <label class="form-label"><p class="fs-4">評価</p></label><br>
                        <input type="radio" name="star" value="5" required> <span class="star5_rating" data-rate="5"></span><br> <!-- 星5 -->
                        <input type="radio" name="star" value="4"> <span class="star5_rating" data-rate="4"></span><br> <!-- 星4 -->
                        <input type="radio" name="star" value="3"> <span class="star5_rating" data-rate="3"></span><br> <!-- 星3 -->
                        <input type="radio" name="star" value="2"> <span class="star5_rating" data-rate="2"></span><br> <!-- 星2 -->
                        <input type="radio" name="star" value="1"> <span class="star5_rating" data-rate="1"></span><br> <!-- 星1 -->
                </div>
                <!-- 編集内容を送信 -->
                <input type="submit" value="編集する" class="mt-3 btn btn-primary">
            </form>
        <p class="mt-5"><a href="index.php">トップ</a></p>
    </div>
<br>

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
