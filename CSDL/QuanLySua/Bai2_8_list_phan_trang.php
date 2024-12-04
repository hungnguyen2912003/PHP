<style>
    table {
        border: 5px solid #BA4C00;
        border-collapse: collapse;
    }

    tr, td {
        border: 2px solid rgb(160, 160, 160);
        padding: 5px;
    }
</style>

<?php
$conn = mysqli_connect('localhost', 'root', '', 'qlbansua');
mysqli_set_charset($conn, 'UTF8');

$rowsPerPage = 2;
if (!isset($_GET['page']))
{
    $_GET['page'] = 1;
}
//vị trí của mẩu tin đầu tiên trên mỗi trang
$offset =($_GET['page']-1)*$rowsPerPage;

echo "<table style='width: 800px; margin: 0 auto;'>";

$result = mysqli_query($conn, 'SELECT Ten_sua, Ten_hang_sua, hinh, TP_Dinh_Duong, Loi_ich, Trong_luong, Don_gia FROM sua JOIN hang_sua on sua.Ma_hang_sua = hang_sua.Ma_hang_sua LIMIT ' . $offset . ', ' . $rowsPerPage);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_row($result)) {
        echo "<tr style='background-color: #FFEEE6;'><td colspan='2' style='text-align: center; color: #F36B09; font-size: 36px; font-weight: bold;'>$row[0] - $row[1]</td></tr>";
        echo "<tr>";
        echo "<td style='border: 1px solid black;'><img style='width: 200px; height: 180px;' src='Hinh_sua/$row[2]'/></td>";
        echo "<td style='border: 1px solid black;'>" .
            "<span style='font-style: italic; font-weight: bold;'>Thành phần dinh dưỡng:</span> <br>" . $row[3] . "<br>" .
            "<span style='font-style: italic; font-weight: bold;'>Lợi ích:</span> <br>" . $row[4] . "<br>";
        echo "<p><span style='font-weight: bold; font-style: italic;'>Trọng lượng:</span> <span style='color:#994C5F;'>$row[5]</span> gr - " .
            "<span style='font-weight: bold; font-style: italic;'>Đơn giá:</span> <span style='color:#994C5F;'>$row[6]</span>" . " VNĐ</p>";
        echo "</td>";
        echo "</tr>";
    }
}

echo "</table>";

$re = mysqli_query($conn, 'SELECT * FROM sua');
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
