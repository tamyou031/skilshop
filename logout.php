<!-- ログアウト処理 -->

<?php
    //セッションスタート
    session_start();
    //セッション変数の初期化
    $_SESSION = array();
    //セッションの破棄
    session_destroy();
    //トップメニューへ移動
    header("Location:index.php");
?>