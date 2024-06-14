<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理員 - 統計圖表</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* 全局樣式 */
        body {
            font-family: '微軟正黑體', Arial, sans-serif;
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
            margin: 0;
        }

        /* 導航菜單 */
        nav {
            background-color: #333;
            padding: 15px 0;
            text-align: center;
            margin-bottom: 20px;
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

        /* 主要內容區域 */
        .content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .charts-container {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
            gap: 20px;
        }

        .chart-container {
            width: 45%;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            text-align: center;
        }

        canvas {
            border-radius: 10px;
        }

        select {
            padding: 10px;
            font-size: 1em;
        }

        /* 顯示選擇的月份樣式 */
        .selected-month {
            margin-top: 10px;
            font-size: 1.2em;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-overlay">
            <h1>管理員 - 統計圖表</h1>
        </div>
    </header>
    <nav>
        <ul>
            <li><a href="completed_orders.php">已結單商品</a></li>
            <li><a href="receive.php">意見回饋</a></li>
            <li><a href="logout.php">登出</a></li>
        </ul>
    </nav>
    <div class="content">
        <div class="charts-container">
            <div class="chart-container">
                <h2 style="text-align: center;">商品銷售量排行</h2>
                <canvas id="productSalesChart" width="400" height="300"></canvas>
            </div>
            <div class="chart-container">
                <h2 style="text-align: center;">團購主每月銷售排行</h2>
                <select id="monthSelector" onchange="updateMonthlySalesChart()">
                    <option value="1">一月</option>
                    <option value="2">二月</option>
                    <option value="3">三月</option>
                    <option value="4">四月</option>
                    <option value="5">五月</option>
                    <option value="6">六月</option>
                    <option value="7">七月</option>
                    <option value="8">八月</option>
                    <option value="9">九月</option>
                    <option value="10">十月</option>
                    <option value="11">十一月</option>
                    <option value="12">十二月</option>
                </select>
                <div id="selectedMonth" class="selected-month"></div>
                <canvas id="monthlySalesChart" width="400" height="300"></canvas>
            </div>
        </div>

        <?php
        // 連接資料庫
        $servername = "localhost";
        $username = "id22313627_admin"; // 修改為您的資料庫用戶名
        $password = "Admin_123"; // 修改為您的資料庫密碼
        $dbname = "id22313627_project"; // 資料庫名稱

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("連接失敗：" . $conn->connect_error);
        }

        // 獲取商品銷售量排行
        $sqlProductSales = "SELECT product_name, SUM(amount) AS total_amount FROM list GROUP BY product_name ORDER BY total_amount DESC LIMIT 5";
        $resultProductSales = $conn->query($sqlProductSales);

        $productNames = [];
        $totalAmounts = [];

        if ($resultProductSales->num_rows > 0) {
            while ($row = $resultProductSales->fetch_assoc()) {
                $productNames[] = $row['product_name'];
                $totalAmounts[] = $row['total_amount'];
            }
        }

        // 預設顯示一月的每月銷售金額排行
        $initialMonth = 1;
        if (isset($_GET['month'])) {
            $initialMonth = $_GET['month'];
        }

        // 獲取團購主每月銷售金額排行
        $sqlMonthlySales = "SELECT iname, SUM(amount) AS total_amount
                            FROM list
                            WHERE MONTH(TWtime) = $initialMonth
                            GROUP BY iname
                            ORDER BY total_amount DESC";
        $resultMonthlySales = $conn->query($sqlMonthlySales);

        $buyerNames = [];
        $monthlySales = [];

        if ($resultMonthlySales->num_rows > 0) {
            while ($row = $resultMonthlySales->fetch_assoc()) {
                $buyerNames[] = $row['iname'];
                $monthlySales[] = $row['total_amount'];
            }
        }

        // 關閉資料庫連接
        $conn->close();
        ?>

        <script>
            // 商品銷售量排行
            var productNames = <?php echo json_encode($productNames); ?>;
            var totalAmounts = <?php echo json_encode($totalAmounts); ?>;

            var ctx1 = document.getElementById('productSalesChart').getContext('2d');
            var productSalesChart = new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: productNames,
                    datasets: [{
                        label: '商品銷售量',
                        data: totalAmounts,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // 團購主每月銷售金額排行
            var buyerNames = <?php echo json_encode($buyerNames); ?>;
            var monthlySales = <?php echo json_encode($monthlySales); ?>;

            var ctx2 = document.getElementById('monthlySalesChart').getContext('2d');
            var monthlySalesChart = new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: buyerNames,
                    datasets: [{
                        label: '每月銷售量',
                        data: monthlySales,
                        backgroundColor: 'rgba(255, 159, 64, 0.2)',
                        borderColor: 'rgba(255, 159, 64, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // 更新每月銷售金額圖表
            function updateMonthlySalesChart() {
                var selectedMonth = document.getElementById('monthSelector').value;
                var url = window.location.href.split('?')[0] + '?month=' + selectedMonth;
                window.location.href = url;
            }

            // 顯示選擇的月份
            var selectedMonthElement = document.getElementById('selectedMonth');
            var initialMonth = <?php echo json_encode($initialMonth); ?>;
            var monthNames = [
                "一月", "二月", "三月", "四月", "五月", "六月",
                "七月", "八月", "九月", "十月", "十一月", "十二月"
            ];

            selectedMonthElement.textContent = '目前選擇的月份：' + monthNames[initialMonth - 1];
        </script>

    </div>
</body>
</html>
