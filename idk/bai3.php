<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài 3</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        .result-box {
            background-color: #fff;
            border: 2px solid #333;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <div class="result-box">
        <?php
        define("N", 10000);

        function kiemtraSNT($n) {
            if ($n < 2) return false;
            for ($i = 2; $i <= sqrt($n); $i++) {
                if ($n % $i == 0) return false;
            }
            return true;
        }

        function TinhTong($n) {
            $sum = 0;
            for ($i = 10; $i < $n && $i < 100; $i++) {
                if ($i % 2 != 0) {
                    $sum += $i;
                }
            }
            return $sum;
        }

        function demChuSo($n) {
            $count = 0;
            while ($n != 0) {
                $n = (int)($n / 10);
                $count++;
            }
            return $count;
        }

        $n = rand(1, N);

        $isPrime = kiemtraSNT($n) ? "là số nguyên tố" : "không phải là số nguyên tố";

        $sumOdd = TinhTong($n);

        echo "Số $n được tạo ngẫu nhiên <br>";
        echo "$n $isPrime<br>";
        echo "Tổng các số lẻ có 2 chữ số nhỏ hơn $n là: $sumOdd<br>";
        $chuso = demChuSo($n);
        echo "Số $n có $chuso chữ số";
        ?>
    </div>
</body>
</html>
