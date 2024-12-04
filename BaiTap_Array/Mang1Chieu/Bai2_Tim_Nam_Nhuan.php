<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài 2 - Mảng 1 chiều</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;

            margin: 0;
            padding: 0;
            font-size: 18px;
            font-family: Arial, Helvetica, sans-serif;
        }        
        table {
            width: 700px;
            border: none;
            border-collapse: collapse;
            background-color: #BCEDFF;
        }
        input[type='text']{
            width: 300px;
            height: 30px;
            font-size: 20px;
        }
        input[type='submit']{
            width: 250px;
            height: 30px;
            font-size: 18px;
            background-color: #70D6FF;
            font-weight: bold;
        }
        td{
            padding: 10px;
        }
    </style>
</head>
<body>

<?php
    $namNhuan1 = "";
    $namNhuan2 = "";
    $msg1 = "";
    $msg2 = "";
    $kq1 = "";
    $kq2 = "";
    function nam_nhuan($nam){
        if($nam % 400 == 0 || ($nam % 4 == 0 && $nam % 100 != 0))
            return 1;
        return 0;
    }
    if(isset($_POST['thucHien1'])){
        if(!empty($_POST['namNhuan1'])){
            $namNhuan1 = $_POST['namNhuan1'];
            if(ctype_digit($namNhuan1)){
                if($namNhuan1 < 2000){
                    foreach(range($namNhuan1, 2000) as $year){
                        if(nam_nhuan($year) == 1){
                            if($kq1 != nam_nhuan($year))
                                $kq1 = "$year là năm nhuận";
                            else
                                $kq1 = "Không có năm nhuận";
                        }
                    }

                }
                else{
                    $msg1 = "Vui lòng nhập số năm nhỏ hơn năm 2000";
                }
            }
            else{
                $msg1 = "Vui lòng nhập năm là một con số nguyên!";
            }
        }
        else{
            $msg1 = "Vui lòng nhập năm vào ô!";
        }

    }

    if(isset($_POST['thucHien2'])){
        if(!empty($_POST['namNhuan2'])){
            $namNhuan2 = $_POST['namNhuan2'];
            if(is_numeric($namNhuan2)){
                if($namNhuan2 > 2000){
                    foreach(range(2000, $namNhuan2) as $year){
                        if(nam_nhuan($year) == 1){
                            if($kq2 != nam_nhuan($year))
                                $kq2 = "$year là năm nhuận";
                            else
                                $kq2 = "Không có năm nhuận";
                        }
                    }

                }
                else{
                    $msg2 = "Vui lòng nhập số năm nhỏ hơn năm 2000";
                }
            }
            else{
                $msg2 = "Vui lòng nhập năm là một con số!";
            }
        }
        else{
            $msg2 = "Vui lòng nhập năm vào ô!";
        }
    }

?>

    <form action="Bai2_Tim_Nam_Nhuan.php" method="post">
        <h3 style="text-align: center; color: #3931AF;">Nhập năm vào nhỏ hơn năm 2000:</h3>
        <table >
            <tr>
                <td colspan="2" style="background-color: #3366ff">
                    <h2 style="font-style: italic; font-weight: bold; color: #ffffff; text-align: center;">TÌM NĂM NHUẬN</h2>
                </td>
            </tr>
            <tr>
                <td style="color: #000066; width: 200px; text-align: center;">Năm: </td>
                <td>
                    <input type="text" name="namNhuan1" value="<?php echo trim($namNhuan1)?>">
                </td>
            </tr>
            <tr>
                <td colspan="2" style="color: #ffffcc;">
                    <textarea cols="90" rows="3" style="background-color: #FFFFD3;" readonly><?php echo $kq1?>
                    </textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <input type="submit" name="thucHien1" value="Tìm năm nhuận" style="color: red;">
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <span style="color: red; font-weight: bold;">
                        <?php echo $msg1?>
                    </span>
                </td>
            </tr>
        </table>
        <h3 style="text-align: center; color: #3931AF;">Nhập năm vào lớn hơn năm 2000:</h3>
        <table>
            <tr>
                <td colspan="2" style="background-color: #3366ff">
                    <h2 style="font-style: italic; font-weight: bold; color: #ffffff; text-align: center;">TÌM NĂM NHUẬN</h2>
                </td>
            </tr>
            <tr>
                <td style="color: #000066; width: 200px; text-align: center;">Năm: </td>
                <td>
                    <input type="text" name="namNhuan2" value="<?php echo trim($namNhuan2)?>">
                </td>
            </tr>
            <tr>
                <td colspan="2" style="color: #ffffcc;">
                    <textarea cols="90" rows="3" style="background-color: #FFFFD3;" readonly><?php echo $kq2?>
                    </textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <input type="submit" name="thucHien2" value="Tìm năm nhuận" style="color: red;">
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <span style="color: red; font-weight: bold;">
                        <?php echo $msg2?>
                    </span>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>