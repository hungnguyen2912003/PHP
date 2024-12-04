<?php
// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'qlbansua');
mysqli_set_charset($conn, 'UTF8');

$hangSua = mysqli_query($conn, "SELECT Ma_hang_sua, Ten_hang_sua FROM hang_sua");

$loaiSua = mysqli_query($conn, "SELECT Ma_loai_sua, Ten_loai FROM loai_sua");
?>

<style>
    body{
        font-family: Arial, Helvetica, sans-serif;
    }
    td{
        padding: 10px;
    }
    input{
        height: 25px;
    }
    select{
        width: 150px;
        height: 30px;
    }
    textarea{
        overflow: scroll;
        resize: none;
        width: 100%;
        height: 60px;
    }
</style>
<script>
    function handleFileSelect(event) {
        // Lấy file đã chọn
        const fileInput = document.getElementById('fileInput');
        const filePath = fileInput.value.split('\\').pop(); // Lấy tên file từ đường dẫn

        // Hiển thị tên file trong ô input hinhAnh
        document.getElementById('hinhAnh').value = filePath;
    }
</script>
<body>
    <form action="" method="post">
    <table style="width:800px; margin: 0 auto; background-color: #FDDEDC">
        <tr style="background-color: #FE6C6C;">
            <td colspan="2" style="text-align: center; font-weight: bold; font-size: 30px; color: white; height: 50px;">
                THÊM SỮA MỚI
            </td>
        </tr>
        <tr>
            <td>Mã sữa: </td>
            <td>
                <input type="text" name="maSua" value="<?php if(isset($_POST['maSua'])) echo $_POST['maSua']?>"/>
            </td>
        </tr>
        <tr>
            <td>Tên sữa: </td>
            <td>
                <input style="width: 400px;" type="text" name="tenSua" value="<?php if(isset($_POST['tenSua'])) echo $_POST['tenSua']?>"/>
            </td>
        </tr>
        <tr>
            <td>Hãng sữa: </td>
            <td>
                <select name="hangSua">
                    <?php while ($row = mysqli_fetch_assoc($hangSua)) : ?>
                        <option value="<?= $row['Ma_hang_sua']; ?>"><?= $row['Ten_hang_sua']; ?></option>
                    <?php endwhile; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Loại sữa: </td>
            <td>
                <select name="loaiSua">
                    <?php while ($row = mysqli_fetch_assoc($loaiSua)) : ?>
                        <option value="<?= $row['Ma_loai_sua']; ?>"><?= $row['Ten_loai']; ?></option>
                    <?php endwhile; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Trọng lượng: </td>
            <td>
                <input type="text" name="trongLuong" value="<?php if(isset($_POST['trongLuong'])) echo $_POST['trongLuong']?>"/> (gr hoặc ml)
            </td>
        </tr>
        <tr>
            <td>Đơn giá: </td>
            <td>
                <input type="text" name="donGia" value="<?php if(isset($_POST['donGia'])) echo $_POST['donGia']?>"/> (VNĐ)
            </td>
        </tr>
        <tr>
            <td>Thành phần dinh dưỡng: </td>
            <td>
                <textarea name="thanhPhan"></textarea>
            </td>
        </tr>
        <tr>
            <td>Lợi ích: </td>
            <td>
                <textarea name="loiIch"></textarea>
            </td>
        </tr>
        <tr>
            <td>Hình ảnh: </td>
            <td>
                <input type="text" id="hinhAnh" name="hinhAnh" readonly style="width: 80%;" />
                <input type="file" id="fileInput" style="display:none;" onchange="handleFileSelect(event)" />
                <button style="width: 80px;" type="button" onclick="document.getElementById('fileInput').click()">Browser</button>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;">
                <input type="submit" name="btnThemMoi" value="Thêm mới"/>
            </td>
        </tr>
    </table>
</form>
</body>


<?php
if (isset($_POST['btnThemMoi'])) {
    $maSua = $_POST['maSua'];
    $tenSua = $_POST['tenSua'];
    $hangSua = $_POST['hangSua'];
    $loaiSua = $_POST['loaiSua'];
    $trongLuong = $_POST['trongLuong'];
    $donGia = $_POST['donGia'];
    $thanhPhan = $_POST['thanhPhan'];
    $loiIch = $_POST['loiIch'];
    $hinhAnh = $_POST['hinhAnh'];

    // Check for empty fields
    if (empty($maSua) || empty($tenSua) || empty($hangSua) || empty($loaiSua) ||
        empty($trongLuong) || empty($donGia) || empty($thanhPhan) || empty($loiIch) || empty($hinhAnh)) {
        if(is_numeric($trongLuong) > 0 && is_numeric($donGia) > 0){
            echo "<p style='color: red; text-align: center; font-weight: bold;'>Kiểm tra lại thông tin</p>";
        }
    } else {
        // Insert data into the database
        $sql = "INSERT INTO sua (Ma_sua, Ten_sua, Ma_hang_sua, Ma_loai_sua, Trong_luong, Don_gia, TP_Dinh_Duong, Loi_ich, Hinh)
                      VALUES ('$maSua', '$tenSua', '$hangSua', '$loaiSua', '$trongLuong', '$donGia', '$thanhPhan', '$loiIch', '$hinhAnh')";

        if (mysqli_query($conn, $sql)) {
            echo "<p style='text-align: center; font-size: 24px;'>Kết quả sau khi thêm mới thành công</p>";
            echo "<p style='text-align: center;'>Thêm sữa thành công!</p>";

            $result = mysqli_query($conn, "SELECT Ten_sua, Ten_hang_sua, hinh, TP_Dinh_Duong, Loi_ich, Trong_luong, Don_gia 
                                           FROM sua 
                                           JOIN hang_sua ON sua.Ma_hang_sua = hang_sua.Ma_hang_sua 
                                           WHERE Ma_sua = '$maSua'");
            echo "<table style='width: 800px; margin: 0 auto; border-collapse: collapse; border: 3px solid #A5581F;'>";
            while ($row = mysqli_fetch_row($result)) {
                echo "<tr style='background-color: #FFEEE6;'><td colspan='2' style='text-align: center; color: #F36B09; font-size: 36px; font-weight: bold;'>$row[0] - $row[1]</td></tr>";
                echo "<tr><td style='border: 1px solid black;'><img style='width: 200px; height: 180px;' src='Hinh_sua/$row[2]'/></td>";
                echo "<td style='border: 1px solid black;'>";
                echo "<span style='font-style: italic; font-weight: bold;'>Thành phần dinh dưỡng:</span><br>$row[3]<br>";
                echo "<span style='font-style: italic; font-weight: bold;'>Lợi ích:</span><br>$row[4]<br>";
                echo "<p><span style='font-weight: bold; font-style: italic;'>Trọng lượng:</span> <span style='color:#994C5F;'>$row[5]</span> gr - ";
                echo "<span style='font-weight: bold; font-style: italic;'>Đơn giá:</span> <span style='color:#994C5F;'>$row[6]</span> VNĐ</p>";
                echo "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<p style='color: red; text-align: center;'>Có lỗi xảy ra khi thêm mới</p>";
        }
    }
}
?>
