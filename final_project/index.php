<?php
// 資料庫連線設定
$servername = "localhost";
$username = "id22313627_admin"; // 修改為您的資料庫用戶名
$password = "Admin_123"; // 修改為您的資料庫密碼

// 建立資料庫連線
$conn = new mysqli($servername, $username, $password);

// 檢查連線
if ($conn->connect_error) {
    die("連接失敗：" . $conn->connect_error);
}

// 建立資料庫
$sql_create_db = "CREATE DATABASE IF NOT EXISTS id22313627_project";
$conn->query($sql_create_db);

// 選擇資料庫
$conn->select_db("id22313627_project");

// 檢查是否存在管理員帳戶，如果不存在，則創建
$result = $conn->query("SELECT * FROM user WHERE role = 'admin'");
if ($result->num_rows == 0) {
    // 創建管理員帳戶
    $adminUsername = '大雄';
    $adminPassword = '1111'; // 您可以使用安全的密碼加密方式來設置密碼
    $adminRole = 'admin';
    $adminEmail = 'admin@gmail.com';

    // 執行資料庫插入操作
    $sql = "INSERT INTO user (name, password, role, img, email)
            VALUES ('$adminUsername', '$adminPassword', '$adminRole', '', '$adminEmail')";
    $conn->query($sql);
}

// 關閉資料庫連線
$conn->close();
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登入</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f3f3f3;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background-color: #ffffcc; /* 淡黃色 */
            padding: 40px; /* 增加填充 */
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            width: 350px; /* 增加寬度 */
            text-align: center;
        }
        .login-container h2 {
            margin-bottom: 30px; /* 增加下邊距 */
            text-align: center;
            font-size: 2em; /* 字體更大 */
            font-weight: bold; /* 字體更粗 */
            color: #333;
        }
        .login-container p {
            margin-bottom: 20px;
            color: #666;
        }
        .login-container form {
            display: flex;
            flex-direction: column;
        }
        .login-container form input[type="text"],
        .login-container form input[type="password"],
        .login-container form select {
            margin-bottom: 20px; /* 增加下邊距 */
            padding: 12px; /* 增加填充 */
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 1.1em; /* 字體更大 */
        }
        .login-container form input[type="submit"] {
            background-color: #4caf50; /* 綠色 */
            color: #fff;
            border: none;
            padding: 12px; /* 增加填充 */
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 1.1em; /* 字體更大 */
        }
        .login-container form input[type="submit"]:hover {
            background-color: #45a049; /* 深綠色 */
        }
        .register-link {
            text-align: center;
            margin-top: 20px; /* 增加上邊距 */
        }
        .register-link a {
            color: #007bff; /* 藍色 */
            text-decoration: underline; /* 加底線 */
            position: relative; /* 讓箭頭相對於文字 */
        }
        .register-link a::before {
            content: ' ►'; /* 加上箭頭 */
            position: relative;
            right: 0px; /* 與文字間距 */
            top: 0;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>歡迎來到小張團購網</h2>
        <?php
        // 檢查 URL 中的 registration 參數是否為 success，如果是，則顯示註冊成功的訊息
        if (isset($_GET['registration']) && $_GET['registration'] === 'success') {
            echo '<p style="color: green;">註冊成功，請重新登入</p>';
        }
        ?>
        <p>請先登入方可進入網站</p>
        <form action="check.php" method="POST">
            <input type="text" name="username" placeholder="使用者名稱" required>
            <input type="password" name="password" placeholder="密碼" required>
            <select name="role" required>
                <option value="">選擇身份</option>
                <option value="user">一般使用者</option>
                <option value="initiator">團購主</option>
                <option value="admin">管理員</option>
            </select>
            <input type="submit" value="登入">
        </form>
        <div class="register-link">
            <a href="register.php">你還沒有帳號嗎？點此註冊</a>
        </div>
    </div>
</body>
</html>
