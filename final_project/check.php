<?php
session_start();

// 資料庫連線設定
$servername = "localhost";
$username = "id22313627_admin"; // 修改為您的資料庫用戶名
$password = "Admin_123"; // 修改為您的資料庫密碼
$dbname = "id22313627_project"; // 資料庫名稱

// 創建連接
$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連接
if ($conn->connect_error) {
    die("連接失敗：" . $conn->connect_error);
}

// 接收來自 index.php 的 POST 資料
$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];

// 檢查資料庫中是否有相符的使用者
$sql = "SELECT * FROM user WHERE name='$username' AND password='$password' AND role='$role'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // 使用者存在，設定 session
    $_SESSION['username'] = $username;
    $_SESSION['password'] = $password;
    $_SESSION['role'] = $role;
    
    // 從資料庫中獲取使用者的電子郵件、ID、照片
    $userData = $result->fetch_assoc();
    $_SESSION['email'] = $userData['email'];
    $_SESSION['user_id'] = $userData['id'];
    $_SESSION['img'] = $userData['img'];

    // 釋放結果集
    $result->free();

    // 關閉連接
    $conn->close();

    // 根據使用者的角色導向到相應的介面
    switch ($role) {
        case 'user':
            header("Location: user.php");
            break;
        case 'initiator':
            header("Location: initiator.php");
            break;
        case 'admin':
            header("Location: admin.php");
            break;
        default:
            // 如果角色未知，導向登出的頁面
            header("Location: logout.php");
            break;
    }
    exit();
} else {
    // 使用者不存在，導向登出的頁面
    header("Location: logout.php");
    exit();
}
?>
