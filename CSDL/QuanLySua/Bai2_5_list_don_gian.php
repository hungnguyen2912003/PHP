<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin các sản phẩm</title>

    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin: 0;
            padding: 0;
            font-size: 18px;
            font-family: Arial, Helvetica, sans-serif;
        }

        th, td {
            border: 2px solid rgb(160, 160, 160);
            padding: 5px;
        }

        .color-row {
            background-color: #FEE0C1;
        }
        .white-row {
            background-color: #ffffff;
        }
    </style>
</head>
<body>

<table>
    <tr>
        <td colspan="2" style="background-color: #FFEEE6">
            <h2 style="text-align: center; color: #F86510">THÔNG TIN CÁC SẢN PHẨM</h2>
        </td>
    </tr>
    <?php
    $connect = mysqli_connect("localhost", "root", "", "qlbansua")
    OR die ('Không thể kết nối MySQL: ' . mysqli_connect_error() );

    $sql = 'select Hinh, Ten_sua, Ten_hang_sua, Ten_loai, Trong_luong, Don_gia from sua s join hang_sua hs on s.Ma_hang_sua = hs.Ma_hang_sua join loai_sua ls on s.Ma_loai_sua = ls.Ma_loai_sua';

    $result = mysqli_query($connect, $sql);

    if(mysqli_num_rows($result)<>0)
        while($rows=mysqli_fetch_array($result))
        {

            echo "<tr>";
            echo "<td style='text-align: center; width: 300px'>";
            echo "<img style='width: 150px; height: 200px;' src='Hinh_sua/{$rows['Hinh']}'>";
            echo "</td>";
            echo "<td>";
            echo "<p style='font-weight: bold;'>{$rows['Ten_sua']}</p>";
            echo "<br>";
            echo "Nhà sản xuất: " . "{$rows['Ten_hang_sua']}";
            echo "<br>";
            echo "{$rows['Ten_loai']}" . " - " . "{$rows['Trong_luong']}" . " gr - " . "{$rows['Don_gia']}" . " VNĐ";
            echo "</td>";
            echo "</tr>";
        }
    ?>
</table>
</body>