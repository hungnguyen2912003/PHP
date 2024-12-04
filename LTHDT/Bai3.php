<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phân số</title>

    <style>
        td{
            padding: 10px;
        }
    </style>
</head>
<body>

<?php
$msg = "";
$kq = "";

class PhanSo{
    protected $tuSo;
    protected $mauSo;

    public function __construct($tuSo, $mauSo)
    {
        $this->tuSo = $tuSo;
        $this->mauSo = $mauSo;
    }

    public function ptCong(PhanSo $ps)
    {
        $tuSo = $this->tuSo * $ps->mauSo + $ps->tuSo * $this->mauSo;
        $mauSo = $this->mauSo * $ps->mauSo;
        return new PhanSo($tuSo, $mauSo);
    }

    public function ptTru(PhanSo $ps)
    {
        $tuSo = $this->tuSo * $ps->mauSo - $ps->tuSo * $this->mauSo;
        $mauSo = $this->mauSo * $ps->mauSo;
        return new PhanSo($tuSo, $mauSo);
    }

    public function ptNhan(PhanSo $ps)
    {
        $tuSo = $this->tuSo * $ps->tuSo;
        $mauSo = $this->mauSo * $ps->mauSo;
        return new PhanSo($tuSo, $mauSo);
    }

    public function ptChia(PhanSo $ps)
    {
        $tuSo = $this->tuSo * $ps->mauSo;
        $mauSo = $this->mauSo * $ps->tuSo;
        return new PhanSo($tuSo, $mauSo);
    }

    private function UCLN($a, $b)
    {
        return ($b == 0) ? $a : $this->UCLN($b, $a % $b);
    }

    public function rutGon()
    {
        $ucln = $this->UCLN($this->tuSo, $this->mauSo);
        $this->tuSo /= $ucln;
        $this->mauSo /= $ucln;
        return $this->tuSo . "/" . $this->mauSo;
    }

    public function hienThi(): string
    {
        return $this->tuSo . "/" . $this->mauSo;
    }
}

if (isset($_POST['tinhToan'])) {
    if (!empty($_POST['tuSo1']) && !empty($_POST['tuSo2']) && !empty($_POST['mauSo1']) && !empty($_POST['mauSo2'])) {
        $tuSo1 = $_POST['tuSo1'];
        $tuSo2 = $_POST['tuSo2'];
        $mauSo1 = $_POST['mauSo1'];
        $mauSo2 = $_POST['mauSo2'];

        if (isset($_POST['ptinh'])) {
            $type = $_POST['ptinh'];

            if (is_numeric($tuSo1) && is_numeric($tuSo2) && is_numeric($mauSo1) && is_numeric($mauSo2)) {
                if ($mauSo1 == 0 || $mauSo2 == 0) {
                    $msg = "Mẫu số không thể bằng 0.";
                } else {
                    $ps1 = new PhanSo($tuSo1, $mauSo1);
                    $ps2 = new PhanSo($tuSo2, $mauSo2);
                    switch ($type) {
                        case "cong":
                            $pt = $ps1->ptCong($ps2);
                            $kq = "Phép cộng là: " . $ps1->hienThi() . " + " . $ps2->hienThi() . " = " . $pt->rutGon();
                            break;
                        case "tru":
                            $pt = $ps1->ptTru($ps2);
                            $kq = "Phép trừ là: " . $ps1->hienThi() . " - " . $ps2->hienThi() . " = " . $pt->rutGon();
                            break;
                        case "nhan":
                            $pt = $ps1->ptNhan($ps2);
                            $kq = "Phép nhân là: " . $ps1->hienThi() . " * " . $ps2->hienThi() . " = " . $pt->rutGon();
                            break;
                        case "chia":
                            if ($tuSo2 == 0) {
                                $msg = "Không thể chia cho phân số có tử số bằng 0.";
                            } else {
                                $pt = $ps1->ptChia($ps2);
                                $kq = "Phép chia là: " . $ps1->hienThi() . " / " . $ps2->hienThi() . " = " . $pt->rutGon();
                            }
                            break;
                        default:
                            $msg = "Vui lòng lựa chọn phép tính";
                    }
                }
            } else {
                $msg = "Vui lòng nhập Tử số và Mẫu số là một con số";
            }
        } else {
            $msg = "Vui lòng chọn phép tính.";
        }
    } else {
        $msg = "Vui lòng nhập đầy đủ thông tin";
    }
}
?>

<h4 style="color: #6A39FF">Chọn các phép tính trên phân số</h4>

<form action="" method="post">
    <table>
        <tr>
            <td>Nhập phân số thứ 1:</td>
            <td>Tử số: <input type="text" name="tuSo1" value="<?php if (isset($_POST['tuSo1'])) echo $_POST['tuSo1']; ?>" /></td>
            <td>Mẫu số: <input type="text" name="mauSo1" value="<?php if (isset($_POST['mauSo1'])) echo $_POST['mauSo1']; ?>" /></td>
        </tr>
        <tr>
            <td>Nhập phân số thứ 2:</td>
            <td>Tử số: <input type="text" name="tuSo2" value="<?php if (isset($_POST['tuSo2'])) echo $_POST['tuSo2']; ?>" /></td>
            <td>Mẫu số: <input type="text" name="mauSo2" value="<?php if (isset($_POST['mauSo2'])) echo $_POST['mauSo2']; ?>" /></td>
        </tr>
        <tr>
            <td colspan="3">
                <fieldset>
                    <legend>Chọn phép tính</legend>
                    <label><input type="radio" name="ptinh" value="cong" <?php if (isset($_POST['ptinh']) && ($_POST['ptinh']) == "cong") echo 'checked="checked"'; ?> /> Cộng</label>
                    <label><input type="radio" name="ptinh" value="tru" <?php if (isset($_POST['ptinh']) && ($_POST['ptinh']) == "tru") echo 'checked="checked"'; ?> /> Trừ</label>
                    <label><input type="radio" name="ptinh" value="nhan" <?php if (isset($_POST['ptinh']) && ($_POST['ptinh']) == "nhan") echo 'checked="checked"'; ?> /> Nhân</label>
                    <label><input type="radio" name="ptinh" value="chia" <?php if (isset($_POST['ptinh']) && ($_POST['ptinh']) == "chia") echo 'checked="checked"'; ?> /> Chia</label>
                </fieldset>
            </td>
        </tr>
        <tr>
            <td colspan="3"><input type="submit" name="tinhToan" value="Kết quả" /></td>
        </tr>
        <tr>
            <td colspan="3"><?php echo $kq ?></td>
        </tr>
        <tr>
            <td colspan="3"><span style="font-weight: bold; color: red;"><?php echo $msg; ?></span></td>
        </tr>
    </table>
</form>

</body>
</html>
