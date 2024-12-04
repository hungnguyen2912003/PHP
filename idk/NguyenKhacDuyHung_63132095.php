<?php

//Đề 1
//Họ tên: Nguyễn Khắc Duy Hưng
//MSSV: 63132095


$msg = "";
$maNV = "";
$hoNV = "";
$tenNV = "";
$ngSinh = "";
$gioiTinh = "";
$diaChi = "";
$anhNV = "";

// Kết nối cơ sở dữ liệu
$connect = mysqli_connect("localhost", "root", "", "qlbansua") OR die ('Không thể kết nối MySQL: ' . mysqli_connect_error());

if (isset($_POST["themMoi"])) {
    $maNV = $_POST["maNV"];
    $hoNV = $_POST["hoNV"];
    $tenNV = $_POST["tenNV"];
    $ngSinh = $_POST["ngSinh"];
    $gioiTinh = $_POST["gioiTinh"];
    $diaChi = $_POST["diaChi"];
    $anhNV = $_FILES['anhNV']['name'];

    if (!empty($maNV) && !empty($hoNV) && !empty($tenNV) && !empty($ngSinh) && !empty($diaChi)) {
        if (!ctype_digit($maNV) || $maNV <= 0 || strlen($maNV) > 10) {
            $msg = "<span style='color: red; font-weight: bold;'>Mã nhân viên phải là số, lớn hơn 0 và tối đa 10 chữ số.</span>";
        }elseif(!isset($gioiTinh)){
            $msg = "<span style='color: red; font-weight: bold;'>Vui lòng chọn giới tính</span>";
        } else {
            if (isset($_FILES['anhNV']) && $_FILES['anhNV']['error'] == 0) {
                $errors = array();
                $file_name = $_FILES['anhNV']['name'];
                $file_size = $_FILES['anhNV']['size'];
                $file_tmp = $_FILES['anhNV']['tmp_name'];
                $array = explode('.', $file_name);
                $file_ext = @strtolower(end($array));
                $expensions = array("jpeg", "jpg", "png");

                if (!in_array($file_ext, $expensions)) {
                    $msg = "<span style='color: red; font-weight: bold;'>Đuôi file hình ảnh không hợp lệ.</span>";
                } elseif ($file_size > 2097152) {
                    $msg = "<span style='color: red; font-weight: bold;'>Hình ảnh phải dưới 2MB!</span>";
                } else {
                    move_uploaded_file($file_tmp, "E:\\PTPMMaNguonMo\\htdocs\\img" . $file_name);
                }
            }
            else {
                $msg = "<span style='color: red; font-weight: bold;'>Vui lòng chọn một hình ảnh.</span>";
            }

            if (empty($msg)) {
                $check_maNV = mysqli_query($connect, "SELECT * FROM nhanvien WHERE maNV = '$maNV'");
                if (mysqli_num_rows($check_maNV) != 0) {
                    $msg = "<span style='color: red; font-weight: bold;'>Đã có mã nhân viên này. Vui lòng nhập lại</span>";
                } else {
                    $sql = "INSERT INTO nhanvien (maNV, hoNV, tenNV, ngaySinh, gioiTinh, diaChi, anhNV) VALUES ('$maNV', '$hoNV', '$tenNV', '$ngSinh', '$gioiTinh', '$diaChi', '$anhNV')";
                    if (mysqli_query($connect, $sql)) {
                        $msg = "<span style='color: green; font-weight: bold;'>Thêm mới nhân viên có mã $maNV thành công!</span>";
                    } else {
                        $msg = "<span style='color: red; font-weight: bold;'>Đã xảy ra lỗi khi thêm mới!</span>";
                    }
                }
            }
        }
    } else {
        $msg = "<span style='color: red; font-weight: bold;'>Vui lòng thông tin không được để trống</span>";
    }
}
?>

<style>
    td{
        padding: 5px;
    }
    table{
        margin: 0 auto;
        border: 1px solid black;

    }
    h2{
        font-weight: bold;
        font-size: 30px;
    }
    input[type=text]{
        width: 80%;
    }
</style>

<form method="post" action="" enctype="multipart/form-data">
    <table>
        <tr>
            <td colspan="2" style="text-align:center;">
                <h2>THÊM MỚI NHÂN VIÊN</h2>
            </td>
        </tr>
        <tr>
            <td><label>Mã nhân viên</label></td>
            <td><input type="text" name="maNV" value="<?php echo $maNV;?>"/></td>
        </tr>
        <tr>
            <td><label>Họ nhân viên</label></td>
            <td><input type="text" name="hoNV" value="<?php echo $hoNV;?>" /></td>
        </tr>
        <tr>
            <td><label>Tên nhân viên</label></td>
            <td><input type="text" name="tenNV" value="<?php echo $tenNV;?>"/></td>
        </tr>
        <tr>
            <td><label>Ngày sinh</label></td>
            <td><input type="date" name="ngSinh" placeholder="YYYY-MM-DD" value="<?php echo $ngSinh;?>"/></td>
        </tr>
        <tr>
            <td><label>Giới tính</label></td>
            <td>
                <input type="radio" name="gioiTinh" value="1" <?php if(isset($_POST['gioiTinh']) && $_POST['gioiTinh'] == "1") echo 'checked'; ?>/> Nam
                <input type="radio" name="gioiTinh" value="0" <?php if(isset($_POST['gioiTinh']) && $_POST['gioiTinh'] == "0") echo 'checked'; ?>/> Nữ
            </td>
        </tr>
        <tr>
            <td><label>Địa chỉ</label></td>
            <td><input type="text" name="diaChi" value="<?php echo $diaChi;?>"/></td>
        </tr>
        <tr>
            <td><label>Ảnh nhân viên</label></td>
            <td><input type="file" name="anhNV" value="<?php echo $anhNV;?>"/></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center;">
                <input type="submit" name="themMoi" value="Thêm mới"/>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center;">
                <?php echo $msg;?>
            </td>
        </tr>
    </table>
</form>

<?php
$result = mysqli_query($connect, "SELECT * FROM nhanvien");

if (mysqli_num_rows($result) > 0) {
    echo "<h2 style='text-align:center;'>DANH SÁCH NHÂN VIÊN</h2>";
    echo "<table border='1' style='margin: 0 auto; width: 600px; border-collapse: collapse;'>";
    echo "<tr><th>Mã NV</th><th>Họ</th><th>Tên</th><th>Ngày sinh</th><th>Giới tính</th><th>Địa chỉ</th><th>Ảnh</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr style='text-align: center;'>";
        echo "<td>{$row['maNV']}</td>";
        echo "<td>{$row['hoNV']}</td>";
        echo "<td>{$row['tenNV']}</td>";
        echo "<td>{$row['ngaySinh']}</td>";
        echo "<td>" . ($row['gioiTinh'] == 1 ? 'Nam' : 'Nữ') . "</td>";
        echo "<td>{$row['diaChi']}</td>";
        echo "<td><img src='img\\{$row['anhNV']}' width='100'></td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p style='text-align:center;'>Chưa có nhân viên nào được thêm vào.</p>";
}
?>