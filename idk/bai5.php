<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ma Trận Ngẫu Nhiên</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e9ecef; 
            margin: 20px;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #065744;
            font-size: 36px;
            margin-bottom: 20px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2); 
        }
        .header {
            display: flex;
            justify-content: space-around; 
            margin-top: 40px;
            margin-bottom: 10px;
            color: #333;
        }
        .table-container {
            display: flex;
            justify-content: space-around; 
            margin-top: 20px;
        }
        table {
            width: 30%;
            border-collapse: collapse;
            border-radius: 10px; 
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            background-color: white; 
        }
        th {
            background-color: #4CAF50; 
            color: white;
            padding: 15px;
            font-size: 22px; 
            text-transform: uppercase; 
            letter-spacing: 1px; 
        }
        td {
            border: 1px solid #ddd; 
            padding: 20px; 
            text-align: center;
            font-size: 20px; 
            transition: background-color 0.3s, transform 0.2s; 
        }
        td:hover {
            background-color: #f8f9fa; 
            transform: translateY(-2px); 
        }
        .negative {
            background-color: #ffdddd; 
            font-weight: bold; 
        }
    </style>
</head>
<body>
    <h1>MA TRẬN NGẪU NHIÊN</h1>

    <?php
        // Tạo kích thước ngẫu nhiên cho ma trận
        $n = rand(2, 5);
        $m = rand(2, 5);

        // Khởi tạo ma trận
        $ma_tran = array();

        // Tạo ma trận với các phần tử ngẫu nhiên
        for ($i = 0; $i < $m; $i++) {
            for ($j = 0; $j < $n; $j++) {
                $ma_tran[$i][$j] = rand(-100, 100);
            }
        }

        echo "<div class='header'>";
        echo "<h2>Ma trận ban đầu</h2>";
        echo "<h2>Ma trận sắp xếp</h2>";
        echo "<h2>Ma trận sau khi thay đổi</h2>";
        echo "</div>";
        
        // In ma trận ban đầu
        echo "<div class='table-container'>";
        echo "<table>";
        for ($i = 0; $i < $m; $i++) {
            echo "<tr>";       
            for ($j = 0; $j < $n; $j++) {
                if ($ma_tran[$i][$j] < 0) {
                    echo "<td class='negative'>{$ma_tran[$i][$j]}</td>";
                } else {
                    echo "<td>{$ma_tran[$i][$j]}</td>";
                }
            }
            echo "</tr>";
        }
        echo "</table>";

        // Sắp xếp tăng dần các phần tử trong ma trận
        $a = array();
        for ($i = 0; $i < $m; $i++) {
            for ($j = 0; $j < $n; $j++) {
                $a[] = $ma_tran[$i][$j];
            }
        }

        // Sắp xếp bằng thuật toán Bubble Sort
        $so_luong = count($a);
        for ($i = 0; $i < $so_luong - 1; $i++) {
            for ($j = 0; $j < $so_luong - $i - 1; $j++) {
                if ($a[$j] > $a[$j + 1]) {
                    // Hoán đổi
                    $tam = $a[$j];
                    $a[$j] = $a[$j + 1];
                    $a[$j + 1] = $tam;
                }
            }
        }

        // Chuyển lại vào ma trận
        for ($i = 0; $i < $m; $i++) {
            for ($j = 0; $j < $n; $j++) {
                $ma_tran[$i][$j] = $a[$i * $n + $j];
            }
        }

        // In ma trận đã sắp xếp
        echo "<table>";
        for ($i = 0; $i < $m; $i++) {
            echo "<tr>";
            for ($j = 0; $j < $n; $j++) {
                echo "<td>{$ma_tran[$i][$j]}</td>";
            }
            echo "</tr>";
        }
        echo "</table>";

        // Thay thế các phần tử âm thành 0
        for ($i = 0; $i < $m; $i++) {
            for ($j = 0; $j < $n; $j++) {
                if ($ma_tran[$i][$j] < 0) {
                    $ma_tran[$i][$j] = 0;
                }
            }
        }

        // In ma trận sau khi đã thay đổi
        echo "<table>";
        for ($i = 0; $i < $m; $i++) {
            echo "<tr>";
            for ($j = 0; $j < $n; $j++) {
                echo "<td>{$ma_tran[$i][$j]}</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>"; // Kết thúc div.table-container

        // Lấy ngày giờ hiện tại
        // Thiết lập múi giờ
        date_default_timezone_set('Asia/Ho_Chi_Minh'); 

        // Lấy ngày giờ hiện tại
        $ngay_hien_tai = date('d-m-Y H:i:s'); // Định dạng: Năm-Tháng-Ngày Giờ:Phút:Giây

        // Hiển thị ngày giờ hiện tại và tháng
        echo "<p style='text-align: center; font-size: 18px;'>Ngày giờ hiện tại: $ngay_hien_tai</p>";
    ?>
</body>
</html>
