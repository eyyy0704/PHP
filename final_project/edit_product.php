<?php
session_start();
$user_id = $_SESSION['user_id'];

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

// 查詢目前新增了哪些商品，包括團購主的名稱和電子郵件
$sql_products = "SELECT p.*, u.name AS iname, u.email AS iemail FROM product p INNER JOIN user u ON p.iname = u.name";
$result_products = $conn->query($sql_products);

// 獲取個人頭像和名稱
$username = $_SESSION['username'];
$sql_user_info = "SELECT * FROM user WHERE name='$username'";
$result_user_info = $conn->query($sql_user_info);
$user_info = $result_user_info->fetch_assoc();

// 關閉連接
$conn->close();
?>

<!DOCTYPE html>
<html lang="zh-Hant">
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
        /* 商品列表 */
        .product-list {
            margin-top: 20px;
        }
        .product-item {
            display: flex;
            align-items: center;
            border: 1px solid #ccc;
            margin-bottom: 20px;
            border-radius: 5px;
            overflow: hidden; /* 隱藏圖片溢出部分 */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* 陰影效果 */
        }
        .product-item img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            float: left; /* 左浮動 */
            margin-right: 20px;
        }
        .product-item button {
            padding: 10px;
        }
        .product-button button {
            padding: 10px;
            background-color: lightslategray;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .product-button button:hover {
            background-color: #45a049;
        }
        .product-details {
            padding: 20px;
            background-color: #fff;
        }
        .product-details h3 {
            margin-top: 0;
            color: #333;
        }
        .product-details p {
            margin: 10px 0;
            color: #666;
        }
    </style>
    <script>
    function turnToPage() {
    // 將用戶重定向到 edit_product.php 頁面
    window.location.href = "initiator.php";
    }
    
</script>
</head>
<body>
    <div class="header">
        <h1>歡迎來到小張團購網 - 團購主介面</h1>
    </div>
    <div class="container">
        <div class="user-info">
            <img src="<?php echo $user_info['img']; ?>" alt="個人頭像">
            <p>歡迎，<?php echo $user_info['name']; ?>！</p>
        </div>
        <div class="menu">
            <a href="add.php">新增商品</a>
            <a href="initiator_info.php">更改個人資訊</a>
            <a href="opinion2.php">客服中心</a>
            <a href="logout.php">登出</a>
        </div>
        <div class="product-list">
            <h2>商品列表：</h2>
            <?php if ($result_products->num_rows > 0): ?>
                <?php while($row = $result_products->fetch_assoc()): ?>
                    <form method="post" action="initiator.php">
                    <div class="product-item">
                    <img src="<?php echo $row['image']; ?>" alt="商品圖片">
                    <div class="product-details">
                    <p>商品名稱：<input type="text" name="name" value="<?php echo $row['pname']; ?>"></p>
                    <p>商品描述：<input type="text" name="description" value="<?php echo $row['description']; ?>"></p>
                    <p>價格：<input type="text" name="price" value="<?php echo $row['price']; ?>">元</p>
                    <p>收單時間：<input type="text" name="deadline" value="<?php echo $row['deadline']; ?>"></p>
                    <p>所需人數：<input type="text" name="required_quantity" value="<?php echo $row['required_quantity']; ?>"></p>
                    </div>
                    <div class="product-button">
                        <button type="submit" class="save" onclick="turnToPage()">儲存</button>
                    </div>
                    </div>
                    </form>

                <?php endwhile; ?>
            <?php else: ?>
                <p>目前沒有新增任何商品。</p>
            <?php endif; ?>
        </div>
    </div>
    <!-- <script>
    document.addEventListener('DOMContentLoaded', function() {
    const products = document.querySelectorAll('.product-item');

    products.forEach(product => {
        const name = product.querySelector('.name');
        const decsription = product.querySelector('.decsription');
        const price = product.querySelector('.price');
        const deadline = product.querySelector('.deadline');
        const require_quantity = product.querySelector('.require_quantity');
        const saveBtn = product.querySelector('.save');

        saveBtn.addEventListener('click', function() {
            //const form = product.querySelector('form');
            const Name = name.textContent;
            const Decsription = Decsription.textContent;
            const Price = price.textContent;
            const Deadline = deadline.textContent;
            const Require_quantity = Require_quantity.textContent;
            const formData = new FormData();
            formData.append('name', Name);
            formData.append('description', Decsription);
            formData.append('price', Price);
            formData.append('deadline', Deadline);
            formData.append('require_quantity', Require_quantity);

            fetch('initiator.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                console.log(data);
                alert("商品資訊已成功更新！");
            })
            .catch((error) => {
                console.error('Error:', error);
                alert("更新商品資訊時出現錯誤！");
            });
            
        });
    });
});

</script> -->

</body>
</html>
