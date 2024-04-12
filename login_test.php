<!-- ログイン認証画面 -->

<?php
//ヘッダー部分のテンプレート
include __DIR__ . '/inc/header.php';
?>

<title>ログイン</title>
    <div class="container px-4">
        <h1 class="m-5">ログイン画面</h1>
            <!-- 入力フォーム -->
            <form method="post" action="login_test.php">
                <div class="mb-4">
                    <!-- メールアドレス -->
                    <label for = "mail" class="form-label">メールアドレス：</label>
                    <input type="text" name="mail" required>
                </div>
                <div class="mb-4">
                    <!-- パスワード -->
                    <label for = "passeord" class="form-label">パスワード：</label>
                    <input type="password" name="password"  id="input_pass" required>
                    <!-- 入力したパスワードの表示/非表示を切り替えるボタン -->
                    <button id="btn_passview" class="btn btn-primary">表示</button>
                </div>
                <!-- フォームに入力した情報を送信 -->
                <input type="submit" value="ログイン" class="btn btn-primary">
            </form>

        <!-- 入力フォームから送信された情報を認証する処理 -->
        <?php
            //すでにログインしている場合は「ログイン済みです」と表示される
            if (!empty($_SESSION['login'])) {
                echo "ログイン済みです<br>";
                echo "<a href =index.php>戻る</a>";
                exit;
            }

            //フォームにメールアドレスまたはパスワードが入力されてない場合はエラーメッセージを表示
            if ((empty($_POST['mail'])) || (empty($_POST['password']))) {
                echo "メールアドレス、パスワードを入力してください。";
                exit;
            }

            //データベース接続
            $dsn = "mysql:host=127.0.0.1:3309; dbname=skilshop";
            $u_name = "root";
            $p_word = "";
            try{
                $dbh = new PDO($dsn,$u_name,$p_word);
            } catch(PDOException $e){
                $msg = $e->getMessage();
            }

            //ログイン認証
            try {
                //送信したメールアドレスと合致するユーザーのパスワードを抽出
                $sql = "SELECT password FROM users WHERE email = :email";
                $stmt = $dbh->prepare($sql);
                $stmt->bindParam(":email",$_POST['mail'],PDO::PARAM_STR);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                //パスワードが合致しない場合
                if(!$result){
                    echo "ログインに失敗しました。";
                    exit;
                }
                //送信されたパスワードとデータベースに登録されているパスワードのハッシュ値を比較
                if(password_verify($_POST['password'],$result['password'])){
                    //セッションを生成・保持
                    session_regenerate_id(true);
                    $_SESSION['login'] = true;
                    
                    $sql2 =  "SELECT * FROM users WHERE email = :email";
                    $stmt2 = $stmt = $dbh->prepare($sql2);
                    $stmt2->bindParam(":email",$_POST['mail'],PDO::PARAM_STR);
                    $stmt2->execute();
                    $result2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                    //ユーザーメニューでユーザー名を表示するためにセッションを生成
                    $_SESSION['user_name'] = $result2['name'];
                    ///ユーザーメニューへ遷移
                    header("Location:user_admin.php");
                }else{
                    echo "ログインに失敗しました。(パスワードまたはメールアドレスが違います)";
                }
            } catch (PDOException $e) {
                echo "エラー！";
                exit;
            }
        ?>
    </div>

<?php 
//フッター部分のテンプレート
include __DIR__ . '/inc/footer.php'; 
?>