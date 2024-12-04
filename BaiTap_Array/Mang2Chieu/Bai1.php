<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo ma trận</title>

    <style>
        td{
            padding: 5px;
        }
    </style>
</head>
<body>

<?php
$msg = "";
$soDong = "";
$soCot = "";
$maTran = "";
$arr = array();
$sum = 0;

if (isset($_POST["taoMaTran"])) {
    if (!empty($_POST["soDong"]) && !empty($_POST["soCot"])) {
        $soDong = $_POST["soDong"];
        $soCot = $_POST["soCot"];

        if ($soDong >= 2 && $soDong <= 5 && $soCot >= 2 && $soCot <= 5) {
            $maTran = "Ma trận vừa tạo là: \n";
            for ($i = 0; $i < $soDong; $i++) {
                for ($j = 0; $j < $soCot; $j++) {
                    $arr[$i][$j] = rand(-1000, 1000);
                    $maTran .= $arr[$i][$j] . "\t";  // Thêm giá trị vào chuỗi ma trận
                }
                $maTran .= "\n";  // Xuống dòng sau khi hoàn thành một hàng
            }
            $maTran .= "Các phần tử thuộc dòng chẵn cột lẻ của ma trận là: ";
            for ($i = 0; $i < $soDong; $i++) {
                for ($j = 0; $j < $soCot; $j++) {
                    if($i % 2 == 1 && $j % 2 == 0)
                        $maTran .= $arr[$i][$j] . "\t";  // Thêm giá trị vào chuỗi ma trận
                }
                $maTran .= "\n";  // Xuống dòng sau khi hoàn thành một hàng
            }

            $maTran .= "Tổng các phần tử là bội số của 10 của ma trận là: ";
            for ($i = 0; $i < $soDong; $i++) {
                for ($j = 0; $j < $soCot; $j++) {
                    if ($arr[$i][$j] % 10 == 0) {
                        $sum += $arr[$i][$j];
                    }
                }
            }
            $maTran .= "$sum";

        } else {
            $msg = "Nhập vào số dòng và cột từ 2 đến 5.";
        }
    } else {
        $msg = "Vui lòng nhập số dòng và số cột của ma trận.";
    }
}
?>

<form action="" method="post">
    <table>
        <tr>
            <td>Nhập số dòng (m): </td>
            <td>
                <label>
                    <input type="text" name="soDong" value="<?php echo $soDong; ?>"/>
                </label>
            </td>
        </tr>
        <tr>
            <td>Nhập số cột (n): </td>
            <td>
                <label>
                    <input type="text" name="soCot" value="<?php echo $soCot; ?>"/>
                </label>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center;">
                <input type="submit" name="taoMaTran" value="Tạo ma trận">
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <label>
                    <textarea rows="10" cols="50" style="font-size: 16px" readonly><?php echo $maTran; ?></textarea>
                </label>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <label style="color: red; font-weight: bold;"><?php echo $msg; ?></label>
            </td>
        </tr>
    </table>
</form>
</body>
</html>
