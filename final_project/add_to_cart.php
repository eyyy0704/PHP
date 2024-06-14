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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 接收表單提交的資料
    $productId = $_POST['productId'];
    $quantity = $_POST['quantity'];
    $taiwanTime = $_POST['taiwanTime'];
    $uname = $_SESSION['username']; // 從 session 中取得目前登入者名稱
    
    // 查詢目前登入者的電子郵件
    $sql_email = "SELECT email FROM user WHERE name='$uname'";
    $result_email = $conn->query($sql_email);
    $row_email = $result_email->fetch_assoc();
    $uemail = $row_email['email']; // 從資料庫中取得目前登入者的電子郵件
    
    // 查詢商品資訊，包括團購主的名稱和電子郵件
    $sql_product_info = "SELECT pname, iname, iemail FROM product WHERE id='$productId'";
    $result_product_info = $conn->query($sql_product_info);
    $row_product_info = $result_product_info->fetch_assoc();
    $pname = $row_product_info['pname'];
    $iname = $row_product_info['iname']; 
    $iemail = $row_product_info['iemail'];

    // 插入資料到資料表 list
    $sql = "INSERT INTO list (uname, uemail, amount, iname, iemail, product_name, TWtime) 
            VALUES ('$uname', '$uemail', '$quantity', '$iname', '$iemail', '$pname', '$taiwanTime')";

    if ($conn->query($sql) === TRUE) {
        echo "資料已成功插入到資料表 list";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $sql2 = "UPDATE product SET joined = joined + $quantity WHERE id = $productId";
    $result2 = $conn->query($sql2);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>購物紀錄</title>
    <style>
        /* CSS 样式 */
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f9fd; /* 更改背景色 */
            margin: 0;
            padding: 0;
        }
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

        /* 導覽列 */
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
            width: 50%;
            margin: 50px auto;
            display: row;
            flex-wrap: wrap;
            gap: 20px;
            text-align: center;
        }

        .card {
            background-color: #fff;
            padding: 20px;
            margin: 10px;
            border-radius: 10px;
            box-shadow: 0px 0px 20px 0px rgba(0,0,0,0.1); /* 調整陰影效果 */
            flex: 1 1 calc(33.333% - 20px);
            box-sizing: border-box;
            transition: transform 0.3s;
            
        }

        .card:hover {
            transform: translateY(-5px); /* 懸停時元素上移 */
        }

        .card h3 {
            margin-top: 0;
            margin-bottom: 10px;
            color: #333;
        }

        .card p {
            margin: 5px 0;
            color: #666; /* 更改文字顏色 */
        }

        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header img {
            width: 50px;
            height: 50px;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <!-- <div class="container"> -->
        <div class="header">
        <header>
        <div class="header-overlay">
            <h1>購物紀錄</h1>
            <img src="./img/shopping-cart.png" alt="Shopping Cart Icon">
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
        </div>
        <div class="container">
        <ul>
            <?php
            // 查詢與目前登入者名稱相同的購物紀錄
            $uname = $_SESSION['username']; // 使用 $_SESSION 來儲存使用者名稱
            $sql = "SELECT list.*, p.price FROM list, product p WHERE list.product_name = p.pname AND list.uname = '$uname'";
            $result = $conn->query($sql);            //$result2 = $conn->query($sql2);

            if ($result -> num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='card'>";
                    echo "<h3>商品名稱：" . $row['product_name'] . "</h3>";
                    echo "<p>訂購時間：" . $row['TWtime'] . "</p>";
                    echo "<p>訂購數量：" . $row['amount'] . "</p>";
                    echo "<p>總金額：" . $row['amount'] * $row['price'] . "</p>";
                    echo "<p>團購主名稱：" . $row['iname'] . "</p>";
                    echo "<p>團購主電子郵件：" . $row['iemail'] . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>暫無購物紀錄</p>";
            }
            ?>
        </ul>
    </div>
</body>
</html>

<?php
    $conn->close();
?>
