<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài 1 - Mảng 1 chiều</title>
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
            border: 2px solid black;

            margin: 0 auto;
            border-radius: 20px;
        }   
        td{
            padding: 10px;
        }
        input[type='text']{
            width: 500px;
            height: 30px;
            font-size: 20px;
        }
        input[type='submit']{
            width: 150px;
            height: 30px;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <?php
        $msg = "";
        $arr = array();
        $num = "";
        $count_even = "";
        $count_lessthan100 = "";
        $sumgtam = "";
        $viTri = "";
        $ketqua = "";

        function demSoChan($arr): int
        {
            $count = 0;
            //Đếm số chẵn trong mảng
            foreach($arr as $e){
                if($e % 2 == 0){
                    $count++;
                }
            }
            return $count;
        }

        //Đếm phần tử có giá trị là số nhỏ hơn 100.
        function demGiaTriNhoHon100($arr): int
        {

            $count = 0;
            foreach($arr as $s){
                if($s < 100){
                    $count++;
                }
            }
            return $count;
        }

        //Tổng giá trị âm
        function TongGTAm($arr): int
        {
            $sum = 0;
            foreach($arr as $s){
                if($s < 0){
                    $sum += $s;
                }
            }
            return $sum;
        }

        function viTriKeCuoi($arr): string
        {
            //vị trí của các thành phần trong mảng có chữ số kề cuối là 0.
            $positions = array(); // Mảng lưu vị trí
            foreach ($arr as $key => $value) {
                // Lấy chữ số cuối cùng của phần tử
                $lastDigit = $value % 10;

                // Kiểm tra nếu chữ số cuối cùng là 0
                if ($lastDigit === 0) {
                    // Lưu vị trí của phần tử vào mảng $positions
                    $positions[] = $key;
                }
            }
            return implode(", ", $positions);
        }


        function sapXepMang($arr): string
        {
            //Sắp xếp mảng
            $sort_arr = $arr;
            sort($sort_arr);
            return implode(", ", $sort_arr);
        }

        if(isset($_POST['thucHien'])){
            if(!empty($_POST['num'])){
                $num = $_POST['num'];
                if($num > 0 && ctype_digit($num)){
                    for($i = 0; $i < $num; $i++)
                    {
                        $x = rand(-500, 500);
                        $arr[$i] = $x;
                    }
                    $count_even = demSoChan($arr);
                    $count_lessthan100 = demGiaTriNhoHon100($arr);
                    $sumgtam = TongGTAm($arr);
                    $viTri = viTriKeCuoi($arr);

                    //Hiển thị mảng
                    $ketqua = sapXepMang($arr);
                }
                else
                    $msg = 'Vui lòng nhập n là một số nguyên và lớn hơn 0';

            }
            else{
                $msg = 'Vui lòng nhập n!';
            }
        }
    ?>
    <form action="" method="post">
        <table>
            <tr>
                <td style="text-align: center;" colspan="2">
                    <h2>Tạo mảng</h2>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Nhập n: </label>
                </td>
                <td>
                    <input type="text" name="num" value="<?php echo trim($num)?>">
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <input type="submit" name="thucHien" value="Thực hiện">
                </td>
            </tr>
            <tr>
                <td>
                    <label>Mảng được tạo: </label>
                </td>
                <td>
                    <?php echo $ketqua?>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    Có <span style="font-weight: bold; color: red;"><?php echo $count_even?></span> thành phần trong mảng có giá trị là số chẵn
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    Có <span style="font-weight: bold; color: red;"><?php echo $count_lessthan100?></span> thành phần trong mảng có giá trị là số nhỏ hơn 100
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    Tổng của các thành phần trong mảng giá trị là số âm: <span style="font-weight: bold; color: red;"><?php echo $sumgtam?></span>
                </td>
            </tr>   
            <tr>
                <td colspan="2" style="text-align: center;">
                    Vị trí của các thành phần trong mảng có chữ số kề cuối là 0:
                    <span style="font-weight: bold; color: red;">
                    <?php
                        if(!empty(viTriKeCuoi($arr, $num)))
                            echo $viTri;
                        else{
                            echo "Không có";
                        }
                    ?>
                    </span>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Mảng sau khi sắp xếp tăng dần: </label>
                </td>
                <td>
                    <?php
                        echo $ketqua;
                    ?>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <label style="color: red; font-weight: bold;"><?php echo $msg?></label>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>