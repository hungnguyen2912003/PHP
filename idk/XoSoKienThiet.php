<?php
// Hàm để định dạng số
function formatNumber($number, $length) {
    return str_pad($number, $length, '0', STR_PAD_LEFT);
}

// Ngày hôm nay
$currentDate = date('d/m/Y');

// Tạo số ngẫu nhiên cho các giải
$results = [
    'Giải 8' => formatNumber(rand(0, 99), 2),
    'Giải 7' => formatNumber(rand(0, 999), 3),
    'Giải 6' => [formatNumber(rand(0, 9999), 4), formatNumber(rand(0, 9999), 4), formatNumber(rand(0, 9999), 4)],
    'Giải 5' => formatNumber(rand(0, 9999), 4),
    'Giải 4' => [
        formatNumber(rand(0, 99999), 5),
        formatNumber(rand(0, 99999), 5),
        formatNumber(rand(0, 99999), 5),
        formatNumber(rand(0, 99999), 5),
        formatNumber(rand(0, 99999), 5),
        formatNumber(rand(0, 99999), 5),
        formatNumber(rand(0, 99999), 5),
    ],
    'Giải 3' => [formatNumber(rand(0, 99999), 5), formatNumber(rand(0, 99999), 5)],
    'Giải 2' => formatNumber(rand(0, 99999), 5),
    'Giải 1' => formatNumber(rand(0, 99999), 5),
    'Đặc biệt' => formatNumber(rand(0, 999999), 6),
];

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bảng Xổ Số</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 10px;
        }
        table {
            width: 70%;
            margin: 0 auto;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: center;
            padding: 10px;
        }
        th {
            background-color: #ff6666;
            color: white;
            width: 5%; /* Giảm chiều rộng cho cột Giải */
        }
        td {
            width: 5%; /* Đặt chiều rộng cho cột Số */
        }
        h2, h3 {
            text-align: center;
        }
        .number {
            font-size: 1em;
            font-weight: bold; /* In đậm số */
            padding: 0 20px; /* Thêm khoảng cách giữa các số */
        }
        .special {
            font-size: 1.2em; /* Kích thước lớn hơn */
            font-weight: bold; /* In đậm */
            color: red; /* Màu đỏ */
        }
        .red {
            color: red; /* Màu đỏ */
        }
        /* Màu nền cho các hàng 2, 4, 6, 8, 10 */
        tr:nth-child(2), 
        tr:nth-child(4), 
        tr:nth-child(6), 
        tr:nth-child(8), 
        tr:nth-child(10) {
            background-color: #ffcccc; /* Màu nền nhạt hơn */
        }
        /* Thêm margin cho các số */
        .numbers-group {
            margin-bottom: 10px; /* Khoảng cách giữa 4 số và 3 số */
        }
    </style>
</head>
<body>

<h2>XỔ SỐ KHÁNH HOÀ</h2>

<h3>Ngày <?php echo $currentDate; ?></h3>

<table>
    <tr>
        <th>Giải</th>
        <th>Số</th>
    </tr>
    <?php foreach ($results as $key => $value): ?>
        <tr>
            <td><?php echo $key; ?></td>
            <td>
                <?php 
                // Nếu là giải 6, 4, hoặc 3 thì hiển thị số hàng ngang
                if (is_array($value)) {
                    if ($key == 'Giải 4') {
                        // Hiển thị 4 số trên và 3 số dưới với khoảng cách
                        echo '<div class="numbers-group">' . implode('', array_map(function($num) {
                            return '<span class="number">' . $num . '</span>';
                        }, array_slice($value, 0, 4))) . '</div>'; // 4 số trên
                        echo '<div>' . implode('', array_map(function($num) {
                            return '<span class="number">' . $num . '</span>';
                        }, array_slice($value, 4, 3))) . '</div>'; // 3 số dưới
                    } else {
                        echo implode('', array_map(function($num) {
                            return '<span class="number">' . $num . '</span>';
                        }, $value));
                    }
                } else {
                    // Định dạng số theo yêu cầu
                    if ($key == 'Giải 8') {
                        echo '<span class="number red">' . $value . '</span>'; // Giải 8 màu đỏ
                    } elseif ($key == 'Đặc biệt') {
                        echo '<span class="number special">' . $value . '</span>'; // Giải đặc biệt
                    } else {
                        echo '<span class="number">' . $value . '</span>'; // Các giải khác
                    }
                }
                ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>