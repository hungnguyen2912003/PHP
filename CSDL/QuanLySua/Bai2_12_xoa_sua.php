<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin khách hàng</title>

    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 0;
            font-size: 14px;
            font-family: Arial, Helvetica, sans-serif;
        }

        table {
            width: 90%;
            border: 1px solid rgb(140, 140, 140);
            margin-top: 20px;
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

<h2 style="text-align: center; color: black;">THÔNG TIN KHÁCH HÀNG</h2>

<table>
    <tr style="color: crimson">
        <th>Mã KH</th>
        <th>Tên khách hàng</th>
        <th>Giới tính</th>
        <th>Địa chỉ</th>
        <th>Số điện thoại</th>
        <th>Email</th>
        <th><img src="images/pencil.png" style="width: 20px;"></th>
        <th><img src="images/delete.png" style="width: 20px;"></th>
    </tr>
    <?php
    $connect = mysqli_connect("localhost", "root", "", "qlbansua")
    OR die ('Không thể kết nối MySQL: ' . mysqli_connect_error() );

    $sql = 'select * from khach_hang';

    $result = mysqli_query($connect, $sql);

    $row_count = 0;
    if(mysqli_num_rows($result)<>0)
        while($row=mysqli_fetch_row($result))
        {
            $row_class = $row_count % 2 == 0 ? 'color-row' : 'white-row';
            echo "<tr class='$row_class'>";
            echo "<td>$row[0]</td>";
            echo "<td>$row[1]</td>";
            echo "<td style='text-align: center;'>" . ($row[2] == 1 ? 'Nữ' : 'Nam') . "</td>";
            echo "<td>$row[3]</td>";
            echo "<td>$row[4]</td>";
            echo "<td>$row[5]</td>";
            echo "<td style='text-align: center;'><a href='cap_nhat.php?Ma_khach_hang=$row[0]'>Sửa</a></td>";
            echo "<td style='text-align: center;'><a href='xoa.php?Ma_khach_hang=$row[0]'>Xoá</a></td>";
            echo "</tr>";
            $row_count++;
        }
    ?>
</table>
</body>