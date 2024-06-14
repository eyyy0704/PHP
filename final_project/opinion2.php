<?php
session_start();

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

if (!isset($_SESSION['username'])) {
    header("Location: index.php"); // 如果沒有登入，導向登入頁面
    exit();
}

// 獲取個人頭像和名稱
$username = $_SESSION['username'];
$sql_user_info = "SELECT * FROM user WHERE name='$username'";
$result_user_info = $conn->query($sql_user_info);
$user_info = $result_user_info->fetch_assoc();

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
            header("Location: initiator.php");
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
            background-color: #f3f3f3;
        }
        /* 頁面標題 */
        /* header {
            background-image: url('header-bg.jpg');
            background-size: cover;
            height: 200px;
            position: relative;
        } */
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

        /* h1 {
            color: white;
            font-size: 3em;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        } */

        /* 導航菜單 */
        nav {
            background-color: #333;
            padding: 15px 0;
            text-align: center;
            display: flex;
            justify-content: center; 
            align-items: center;
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
        .header {
            background-color: #333;
            color: white;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }
        .container {
            max-width: 800px;
            margin: /* 0px */ 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        /* 用戶信息 */
        .user-info {
            text-align: center;
            margin-bottom: 20px;
        }
        .user-info img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
            border: 4px solid #fff; /* 白色外框 */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* 陰影效果 */
        }
        .user-info p {
            margin: 0;
            font-size: 18px;
            color: #555;
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
            display: flex;
            justify-content: center; 
            align-items: center;
        }
        textarea {
            height: 100px;
            display: flex;
            justify-content: center; 
            align-items: center;
        }
        
        /* 主菜單 */
        .menu {
            text-align: center;
            margin-bottom: 20px;
        }
        .menu a {
            text-decoration: none;
            font-size: 14px;
            color: #333;
            padding: 10px 20px;
            margin: 0 6px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f0f0f0;
            transition: background-color 0.3s ease;
        }
        .menu a:hover {
            background-color: #ddd;
        }
        .button-container{
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
    <header>
        <div class="header">
            <h1>意見反饋</h1>
        </div>
    </header>
    <div class="container">
        <div class="user-info">
            <img src="<?php echo $user_info['img']; ?>" alt="個人頭像">
            <p>歡迎，<?php echo $user_info['name']; ?>！</p>
        </div>
        <div class="menu">
            <a href="initiator.php">商品列表</a>
            <a href="add.php">新增商品</a>
            <a href="ini_profile.php">更改個人資訊</a>
            <!-- <a href="opinion2.php">客服中心</a> -->
            <a href="logout.php">登出</a>
        </div>
   <!--  </div>    
    <div class="container"> -->
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
            <script>
                function showConfirmation() {
                alert("已成功送出！");
                return true; // 表示表单可以提交
            }
    </script>
        </form>
    </div>
</body>
</html>
