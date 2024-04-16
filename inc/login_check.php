<!-- ログインしているかを確認 -->

<?php

if(empty($_SESSION['login'])){
    echo "このページへアクセスするには、<a href = 'login_test.php'>ログイン</a>が必要です。";
    exit;
}
?>
