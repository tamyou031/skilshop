<!-- csrf対策用のトークンチェック処理 -->

<?php
// セッションが始まっていない場合はセッションを始める
if(!isset($_SESSION)){
    session_start();
}
// トークンのPOSTがない場合は終了
if(empty($_POST['token'])){
    echo "エラーが発生しました。";
    exit;
}
// トークンが違う場合も同様に終了
if(!(hash_equals($_SESSION['token'],$_POST['token']))){
    echo "エラーが発生しました。（２）";
    exit;
}