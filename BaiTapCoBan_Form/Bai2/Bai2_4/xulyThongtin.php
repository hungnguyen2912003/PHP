<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin người dùng</title>
    <style>
        h2{
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>Bạn đã đăng nhập thành công, dưới đây là những thông tin bạn nhập: </h2>
    <p><strong>Họ tên:</strong>
    
    <?php
        if(isset($_POST['hoTen'])){
            echo $_POST['hoTen']; 
        } 
        else
            echo "Chưa nhập họ tên";
     ?>
    </p>
    <p><strong>Địa chỉ:</strong> 
    <?php 
        if(isset($_POST['diaChi'])){
            echo $_POST['diaChi']; 
        } 
        else
            echo "Chưa nhập địa chỉ";        
    ?>
    </p>
    <p><strong>Số điện thoại:</strong> 
    <?php
        if(isset($_POST['soDienThoai'])){
            echo $_POST['soDienThoai']; 
        } 
        else
            echo "Chưa nhập số điện thoại";    
    ?>
    </p>
    <p><strong>Giới tính:</strong> 
        <?php 
            if(isset($_POST['male'])) {
                echo "Nam";
            } 
            if(isset($_POST['female'])) {
                echo "Nữ";
            }
            if(!isset($_POST['male']) && !isset($_POST['female'])){
                echo "Chưa chọn giới tính";
            }
        ?>
    </p>
    <p><strong>Quốc tịch:</strong>
        <?php 
            if(isset($_POST['quocTich'])) {
                $quocTich = $_POST['quocTich'];
                if($quocTich == "VN") {
                    echo "Việt Nam";
                } elseif($quocTich == "USA") {
                    echo "Hoa Kỳ";
                } elseif($quocTich == "CA") {
                    echo "Canada";
                } elseif($quocTich == "FR") {
                    echo "Pháp";
                } elseif($quocTich == "AU") {
                    echo "Úc";
                } elseif($quocTich == "CN") {
                    echo "Trung Quốc";
                } else {
                    echo "Không xác định";
                }
            } else {
                echo "Chưa chọn quốc gia";
            }
        ?>
    </p>

    <p><strong>Các môn đã học:</strong> 
        <?php 
            if(isset($_POST['php_mysql'])) {
                echo "PHP & MySQL ";
            }
            if(isset($_POST['c#'])) {
                echo "C# ";
            }
            if(isset($_POST['xml'])) {
                echo "XML ";
            }
            if(isset($_POST['python'])) {
                echo "Python";
            }
        ?>
    </p>
    <p><strong>Ghi chú:</strong> <?php echo $_POST['note']; ?></p>
    <a href="javascript:window.history.back(-1);">Trở về trang trước</a>
</body>
</html>