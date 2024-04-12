<!-- 口コミ詳細画面 -->

<?php
//ヘッダー部分のテンプレート
include __DIR__ . '/inc/header.php';
//XSS用の関数を読み込み
require_once 'function.php';
?>

<?php
//データベースへ接続
if(isset($_GET['id'])){
    $id = $_GET['id'];
}
$dsn = "mysql:host=127.0.0.1:3309; dbname=skilshop";
$u_name = "root";
$p_word = "";
try{
    $dbh = new PDO($dsn,$u_name,$p_word);
} catch(PDOException $e){
    $msg = $e->getMessage();
}

//reviewsテーブルからデータを取得
$sql_r = "SELECT * FROM reviews WHERE review_id=$id";
$stmt_r = $dbh->query($sql_r);
$result_r = $stmt_r->fetch();
$star = $result_r['star'];
?>

<title>口コミ：<?php echo str2html($result_r[3]) ; ?></title>
<body>
    <div class="container px-3">
    <!-- 口コミのタイトルと内容を表示 -->
    <h2>口コミ：<?php echo str2html($result_r['title']) ; ?> </h2>
        <p class="my-3"><?php echo str2html($result_r['text']) ; ?></p>
    <!-- 星評価を表示 -->
    <h3>評価</h3>
    <?php if($star ==5 ){
                    echo '<span class="star5_rating" data-rate="5"></span>';    // 変数starが5なら星5つを表示
                }elseif ($star ==4) {
                    echo  '<span class="star5_rating" data-rate="4"></span>';   // 変数starが4なら星4つを表示
                }elseif ($star ==3) {
                    echo '<span class="star5_rating" data-rate="3"></span>';    // 変数starが3なら星3つを表示
                }elseif ($star ==2) {
                echo '<span class="star5_rating" data-rate="2"></span>';    // 変数starが2なら星2つを表示
                }elseif($star == 1){
                echo '<span class="star5_rating" data-rate="1"></span>';    // 変数starが1なら星1つを表示
            }
            ?><br>
        <p class="mt-4"><a href="user_admin.php">ユーザーメニュー</a></p>
    </div>
</body>

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

