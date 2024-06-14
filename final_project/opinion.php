<?php
session_start();
unset($_SESSION['success_message']);
unset($_SESSION['error_message']);

// 檢查是否有成功訊息
if (isset($_SESSION['success_message'])) {
    // 顯示成功訊息
    echo $_SESSION['success_message'];
    // 清除成功訊息
    unset($_SESSION['success_message']);
}

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

// 檢查是否有登入使用者
if (!isset($_SESSION['username'])) {
    header("Location: index.php"); // 如果沒有登入，導向登入頁面
    exit();
}

// 獲取目前登入使用者的資料
$loggedin_username = $_SESSION['username'];
$sql_loggedin_user = "SELECT * FROM user WHERE name='$loggedin_username'";
$result_loggedin_user = $conn->query($sql_loggedin_user);
$loggedin_user_info = $result_loggedin_user->fetch_assoc();

// 當表單被提交時
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']); // 使用 trim() 函數去除空格
    $email = trim($_POST['email']); // 使用 trim() 函數去除空格
    $role = $_POST['role'];
    $text = $_POST['text'];
    
    // 確認填寫表單的使用者資訊與目前登入者的資料是否符合
    if ($name == $loggedin_user_info['name'] && $email == $loggedin_user_info['email'] && $role == $loggedin_user_info['role']) {
        // 將資料插入資料庫
        $sql = "INSERT INTO opinion (name, email, role, text) VALUES ('$name', '$email', '$role', '$text')";
        
        if ($conn->query($sql) === TRUE) {
            $_SESSION['success_message'] = "意見已成功提交！";
            header("Location: user.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "填寫的使用者資訊與目前登入者資料不符合！";
    }
}

// 關閉連接
$conn->close();
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<!-- <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>意見反饋</title>
    <style>
        /* 全局樣式 */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f3f3f3;
        }
        .container {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
        form {
            margin-top: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="email"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        textarea {
            height: 100px;
        }
        input[type="submit"] {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #555;
        }
    </style>
</head> -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>意見反饋</title>
    <style>
        /* 全局樣式 */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        /* 頁面標題 */
        header {
            background-image: url('header-bg.jpg');
            background-size: cover;
            height: 200px;
            position: relative;
        }

        .header-overlay {
            background-color: rgba(0, 0, 0, 0.5);
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        h1 {
            color: white;
            font-size: 3em;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        /* 導航菜單 */
        nav {
            background-color: #333;
            padding: 15px 0;
            text-align: center;
        }

        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        li {
            display: inline;
            margin-right: 20px;
        }

        a {
            color: white;
            text-decoration: none;
            font-size: 1.2em;
            transition: color 0.3s;
        }

        a:hover {
            color: #ff7f00;
        }

        .container {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
        form {
            margin-top: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="email"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        textarea {
            height: 100px;
        }
        .button-container{
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }
        input[type="submit"] {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #555;
        }

    </style>
</head>
<body>
    <header>
        <div class="header-overlay">
            <h1>意見反饋</h1>
        </div>
    </header>
    <nav>
        <ul>
            <li><a href="user.php">商品介面</a></li>
            <li><a href="add_to_cart.php">訂購清單</a></li>
            <li><a href="opinion.php">客服中心</a></li>
            <li><a href="notification.php">通知</a></li>
            <li><a href="user_info.php">個人資料</a></li>
            <li><a href="logout.php">登出</a></li>
        </ul>
    </nav>
    <div class="container">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="name">使用者名稱:</label>
            <input type="text" id="name" name="name" required>
            
            <label for="email">電子郵件:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="role">身分:</label>
            <select id="role" name="role">
                <option value="user">一般使用者</option>
                <option value="initiator">團購主</option>
            </select>
            
            <label for="text">想說的話:</label>
            <textarea id="text" name="text" required></textarea>

            <div class="button-container">
                <input type="submit" value="傳送">
            </div>
        </form>
    </div>
</body>
</html>
