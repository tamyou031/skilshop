<!-- ユーザー情報登録画面 -->

<?php
//ヘッダー部分のテンプレート
include __DIR__ . '/inc/header.php';

//csrf対策用のトークン生成
$token = bin2hex(random_bytes(20));
$_SESSION['token'] = $token;
?>

<title>新規会員登録</title>

    <div class="conainer px-5">
        <h1 class="m-4">新規会員登録</h1>
        <!-- フォーム：入力した情報はユーザー登録画面（register.php）へ送信される -->
        <form action="register.php" method="post">
            <!-- ユーザー名 -->
            <div class="mb-3">
                <label class="form-label">ユーザ名：
                    <input type="text" name="username" required>
                </label>
            </div>
            <!-- パスワード -->
            <div class="mb-3">
                <label class="form-label" >パスワード：
                    <input type="password" name="password"  id="input_pass" required>
                    <button class="btn btn-primary" id="btn_passview">表示</button>
                </label>
            </div>
            <!-- メールアドレス -->
            <div class="mb-3">
                <label class="form-label">メールアドレス：
                    <input type="text" name="mail" required>
                </label>
            </div>
            <!-- csrf対策用トークン -->
            <input type="hidden" name="token" value="<?php echo $token; ?>">
            <!-- フォームの情報を送信 -->
            <input type="submit" value="登録" class="btn btn-primary">
        </form>
        <p class="m-3">すでに登録済みの場合は<a href="login.php">こちら</a></p>
    </div>
<?php
//フッター部分のテンプレート
include __DIR__ . '/inc/footer.php'; 
?>