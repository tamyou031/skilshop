<!-- ヘッダーの共通部分のテンプレート -->
<?php
    //セッション
    if(!isset($_SESSION)){
        session_start();
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <!-- サイト全体の装飾のためにBootstrapを使用 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="js/script.js"></script>
</head>

<!-- ヘッダーメニュー -->
<header>
    <div class="mb-4 container text-center border-bottom border-primary">
        <div class="row">
            <div class="col">
                <!-- トップ画面へ遷移するためのリンク -->
                <strong><a href="index.php">トップ</a></strong>
            </div>
            <div class="col">
                <!-- サービスを検索するための検索フォーム -->
                <form action='search.php' method="post">
                    <label>
                        <input type="text" name="search_name" style="width:150px">
                        <input type="submit" value="検索" class="mb-2">
                    </label>
                </form>
            </div>
            <!-- 各種画面への遷移 -->
            <!-- ログインをしていない場合は、新規登録とログイン画面へ遷移するリンクが表示 -->
            <?php if(empty($_SESSION['login'])): ?>
                <div class="col"><strong><a href="signup.php">新規登録</a></strong></div>
                <div class="col"><strong><a href="login_test.php">ログイン</a></strong></div>
            <!-- すでにログインしている場合はサービス出品とログアウトへ遷移するリンクを表示 -->
            <?php else: ?>
                <div class="col"><strong><a href="make_service.php">サービス出品</a></strong></div>
                <div class="col"><strong><a href="logout.php">ログアウト</a></strong></div>
            <?php endif; ?>
        </div>
    </div>
</header>
