<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tính tiền điện</title>

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
            width: 400px;
            border: none;
            border-collapse: collapse;
            text-align: center;
            margin: 0 auto;
        }

        .title {
            background-color: #FCD86C;
            height: 50px;
        }

        h2 {
            font-style: italic;
            font-weight: bold;
            color: #995D14;
            margin: 0;
        }

        label {
            text-align: left;
            display: inline-block;
            width: 150px;
            color: #cc3300;
            font-weight: bold;
            font-size: 14px;
        }

        input[type="text"] {
            width: 200px;
        }

        span {
            color: #333;
        }

        td {
            padding: 10px 10px;
        }

        tbody,tfoot{
            background-color: #FFF4D4;
        }

        .errorMsg{
            color: red;
        }

    </style>
</head>
<body>

    <?php
        $error = "";
        $tenChuHo = "";
        $soTien = 0;

        if(isset($_POST['chisoCu'])) 
            $chisoCu=trim($_POST['chisoCu']); 
        else $chisoCu=0;


        if(isset($_POST['chisoMoi'])) 
            $chisoMoi=trim($_POST['chisoMoi']); 
        else $chisoMoi=0;

        if(isset($_POST['donGia'])) 
            $donGia=trim($_POST['donGia']); 
        else $donGia=2000;

        if(isset($_POST['tinh'])) {
            if(isset($_POST['tenChuHo']) && !empty($_POST['tenChuHo'])) {
                $tenChuHo = trim($_POST['tenChuHo']);
        
                if (isset($_POST['chisoCu']) && isset($_POST['chisoMoi'])) {
                    if (is_numeric($chisoCu) && is_numeric($chisoMoi)) {
                        if ($chisoMoi > $chisoCu) {
                            $soTien = ($chisoMoi - $chisoCu) * $donGia;
                        } 
                        else {
                            $error = "Chỉ số mới phải lớn hơn chỉ số cũ!";
                            $soTien = 0;
                        }
                    } else {
                        $error = "Vui lòng nhập chỉ số cũ hoặc chỉ số mới là số!";
                        $soTien = 0;
                    }
                } else {
                    $error = "Vui lòng nhập đầy đủ thông tin!";
                    $soTien = 0;
                }
            } else {
                $error = "Vui lòng nhập tên chủ hộ!";
                $soTien = 0;
            }
        }
    ?>

    <form action="" method="post">
        <table>
            <thead>
                <tr>
                    <td colspan="3" class="title">
                        <h2>THANH TOÁN TIỀN ĐIỆN</h2>
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <label>Tên chủ hộ</label>
                    </td>
                    <td>
                        <input type="text" name="tenChuHo" value="<?php  echo $tenChuHo;?>">
                    </td>
                    <td></td>
                </tr>

                <tr>
                    <td>
                        <label>Chỉ số cũ</label>
                    </td>
                    <td>
                        <input type="text" name="chisoCu" value="<?php  echo $chisoCu;?>">
                    </td>
                    <td style="color: #cc3300;">(Kw)</td>
                </tr>

                <tr>
                    <td>
                        <label>Chỉ số mới</label>
                    </td>
                    <td>
                        <input type="text" name="chisoMoi" value="<?php  echo $chisoMoi;?>">
                    </td>
                    <td style="color: #cc3300;">(Kw)</td>
                </tr>

                <tr>
                    <td>
                        <label>Đơn giá</label>
                    </td>
                    <td>
                        <input type="text" name="donGia" value="<?php  echo $donGia;?>">
                    </td>
                    <td style="color: #cc3300;">(VNĐ)</td>
                </tr>

                <tr>
                    <td>
                        <label>Số tiền thanh toán</label>
                    </td>
                    <td>
                        <input type="text" name="soTien" readonly style="background-color: #ffcccc" value="<?php  echo $soTien;?>">
                    </td>
                    <td style="color: #cc3300;">(VNĐ)</td>
                </tr>

            </tbody>
            <tfoot>
                
            <tr>
                <td colspan="3">
                    <input type="submit" name="tinh" value="Tính">
                </td>
            </tr>

            <tr>
                <td colspan="3">
                    <span class="errorMsg"><?php  echo $error;?></span>
                </td>
            </tr>
            </tfoot>
            
        </table>
    </form>
    
</body>
</html>