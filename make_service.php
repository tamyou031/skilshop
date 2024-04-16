<!-- サービス制作画面 -->
<?php
//ヘッダー部分のテンプレート
include __DIR__ . '/inc/header.php';
// ログインチェック
include __DIR__ . '/inc/login_check.php';
//csrf対策のトークン生成
$token = bin2hex(random_bytes(20));
$_SESSION['token'] = $token;
?>

<title>サービス制作画面</title>
<div class="container px-4">
    <h1 class="mb-4">サービス制作</h1>
        <!-- 入力フォーム -->
        <form action="service_register.php" method="post">
            <!-- タイトル -->
            <div class="mb-3">
                <label class="form-label">
                    <b class="fs-3">・タイトル</b>
                </label>
                <input type="text" name="title" class="form-control" required>        
            </div>
            <!-- サービス内容 -->
            <div class="mb-3">
                <label class="form-label">
                    <b class="fs-3">・サービス内容</b>
                </label>
                <textarea name="text" class="form-control" rows = "5" required></textarea>
            </div>
            <!-- 料金 -->
            <div class="mb-3">
                <label class="form-label">
                    <b class="fs-3">・料金（税抜き）</b><br>
                </label>
                <input type="number" name="price" min="1" required >　円
            </div>
            <!-- イメージ画像を選択 -->
            <div class="mb-3">
                <label class="form-label">
                    <b class="fs-3">・イメージ画像</b>
                </label><br>
                <!--imagesフォルダに保存されている画像4枚を2行2列で表示（ラジオボタンで選択）  -->
                <table>
                    <td>
                        <input class="thum" type="radio" name="thumbnail" value="1">
                            <img src="images/design1.jpg" alt="" width="300" height="200"><br>
                        <input class="thum" type="radio" name="thumbnail" value="2">
                            <img src="images/design2.jpg" alt="" width="300" height="200"><br>
                    </td>
                    <td>
                        <input class="thum" type="radio" name="thumbnail" value="3">
                            <img src="images/design3.jpg" alt="" width="300" height="200"><br>
                        <input class="thum" type="radio" name="thumbnail" value="4">
                            <img src="images/design4.jpg" alt="" width="300" height="200">
                    </td>
                </table>
            </div>
            <!-- 生成したトークンを送信 -->
            <input type="hidden" name="token" value="<?php echo $token ?>">
            <!-- 入力内容をservice_register.phpへ送信 -->
            <input class="mb-5 btn btn-primary"  type="submit" value="送信">
        </form>   
</div>

<?php 
//フッター部分のテンプレート
include __DIR__ . '/inc/footer.php'; 
?>

