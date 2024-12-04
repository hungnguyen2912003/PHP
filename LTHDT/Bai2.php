<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý thông tin nhân viên</title>

    <style>
        table {
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
        }
        td{
            padding: 5px 5px;
        }
        input{
            height: 20px;
        }
    </style>
</head>
<body>
<?php
    $tienThuong = "";
    $tienLuong = "";
    $tienPhat = "";
    $troCap = "";
    $thucLinh = "";
    $msg = "";

    if(isset($_POST["thucHien"]))
    {
        if(!empty($_POST["hoTen"]) && !empty($_POST["ngaySinh"]) && !empty($_POST["ngayVaoLam"]) && !empty($_POST["gioiTinh"]) && !empty($_POST["heSoLuong"]) && !empty($_POST["loaiNV"]))
        {
            $hoTen = $_POST["hoTen"];
            $ngaySinh = $_POST["ngaySinh"];
            $ngayVaoLam = $_POST["ngayVaoLam"];
            $gioiTinh = $_POST["gioiTinh"];
            $type = $_POST["loaiNV"];
            $soCon = $_POST["soCon"];
            $heSoLuong = $_POST["heSoLuong"];
            if(ctype_digit($soCon) && is_numeric($heSoLuong)){
                if($soCon > 0 && $heSoLuong > 0){
                    if($type == "VP"){
                        if(isset($_POST["soNgayVang"])){
                            $soNgayVang = $_POST["soNgayVang"];
                            if(ctype_digit($soNgayVang)){
                                $vanPhong = new NhanVienVanPhong($hoTen, $gioiTinh, $ngayVaoLam, $heSoLuong, $soCon, $soNgayVang);
                                $tienLuong = number_format($vanPhong->TinhTienLuong(), 0, ',', '.') . " VNĐ";
                                $tienThuong = number_format($vanPhong->TinhTienThuong(), 0, ',', '.') . " VNĐ";
                                $tienPhat = number_format($vanPhong->TinhTienPhat(), 0, ',', '.') . " VNĐ";
                                $troCap = number_format($vanPhong->TinhTroCap(), 0, ',', '.') . " VNĐ";
                                $thucLinh = number_format($vanPhong->TinhTienLuong() + $vanPhong->TinhTienThuong() - $vanPhong->TinhTienPhat() + $vanPhong->TinhTroCap(), 0, ',', '.') . " VNĐ";
                            }
                            else{
                                $msg = "Vui lòng nhập số ngày vắng là một con số cụ thể";
                            }

                        }
                        else{
                            $msg = "Vui lòng nhập số ngày vắng";
                        }
                    }
                    else{

                        if(isset($_POST["soSanPham"])){
                            $soSanPham = $_POST["soSanPham"];
                            if(ctype_digit($soSanPham)){
                                $sanPham = new NhanVienSanXuat($hoTen, $gioiTinh, $ngayVaoLam, $heSoLuong, $soCon, $soSanPham);
                                $tienLuong = number_format($sanPham->TinhTienLuong(), 0, ',', '.') . " VNĐ";
                                $tienThuong = number_format($sanPham->TinhTienThuong(), 0, ',', '.') . " VNĐ";
                                $tienPhat = 0;
                                $troCap = number_format($sanPham->TinhTroCap(), 0, ',', '.') . " VNĐ";
                                $thucLinh = number_format($sanPham->TinhTienLuong() + $sanPham->TinhTienThuong() + $sanPham->TinhTroCap(), 0, ',', '.') . " VNĐ";
                            }
                            else{
                                $msg = "Vui lòng nhập số sản phẩm là một con số cụ thể";
                            }
                        }
                        else{
                            $msg = "Vui lòng nhập số sản phẩm";
                        }
                    }
                }
                else{
                    $msg = "Vui lòng nhập số con hoặc hệ số lương lớn hơn 0";
                }
            }
            else{
                $msg = "Vui lòng nhập số con (nguyên dương) và hệ số lương là một con số cụ thể";
            }
        }
        else{
            $msg = "Vui lòng nhập đầy đủ thông tin";
        }
    }

?>
<h2 style="text-align: center">QUẢN LÝ NHÂN VIÊN</h2>

<form method="post">
    <table>
        <tr>
            <td style="background-color: #FFFFCC;">
                <label>Họ và tên: </label>
            </td>
            <td style="background-color: #FFFFCC;">
                <label>
                    <input type="text" name="hoTen" style="width: 300px;" value="<?php if(isset($_POST['hoTen'])) echo $_POST['hoTen'];?>">
                </label>
            </td>
            <td style="background-color: #FFFFCC;">
                <label>Số con: </label>
            </td>
            <td style="background-color: #FFFFCC;">
                <label>
                    <input type="text" name="soCon" value="<?php if(isset($_POST['soCon'])) echo $_POST['soCon'];?>">
                </label>
            </td>
        </tr>
        <tr>
            <td style="background-color: #FFFFCC;">
                <label>Ngày sinh: </label>
            </td>
            <td style="background-color: #FFFFCC;">
                <label>
                    <input type="date" name="ngaySinh" value="<?php if(isset($_POST['ngaySinh'])) echo $_POST['ngaySinh'];?>">
                </label>
            </td>
            <td style="background-color: #FFFFCC;">
                <label>Ngày vào làm: </label>
            </td>
            <td style="background-color: #FFFFCC;">
                <label>
                    <input type="date" name="ngayVaoLam" value="<?php if(isset($_POST['ngayVaoLam'])) echo $_POST['ngayVaoLam'];?>">
                </label>
            </td>
        </tr>
        <tr>
            <td style="background-color: #FFFFCC;">
                <label>Giới tính</label>
            </td>
            <td style="background-color: #FFFFCC;">
                <label>
                    <input type="radio" name="gioiTinh" value="male" <?php if(isset($_POST['gioiTinh'])&&($_POST['gioiTinh'])=="male") echo 'checked="checked"'?>/> Nam
                </label>
                <label>
                    <input type="radio" name="gioiTinh" value="female" <?php if(isset($_POST['gioiTinh'])&&($_POST['gioiTinh'])=="female") echo 'checked="checked"'?>/> Nữ
                </label>
            </td>
            <td style="background-color: #FFFFCC;">
                <label>Hệ số lương</label>
            </td>
            <td style="background-color: #FFFFCC;">
                <label>
                    <input type="text" name="heSoLuong" value="<?php if(isset($_POST['heSoLuong'])) echo $_POST['heSoLuong'];?>"/>
                </label>
            </td>
        </tr>
        <tr>
            <td style="background-color: #FFFFCC;">
                <label>Loại nhân viên</label>
            </td>
            <td style="background-color: #FFFFCC;">
                <label>
                    <input type="radio" name="loaiNV" value="VP" <?php if(isset($_POST['loaiNV'])&&($_POST['loaiNV'])=="VP") echo 'checked="checked"'?>/> Văn phòng
                </label>
            </td>
            <td colspan="2" style="background-color: #FFFFCC;">
                <label>
                    <input type="radio" name="loaiNV" value="SX" <?php if(isset($_POST['loaiNV'])&&($_POST['loaiNV'])=="SX") echo 'checked="checked"'?>/> Sản xuất
                </label>
            </td>
        </tr>
        <tr>
            <td style="background-color: #FFFFCC;"></td>
            <td style="background-color: #FFFFCC;">
                <label>
                    Số ngày vắng:
                    <input type="text" name="soNgayVang" value="<?php if(isset($_POST['soNgayVang'])) echo $_POST['soNgayVang'];?>"/>
                </label>
            </td>
            <td colspan="2" style="background-color: #FFFFCC;">
                <label>
                    Số sản phẩm:
                    <input type="text" name="soSanPham" value="<?php if(isset($_POST['soSanPham'])) echo $_POST['soSanPham'];?>"/>
                </label>
            </td>
        </tr>
        <tr>
            <td colspan="4" style="text-align: center">
                <input type="submit" name="thucHien" value="Tính lương"/>
            </td>
        </tr>
        <tr>
            <td style="background-color: #FFFFCC; text-align: center;">
                <label>Tiền lương: </label>
            </td>
            <td style="background-color: #FFFFCC; text-align: center;">
                <label>
                    <input type="text" name="tienLuong" readonly value="<?php echo $tienLuong?>"/>
                </label>
            </td>
            <td style="background-color: #FFFFCC; text-align: center;">
                <label>Trợ cấp: </label>
            </td>
            <td style="background-color: #FFFFCC; text-align: center;">
                <label>
                    <input type="text" name="troCap" readonly value="<?php echo $troCap?>"/>
                </label>
            </td>
        </tr>
        <tr>
            <td style="background-color: #FFFFCC; text-align: center;">
                <label>Tiền thưởng: </label>
            </td>
            <td style="background-color: #FFFFCC; text-align: center;">
                <label>
                    <input type="text" name="tienThuong" readonly value="<?php echo $tienThuong?>"/>
                </label>
            </td>
            <td style="background-color: #FFFFCC; text-align: center;">
                <label>Tiền phạt: </label>
            </td>
            <td style="background-color: #FFFFCC; text-align: center;">
                <label>
                    <input type="text" name="tienPhat" readonly value="<?php echo $tienPhat?>"/>
                </label>
            </td>
        </tr>
        <tr>
            <td colspan="4" style="text-align: center; background-color: #FFFFCC;">
                <label>Thực lĩnh:
                    <input type="text" name="thucLinh" readonly value="<?php echo $thucLinh?>"/>
                </label>
            </td>
        </tr>
        <tr>
            <td colspan="4" style="text-align: center">
                <span style="font-weight: bold; color: red;"><?php echo $msg?></span>
            </td>
        </tr>
    </table>
</form>

</body>
</html>

<?php

class NhanVien{
    protected $hoTen;
    protected $gioiTinh;
    protected $ngayVaoLam;
    protected $heSoLuong;
    protected $soCon;
    const LUONGCOBAN = 1500000;

    /**
     * @return mixed
     */
    public function getHoTen()
    {
        return $this->hoTen;
    }

    /**
     * @param mixed $hoTen
     */
    public function setHoTen($hoTen): void
    {
        $this->hoTen = $hoTen;
    }

    /**
     * @return mixed
     */
    public function getGioiTinh()
    {
        return $this->gioiTinh;
    }

    /**
     * @param mixed $gioiTinh
     */
    public function setGioiTinh($gioiTinh): void
    {
        $this->gioiTinh = $gioiTinh;
    }

    /**
     * @return mixed
     */
    public function getNgayVaoLam()
    {
        return $this->ngayVaoLam;
    }

    /**
     * @param mixed $ngayVaoLam
     */
    public function setNgayVaoLam($ngayVaoLam): void
    {
        $this->ngayVaoLam = $ngayVaoLam;
    }

    /**
     * @return mixed
     */
    public function getHeSoLuong()
    {
        return $this->heSoLuong;
    }

    /**
     * @param mixed $heSoLuong
     */
    public function setHeSoLuong($heSoLuong): void
    {
        $this->heSoLuong = $heSoLuong;
    }

    /**
     * @return mixed
     */
    public function getSoCon()
    {
        return $this->soCon;
    }

    /**
     * @param mixed $soCon
     */
    public function setSoCon($soCon): void
    {
        $this->soCon = $soCon;
    }

    /**
     * @param $hoTen
     * @param $gioiTinh
     * @param $ngayVaoLam
     * @param $heSoLuong
     * @param $soCon
     * @param $luongCanBan
     */
    public function __construct($hoTen, $gioiTinh, $ngayVaoLam, $heSoLuong, $soCon)
    {
        $this->hoTen = $hoTen;
        $this->gioiTinh = $gioiTinh;
        $this->ngayVaoLam = $ngayVaoLam;
        $this->heSoLuong = $heSoLuong;
        $this->soCon = $soCon;
    }

    public function tinhTienThuong(): float|int
    {
        // Chuyển thành đối tượng DateTime
        $dateLamViec = new DateTime($this->ngayVaoLam);
        $dateHienTai = new DateTime();

        $yearLamViec = $dateLamViec->format('Y');
        $yearHienTai = $dateHienTai->format('Y');

        return ($yearHienTai - $yearLamViec) * self::LUONGCOBAN;
    }
}

class NhanVienVanPhong extends NhanVien{
    private $soNgayVang;
    const DONGIAPHAT = 200000;
    const DINHMUCVANG = 5;

    public function __construct($hoTen, $gioiTinh, $ngayVaoLam, $heSoLuong, $soCon, $soNgayVang)
    {
        parent::__construct($hoTen, $gioiTinh, $ngayVaoLam, $heSoLuong, $soCon);
        $this->soNgayVang = $soNgayVang;
    }

    public function TinhTienPhat(): float|int
    {
        if($this->soNgayVang > self::DINHMUCVANG)
            return $this->soNgayVang * self::DONGIAPHAT;
        return 0;
    }

    public function TinhTroCap(): float|int
    {
        if($this->gioiTinh == "Nữ")
            return 200000 * $this->soCon * 1.5;
        else
            return 200000 * $this->soCon;
    }

    public function TinhTienLuong(): float|int
    {
        return self::LUONGCOBAN * $this->heSoLuong;
    }
}

class NhanVienSanXuat extends NhanVien{
    private $soSanPham;
    const DINHMUCSP = 5;
    const DONGIASP = 50000;

    public function __construct($hoTen, $gioiTinh, $ngayVaoLam, $heSoLuong, $soCon, $soSanPham)
    {
        parent::__construct($hoTen, $gioiTinh, $ngayVaoLam, $heSoLuong, $soCon);
        $this->soSanPham = $soSanPham;
    }

    public function TinhTienThuong(): float|int
    {
        if ($this->soSanPham > self::DINHMUCSP)
            return ($this->soSanPham - self::DINHMUCSP) * self::DONGIASP * 0.03;
        return 0;
    }

    public function TinhTroCap(): float|int
    {
        return $this->soCon * 120000;
    }

    public function TinhTienLuong(): float|int
    {
        return $this->soSanPham * self::DONGIASP;
    }
}
?>