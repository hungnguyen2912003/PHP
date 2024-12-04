<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài 3 - Mảng 1 chiều</title>
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
            width: 800px;
            border: none;
            border-collapse: collapse;
            background-color: #B8EEFF;
        }
        input[type='text']{

            height: 30px;
            font-size: 20px;
        }
        td{
            padding: 10px;
        }
        h2{
            font-weight: bold;
            font-style: italic;
            color: white;
            
        }
    </style>
</head>
<body>

<?php
    $nam = "";
    $nam_al = "";
    $msg = "";
    $hinh_anh = "";
    $mang_can = array("Quý", "Giáp", "Ất", "Bính", "Đinh", "Mậu", "Kỷ", "Canh", "Tân", "Nhâm");
    $mang_chi = array("Hợi", "Tý", "Sửu", "Dần", "Mão", "Thìn", "Tỵ", "Nhọ", "Mùi", "Thân", "Dậu", "Tuất");
    $mang_hinh = array("hoi.jpg", "ty.jpg", "suu.jpg", "dan.jpg", "meo.jpg", "thin.jpg", "ran.jpg", "ngo.jpg", 
                        "mui.jpg", "than.jpg", "dau.jpg", "tuat.jpg");

    if(isset($_POST['thucHien'])){
        if(!empty($_POST['nam'])){
            if(ctype_digit($_POST['nam'])){
                $nam = $_POST['nam'];
                $namtam = $nam - 3;
                $can = $namtam % 10;
                $chi = $namtam % 12;
                $nam_al = $mang_can[$can] . " " . $mang_chi[$chi];
                $hinh = $mang_hinh[$chi];
                $hinh_anh = "<img src='images/$hinh' style = 'width: 300px;'>";
            }
            else{
                $msg = 'Vui lòng nhập năm là một con số nguyên!';
            }
        }
        else{
            $msg = 'Vui lòng nhập năm!';
        }
    }
?>
    <form action="Bai3_Tim_Nam_Am_Lich.php" method="post">
        <table>
            <tr>
                <td colspan="3" style="text-align: center; background-color: #0D63C6;">
                    <h2>TÍNH NĂM ÂM LỊCH</h2>
                </td>

            </tr>
            <tr>
                <td style="text-align: center; color: #000066; font-weight: bold;">
                    Năm dương lịch
                </td>
                <td>
                    
                </td>
                <td style="text-align: center; color: #000066; font-weight: bold;">
                    Năm âm lịch
                </td>
            </tr>
            <tr style="text-align: center;">
                <td><input type="text" name="nam" value="<?php echo $nam?>"></td>
                <td>
                    <button type="submit" name="thucHien" style="color: red; background-color: #FFFFD3; font-weight: bold;">=></button>
                </td>
                <td><input type="text" name="amLich" style="color: red; background-color: #FFFFD3; font-weight: bold;" readonly value="<?php echo $nam_al ?>"></td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: center;">
                    <?php echo $hinh_anh?>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: center; color: red;">
                    <?php echo $msg?>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>