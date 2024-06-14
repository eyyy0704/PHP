<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {

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

    // 接收表單提交的資料
    $productName = $_POST['productName'];
    $productPrice = $_POST['productPrice'];
    $productDescription = $_POST['productDescription'];
    $deadline = $_POST['deadline'];
    $requiredQuantity = $_POST['requiredQuantity'];

    // 上傳圖片
    $target_dir = "images/"; // 上傳目錄
    $target_file = $target_dir . basename($_FILES["Image"]["name"]); // 上傳文件路徑
    move_uploaded_file($_FILES["Image"]["tmp_name"], $target_file); // 上傳文件

    // 獲取團購主名稱和電子郵件
    $username = $_SESSION['username'];
    $sql_user_info = "SELECT * FROM user WHERE name='$username'";
    $result_user_info = $conn->query($sql_user_info);
    $user_info = $result_user_info->fetch_assoc();
    $iname = $user_info['name']; // 團購主名稱
    $iemail = $user_info['email']; // 團購主電子郵件

    // 檢查是否所有必填字段都有值
    if (!empty($productName) && !empty($productPrice) && !empty($productDescription) && !empty($deadline) && !empty($requiredQuantity)) 
    {
        // 將資料插入資料庫
        $sql = "INSERT INTO product (pname, price, description, deadline, required_quantity, image, joined, iname, iemail) 
                VALUES ('$productName', '$productPrice', '$productDescription', '$deadline', '$requiredQuantity', '$target_file', '0', '$iname', '$iemail')";
        $sql2 = "INSERT INTO list (uid, uname, uemail, amount, iname, iemail, product_name, TWtime) 
                VALUES ('0', '0', '0', '0', '0', '0', '$productName', '0')";

        if ($conn->query($sql) == TRUE && $conn->query($sql2) == TRUE) {
            // 成功新增商品後跳轉到 initiator.php
            $_SESSION['success_message'] = "成功新增商品";
            header("Location: initiator.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } 
    else 
    {
        echo "請填寫所有必填欄位。";
    }
    // 獲取個人頭像和名稱
    $username = $_SESSION['username'];
    $sql_user_info = "SELECT * FROM user WHERE name='$username'";
    $result_user_info = $conn->query($sql_user_info);
    $user_info = $result_user_info->fetch_assoc();

    // 關閉連接
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>團購主介面</title>
    <style>
        /* 全局樣式 */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f3f3f3;
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
            margin: 0 auto;
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
        /* 主菜單 */
        .menu {
            text-align: center;
            margin-bottom: 20px;
        }
        .menu a {
            text-decoration: none;
            color: #333;
            padding: 10px 20px;
            margin: 0 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f0f0f0;
            transition: background-color 0.3s ease;
        }
        .menu a:hover {
            background-color: #ddd;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-top: 10px;
            color: #333;
        }

        input, textarea, select {
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<div class="header">
        <h1>歡迎來到小張團購網 - 團購主介面</h1>
    </div>
    <div class="container">
        <div class="menu">
            <a href="initiator.php">商品列表</a>
            <a href="initiator_info.php">更改個人資訊</a>
            <a href="opinion2.php">客服中心</a>
            <a href="logout.php">登出</a>
        </div>
        <h1>新增商品</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
            <label for="productName">商品名稱</label>
            <input type="text" id="productName" name="productName" required>

            <label for="productPrice">商品價格</label>
            <input type="number" id="productPrice" name="productPrice" min="0" required>

            <label for="productDescription">商品描述</label>
            <textarea id="productDescription" name="productDescription" rows="4" required></textarea>

            <label for="deadline">收單時間</label>
            <input type="datetime-local" id="deadline" name="deadline" required>

            <label for="requiredQuantity">所需人數</label>
            <input type="number" id="requiredQuantity" name="requiredQuantity" min="1" required>

            <label for="productImage">上傳商品圖片</label>
            <input type="file" id="Image" name="Image"  required>

            <input type="submit" value="新增商品">
        </form>
    </div>
</body>
</html>
