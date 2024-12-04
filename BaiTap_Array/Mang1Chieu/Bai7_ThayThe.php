<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài 7 - Mảng 1 chiều</title>
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
            width: 150px;
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
    $mang = "";
    $gtcanthaythe = "";
    $gtthaythe = "";
    $msg = "";
    $mang_cu = "";
    $mang_thayThe = "";
    $arr = array();

    function thay_the($mang, $cu, $moi)
    {
        for($i = 0; $i < count($mang); $i++){
            if($mang[$i] == $cu){
                $mang[$i] = $moi;
            }
        }
        return $mang;
    }

    if(isset($_POST["thayThe"])){
        if(!empty($_POST["mang"])){
            $mang = $_POST["mang"];
            $mang = preg_replace('/\s+/', '', $_POST['mang']);
            if(preg_match('/^(\d+(,\d+)*)?$/', $mang)){
                $arr = array_map('trim', explode(",", $mang));
                $mang_cu = implode(",", $arr);
                if(isset($_POST["gtcanthaythe"]) && isset($_POST["gtthaythe"])){
                    if(is_numeric($_POST["gtcanthaythe"]) && is_numeric($_POST["gtthaythe"])){
                        $gtcanthaythe = trim($_POST["gtcanthaythe"]);
                        $gtthaythe = trim($_POST["gtthaythe"]);
                        // Thay thế giá trị cũ thành giá trị mới trong mảng
                        $arr = thay_the($arr, $gtcanthaythe, $gtthaythe);
                        $mang_thayThe = implode(",", $arr); // Chuỗi hiển thị mảng sau thay thế
                    }
                    else{
                        $msg = "Nhập giá trị cần thay thế và giá trị thay thế là một số";
                    }
                }
                else{
                    $msg = "Vui lòng nhập giá trị cần thay thế và giá trị thay thế";
                }
            }
            else
                $msg = "Vui lòng nhập mảng đúng định dạng. Các phần tử ngăn cách nhau bởi dấu ','";
        }
        else{
            $msg = "Vui lòng nhập mảng";
        }
    }
?>

<form action="Bai7_ThayThe.php" method="post">
    <table >
        <tr>
            <td colspan="2" style="background-color: #A70F75;">
                <h2 style="font-style: italic; font-weight: bold; color: #ffffff; text-align: center;">THAY THẾ</h2>
            </td>
        </tr>
        <tr style="background-color: #FFDBF6;">
            <td style="color: #cc0099; width: 300px; font-weight: bold;">Nhập các phần tử: </td>
            <td>
                <input type="text" name="mang" style="width: 600px;" value="<?php echo $mang?>">
            </td>
        </tr>
        <tr style="background-color: #FFDBF6;">
            <td style="color: #cc0099; width: 300px; font-weight: bold;">Giá trị cần thay thế: </td>
            <td>
                <input type="text" name="gtcanthaythe" style="width: 200px;" value="<?php echo $gtcanthaythe?>">
            </td>
        </tr>
        <tr style="background-color: #FFDBF6;">
            <td style="color: #cc0099; width: 300px; font-weight: bold;">Giá trị thay thế: </td>
            <td>
                <input type="text" name="gtthaythe" style="width: 200px;" value="<?php echo $gtthaythe?>">
            </td>
        </tr>
        <tr style="background-color: #FFDBF6">
            <td></td>
            <td>
                <input type="submit" name="thayThe" value="Thay thế">
            </td>
        </tr>

        <tr>
            <td style="color: #cc0099; font-weight: bold;">Mảng cũ: </td>
            <td>
                <input type="text" name="mang_cu" readonly style="width: 600px; background-color: #FFA5A3;" value="<?php echo $mang_cu?>">
            </td>
        </tr>
        <tr>
            <td style="color: #cc0099; font-weight: bold;">Mảng sau khi thay thế: </td>
            <td>
                <input type="text" name="mang_thayThe" readonly style="width: 600px; background-color: #FFA5A3;" value="<?php echo $mang_thayThe?>">
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;">
                (<span style="color: red; font-weight: bold">
                        Ghi chú:
                    </span> Các phần tử trong mảng sẽ cách nhau bằng dấu ",")
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