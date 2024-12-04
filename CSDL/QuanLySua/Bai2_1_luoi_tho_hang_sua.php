<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin hãng sữa</title>

    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 0;
            font-size: 18px;
            font-family: Arial, Helvetica, sans-serif;
        }

        h2 {
            text-align: center;
            color: #2A7FAA;
            font-style: italic;
        }

        table {
            width: 90%;
            max-width: 1000px;
            border: 1px solid rgb(140, 140, 140);
            margin-top: 20px;
        }

        th, td {
            border: 2px solid rgb(160, 160, 160);
            padding: 5px;
        }
    </style>
</head>
<body>

<h2 style="text-align: center; color: #2A7FAA; font-style: italic">THÔNG TIN HÃNG SỮA</h2>

<table>
    <tr>
        <th>Mã HS</th>
        <th>Tên hãng sữa</th>
        <th>Địa chỉ</th>
        <th>Điện thoại</th>
        <th>Email</th>
    </tr>
    <?php
    $connect = mysqli_connect("localhost", "root", "", "qlbansua")
    OR die ('Không thể kết nối MySQL: ' . mysqli_connect_error() );

    $sql = 'select * from hang_sua';

    $result = mysqli_query($connect, $sql);

    if(mysqli_num_rows($result)<>0)
        while($rows=mysqli_fetch_row($result))
        {
            echo "<tr>";
            echo "<td>$rows[0]</td>";
            echo "<td>$rows[1]</td>";
            echo "<td>$rows[2]</td>";
            echo "<td>$rows[3]</td>";
            echo "<td>$rows[4]</td>";
            echo "</tr>";
        }
    ?>
</table>
</body>