<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bảng cửu chương</title>
    <style>
        body {
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
			
        }
		.container h3{
			color: #0033cc;
		}
        .multiplication-table {
            border: 1px solid #000;
            margin: 10px;
            padding: 10px;
            width: 200px;
            text-align: center;
            background-color: #99ccff; 
            transition: transform 0.3s, background-color 0.3s;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3); /* Tạo hiệu ứng đổ bóng */
        }
        /* Hiệu ứng hover */
        .multiplication-table:hover {
            transform: scale(1.1); 
            background-color: #6699ff;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        // In 5 bảng cửu chương đầu tiên
        for ($n = 1; $n <= 5; $n++) {
            echo "<div class='multiplication-table'>";
            echo "<h3>Bảng cửu chương $n</h3>";
            for ($i = 1; $i <= 10; $i++) {
                $kq = $n * $i;
                echo "$n * $i = $kq<br>";
            }
            echo "</div>";
        }
        ?>
    </div>

    <div class="container">
        <?php
        // In 5 bảng cửu chương còn lại
        for ($n = 6; $n <= 10; $n++) {
            echo "<div class='multiplication-table'>";
            echo "<h3>Bảng cửu chương $n</h3>";
            for ($i = 1; $i <= 10; $i++) {
                $kq = $n * $i;
                echo "$n * $i = $kq<br>";
            }
            echo "</div>";
        }
        ?>
    </div>
</body>
</html>
