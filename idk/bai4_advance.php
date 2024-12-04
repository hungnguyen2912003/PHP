<?php
function isPrime($n) {
    if ($n <= 1) return false; // 0 và 1 không phải số nguyên tố
    for ($i = 2; $i <= sqrt($n); $i++) {
        if ($n % $i == 0) return false; // Nếu chia hết cho bất kỳ số nào, không phải số nguyên tố
    }
    return true; // Nếu không chia hết cho bất kỳ số nào, là số nguyên tố
}

// Kiểm tra xem người dùng đã gửi giá trị chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Nhận giá trị n từ form
    $n = intval($_POST['n']);
    
    // Kiểm tra giá trị n
    if (isPrime($n)) {
        $output = "$n là số nguyên tố.<br>";
    } else {
        $output = "$n không phải là số nguyên tố.<br>";
    }
    

    // Tạo mảng
    $array = [];
    for ($i = 0; $i < $n; $i++) {
        $array[$i] = rand(-100, 100);
    }
    $output .= "Mảng được tạo: " . implode(", ", $array) . "<br>";

    // Sắp xếp mảng tăng dần bằng thuật toán bubble sort
    for ($i = 0; $i < $n - 1; $i++) {
        for ($j = 0; $j < $n - 1 - $i; $j++) {
            if ($array[$j] > $array[$j + 1]) {
                // Hoán đổi các phần tử
                $temp = $array[$j];
                $array[$j] = $array[$j + 1];
                $array[$j + 1] = $temp;
            }
        }
    }

    $output .= "Mảng sau khi sắp xếp tăng dần: " . implode(", ", $array) . "<br>";

    // Tính tổng vị trí lẻ
    $sum = 0;
    for ($i = 1; $i < $n; $i += 2) { 
        $sum += $array[$i];
    }

    $output .= "Tổng các phần tử ở vị trí lẻ: $sum";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo và Sắp xếp Mảng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f9f9f9;
        }
        
        .container {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 400px; /* Set a fixed width for the box */
            text-align: center; /* Center-align the text */
        }

        h1 {
            color: #333;
        }

        input[type="number"] {
            padding: 10px;
            margin: 10px 0;
            width: calc(100% - 22px); /* Responsive width */
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            background-color: #007BFF;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tạo và Sắp xếp Mảng</h1>
        <form method="post" action="">
            <label for="n">Nhập giá trị n:</label>
            <input type="number" name="n" id="n" required>
            <input type="submit" value="Tạo mảng">
        </form>
        <?php
        // Hiển thị kết quả
        if (isset($output)) {
            echo "<div style='margin-top: 20px;'>$output</div>";
        }
        ?>
    </div>
</body>
</html>