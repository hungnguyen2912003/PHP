<?php
session_start();
$msg = "";
$maNV = "";
$hotenNV = "";
$ngaySinh = "";
$sdt = "";
$maChucVu = "";
$hienThi = "";
if (!isset($_SESSION['nhan_vien'])) {
    $_SESSION['nhan_vien'] = [
        'ma_nv' => "63132095",
        'ho_ten' => "Nguyễn Khắc Duy Hưng",
        'ngay_sinh' => "29-01-2003",
        'gioi_tinh' => "Nam",
        'so_dien_thoai' => "0898386715",
        'ma_chuc_vu' => "Trưởng phòng"
    ];
}
$nhan_vien = $_SESSION['nhan_vien'];
if (isset($_POST["themNV"])) {

    if (!empty($_POST["maNV"]) && !empty($_POST["hotenNV"]) && !empty($_POST["ngaySinh"]) && !empty($_POST["sdt"]) && !empty($_POST["maChucVu"])) {

        $maNV = $_POST["maNV"];
        $hotenNV = $_POST["hotenNV"];
        $ngaySinh = $_POST["ngaySinh"];
        $gioiTinh = $_POST['gt'];
        $sdt = $_POST["sdt"];
        $maChucVu = $_POST["maChucVu"];

        if (is_numeric($maNV) && $maNV > 0) {
            if (is_numeric($sdt) && $sdt > 0) {
                $is_trung = false;
                foreach ($nhan_vien as $nv) {
                    if ($nv['ma_nv'] === $maNV) {
                        $is_trung = true;
                        break;
                    }
                }
                if ($is_trung) {
                    $msg = "Không thêm được Nhân viên vì đã có Mã nhân viên này rồi";
                } else {

                    $nhan_vien[] = [
                        'ma_nv' => $maNV,
                        'ho_ten' => $hotenNV,
                        'ngay_sinh' => $ngaySinh,
                        'gioi_tinh' => $gioiTinh,
                        'so_dien_thoai' => $sdt,
                        'ma_chuc_vu' => $maChucVu
                    ];
                    $_SESSION['nhan_vien'] = $nhan_vien;
                    $msg = "Thêm thành công NV";
                }
            } else {
                $msg = "Vui lòng nhập số điện thoại là số";
            }
        } else {
            $msg = "Vui lòng nhập mã nhân viên là số";
        }
    } else {
        $msg = "Vui lòng điền đầy đủ thông tin";
    }
}

if (isset($_POST['hienThi'])) {
    $stt = 1;
    foreach ($nhan_vien as $nv) {
        $hienThi .= "<tr>
                            <td>$stt</td>
                            <td>{$nv['ma_nv']}</td>
                            <td>{$nv['ho_ten']}</td>
                            <td>{$nv['ngay_sinh']}</td>
                            <td>{$nv['gioi_tinh']}</td>
                            <td>{$nv['so_dien_thoai']}</td>
                            <td>{$nv['ma_chuc_vu']}</td>
                        </tr>";
        $stt++;
    }
}
?>

<style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        padding: 0;
        font-size: 18px;
        font-family: Arial, Helvetica, sans-serif;
    }
    .container {
        width: 800px;
        margin: 0 auto;
        border: 1px solid black;
        border-radius: 10px;
        font-size: 16px;
        padding: 5px;
    }
    td {
        padding: 5px;
    }
    input[type=text] {
        width: 80%;
        height: 30px;
    }
    input[type=submit] {
        width: 180px;
        height: 50px;
    }
    select {
        width: 200px;
        height: 30px;
    }
</style>

<form method="post" action="">
    <h2 style="text-align: center;">QUẢN LÝ NHÂN VIÊN</h2>
    <table class="container">
        <tr>
            <td>
                <label>Mã NV: </label>
            </td>
            <td>
                <input type="text" name="maNV" value="<?php echo $maNV; ?>"/>
            </td>
        </tr>
        <tr>
            <td>
                <label>Họ tên NV: </label>
            </td>
            <td>
                <input type="text" name="hotenNV" value="<?php echo $hotenNV; ?>"/>
            </td>
        </tr>
        <tr>
            <td>
                <label>Ngày sinh: </label>
            </td>
            <td>
                <input type="date" name="ngaySinh" value="<?php echo $ngaySinh; ?>"/>
            </td>
        </tr>
        <tr>
            <td>
                <label>Giới tính: </label>
            </td>
            <td>
                <input type="radio" name="gt" value="Nam" <?php if (isset($gioiTinh) && $gioiTinh === 'male') echo 'checked'; ?>/> Nam
                <input type="radio" name="gt" value="Nữ" <?php if (isset($gioiTinh) && $gioiTinh === 'female') echo 'checked'; ?>/> Nữ
            </td>
        </tr>
        <tr>
            <td>
                <label>Số điện thoại: </label>
            </td>
            <td>
                <input type="text" name="sdt" value="<?php echo $sdt; ?>"/>
            </td>
        </tr>
        <tr>
            <td>
                <label>Mã chức vụ: </label>
            </td>
            <td>
                <select name="maChucVu">
                    <option value="Trưởng phòng" <?php if ($maChucVu === 'Trưởng phòng') echo 'selected'; ?>>Trưởng phòng</option>
                    <option value="Quản lý" <?php if ($maChucVu === 'Quản lý') echo 'selected'; ?>>Quản lý</option>
                    <option value="Kinh tế" <?php if ($maChucVu === 'Kinh tế') echo 'selected'; ?>>Kế toán</option>
                    <option value="Thu ngân" <?php if ($maChucVu === 'Thu ngân') echo 'selected'; ?>>Thu ngân</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;">
                <input type="submit" name="themNV" value="Thêm NV vào danh sách"/>
                <input type="submit" name="hienThi" value="Hiển thị danh sách">
            </td>
        </tr>
        <tr>
            <td colspan="2" style="font-weight: bold; text-align: center; color: red;">
                <?php echo $msg; ?>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <h2 style='text-align: center;'>Danh sách nhân viên</h2>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table style='border: 1px solid black; width: 100%;'>
                    <tr>
                        <th>STT</th>
                        <th>Mã NV</th>
                        <th>Họ tên</th>
                        <th>Ngày sinh</th>
                        <th>Giới tính</th>
                        <th>Số điện thoại</th>
                        <th>Mã chức vụ</th>
                    </tr>
                    <?php echo $hienThi; ?>
                </table>
            </td>
        </tr>
    </table>
</form>
