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
            background-color: #8FCCFC;
            font-weight: bold;
        }
        td{
            padding: 10px;
        }
    </style>
</head>
<body>

<?php
    function timKiem($mang, $giaTri): int
    {
        for ($i = 0; $i < count($mang); $i++){
            if ($mang[$i] == $giaTri) {
                return $i;
            }
        }
        return -1;
    }

    $msg = "";
    $mang = "";
    $mang_hienthi = "";
    $num = "";
    $kqua = "";
    $arr = array();



    if(isset($_POST["timKiem"])){
        if(!empty($_POST["mang"])){
            $mang = $_POST["mang"];
            $mang = preg_replace('/\s+/', '', $_POST['mang']);
            if(preg_match('/^(\d+(,\d+)*)?$/', $mang)){
                $arr = explode(",", $mang);
                if(!empty($_POST["num"])){
                    $num = $_POST["num"];
                    if(is_numeric($_POST["num"])){
                        $mang_hienthi = implode(",", $arr);
                        $pos = timKiem($arr, $num);
                        if($pos != -1){
                            $kqua = "Tìm thấy $num tại vị trí thứ $pos của mảng";
                        }
                        else{
                            $kqua = "Không tìm thấy $num trong mảng";
                        }
                    } else {
                        $msg = "Vui lòng nhập dữ liệu tìm kiếm là một số cụ thể";
                    }
                } else {
                    $msg = "Vui lòng nhập phần tử cần tìm kiếm vào ô 'Tìm kiếm'";
                }
            } else {
                $msg = "Vui lòng nhập dữ liệu đúng định dạng. Các phần tử trong mảng cách nhau bởi dấu ','";
            }
        }
        else
            $msg = "Vui lòng nhập mảng";
    }

?>

    <form action="Bai6_Tim_Kiem.php" method="post">
        <table >
            <tr>
                <td colspan="2" style="background-color: #339A99;">
                    <h2 style="font-style: italic; font-weight: bold; color: #ffffff; text-align: center;">TÌM KIẾM</h2>
                </td>
            </tr>
            <tr>
                <td style="color: #006666; width: 300px; font-weight: bold;">Nhập mảng: </td>
                <td>
                    <input type="text" name="mang" style="width: 500px;" value="<?php echo $mang?>">
                </td>
            </tr>
            <tr>
                <td style="color: #006666; width: 300px; font-weight: bold;">Nhập số cần tìm: </td>
                <td>
                    <input type="text" name="num" style="width: 200px;" value="<?php echo $num?>">
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" name="timKiem" value="Tìm kiếm">
                </td>
            </tr>
            <tr>
                <td style="color: #006666; font-weight: bold;">Mảng: </td>
                <td>
                    <input type="text" name="mang_kq" readonly style="width: 500px;" value="<?php echo $mang_hienthi?>">
                </td>
            </tr>
            <tr>
                <td style="color: #006666; font-weight: bold;">Kết quả tìm kiếm: </td>
                <td>
                    <input type="text" name="kqua" readonly style="width: 500px; color: red; font-weight: bold;" value="<?php echo $kqua?>">
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