<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>

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
    <form action="ketquapheptinh.php" method="post">
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
                    <td style="text-align: right; color: blue; font-weight: bold;">Chọn phép tính :</td>
                    <td>
                        <input type="radio" name="ptCong"> <span style="color: red;">Cộng</span>
                    </td>
                    <td>
                        <input type="radio" name="ptTru"> <span style="color: red;">Trừ</span>
                    </td>
                    <td>
                        <input type="radio" name="ptNhan"> <span style="color: red;">Nhân</span>
                    </td>
                    <td>
                        <input type="radio" name="ptChia"> <span style="color: red;">Chia</span>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right; color: red; font-weight: bold;">Số thứ nhất :</td>
                    <td colspan="4">
                        <input type="text" name="soThuNhat">
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right; color: red; font-weight: bold;">Số thứ hai :</td>
                    <td colspan="4">
                        <input type="text" name="soThuHai">
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" style="text-align: center;">
                        <input type="submit" name="tinh" value="Tính">
                    </td>
                </tr>


            </tfoot>
        </table>
    </form>
</body>
</html>