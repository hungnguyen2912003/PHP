
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

echo "<table style='width: 800px; margin: 0 auto;'>";

if (isset($_GET['Ten_sua'])) {
    $ten_sua = $_GET['Ten_sua'];

    $sql = "SELECT Ten_sua, Ten_hang_sua, hinh, TP_Dinh_Duong, Loi_ich, Trong_luong, Don_gia FROM sua 
            JOIN hang_sua on sua.Ma_hang_sua = hang_sua.Ma_hang_sua WHERE Ten_sua = '$ten_sua'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) <> 0) {
        while ($row = mysqli_fetch_row($result)) {
            echo "<tr style='background-color: #FFEEE6;'><td colspan='2' style='text-align: center; color: #F36B09; font-size: 36px; font-weight: bold;'>$row[0] - $row[1]</td></tr>";
            echo "<tr>";
            echo "<td style='border: 1px solid black;'><img style='width: 200px; height: 200px;' src='Hinh_sua/$row[2]'/></td>";
            echo "<td style='border: 1px solid black;'>" .
                "<span style='font-style: italic; font-weight: bold;'>Thành phần dinh dưỡng:</span> <br>" . $row[3] . "<br>" .
                "<span style='font-style: italic; font-weight: bold;'>Lợi ích:</span> <br>" . $row[4] . "<br>";
            echo "<p style='text-align: right;'><span style='font-weight: bold; font-style: italic;'>Trọng lượng:</span> $row[5]" .
                " gr - " . "<span style='font-weight: bold; font-style: italic;'>Đơn giá:</span> " . $row[6] . " VNĐ" .
                "</p>";
            echo "</td>";
            echo "</tr>";
            echo "<tr><td style='text-align: right; border: 1px solid black;'><a href='javascript:window.history.back(-1);'>Quay về</a></td></tr>";
        }
    } else {
        echo "Sản phẩm không tồn tại.";
    }
} else {
    echo "Không có tên sữa nào được chọn.";
}

echo "</table>";
?>
