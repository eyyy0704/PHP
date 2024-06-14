<?php
session_start();
$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 连接到数据库
    $servername = "localhost";
    $username = "id22313627_admin"; // 修改为您的数据库用户名
    $password = "Admin_123"; // 修改为您的数据库密码
    $dbname = "id22313627_project"; // 数据库名称

    $conn = new mysqli($servername, $username, $password, $dbname);

    // 检查连接
    if ($conn->connect_error) {
        die("连接失败：" . $conn->connect_error);
    }

    // 获取表单数据
    $name = $_POST['name'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    $target_dir = "uploads/"; // 上傳目錄
    $target_file = $target_dir . basename($_FILES["img"]["name"]); // 上傳文件路徑
    move_uploaded_file($_FILES["img"]["tmp_name"], $target_file); // 上傳文件

    // 更新数据库中的记录
    $sql = "UPDATE user SET name = '$name', password = '$password', email = '$email', img = '$target_file' WHERE id = '$user_id'";
    $sql2 = "UPDATE list SET uname = '$name', uemail = '$email' WHERE id = '$user_id'";
    if ($conn->query($sql) === TRUE) {
        header("Location: user_info.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // 关闭数据库连接
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>小張團購網</title>
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

        /* 個人資訊 */
        .profile-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 18px;
        }

        .profile-item {
            background-color: #fff;
            width: 400px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .profile-item label {
            font-weight: bold;
            display: block;
            margin-bottom: 8px;
        }

        .profile-item input[type="text"],
        .profile-item input[type="email"] {
            width: 95%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            display: flex;
            justify-content: center;
        }

        .profile-item input[disabled] {
            background-color: #e9e9e9;
        }

        .profile-item input[type="file"] {
            margin-bottom: 8px;
        }

        .profile-item .button-container {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }

        .profile-item button {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .profile-item button:hover {
            background-color: #45a049;
        }

        .profile-item img {
            max-width: 100%;
            height: auto;
            margin-top: 10px;
            border-radius: 8px;
        }

    </style>
    <script>
        function enableEditing() {
            document.getElementById('name').disabled = false;
            document.getElementById('password').disabled = false;
            document.getElementById('email').disabled = false;
            document.getElementById('profile-pic-row').style.display = 'block';
            document.getElementById('update-button').style.display = 'none';
            document.getElementById('save-button').style.display = 'block';
        }
    </script>
</head>
<body>
    <header>
        <div class="header-overlay">
            <h1>小張團購網</h1>
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
    <div class="profile-container">
        <?php            
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

            // 取得user資料
            $sql = "SELECT * FROM user WHERE id = '$user_id'";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $user_name = $row['name'];
                    $password = $row['password'];
                    $email = $row['email'];
                    $img = $row['img'];
                }
            }

            // 關閉連接
            $conn->close();
        ?>
        <form class="profile-item" action="user_info.php" method="post" enctype="multipart/form-data">
            <img id="profile-image" src=<?php echo $img; ?> alt="Profile Picture">

            <div id="profile-pic-row" style="display: none;">
                <label for="profile-pic">編輯照片</label>
                <input type="file" id="img" name="img">
            </div>

            <label for="name">名字</label>
            <input type="text" id="name" name="name" value= <?php echo $user_name; ?> disabled>

            <label for="password">密碼</label>
            <input type="text" id="password" name="password" value= <?php echo $password; ?> disabled>
            
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value=<?php echo $email; ?> disabled>
            
            <div class="button-container">
                <button type="button" id="update-button" onclick="enableEditing()">修改資訊</button>
                <button type="submit" id="save-button" style="display: none;">儲存</button>
            </div>
        </form>
    </div>
</body>
