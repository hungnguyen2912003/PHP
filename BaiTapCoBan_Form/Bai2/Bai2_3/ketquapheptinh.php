<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
        }
        table {
            width: 500px;
            border: none;
            border-collapse: collapse;
            margin: 0 auto;
        }
        
        h2{
            text-align: center;
        }
        input[type="text"] {
            width: 300px;
        }
        td{
            padding: 5px;
        }
    </style>

</head>
<body>
<?php

    $soThuNhat = $_POST['soThuNhat'];
    $soThuHai = $_POST['soThuHai'];
    $phepTinh = "";
    $ketQua = 0;
    $msg = "";

    if(isset($_POST['tinh'])) 
    {
        if(isset($_POST['ptCong']) || isset($_POST['ptTru']) || isset($_POST['ptNhan']) || isset($_POST['ptChia'])){
            if(isset($_POST['soThuNhat']) && isset($_POST['soThuHai'])){
                if(is_numeric($soThuNhat) && is_numeric($soThuHai))
                {
                    if(isset($_POST['ptCong'])) {
                        $phepTinh = 'Cộng';
                        $ketQua = $soThuNhat + $soThuHai;
                    } elseif(isset($_POST['ptTru'])) {
                        $phepTinh = 'Trừ';
                        $ketQua = $soThuNhat - $soThuHai;
                    } elseif(isset($_POST['ptNhan'])) {
                        $phepTinh = 'Nhân';
                        $ketQua = $soThuNhat * $soThuHai;
                    } elseif(isset($_POST['ptChia'])) {
                        $phepTinh = 'Chia';
                        if($soThuHai != 0) {
                            $ketQua = $soThuNhat / $soThuHai;
                        } else {
                            echo 'Không thể chia cho 0.';
                            exit;
                        }
                    }
                }
                else
                {
                    $msg = "Vui lòng nhập số thứ nhất và số thứ hai dưới dạng chữ số";
                }
            }
            else{
                $msg = "Vui lòng nhập đầy đủ thông tin";
            }
        }
        else{
            $msg = "Vui lòng lựa chọn phép tính";
        }
    }
?>
    <table>
            <thead>
                <tr>
                    <td colspan="5">
                        <h2>PHÉP TÍNH TRÊN HAI SỐ</h2>
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: right; color: #995D14; font-weight: bold;">Chọn phép tính :</td>
                    <td style="color: red; font-weight: bold;">
                        <?php  echo $phepTinh;?>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right; color: blue; font-weight: bold;">Số thứ nhất :</td>
                    <td colspan="4">
                        <input type="text" name="soThuNhat" value="<?php  echo $soThuNhat;?>">
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right; color: blue; font-weight: bold;">Số thứ hai :</td>
                    <td colspan="4">
                        <input type="text" name="soThuHai" value="<?php  echo $soThuHai;?>">
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right; color: blue; font-weight: bold;">Kết quả :</td>
                    <td colspan="4">
                        <input type="text" name="ketQua" value="<?php  echo $ketQua;?>">
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" style="text-align: center; font-style: italic;">
                        <a href="javascript:window.history.back(-1);">Trở về trang trước</a>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" style="text-align: center;">
                        <span style="color: red;"><?php  echo $msg;?></span>
                    </td>
                </tr>
            </tfoot>
    </table>
</body>
</html>



