<?php
// 處理表單提交
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 連接到資料庫
    $servername = "localhost";
    $username = "id22313627_admin"; // 修改為您的資料庫用戶名
    $password = "Admin_123"; // 修改為您的資料庫密碼
    $dbname = "id22313627_project"; // 資料庫名稱

    // 建立連接
    $conn = new mysqli($servername, $username, $password, $dbname);

    // 檢查連接
    if ($conn->connect_error) {
        die("連接失敗：" . $conn->connect_error);
    }

    // 接收表單提交的資料
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $email = $_POST['email'];

    // 上傳使用者頭像
    $target_dir = "uploads/"; // 上傳目錄
    $target_file = $target_dir . basename($_FILES["img"]["name"]); // 上傳文件路徑
    move_uploaded_file($_FILES["img"]["tmp_name"], $target_file); // 上傳文件

    // 執行資料庫插入操作
    $sql = "INSERT INTO user (name, password, role, img, email)
            VALUES ('$username', '$password', '$role', '$target_file', '$email')";

    if ($conn->query($sql) === TRUE) {
        // 註冊成功，導回登入頁面
        header("Location: index.php?registration=success");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // 關閉連接
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>註冊</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .register-container {
            background-color: #ffffcc;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }
        .register-container h2 {
            margin-bottom: 20px;
            text-align: center;
            font-size: 2em;
            font-weight: bold;
            color: #333333;
        }
        .register-container form {
            display: flex;
            flex-direction: column;
        }
        .register-container form input[type="text"],
        .register-container form input[type="password"],
        .register-container form input[type="file"],
        .register-container form select,
        .register-container form input[type="email"] {
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #cccccc;
            outline: none;
            transition: border-color 0.3s ease;
        }
        .register-container form input[type="text"]:focus,
        .register-container form input[type="password"]:focus,
        .register-container form input[type="file"]:focus,
        .register-container form select:focus,
        .register-container form input[type="email"]:focus {
            border-color: #4caf50;
        }
        .register-container form input[type="submit"] {
            background-color: #4caf50;
            color: #ffffff;
            border: none;
            padding: 15px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .register-container form input[type="submit"]:hover {
            background-color: #45a049;
        }
        .register-container form input[type="file"] {
            padding: 10px;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>註冊</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
            <input type="text" name="username" placeholder="使用者名稱" required>
            <input type="password" name="password" placeholder="密碼" required>
            <select name="role" required>
                <option value="">選擇身份</option>
                <option value="user">一般使用者</option>
                <option value="initiator">團購主</option>
            </select>
            <input type="file" name="img" required>
            <input type="email" name="email" placeholder="電子郵件" required>
            <input type="submit" value="註冊">
        </form>
    </div>
</body>
</html>
