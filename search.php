<!-- ヘッダー部分の検索機能 -->

<?php
//ヘッダー部分のテンプレート
include __DIR__ . '/inc/header.php';
?>

<?php
//データベースへ接続
$dsn = "mysql:host=127.0.0.1:3309; dbname=skilshop";
$u_name = "root";
$p_word = "";
try{
    $dbh = new PDO($dsn,$u_name,$p_word);
    //make_serviceテーブルのタイトルから文字が一部でも一致していれば選択
    $sql = "SELECT * FROM make_service WHERE  title LIKE '%" . $_POST["search_name"] . "%'";    
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
} catch(PDOException $e){
    echo "失敗:" . $e->getMessage() . "\n";
    exit();
}

?>

<html>
    <title>検索結果</title>
    <body>
        <div class="container px4">
            <table>
                <tr><th class="fs-4">検索結果</th></tr>
                <!-- foreachを使って結果をループさせる -->
                <?php foreach ($stmt as $row): ?>
                    <tr>
                        <td><a href="service.php?id=<?php echo $row[0] ?>"><?php echo $row[2]?></a></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </body>
</html>