<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài 5 - Mảng 1 chiều</title>
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
        table {
            width: 1000px;
            border: 1px solid black;

        }
        input[type='text']{
            
            height: 30px;
            font-size: 20px;
        }
        input[type='submit']{
            width: 250px;
            height: 30px;
            font-size: 18px;
            background-color: #FCFCB9;
            font-weight: bold;
        }
        td{
            padding: 10px;
        }
    </style>
</head>
<body>

<?php

    $msg = "";
    $num = "";
    
    $mang_kq = "";
    $tong = "";
    $max = "";
    $min = "";
    function tao_mang($n): array
    {
        $mang = array();
        for($i = 0; $i < $n; $i++)
        {
            $x = rand(0,20);
            $mang[$i] = $x;
        }
        return $mang;
    }
    function xuat_mang($mang): string
    {
        $s = "";
        foreach($mang as $a){
            $s .= $a . " ";
        }
        return $s;
    }

    function tinh_tong($mang){
        $sum = 0;
        foreach($mang as $s){
            $sum += $s;
        }
        return $sum;
    }

    function tim_max($mang){
        return max($mang);
    }
    function tim_min($mang){
        return min($mang);
    }

    if(isset($_POST['tinhToan'])){
        if(!empty($_POST['num'])){
            $num = trim($_POST['num']);
            if(ctype_digit($num) && $num > 0){
                $mang = tao_mang($num);
                $mang_kq = xuat_mang($mang);
                $tong = tinh_tong($mang);
                $max = tim_max($mang);
                $min = tim_min($mang);
            }
            else
                $msg = "Vui lòng nhập n là số nguyên dương và lớn hơn 0";
        }
        else{
            $msg = "Vui lòng nhập số nguyên n!";
        }
    }

?>

    <form action="Bai5_Phat_Sinh_Mang_Tinh_Toan.php" method="post">
        <table >
            <tr>
                <td colspan="2" style="background-color: #A70F75;">
                    <h2 style="font-style: italic; font-weight: bold; color: #ffffff; text-align: center;">PHÁT SINH MẢNG VÀ TÍNH TOÁN</h2>
                </td>
            </tr>
            <tr style="background-color: #FFDBF6;">
                <td style="color: #cc0099; width: 300px; font-weight: bold;">Nhập số phần tử: </td>
                <td>
                    <input type="text" name="num" style="width: 400px;" value="<?php echo $num?>">
                </td>
            </tr>
            <tr style="background-color: #FFDBF6">
                <td></td>
                <td>
                    <input type="submit" name="tinhToan" value="Phát sinh và tính toán">
                </td>
            </tr>

            <tr>
                <td style="color: #cc0099; font-weight: bold;">Mảng: </td>
                <td>
                    <input type="text" name="mang_kq" readonly style="width: 500px; background-color: #FEA7A4;" value="<?php echo $mang_kq?>">
                </td>
            </tr>
            <tr>
                <td style="color: #cc0099; font-weight: bold;">GTLN (Max) trong mảng: </td>
                <td>
                    <input type="text" name="max" readonly style="width: 200px; background-color: #FEA7A4;" value="<?php echo $max?>">
                </td>
            </tr>
            <tr>
                <td style="color: #cc0099; font-weight: bold;">GTNN (Min) trong mảng: </td>
                <td>
                    <input type="text" name="min" readonly style="width: 200px; background-color: #FEA7A4;" value="<?php echo $min?>">
                </td>
            </tr>
            <tr>
                <td style="color: #cc0099; font-weight: bold;">Tổng mảng: </td>
                <td>
                    <input type="text" name="tong" readonly style="width: 200px; background-color: #FEA7A4;" value="<?php echo $tong?>">
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    (<span style="color: red;">
                        Ghi chú:
                    </span> Các phần tử trong mảng sẽ có giá trị từ 0 đến 20)
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <span style="color: red; font-weight: bold;">
                        <?php echo $msg?>
                    </span>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>