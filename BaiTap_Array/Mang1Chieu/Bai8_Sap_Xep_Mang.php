<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài 8 - Mảng 1 chiều</title>
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
            background-color: #D1DED4;
        }
        input[type='text']{

            height: 30px;
            font-size: 20px;
        }
        input[type='submit']{
            width: 200px;
            height: 30px;
            font-size: 18px;
            /*background-color: #8FCCFC;*/
            font-weight: bold;
        }
        td{
            padding: 10px;
        }
    </style>
</head>
<body>

<?php
    $mang = "";
    $mang_sxGiamDan = "";
    $mang_sxTangDan = "";
    $msg = "";
    $arr = array();
    function hoanVi(&$a, &$b): void
    {
        $temp = $a;
        $a = $b;
        $b = $temp;
    }

    function sapXepTang($mang)
    {
        for($i = 0; $i < count($mang) - 1; $i++){
            for($j = $i + 1; $j < count($mang); $j++){
                if($mang[$i] > $mang[$j]){
                    hoanVi($mang[$i], $mang[$j]);
                }
            }
        }
        return $mang;
    }

    function sapXepGiam($mang)
    {
        for($i = 0; $i < count($mang) - 1; $i++){
            for($j = $i + 1; $j < count($mang); $j++){
                if($mang[$i] < $mang[$j]){
                    hoanVi($mang[$i], $mang[$j]);
                }
            }
        }
        return $mang;
    }

    if(isset($_POST["sapXep"])){
        if(!empty($_POST["mang"])){
            $mang = $_POST["mang"];
            $mang = preg_replace('/\s+/', '', $_POST['mang']);
            if(preg_match('/^(\d+(,\d+)*)?$/', $mang)){
                $arr = array_map("trim", explode(",", $mang));
                $mang_sxTangDan = implode(",", sapXepTang($arr));
                $mang_sxGiamDan = implode(",", sapXepGiam($arr));
            }
            else
                $msg = "Vui lòng nhập mảng đúng định dạng. Các phần tử ngăn cách nhau bởi dấu ','";
        }
        else{
            $msg = "Vui lòng nhập mảng";
        }
    }

?>

<form action="Bai8_Sap_Xep_Mang.php" method="post">
    <table >
        <tr>
            <td colspan="2" style="background-color: #339A99;">
                <h2 style="font-style: italic; font-weight: bold; color: #ffffff; text-align: center;">SẮP XẾP MẢNG</h2>
            </td>
        </tr>
        <tr>
            <td style="color: #006666; width: 300px; font-weight: bold;">Nhập mảng: </td>
            <td>
                <input type="text" name="mang" style="width: 500px;" value="<?php echo $mang?>"> <span style="font-weight: bold; color: red;">(*)</span>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type="submit" name="sapXep" value="Sắp xếp tăng/giảm">
            </td>
        </tr>
        <tr>
            <td>
                <p style="color: red; font-weight: bold;">Sau khi sắp xếp</p>
            </td>
        </tr>
        <tr>
            <td style="color: #006666; font-weight: bold;">Tăng dần: </td>
            <td>
                <input type="text" name="mangTangDan" readonly style="width: 500px;" value="<?php echo $mang_sxTangDan?>">
            </td>
        </tr>
        <tr>
            <td style="color: #006666; font-weight: bold;">Giảm dần: </td>
            <td>
                <input type="text" name="mangGiamDan" readonly style="width: 500px;" value="<?php echo $mang_sxGiamDan?>">
            </td>
        </tr>

        <tr style="text-align: center; background-color: #76D2D1;">
            <td colspan="2">
                (Các phần tử trong mảng sẽ cách nhau bằng dấu ",")
                <p style="color: red; font-weight: bold"><?php echo $msg?></p>
            </td>
        </tr>
    </table>
</form>
</body>
</html>