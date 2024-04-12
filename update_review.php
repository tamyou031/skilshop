<!-- 口コミ更新完了画面 -->

<?php
//データベース接続
$dsn = "mysql:host=127.0.0.1:3309; dbname=skilshop";
$u_name = "root";
$p_word = "";
try {
    $dbh = new PDO($dsn,$u_name,$p_word);
    if($_SERVER["REQUEST_METHOD"] == "POST"){ //POSTで送信されたか確認
    //変数checkに$_POST["star"]の値（1～5）を代入し、それ以外の数値であれば0を代入
    $check = isset($_POST["star"]) ? $_POST["star"] : 0;  
    $star = $check;
}
    // 口コミ（reviews）テーブルへedit_review.phpから送信された値を上書き
    $sql = "UPDATE reviews SET title = :title, text = :text,star = :star WHERE review_id = :review_id";
    $stmt = $dbh->prepare($sql);
    // 各プレースホルダーにPOSTで送信された値を代入
    $stmt->execute(array(':title' => $_POST['title'], ':text' => $_POST['text'],'star' => $star, ':review_id' => $_POST['id']));

     echo "情報を更新しました。";
} catch (PDOException $e) {
    echo 'エラーが発生しました。:' . $e->getMessage();
}

?>
<!-- 更新完了を表示する -->
<title>更新完了</title>
  <body>          
    <p>
        <a href="index.php">トップへ</a>
    </p> 
  </body>
</html>