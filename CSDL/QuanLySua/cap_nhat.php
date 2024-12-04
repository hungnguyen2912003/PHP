<style>
    td {
        padding: 5px;
    }
</style>

<?php
$connect = mysqli_connect("localhost", "root", "", "qlbansua")
OR die ('Không thể kết nối MySQL: ' . mysqli_connect_error());

if (isset($_GET['Ma_khach_hang'])) {
    $maKhachHang = $_GET['Ma_khach_hang'];

    $sql = "SELECT * FROM khach_hang WHERE Ma_khach_hang = '$maKhachHang'";
    $result = mysqli_query($connect, $sql);
    $row = mysqli_fetch_assoc($result);
}

if (isset($_POST['capNhat'])) {
    $maKhachHang = $_POST['maKhachHang'];
    $tenKhachHang = $_POST['tenKhachHang'];
    $gioiTinh = $_POST['gt'] == 'female' ? 1 : 0;
    $diaChi = $_POST['diaChi'];
    $dienThoai = $_POST['dienThoai'];
    $email = $_POST['Email'];

    $sqlUpdate = "UPDATE khach_hang SET 
                    Ten_khach_hang = '$tenKhachHang',
                    Phai = '$gioiTinh',
                    Dia_chi = '$diaChi',
                    Dien_thoai = '$dienThoai',
                    Email = '$email'
                  WHERE Ma_khach_hang = '$maKhachHang'";

    if (mysqli_query($connect, $sqlUpdate)) {
        echo "<script>
            alert('Cập nhật thành công!');
            window.location.href = 'Bai2_12_xoa_sua.php';
          </script>";
    } else {
        echo "Cập nhật thất bại: " . mysqli_error($connect);
    }
}
?>



<form method="POST" action="">
    <table style="width: 600px; margin: 0 auto; background-color: #FEEBCA;">
        <tr style="background-color: #FECC66;">
            <td colspan="2" style="text-align: center; color: #CB6128; font-style: italic; font-size: 30px; height: 50px; font-weight: bold;">CẬP NHẬT THÔNG TIN KHÁCH HÀNG</td>
        </tr>
        <tr>
            <td><label>Mã khách hàng: </label></td>
            <td><input type="text" name="maKhachHang" value="<?php echo $row['Ma_khach_hang']; ?>" readonly /></td>
        </tr>
        <tr>
            <td><label>Tên khách hàng: </label></td>
            <td><input type="text" name="tenKhachHang" value="<?php echo $row['Ten_khach_hang']; ?>" style="width: 90%;" /></td>
        </tr>
        <tr>
            <td><label>Phái: </label></td>
            <td>
                <input type="radio" name="gt" value="male" <?php echo ($row['Phai'] == 0) ? 'checked' : ''; ?> /> Nam
                <input type="radio" name="gt" value="female" <?php echo ($row['Phai'] == 1) ? 'checked' : ''; ?> /> Nữ
            </td>
        </tr>
        <tr>
            <td><label>Địa chỉ: </label></td>
            <td><input type="text" name="diaChi" value="<?php echo $row['Dia_chi']; ?>" style="width: 90%;" /></td>
        </tr>
        <tr>
            <td><label>Điện thoại: </label></td>
            <td><input type="text" name="dienThoai" value="<?php echo $row['Dien_thoai']; ?>" /></td>
        </tr>
        <tr>
            <td><label>Email: </label></td>
            <td><input type="text" name="Email" value="<?php echo $row['Email']; ?>" style="width: 90%;" /></td>
        </tr>
        <tr style="background-color: #FEE2A8">
            <td colspan="2" style="text-align: center;">
                <input type="submit" name="capNhat" value="Cập nhật" style="width: 100px; height: 30px;" />
            </td>
        </tr>
    </table>
</form>
