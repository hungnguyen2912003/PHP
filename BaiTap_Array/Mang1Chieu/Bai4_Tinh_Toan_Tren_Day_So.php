<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mảng 1 chiều</title>
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
            width: 700px;
            border: none;
            border-collapse: collapse;
            background-color: #D1DED4;
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
            background-color: #ffff99;
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
    $daySo = "";
    $sum = 0;
    $arr = array();

    if(isset($_POST['tinhToan'])){
        if(!empty($_POST['daySo'])){
            $daySo = $_POST['daySo'];
            //Loại bỏ tất cả khoảng trắng
            $daySo = preg_replace('/\s+/', '', $_POST['daySo']);
            //Kiểm tra dãy số đúng định dạng
            if(preg_match('/^(\d+(,\d+)*)?$/', $daySo)){
                $arr = explode(",", $daySo);
                foreach($arr as $s){
                    $sum += (int)$s;
                }
            } else {
                $msg = "Dãy số không hợp lệ. Vui lòng nhập các số nguyên cách nhau bằng dấu ','";
            }
        }
        else{
            $msg = "Vui lòng nhập dữ liệu vào ô 'Dãy số'";
        }
    }
?>

    <form action="Bai4_Tinh_Toan_Tren_Day_So.php" method="post">
        <table >
            <tr>
                <td colspan="2" style="background-color: #009999">
                    <h2 style="font-style: italic; font-weight: bold; color: #ffffff; text-align: center;">NHẬP VÀ TÍNH TRÊN DÃY SỐ</h2>
                </td>
            </tr>
            <tr>
                <td style="color: #800000; width: 200px; text-align: center;">Nhập dãy số: </td>
                <td>
                    <input type="text" name="daySo" value="<?php echo $daySo?>"> <span style="color: red; font-weight: bold;">(*)</span>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <input type="submit" name="tinhToan" value="Tổng dãy số" style="color: #000066; ">
                </td>
            </tr>
            <tr>
                <td style="color: #800000; width: 200px; text-align: center;">Tổng dãy số: </td>
                <td>
                    <input type="text" name="sum" style="color: red; font-weight: bold; background-color: #BAE88E" readonly value="<?php echo $sum?>">
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <span style="color: red; font-weight: bold;">(*)</span> Các số được nhập cách nhau bằng dấu ","
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <span style="color: red; font-weight: bold">
                        <?php echo $msg?>
                    </span>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>