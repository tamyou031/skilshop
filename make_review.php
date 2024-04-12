<!-- 口コミ制作画面 -->

<?php
//ヘッダー部分のテンプレート
include __DIR__ . '/inc/header.php';
// ログインチェック
include __DIR__ . '/inc/login_check.php';

//csrf対策用のトークン生成
$token = bin2hex(random_bytes(20));
$_SESSION['token'] = $token;
?>

<title>口コミ制作画面</title>
    <div class="container px-4">
        <h1>口コミ制作</h1>
            <!-- 口コミの入力 -->
            <form action="review_register.php?id=<?php echo $_GET['id'] ?>" method="post">
                <!-- タイトル -->
                <label class="form-label">
                    <p class = "mt-4 fs-4">タイトル</p>
                </label>
                    <input type="text" name="title" class="form-control" required>
                <br/>
                <!-- 口コミ内容 -->
                <label class="form-label">
                    <p class = "mt-3 fs-4">口コミ内容</p>
                </label>
                    <textarea name="text" class="form-control" rows = "5" required></textarea>
                <!-- 星評価 -->
                <h2 class="mt-4">評価</h2>
                    <input type="radio" name="star" value="5" required> <span class="star5_rating" data-rate="5"></span><br> <!-- 星5 -->
                    <input type="radio" name="star" value="4"> <span class="star5_rating" data-rate="4"></span><br> <!-- 星4 -->
                    <input type="radio" name="star" value="3"> <span class="star5_rating" data-rate="3"></span><br> <!-- 星3 -->
                    <input type="radio" name="star" value="2"> <span class="star5_rating" data-rate="2"></span><br> <!-- 星2 -->
                    <input type="radio" name="star" value="1"> <span class="star5_rating" data-rate="1"></span><br> <!-- 星1 -->
                <!-- csrf対策用トークン -->
                <input type="hidden" name="token" value="<?php echo $token ?>">
                <!-- フォームの内容を送信 -->
                <input type="submit" value="送信" class="mt-4 btn btn-primary">
            </form>
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
<?php include __DIR__ . '/inc/footer.php'; ?>