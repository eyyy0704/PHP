<?php
// 啟動會話
session_start();

// 清除所有會話變數
$_SESSION = array();

// 如果要清除的是使用 cookie 建立的會話，同時刪除 cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 最後銷毀會話
session_destroy();

// 導回到登入頁面
header("Location: index.php");
exit();
?>
