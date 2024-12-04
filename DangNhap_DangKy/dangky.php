<?php

$msg = "";
$username = "";
$password = "";
$confirm_password = "";

$connect = mysqli_connect("localhost", "root", "", "login_register")
OR die ('Không thể kết nối MySQL: ' . mysqli_connect_error() );

if(isset($_POST["dangKy"])){
    $username = mysqli_real_escape_string($connect, $_POST["username"]);
    $password = mysqli_real_escape_string($connect, $_POST["password"]);
    $confirm_password = $_POST["confirm_password"];

    if(!empty($username) && !empty($password) && !empty($confirm_password)){
        if($password == $confirm_password){
            $sql = "INSERT INTO user (username, password) VALUES ('$username', '$password')";
            if(mysqli_query($connect, $sql)){
                $msg = "Đăng ký thành công";
            } else {
                $msg = "Đăng ký thất bại";
            }
        } else {
            $msg = "Mật khẩu không khớp";
        }
    } else {
        $msg = "Các trường không được bỏ trống";
    }
}

?>
<style>
    a{
        text-decoration: none;
    }
    td{
        padding: 10px;
    }
    table{
        width: 60%;
        border: 2px solid black;
        border-collapse: collapse;
        margin: 0 auto;
    }
    input{
        width: 80%;
        padding: 5px;
    }
</style>

<form method="POST" action="">
    <table>
        <tr>
            <td colspan="2" style="text-align:center;">
                <h2>Đăng ký</h2>
            </td>
        </tr>
        <tr>
            <td style="text-align:right;">
                <label>Tên đăng nhập</label>
            </td>
            <td>
                <input type="text" name="username" value="<?php echo $username ?>"/>
            </td>
        </tr>
        <tr>
            <td style="text-align:right;">
                <label>Mật khẩu</label>
            </td>
            <td>
                <input type="password" name="password" value="<?php echo $password ?>"/>
            </td>
        </tr>
        <tr>
            <td style="text-align:right;">
                <label>Xác nhận mật khẩu</label>
            </td>
            <td>
                <input type="password" name="confirm_password" value="<?php echo $confirm_password ?>"/>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center">
                <input type="submit" name="dangKy" value="Đăng ký" style="width: 100px; height: 30px;"/>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center">
                <a href="dangnhap.php">Đăng nhập ngay</a>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center">
                <?php echo $msg ?>
            </td>
        </tr>
    </table>
</form>