<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài 9 - Mảng 1 chiều</title>
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
    $mangA = "";
    $mangB = "";
    $mangC = "";
    $mangCtangdan = "";
    $mangCgiamdan = "";
    $a = array();
    $b = array();
    $c = array();
    $slmangA = "";
    $slmangB = "";
    $msg = "";

    if(isset($_POST["thucHien"])){
        if(!empty($_POST["mangA"]) && !empty($_POST["mangB"])){
            $mangA = $_POST["mangA"];
            $mangB = $_POST["mangB"];
            $mangA = preg_replace('/\s+/', '', $_POST['mangA']);
            $mangB = preg_replace('/\s+/', '', $_POST['mangB']);
            if(preg_match('/^(\d+(,\d+)*)?$/', $mangA) && preg_match('/^(\d+(,\d+)*)?$/', $mangB)){
                $a = array_map("trim", explode(",", $mangA));
                $slmangA = count($a);
                $b = array_map("trim", explode(",", $mangB));
                $slmangB = count($b);
                $c = array_merge($a, $b);
                $mangC = implode(",", $c);
                $cTang = $c;
                sort($cTang);
                $mangCtangdan = implode(",", $cTang);
                $cGiam = $c;
                rsort($cGiam);
                $mangCgiamdan = implode(",", $cGiam);
            }
            else
                $msg = "Vui lòng nhập mảng đúng định dạng. Các phần tử ngăn cách nhau bởi dấu ','";
        }
        else{
            $msg = "Vui lòng nhập mảng A và mảng B";
        }
    }

?>

<form action="Bai9_Gop_Mang.php" method="post">
    <table >
        <tr>
            <td colspan="2" style="background-color: #A70F75;">
                <h2 style="font-style: italic; font-weight: bold; color: #ffffff; text-align: center;">ĐẾM PHẦN TỬ, GHÉP MẢNG VÀ SẮP XẾP</h2>
            </td>
        </tr>
        <tr style="background-color: #FFDBF6;">
            <td style="color: #cc0099; width: 300px; font-weight: bold;">Mảng A: </td>
            <td>
                <input type="text" name="mangA" style="width: 600px;" value="<?php echo $mangA?>">
            </td>
        </tr>
        <tr style="background-color: #FFDBF6;">
            <td style="color: #cc0099; width: 300px; font-weight: bold;">Mảng B: </td>
            <td>
                <input type="text" name="mangB" style="width: 600px;" value="<?php echo $mangB?>">
            </td>
        </tr>

        <tr style="background-color: #FFDBF6">
            <td></td>
            <td>
                <input type="submit" name="thucHien" value="Thực hiện">
            </td>
        </tr>

        <tr>
            <td style="color: #cc0099; font-weight: bold;">Số phần tử của mảng A: </td>
            <td>
                <input type="text" name="slmangA" readonly style="width: 200px; background-color: #FFA3A2;" value="<?php echo $slmangA?>">
            </td>
        </tr>
        <tr>
            <td style="color: #cc0099; font-weight: bold;">Số phần tử của mảng B: </td>
            <td>
                <input type="text" name="slmangB" readonly style="width: 200px; background-color: #FFA3A2;" value="<?php echo $slmangB?>">
            </td>
        </tr>
        <tr>
            <td style="color: #cc0099; font-weight: bold;">Mảng C: </td>
            <td>
                <input type="text" name="mangC" readonly style="width: 600px; background-color: #FFA3A2;" value="<?php echo $mangC?>">
            </td>
        </tr>
        <tr>
            <td style="color: #cc0099; font-weight: bold;">Mảng C tăng dần: </td>
            <td>
                <input type="text" name="mangCtangdan" readonly style="width: 600px; background-color: #FFA3A2;" value="<?php echo $mangCtangdan?>">
            </td>
        </tr>
        <tr>
            <td style="color: #cc0099; width: 300px; font-weight: bold;">Mảng C giảm dần: </td>
            <td>
                <input type="text" name="mangCgiamdan" readonly style="width: 600px; background-color: #FFA3A2;" value="<?php echo $mangCgiamdan?>">
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