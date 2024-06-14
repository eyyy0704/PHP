<?php
session_start();
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

        .product button {
            background-color: #ff7f00;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .product2:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .product button:hover {
            background-color: #ff9933;
        }

        .product2 {
            width: calc(30% - 50px); /* 每個商品佔三分之一 */
            margin-bottom: 40px; /* 商品之間的垂直間距 */
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .product2 img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .product-info2 {
            text-align: center;
        }

        .product2 h2 {
            font-size: 1.3em;
            margin-top: 0;
            margin-bottom: 10px;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .quantity-controls button {
            margin: 0 5px;
            padding: 5px 10px;
            border: none;
            border-radius: 3px;
            background-color: #ccc;
            cursor: pointer;
            align-items: center;
        }

        .quantity {
            font-weight: bold;
        }

    </style>
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
    <main>
        <section class="product-list">
            <!-- 商品列表 -->
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

            // 查詢商品資料 + 取得銷售數量
            $sql = "SELECT * FROM product";
            $result = $conn->query($sql);
    
            $now = new DateTime("now", new DateTimeZone('Asia/Taipei'));
            $nowString = $now->format('Y-m-d H:i:s');
            
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    //$productId = $row['id'];
                    //$joined = $row['joined'];
                    //$required_quantity = $row['required_quantity'];
                    $deadline = new DateTime($row['deadline'], new DateTimeZone('Asia/Taipei'));
                    $deadlineString = $deadline->format('Y-m-d H:i:s');
                    
                    if ($nowString < $deadlineString) {
                        echo "<div class='product' data-product-id='" . $row['id'] . "'>";
                        echo "<img src='" . $row['image'] . "' alt='Product'>";
                        echo "<div class='product-info'>";
                        echo "<h2>" . $row['pname'] . "</h2>";
                        echo "<p>價格：" . $row['price'] . "</p>";
                        echo "<p>目標數量：" . $row['required_quantity'] . "</p>";
                        echo "<p>商品描述：" . $row['description'] . "</p>";
                        echo "<p>收單時間：" . $row['deadline'] . "</p>";
                        if($row['required_quantity'] - $row['joined'] > 0 )
                            echo "<p class='joined'>距離目標數量：<span class='joined-count'>" . $row['required_quantity'] - $row['joined'] ."</p>";
                        else
                            echo "<p>已達目標數量</p>";
                        echo "<div class='quantity-controls'>";
                        echo "<button class='subtract'>-</button>";
                        echo "<span class='quantity'>1</span>";
                        echo "<button class='add'>+</button>";
                        echo "</div>";
                        echo "<br/><button class='add-to-cart' data-uname='" . $_SESSION['username'] . "' data-uemail='" . $_SESSION['email'] . "'>加入</button>";
                        echo "</div>";
                        echo "</div>";
                    }else{
                        echo "<div class='product2' data-product-id='" . $row['id'] . "'>";
                        echo "<img src='" . $row['image'] . "' alt='Product'>";
                        echo "<div class='product-info2'>";
                        echo "<h2>" . $row['pname'] . "</h2>";
                        echo "<h3>收單時間已過</h3>";
                        echo "</div>";
                        echo "</div>";
                    }
                }
            }else {
                echo "<p>暫無商品</p>";
            }
            

            // 關閉連接
            $conn->close();
            ?>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const products = document.querySelectorAll('.product');

            products.forEach(product => {
                const joinedCount = product.querySelector('.joined-count');
                const quantity = product.querySelector('.quantity');
                const subtractBtn = product.querySelector('.subtract');
                const addBtn = product.querySelector('.add');
                const addToCartBtn = product.querySelector('.add-to-cart');

                subtractBtn.addEventListener('click', function() {
                    let count = parseInt(quantity.textContent);
                    if (count > 1) {
                        count--;
                        quantity.textContent = count;
                    }
                });

                addBtn.addEventListener('click', function() {
                    let count = parseInt(quantity.textContent);
                    count++;
                    quantity.textContent = count;
                });

                addToCartBtn.addEventListener('click', function() {
                    const productId = product.dataset.productId; 
                    const quantityValue = parseInt(quantity.textContent);
                    const now = new Date(); // 獲取當前時間
                    const taiwanTime = now.toLocaleString('zh-TW', { timeZone: 'Asia/Taipei' });
                    const data = new FormData();
                    data.append('productId', productId);
                    data.append('quantity', quantityValue);
                    data.append('taiwanTime', taiwanTime);
                   
                    fetch('add_to_cart.php', {
                        method: 'POST',
                        body: data
                    })
                    .then(response => response.text())
                    .then(data => {
                        console.log(data); // 處理後端回傳的響應
                        // 更新距離目標數
                        if(quantityValue < parseInt(joinedCount.textContent)){
                            joinedCount.textContent = parseInt(joinedCount.textContent) - quantityValue;
                        }
                        else{
                            joinedCount.textContent = "已達成";
                        }
                        
                        // 同時清空數量的計數
                        quantity.textContent = '1';
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                    window.location.href = 'add_to_cart.php';
                });
            });
        });
    </script>
</body>
</html>
