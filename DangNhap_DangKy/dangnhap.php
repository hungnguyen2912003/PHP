<?php

$msg = "";
$username = "";
$password = "";

$connect = mysqli_connect("localhost", "root", "", "login_register")
OR die ('Không thể kết nối MySQL: ' . mysqli_connect_error() );

if(isset($_POST["dangNhap"])){
    if(!empty($_POST["username"]) && !empty($_POST["password"])){
        $username = mysqli_real_escape_string($connect, $_POST["username"]);
        $password = mysqli_real_escape_string($connect, $_POST["password"]);
        $sql = "SELECT * FROM user WHERE username = '$username' && password = '$password'";
        if(mysqli_fetch_row(mysqli_query($connect, $sql)) == 0)
        {
            $msg = "Tài khoản hoặc mật khẩu không hợp lệ";
        }
        else{
            mysqli_query($connect, $sql);
            $msg = "Đăng nhập thành công";
            header('location: trangchu.php');
        }
    }
    else
        $msg = "Các trường không được bỏ trống";
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
        width: 40%;
        border: 2px solid black;
        border-collapse: collapse;
        margin: 0 auto;
    }
    input{
        width: 80%;
    }
</style>

<form method="POST" action="">
    <table>
        <tr>
            <td colspan="2" style="text-align:center;">
                <h2>Đăng nhập</h2>
            </td>
        </tr>
        <tr>
            <td style="text-align:right;">
                <label>Tên đăng nhập</label>
            </td>
            <td>
                <input type="text" name="username" value=""/>
            </td>
        </tr>
        <tr>
            <td style="text-align:right;">
                <label>Mật khẩu</label>
            </td>
            <td>
                <input type="password" name="password" value=""/>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center">
                <input type="submit" name="dangNhap" value="Đăng nhập" style="width: 100px;height: 30px;"/>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center">
                <a href="dangky.php">Đăng ký ngay</a>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center">
                <?php echo $msg?>
            </td>
        </tr>

    </table>
</form>