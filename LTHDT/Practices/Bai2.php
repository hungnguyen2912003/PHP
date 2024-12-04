<?php

abstract class NhanVien{
    protected $hoTen;
    protected $gioiTinh;
    protected $ngayVaoLam;
    protected $heSoLuong;
    protected $soCon;

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

    protected const LUONGCANBAN = 1000000;


    abstract public function tinhTienLuong();
    abstract public function tinhTroCap();
    public function tinhTienThuong()
    {
        $tgVaoLam = new DateTime($this->ngayVaoLam);
        $tgHienTai = new DateTime();

        $namVaoLam = $tgVaoLam->format('Y');
        $namHienTai = $tgHienTai->format('Y');
        return number_format(($namHienTai - $namVaoLam) * 1000000, ',', '.');
    }
}

class NhanVienVanPhong extends NhanVien{
    private $soNgayVang;
    const DINHMUCVANG = 5;
    const DONGIAPHAT = 300000;

    /**
     * @return mixed
     */
    public function getSoNgayVang()
    {
        return $this->soNgayVang;
    }

    /**
     * @param mixed $soNgayVang
     */
    public function setSoNgayVang($soNgayVang): void
    {
        $this->soNgayVang = $soNgayVang;
    }


    public function tinhTienPhat()
    {
        if($this->soNgayVang > self::DINHMUCVANG)
            return number_format($this->soNgayVang * self::DONGIAPHAT, 0, ',', '.');
    }

    public function tinhTienLuong()
    {
        return number_format(self::LUONGCANBAN * $this->heSoLuong, 0, ',', '.');
    }

    public function tinhTroCap(){
        if($this->gioiTinh == "female")
            return number_format(200000 * $this->soCon * 1.5, 0, ',', '.');
        else
            return number_format(200000 * $this->soCon, 0, ',', '.');
    }
}

class NhanVienSanXuat extends NhanVien{
    private $soSanPham;
    private const DINHMUCSP = 6;
    private const DONGIASP = 50000;

    /**
     * @return mixed
     */
    public function getSoSanPham()
    {
        return $this->soSanPham;
    }

    /**
     * @param mixed $soSanPham
     */
    public function setSoSanPham($soSanPham): void
    {
        $this->soSanPham = $soSanPham;
    }

    public function tinhTienThuong()
    {
        if($this->soSanPham > self::DINHMUCSP)
            return number_format(($this->soSanPham - self::DINHMUCSP) * self::DONGIASP * 0.03, 0, ',', '.');
    }
    public function tinhTroCap(){
        return number_format($this->soCon * 120000, 0, ',', '.');
    }
    public function tinhTienLuong(){
        return number_format($this->soSanPham * self::DONGIASP, 0, ',', '.');
    }
}

$msg = "";
$tienLuong = "";
$tienThuong = "";
$troCap = "";
$tienPhat = "";
$thucLinh = "";

if(isset($_POST["tinhLuong"])){
    if(!empty($_POST["hoTen"]) && !empty($_POST["gt"]) && !empty($_POST["ngayVaoLam"]) && !empty($_POST["soCon"]) && !empty($_POST["heSoLuong"]) && !empty($_POST["loaiNV"])){
        $hoTen = $_POST["hoTen"];
        $gt = $_POST["gt"];
        $ngayVaoLam = $_POST["ngayVaoLam"];
        $soCon = $_POST["soCon"];
        $heSoLuong = $_POST["heSoLuong"];
        $loaiNV = $_POST["loaiNV"];
        if(ctype_digit($_POST["soCon"]) && is_numeric($_POST["heSoLuong"])){
            if($loaiNV == "vphong"){
                if(!empty($_POST["soNgayVang"])){
                    $soNgayVang = $_POST["soNgayVang"];
                    if(ctype_digit($soNgayVang)){
                        $nvvp = new NhanVienVanPhong();
                        $nvvp->setHoTen($hoTen);
                        $nvvp->setGioiTinh($gt);
                        $nvvp->setNgayVaoLam($ngayVaoLam);
                        $nvvp->setSoCon($soCon);
                        $nvvp->setSoNgayVang($soNgayVang);
                        $nvvp->setHeSoLuong($heSoLuong);
                        $tienLuong = $nvvp->tinhTienLuong();
                        $troCap = $nvvp->tinhTroCap();
                        $tienThuong = $nvvp->tinhTienThuong();
                        $tienPhat = $nvvp->tinhTienPhat();
                        $thucLinh = $tienLuong + $troCap - $tienPhat + $tienThuong;
                    }
                    else
                        $msg = "Vui lòng nhập số ngày vắng là một con số nguyên dương";
                }
                else
                    $msg = "Vui lòng nhập số ngày vắng";
            }
            elseif($loaiNV == "sxuat"){
                if(!empty($_POST["soSanPham"])){
                    $soSanPham = $_POST["soSanPham"];
                    if(ctype_digit($soSanPham)){
                        $nvsx = new NhanVienSanXuat();
                        $nvsx->setHoTen($hoTen);
                        $nvsx->setGioiTinh($gt);
                        $nvsx->setNgayVaoLam($ngayVaoLam);
                        $nvsx->setSoCon($soCon);
                        $nvsx->setHeSoLuong($heSoLuong);
                        $tienLuong = $nvsx->tinhTienLuong();
                        $troCap = $nvsx->tinhTroCap();
                        $tienThuong = $nvsx->tinhTienThuong();
                        $tienPhat = $nvsx->tinhTienPhat();
                        $thucLinh = $tienLuong + $troCap - $tienPhat + $tienThuong;
                    }
                    else
                        $msg = "Vui lòng nhập số sản phẩm là một con số nguyên dương";
                }
                else
                    $msg = "Vui lòng nhập số sản phẩm";
            }
        }
        else
            $msg = "Vui lòng nhập hệ số lương là một con số và số con là số nguyên dương";
    }
    else
        $msg = "Vui lòng nhập và chọn đầy đủ thông tin cần thiết";
}
?>


<html>
<head>
    <title>Quản lý Nhân viên</title>
    <style>

    </style>
</head>
<body>
    <form method="POST" action="">
        <table>
            <tr>
                <td>
                    <h2>QUẢN LÝ NHÂN VIÊN</h2>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Họ và tên: </label>
                </td>
                <td>
                    <input type="text" name="hoTen" value="<?php if(isset($_POST['hoTen'])) echo $_POST['hoTen']?>"/>
                </td>
                <td>
                    <label>Số con: </label>
                </td>
                <td>
                    <input type="text" name="soCon" value="<?php if(isset($_POST['soCon'])) echo $_POST['soCon']?>"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Ngày sinh: </label>
                </td>
                <td>
                    <input type="date" name="ngaySinh" value="<?php if(isset($_POST['ngaySinh'])) echo $_POST['ngaySinh']?>"/>
                </td>
                <td>
                    <label>Ngày vào làm: </label>
                </td>
                <td>
                    <input type="date" name="ngayVaoLam" value="<?php if(isset($_POST['ngayVaoLam'])) echo $_POST['ngayVaoLam']?>"/>
                </td>
            </tr>

            <tr>
                <td>
                    <label>Giới tính: </label>
                </td>
                <td>
                    <input type="radio" name="gt" value="male" <?php if(isset($_POST['gt']) && $_POST['gt'] == "male") echo 'checked="checked"'?>/> Nam
                    <input type="radio" name="gt" value="female" <?php if(isset($_POST['gt']) && $_POST['gt'] == "female") echo 'checked="checked"'?>/> Nữ
                </td>
                <td>
                    <label>Hệ số lương: </label>
                </td>
                <td>
                    <input type="text" name="heSoLuong" value="<?php if(isset($_POST['heSoLuong'])) echo $_POST['heSoLuong']?>"/>
                </td>
            </tr>

            <tr>
                <td>
                    <label>Loại nhân viên: </label>
                </td>
                <td>
                    <input type="radio" name="loaiNV" value="vphong" <?php if(isset($_POST['loaiNV']) && $_POST['loaiNV'] == "vphong") echo 'checked="checked"'?>/> Văn phòng
                </td>
                <td>
                    <input type="radio" name="loaiNV" value="sxuat" <?php if(isset($_POST['loaiNV']) && $_POST['loaiNV'] == "sxuat") echo 'checked="checked"'?>/> Sản xuất
                </td>
            </tr>

            <tr>
                <td>
                </td>
                <td>
                    <label>Số ngày vắng: </label>
                    <input type="text" name="soNgayVang" value="<?php if(isset($_POST['soNgayVang'])) echo $_POST['soNgayVang']?>"/>
                </td>
                <td>
                    <label>Số sản phẩm: </label>
                    <input type="text" name="soSanPham" value="<?php if(isset($_POST['soSanPham'])) echo $_POST['soSanPham']?>"/>
                </td>
            </tr>

            <tr>
                <td>
                    <input type="submit" name="tinhLuong" value="Tính lương"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Tiền lương: </label>
                </td>
                <td>
                    <input type="text" name="tienLuong" value="<?php echo $tienLuong;?>"/>
                </td>
                <td>
                    <label>Trợ cấp: </label>
                </td>
                <td>
                    <input type="text" name="troCap" value="<?php echo $troCap;?>"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Tiền thưởng: </label>
                </td>
                <td>
                    <input type="text" name="tienThuong" value="<?php echo $tienThuong;?>"/>
                </td>
                <td>
                    <label>Tiền phạt: </label>
                </td>
                <td>
                    <input type="text" name="tienPhat" value="<?php echo $tienPhat;?>"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Thực lĩnh: </label>
                    <input type="text" name="thucLinh" value="<?php echo $thucLinh;?>"/>
                </td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: center; font-weight: bold; color: red; font-size: 20px;">
                    <?php echo $msg;?>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
