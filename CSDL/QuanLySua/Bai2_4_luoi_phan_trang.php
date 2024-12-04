<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP & MySQL</title>

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
            color: #BE4557;
        }
    </style>
</head>
<body>

<table>
    <tr>
        <td colspan="6">
            <h2 style="text-align: center; color: #F86510">THÔNG TIN SỮA</h2>
        </td>
    </tr>
    <tr style="color: crimson; background-color: #FEE0C1;">
        <th>STT</th>
        <th>Tên sữa</th>
        <th>Hãng sữa</th>
        <th>Loại sữa</th>
        <th>Trọng lượng</th>
        <th>Đơn giá</th>
    </tr>
    <?php
    $connect = mysqli_connect("localhost", "root", "", "qlbansua")
    OR die ('Không thể kết nối MySQL: ' . mysqli_connect_error());

    $rowsPerPage=10; //số mẩu tin trên mỗi trang, giả sử là 10
    if (!isset($_GET['page']))
    {
        $_GET['page'] = 1;
    }
    //vị trí của mẩu tin đầu tiên trên mỗi trang
    $offset =($_GET['page']-1)*$rowsPerPage;
    //lấy $rowsPerPage mẩu tin, bắt đầu từ vị trí $offset
    $result = mysqli_query($connect, 'SELECT ten_sua, Ten_hang_sua, Ten_loai, Trong_luong,
    Don_gia FROM sua JOIN hang_sua on sua.Ma_hang_sua = hang_sua.Ma_hang_sua JOIN loai_sua on sua.Ma_loai_sua = loai_sua.Ma_loai_sua LIMIT '. $offset . ', ' .$rowsPerPage);


//    $sql = 'select Ten_sua, Ten_hang_sua, Ten_loai, Trong_luong, Don_gia from sua s join hang_sua hs on s.Ma_hang_sua = hs.Ma_hang_sua join loai_sua ls on s.Ma_loai_sua = ls.Ma_loai_sua';

//    $result = mysqli_query($connect, $sql);

    $row_count = 0;
    if(mysqli_num_rows($result)<>0){
        $stt = 1;
        while($rows=mysqli_fetch_row($result))
        {
            $row_class = $row_count % 2 == 0 ? 'white-row' : 'color-row';
            echo "<tr class='$row_class'>";
            echo "<td>$stt</td>";
            echo "<td>$rows[0]</td>";
            echo "<td>$rows[1]</td>";
            echo "<td>$rows[2]</td>";
            echo "<td>{$rows[3]} gram</td>";
            echo "<td>" . number_format($rows[4], 0, ',', '.') . " VNĐ</td>";
            echo "</tr>";
            $row_count++;
            $stt++;
        }
    }
    ?>
</table>

<?php

$re = mysqli_query($connect, 'SELECT * FROM sua');
$numRows = mysqli_num_rows($re);
$maxPage = ceil($numRows / $rowsPerPage);

echo "<div style='text-align: center; margin-top: 10px;'>";

// Gắn thêm nút Back
if ($_GET['page'] > 1) {
    echo "<a href='" . $_SERVER['PHP_SELF'] . "?page=1'><<</a> ";
    echo "<a href='" . $_SERVER['PHP_SELF'] . "?page=" . ($_GET['page'] - 1) . "'><</a> ";
}

for ($i = 1; $i <= $maxPage; $i++) {
    if ($i == $_GET['page']) {
        echo '<b>' . $i . '</b> '; // trang hiện tại sẽ được bôi đậm
    } else {
        echo "<a href='" . $_SERVER['PHP_SELF'] . "?page=" . $i . "'>" . $i . "</a> ";
    }
}

// Gắn thêm nút Next
if ($_GET['page'] < $maxPage) {
    echo "<a href='" . $_SERVER['PHP_SELF'] . "?page=" . ($_GET['page'] + 1) . "'>></a> ";
    echo "<a href='" . $_SERVER['PHP_SELF'] . "?page=" . $maxPage . "'>>></a> ";
}

echo "</div>";

?>

</body>