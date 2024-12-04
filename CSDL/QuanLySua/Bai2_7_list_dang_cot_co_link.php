<?php
$conn = mysqli_connect('localhost', 'root', '', 'qlbansua');
mysqli_set_charset($conn, 'UTF8');

$sql = "SELECT Ten_sua, Trong_luong, Don_gia, Hinh FROM sua";
$result = mysqli_query($conn, $sql);
// Thêm border vào bảng ngoài cùng
echo "<table align='center' width='100%' border='1' cellpadding='5' cellspacing='0' style='border-collapse: collapse;'>";
echo "<tr style='background-color: #FFEEE6;'><td colspan='5' style='text-align: center; color: #F36B09; font-size: 30px; font-weight: bold;'>THÔNG TIN CÁC SẢN PHẨM</td></tr>";
$count = 0;
if (mysqli_num_rows($result) <> 0) {
    while ($row = mysqli_fetch_row($result)) {
        if ($count % 5 == 0) {
            echo "<tr>";
        }
        echo "<td style='text-align: center; width: 200px;'>";
        echo "<table style='margin: 0 auto;'>";
        echo "<tr><td style='text-align: center; font-weight: bold;'><a href='list_chi_tiet.php?Ten_sua=$row[0]'>$row[0]</a></td></tr>";
        echo "<tr><td style='text-align: center;'>" . $row[1] . " gr - " . $row[2] . " VNĐ" . "</td></tr>";
        echo "<tr><td style='text-align: center;'><img style='width: 100px; height: 100px;' src='Hinh_sua/$row[3]' alt='Hình sữa'></td></tr>";
        echo "</table>";
        echo "</td>";
        $count++;
        if ($count % 5 == 0) {
            echo "</tr>";
        }
    }
}

if ($count % 5 != 0) {
    echo "</tr>";
}
echo "</table>";
?>
