<!-- サービス更新完了画面 -->

<?php
//ヘッダー部分のテンプレート
require_once __DIR__ . '/token_check.php';

//データベース処理
$dsn = "mysql:host=127.0.0.1:3309; dbname=skilshop";
$u_name = "root";
$p_word = "";
try {
    if((preg_match('/^[0-9]+$/',$_POST['price']))){ //料金が全て数字で送信されているかチェック
      //データベースへ接続
      $dbh = new PDO($dsn,$u_name,$p_word);
      //登録内容を更新
      $sql = "UPDATE make_service SET title = :title, text = :text,price = :price WHERE service_id = :service_id";
      $stmt = $dbh->prepare($sql);
      //プレースホルダーにedit.phpにて送信されたものを代入し、内容に更新する
      $stmt->execute(array(':title' => $_POST['title'], ':text' => $_POST['text'],'price' => $_POST['price'], ':service_id' => $_POST['id']));
      echo "情報を更新しました。";
  }else{
    $id = $_POST['id'];
  }    
} catch (PDOException $e) {
    echo 'エラーが発生しました。:' . $e->getMessage();
}

?>

<title>更新完了</title>
  <body>
    <div class="container px-4">
      <!-- 料金が数字で入力されてない場合はエラー表示する -->
      <?php if(!(preg_match('/^[0-9]+$/',$_POST['price']))):?>
        <p>料金は半角数字で入力してください。</p>
        <a href="edit.php?id=<?php echo $id ?>">戻る</a><br>
      <?php endif ?>
          <a href="index.php">トップへ</a>
    </div>
  </body>
</html>