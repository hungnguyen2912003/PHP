<html>
<head>
    <title>Tính diện tích và chu vi</title>
    <style>
        fieldset{
            width: 800px;
        }
        legend{
            background-color: #99ccff;
        }
        td{
            padding-top: 5px;
        }
        body{
            font-size: 15px;
        }
    </style>
</head>

<?php

abstract class Hinh
{
    protected $tenHinh;
    protected $doDai;

    public function getTenHinh()
    {
        return $this->tenHinh;
    }

    public function setTenHinh($tenHinh): void
    {
        $this->tenHinh = $tenHinh;
    }

    public function getDoDai()
    {
        return $this->doDai;
    }

    public function setDoDai($doDai): void
    {
        $this->doDai = $doDai;
    }

    abstract public function chuVi();
    abstract public function dienTich();
}

class HinhVuong extends Hinh
{
    public function chuVi()
    {
        return $this->doDai * 4;
    }
    public function dienTich()
    {
        return $this->doDai * $this->doDai;
    }
}

class HinhTron extends Hinh
{
    const PI = 3.14;
    public function chuVi()
    {
        return $this->doDai * 2 * self::PI;
    }
    public function dienTich()
    {
        return pow($this->doDai, 2) * self::PI;
    }
}

class HinhTamGiacDeu extends Hinh
{
    public function chuVi()
    {
        return $this->doDai * 3;
    }
    public function dienTich()
    {
        $p = $this->chuVi()/2;
        return round(sqrt($p * ($p - $this->doDai) * 3), 2);
    }
}

class HinhChuNhat extends Hinh
{
    public function chuVi()
    {
        return ($this->doDai * 2 + $this->doDai) * 2;
    }
    public function dienTich()
    {
        return ($this->doDai * 2 * $this->doDai);
    }
}

$kq = "";
$msg = "";

if(isset($_POST["tinhToan"]))
{
    if(!empty($_POST["hinh"]))
    {
        $hinh = $_POST["hinh"];
        if(!empty($_POST["nameHinh"])){
            $nameHinh = $_POST["nameHinh"];
            if(!empty($_POST["doDai"])){
                $doDai = $_POST["doDai"];
                if(is_numeric($doDai)){
                    if(($_POST["hinh"]) == "hv")
                    {
                        $hv = new HinhVuong();
                        $hv->setTenHinh($nameHinh);
                        $hv->setDoDai($doDai);
                        $kq = "Chu vi hình vuông " . $hv->getTenHinh($nameHinh) . " là: " . $hv->chuVi()
                            . "\n" . "Diện tích hình vuông " . $hv->getTenHinh($nameHinh) . " là: " . $hv->dienTich();
                    }
                    if(($_POST["hinh"]) == "ht")
                    {
                        $ht = new HinhTron();
                        $ht->setTenHinh($nameHinh);
                        $ht->setDoDai($doDai);
                        $kq = "Chu vi hình tròn " . $ht->getTenHinh($nameHinh) . " là: " . $ht->chuVi()
                            . "\n" . "Diện tích hình tròn " . $ht->getTenHinh($nameHinh) . " là: " . $ht->dienTich();
                    }
                    if(($_POST["hinh"]) == "htgd")
                    {
                        $htgd = new HinhTamGiacDeu();
                        $htgd->setTenHinh($nameHinh);
                        $htgd->setDoDai($doDai);
                        $kq = "Chu vi hình tam giác đều " . $htgd->getTenHinh($nameHinh) . " là: " . $htgd->chuVi()
                            . "\n" . "Diện tích hình tam giác đều " . $htgd->getTenHinh($nameHinh) . " là: " . $htgd->dienTich();
                    }
                    if(($_POST["hinh"]) == "hcn")
                    {
                        $hcn = new HinhChuNhat();
                        $hcn->setTenHinh($nameHinh);
                        $hcn->setDoDai($doDai);
                        $kq = "Chu vi hình chữ nhật " . $hcn->getTenHinh($nameHinh) . " là: " . $hcn->chuVi()
                            . "\n" . "Diện tích hình chữ nhật " . $hcn->getTenHinh($nameHinh) . " là: " . $hcn->dienTich();
                    }
                }
                else
                    $msg = "Vui lòng nhập độ dài là một con số";
            }
            else
                $msg = "Vui lòng nhập độ dài";
        }
        else
            $msg = "Vui lòng nhập tên hình";

    }
    else
        $msg = "Vui lòng lựa chọn hình";

}


?>


<body>
    <form action="" method="post">
        <fieldset>
        <legend style="font-size: 20px">Tính chu vi và diện tích</legend>
        <table>
            <tr>
                <td>
                    <label>Chọn hình</label>
                </td>
                <td>
                    <input type="radio" name="hinh" value="hv" <?php if(isset($_POST['hinh']) && ($_POST['hinh']) == "hv") echo 'checked="checked"'?> /> Hình vuông
                </td>
                <td>
                    <input type="radio" name="hinh" value="ht" <?php if(isset($_POST['hinh']) && ($_POST['hinh']) == "ht") echo 'checked="checked"'?>/> Hình tròn
                </td>
                <td>
                    <input type="radio" name="hinh" value="htgd" <?php if(isset($_POST['hinh']) && ($_POST['hinh']) == "htgd") echo 'checked="checked"'?>/> Hình tam giác đều
                </td>
                <td>
                    <input type="radio" name="hinh" value="hcn" <?php if(isset($_POST['hinh']) && ($_POST['hinh']) == "hcn") echo 'checked="checked"'?>/> Hình chữ nhật
                </td>
            </tr>
            <tr>
                <td>
                    <label>Nhập tên</label>
                </td>
                <td colspan="4">
                    <input type="text" name="nameHinh" value="<?php if(isset($_POST['nameHinh'])) echo $_POST['nameHinh']?>"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Nhập độ dài</label>
                </td>
                <td colspan="4">
                    <input type="text" name="doDai" value="<?php if(isset($_POST['doDai'])) echo $_POST['doDai']?>"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Kết quả</label>
                </td>
                <td colspan="4">
                    <textarea rows="4" cols="80" readonly><?php echo $kq;?></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="5" style="text-align: center;">
                    <input type="submit" name="tinhToan" value="Tính" style="width: 50px; height: 30px;"/>
                </td>
            </tr>
            <tr>
                <td colspan="5" style="text-align: center; color: red; font-weight: bold; font-size: 20px">
                    <?php echo $msg;?>
                </td>
            </tr>
        </table>
    </fieldset>
    </form>
</body>
</html>
