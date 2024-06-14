<?php
session_start();

// 資料庫連線設定
$servername = "localhost";
$username = "id22313627_admin";
$password = "Admin_123";
$dbname = "id22313627_project";

// 創建連接
$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連接
if ($conn->connect_error) {
    die("連接失敗：" . $conn->connect_error);
}

// 取得已結單商品資料
$sql = "SELECT * FROM product WHERE joined >= required_quantity";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>已結單商品</title>
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

        /* 商品列表 */
        .product-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            padding: 20px;
        }

        .product {
            width: calc(30% - 50px); /* 每個商品佔三分之一 */
            margin-bottom: 40px; /* 商品之間的垂直間距 */
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .product:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .product img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .product-info {
            text-align: center;
        }

        .product h2 {
            font-size: 1.3em;
            margin-top: 0;
            margin-bottom: 10px;
        }

        .product p {
            margin: 5px 0;
            font-size: 0.9em;
            color: #666;
        }

    </style>
</head>
<body>
    <header>
        <div class="header-overlay">
            <h1>已結單商品</h1>
        </div>
    </header>
    <nav>
        <ul>
            <li><a href="admin.php">管理頁面</a></li>
            <li><a href="receive.php">意見回饋</a></li>
            <li><a href="logout.php">登出</a></li>
        </ul>
    </nav>
    <main>
        <section class="product-list">
            <!-- 顯示已結單商品 -->
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='product' data-product-id='" . $row['id'] . "'>";
                    echo "<img src='" . $row['image'] . "' alt='Product'>";
                    echo "<div class='product-info'>";
                    echo "<h2>" . $row['pname'] . "</h2>";
                    echo "<p>總數量：" . $row['joined'] . "</p>";
                    echo "<p>總金額：" . $row['joined'] * $row['price'] . "</p>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p>暫無已結單商品</p>";
            }

            // 關閉連接
            $conn->close();
            ?>
        </section>
    </main>
</body>
</html>
