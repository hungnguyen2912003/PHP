<?php

class Nguoi{
    protected $hoTen;
    protected $gioiTinh;
    protected $diaChi;

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
    public function getDiaChi()
    {
        return $this->diaChi;
    }

    /**
     * @param mixed $diaChi
     */
    public function setDiaChi($diaChi): void
    {
        $this->diaChi = $diaChi;
    }

    /**
     * @param $hoTen
     * @param $gioiTinh
     * @param $diaChi
     */
    public function __construct($hoTen, $gioiTinh, $diaChi)
    {
        $this->hoTen = $hoTen;
        $this->gioiTinh = $gioiTinh;
        $this->diaChi = $diaChi;
    }

    public function inThongTin(): string
    {
        return "Họ tên: " . $this->hoTen . "\n" . "Địa chỉ: " . $this->diaChi . "\n" . "Giới tính: " . $this->gioiTinh . "\n";
    }
}

class SinhVien extends Nguoi{
    protected $lopHoc;
    protected $nganhHoc;

    /**
     * @return mixed
     */
    public function getLopHoc()
    {
        return $this->lopHoc;
    }

    /**
     * @param mixed $lopHoc
     */
    public function setLopHoc($lopHoc): void
    {
        $this->lopHoc = $lopHoc;
    }

    /**
     * @return mixed
     */
    public function getNganhHoc()
    {
        return $this->nganhHoc;
    }

    /**
     * @param mixed $nganhHoc
     */
    public function setNganhHoc($nganhHoc): void
    {
        $this->nganhHoc = $nganhHoc;
    }



    public function __construct($hoTen, $gioiTinh, $diaChi, $lopHoc, $nganhHoc)
    {
        parent::__construct($hoTen, $gioiTinh, $diaChi);
        $this->lopHoc = $lopHoc;
        $this->nganhHoc = $nganhHoc;
    }


    public function tinhDiemThuong(): float|int
    {
        if ($this->nganhHoc == "CNTT")
            return 1;
        else if ($this->nganhHoc == "Kinh tế" || $this->nganhHoc == "KT")
            return 1.5;
        else
            return 0;
    }

    public function inThongTin(): string
    {
        return parent::inThongTin() . "Lớp học: "  . $this->lopHoc . "\n" . "Ngành học: " . $this->nganhHoc . "\n" . "Điểm thưởng: " . $this->tinhDiemThuong() . " điểm";
    }

}

class GiangVien extends Nguoi{
    protected $trinhDo;
    const LUONGCOBAN = 1500000;

    public function __construct($hoTen, $gioiTinh, $diaChi, $trinhDo)
    {
        parent::__construct($hoTen, $gioiTinh, $diaChi);
        $this->trinhDo = $trinhDo;
    }

    public function tinhLuong()
    {
        if($this->trinhDo == "Cử nhân")
            return self::LUONGCOBAN * 2.34;
        else if($this->trinhDo == "Thạc sĩ")
            return self::LUONGCOBAN * 3.67;
        else if($this->trinhDo == "Tiến sĩ")
            return self::LUONGCOBAN * 5.66;
        else
            return self::LUONGCOBAN;
    }

    public function inThongTin(): string
    {
        return parent::inThongTin() . "Trình độ: " . $this->trinhDo . "\n" . "Lương: " . $this->tinhLuong() . " VNĐ";
    }
}


//////////////////////////////////////////////


$inThongTin = "";
$msg = "";

if (isset($_POST['hienThi']))
{
    if(!empty($_POST['hoTen']) && !empty($_POST['diaChi']) && !empty($_POST['gioiTinh']) && !empty($_POST['vaiTro'])){
        $hoTen = $_POST['hoTen'];
        $diaChi = $_POST['diaChi'];
        $gioiTinh = $_POST['gioiTinh'];
        $type = $_POST['vaiTro'];
        if ($type == 'sinhvien') {
            if(!empty($_POST['lopHoc']) && !empty($_POST['nganhHoc'])){
                $lopHoc = $_POST['lopHoc'];
                $nganhHoc = $_POST['nganhHoc'];
                $sinhVien = new SinhVien($hoTen, $gioiTinh, $diaChi, $lopHoc, $nganhHoc);
                $inThongTin = $sinhVien->inThongTin();
            }
            else{
                $msg = "Vui lòng điền đầy đủ thông tin lớp học và ngành học";
            }

        } elseif ($type == 'giangvien') {
            if(!empty($_POST['trinhDo'])){
                $trinhDo = $_POST['trinhDo'];
                $giangVien = new GiangVien($hoTen, $diaChi, $gioiTinh, $trinhDo);
                $inThongTin = $giangVien->inThongTin();
            }
            else{
                $msg = "Vui lòng lựa chọn trình độ";
            }
        }
    }
    else{
        $msg = "Vui lòng điền đầy đủ thông tin";
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Quản lý thông tin Sinh viên và Giảng viên</title>
    <style>
        table {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
            border-collapse: collapse;
        }
        td{
            padding: 10px;
        }
    </style>
    <script>
        function showOption() {
            const sinhvienInfo = document.getElementById('sinhvien_info');
            const giangvienInfo = document.getElementById('giangvien_info');
            const sinhvienRadio = document.querySelector('input[name="vaiTro"][value="sinhvien"]').checked;
            const giangvienRadio = document.querySelector('input[name="vaiTro"][value="giangvien"]').checked;
            if (sinhvienRadio) {
                sinhvienInfo.style.display = 'block';
                giangvienInfo.style.display = 'none';
            }
            if (giangvienRadio) {
                sinhvienInfo.style.display = 'none';
                giangvienInfo.style.display = 'block';
            }
        }

        // Gọi hàm này khi trang được load để thiết lập trạng thái mặc định
        window.onload = function() {
            showOption();
        }
    </script>
</head>
<body>

<h2 style="text-align: center">Quản lý thông tin Sinh viên và Giảng viên</h2>
<form action="" method="POST">
    <table>
        <tr>
            <td>
                <label>Họ tên: </label>
            </td>
            <td>
                <label>
                    <input type="text" name="hoTen" value="<?php if(isset($_POST['hoTen'])) echo $_POST['hoTen'];?>">
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>Giới tính: </label>
            </td>
            <td>
                <label>
                    <select name="gioiTinh">
                        <option value="Nam" <?php if(isset($_POST['gioiTinh'])&&($_POST['gioiTinh'])=="Nam") echo 'checked="checked"'?>>Nam</option>
                        <option value="Nữ" <?php if(isset($_POST['gioiTinh'])&&($_POST['gioiTinh'])=="Nữ") echo 'checked="checked"'?>>Nữ</option>
                    </select>
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>Địa chỉ: </label>
            </td>
            <td>
                <label>
                    <input type="text" name="diaChi" value="<?php if(isset($_POST['diaChi'])) echo $_POST['diaChi'];?>">
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>Vai trò của bạn là: </label>
            </td>
            <td>
                <label>
                    <input type="radio" name="vaiTro" value="sinhvien" <?php if(isset($_POST['vaiTro'])&&($_POST['vaiTro'])=="sinhvien") echo 'checked="checked"'?> onclick="showOption()">
                </label> Sinh viên
                <label>
                    <input type="radio" name="vaiTro" value="giangvien" <?php if(isset($_POST['vaiTro'])&&($_POST['vaiTro'])=="giangvien") echo 'checked="checked"'?> onclick="showOption()">
                </label> Giảng viên
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div id="sinhvien_info" style="display: none">
                    <table>
                        <tr>
                            <td>
                                <label>Lớp học: </label>
                            </td>
                            <td>
                                <label>
                                    <input type="text" name="lopHoc" value="<?php if(isset($_POST['lopHoc'])) echo $_POST['lopHoc'];?>">
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Ngành học: </label>
                            </td>
                            <td>
                                <label>
                                    <input type="text" name="nganhHoc" value="<?php if(isset($_POST['nganhHoc'])) echo $_POST['nganhHoc'];?>">
                                </label>
                            </td>
                        </tr>
                    </table>
                </div>
                <div id="giangvien_info" style="display: none">
                    <table>
                        <tr>
                            <td style="text-align: center;">Trình độ: </td>
                            <td>
                                <label>
                                    <select name="trinhDo">
                                        <option value="Cử nhân" <?php if(isset($_POST['trinhDo'])&&($_POST['trinhDo'])=="Cử nhân") echo 'checked="checked"'?>>Cử nhân</option>
                                        <option value="Thạc sĩ" <?php if(isset($_POST['trinhDo'])&&($_POST['trinhDo'])=="Thạc sĩ") echo 'checked="checked"'?>>Thạc sĩ</option>
                                        <option value="Tiến sĩ" <?php if(isset($_POST['trinhDo'])&&($_POST['trinhDo'])=="Tiến sĩ") echo 'checked="checked"'?>>Tiến sĩ</option>
                                    </select>
                                </label>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;">
                <input type="submit" name="hienThi" value="Hiển thị thông tin">
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <hr>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <label>
                    <textarea cols="70" rows="10" style="font-size: 16px;"><?php echo trim($inThongTin); ?></textarea>
                </label>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;">
                <input type="submit" name="luuFile" value="Lưu file">
                <input type="submit" name="hienThiFile" value="Hiển thị tất cả file">
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;">
                <span style="color: red; font-weight: bold;"><?php echo $msg?></span>
            </td>
        </tr>
    </table>
</form>
</body>
</html>

