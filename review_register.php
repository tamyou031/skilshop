<!-- 口コミ情報を登録 -->

<?php
//ヘッダー部分のテンプレート
include __DIR__ . '/inc/header.php';
//csrf対策用のトークンチェック
require_once __DIR__ . '/token_check.php';
?>

<?php
//フォーム（make_review.php）から送信されたものを変数に格納
$service_id = $_GET['id'];  //id
$reviewer = $_SESSION['user_name']; // ユーザー名
$title = $_POST['title'];   //口コミタイトル
$text = $_POST['text'];  //口コミ内容
if($_SERVER["REQUEST_METHOD"] == "POST"){   //POSTで送信されたか確認
    //変数checkに$_POST["star"]の値（1～5）を代入し、それ以外の数値であれば0を代入
    $check = isset($_POST["star"]) ? $_POST["star"] : 0;
    $star = $check;
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

//入力された口コミ内容をデータベースに追加
$sql = "INSERT INTO reviews(service_id,username,title, text,star) VALUES (:service_id,:username,:title, :text,:star)";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':service_id', $service_id);   //id
$stmt->bindValue(':username', $reviewer);   //ユーザー名
$stmt->bindValue(':title', $title); //口コミタイトル
$stmt->bindValue(':text', $text);   //口コミ内容
$stmt->bindParam(':star',$star);    //星評価
$stmt->execute();
$msg = '口コミを登録しました';
$link1 = '<a href="index.php">トップへ戻る</a>';

?>

<!-- 登録した内容を表示 -->
<div class="container px-4">
    <h1 class="mb-4"><?php echo $msg; ?></h1><!--メッセージの出力-->
        <h2 class="mb-4">登録内容</h2>
            <div class="border border-info">
                <div class="container px-3">
                    <h3 class="mt-3">タイトル：<?php echo "$title"; ?></h3>

                    <h3 class="mt-3">口コミ内容</h3>
                        <?php echo "<p>$text</p><br>";?>

                    <h3 class="mt-3">評価</h3>
                        <?php if($star == 5 ){  //変数starが5なら星5つを表示
                            echo '<span class="star5_rating" data-rate="5"></span>';
                        }elseif ($star == 4) {  //変数starが4なら星4つを表示
                            echo  '<span class="star5_rating" data-rate="4"></span>';
                        }elseif ($star == 3) {  //変数starが3なら星3つを表示
                            echo '<span class="star5_rating" data-rate="3"></span>';
                        }elseif ($star == 2) {  //変数starが2なら星2つを表示
                        echo '<span class="star5_rating" data-rate="2"></span>';
                        }elseif($star == 1){    //変数starが1なら星1つを表示
                            echo '<span class="star5_rating" data-rate="1"></span>';
                        }
                        ?>
                    <br>
                </div>
            </div>
    <br>
    <?php echo $link1; ?><br>
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

<?php 
//フッター部分のテンプレート
include __DIR__ . '/inc/footer.php'; 
?>