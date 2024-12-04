
<form method="post" action="">
    <table style="width: 100%;">
        <tr style="background-color: #FEECE1;">
            <td style="text-align: center; font-style: italic; font-weight: bold; color: #FC2E5B; font-size: 36px; height: 50px;">
                TÌM KIẾM THÔNG TIN SỮA
            </td>
        </tr>
        <tr style="background-color: #FEECE1;">
            <td style="text-align: center;">
                <?php
                // Kết nối cơ sở dữ liệu
                $conn = mysqli_connect('localhost', 'root', '', 'qlbansua');
                mysqli_set_charset($conn, 'UTF8');

                // Truy vấn để lấy danh sách loại sữa và hãng sữa
                $loaiSuaResult = mysqli_query($conn, "SELECT Ma_loai_sua, Ten_loai FROM loai_sua");
                $hangSuaResult = mysqli_query($conn, "SELECT Ma_hang_sua, Ten_hang_sua FROM hang_sua");
                ?>
                <label style="color: #88290F; font-weight: bold;" >Loại sữa:</label>
                <label>
                    <select name="loaiSua">
                        <option value="">Chọn loại sữa</option>
                        <?php
                        while ($loai = mysqli_fetch_assoc($loaiSuaResult)) {
                            $selected = (isset($_POST['loaiSua']) && $_POST['loaiSua'] == $loai['Ma_loai_sua']) ? 'selected' : '';
                            echo "<option value='{$loai['Ma_loai_sua']}' $selected>{$loai['Ten_loai']}</option>";
                        }
                        ?>
                    </select>
                </label>
                <label style="color: #88290F; font-weight: bold;" >Hãng sữa:</label>
                <label>
                    <select name="hangSua">
                        <option value="">Chọn hãng sữa</option>
                        <?php
                        while ($hang = mysqli_fetch_assoc($hangSuaResult)) {
                            $selected = (isset($_POST['hangSua']) && $_POST['hangSua'] == $hang['Ma_hang_sua']) ? 'selected' : '';
                            echo "<option value='{$hang['Ma_hang_sua']}' $selected>{$hang['Ten_hang_sua']}</option>";
                        }
                        ?>
                    </select>
                </label>
            </td>
        </tr>
        <tr style="background-color: #FEECE1; height: 40px;">
            <td style="text-align: center;">
                <label style="color: #88290F; font-weight: bold;" >Tên sữa:</label>
                <input type="text" name="strTimKiem" value="<?php if(isset($_POST['strTimKiem'])) echo $_POST['strTimKiem'];?>"/>
                <input type="submit" name="btnTimKiem" value="Tìm kiếm" style="background-color: #FCCDCD;"/>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; font-weight: bold; background-color: #FDFEF0">
                <?php
                // Kết nối cơ sở dữ liệu
                $conn = mysqli_connect('localhost', 'root', '', 'qlbansua');
                mysqli_set_charset($conn, 'UTF8');

                if (isset($_POST['btnTimKiem'])) {
                    if(!empty($_POST['strTimKiem'])){
                        // Lấy từ khóa tìm kiếm từ ô input
                        $str = $_POST['strTimKiem'];
                        $loaiSua = !empty($_POST['loaiSua']) ? $_POST['loaiSua'] : '';
                        $hangSua = !empty($_POST['hangSua']) ? $_POST['hangSua'] : '';
                        $count = "<p>Các sản phẩm có tên chứa từ khóa: <strong>'$str'</strong></p>";

                        // Truy vấn tìm kiếm với điều kiện tên sữa chứa từ khóa
                        $sql = "SELECT Ten_sua, Ten_hang_sua, hinh, TP_Dinh_Duong, Loi_ich, Trong_luong, Don_gia 
                            FROM sua 
                            JOIN hang_sua ON sua.Ma_hang_sua = hang_sua.Ma_hang_sua 
                            WHERE Ten_sua LIKE '%$str%'";
                        // Thêm điều kiện vào câu truy vấn nếu chọn loại sữa và hãng sữa
                        if ($loaiSua) {
                            $sql .= " AND sua.Ma_loai_sua = '$loaiSua'";
                        }
                        if ($hangSua) {
                            $sql .= " AND sua.Ma_hang_sua = '$hangSua'";
                        }

                        $result = mysqli_query($conn, $sql);
                        $count = mysqli_num_rows($result);
                        if ($count > 0) {
                            echo "<p style='font-weight: bold; margin-top: 10px; margin-bottom: 20px;'>Có $count sản phẩm được tìm thấy</p>";
                            echo "<table style='width: 800px; margin: 0 auto; border-collapse: collapse; border: 3px solid #A5581F;'>";
                            while ($row = mysqli_fetch_row($result)) {
                                echo "<tr style='background-color: #FFEEE6;'><td colspan='2' style='text-align: center; color: #F36B09; font-size: 36px; font-weight: bold;'>$row[0] - $row[1]</td></tr>";
                                echo "<tr>";
                                echo "<td style='border: 1px solid black;'><img style='width: 200px; height: 180px;' src='Hinh_sua/$row[2]'/></td>";
                                echo "<td style='border: 1px solid black;'>" .
                                    "<span style='font-style: italic; font-weight: bold;'>Thành phần dinh dưỡng:</span> <br>" . $row[3] . "<br>" .
                                    "<span style='font-style: italic; font-weight: bold;'>Lợi ích:</span> <br>" . $row[4] . "<br>";
                                echo "<p><span style='font-weight: bold; font-style: italic;'>Trọng lượng:</span> <span style='color:#994C5F;'>$row[5]</span> gr - " .
                                    "<span style='font-weight: bold; font-style: italic;'>Đơn giá:</span> <span style='color:#994C5F;'>$row[6]</span> VNĐ</p>";
                                echo "</td>";
                                echo "</tr>";
                            }
                            echo "</table>";
                        } else {
                            echo "<p style='margin-top: 10px; margin-bottom: 20px;'>Không tìm thấy sản phẩm nào phù hợp.</p>";
                        }
                    }
                    else{
                        echo "<p style='font-weight: bold; color: red; margin-top: 10px; margin-bottom: 20px;'>Vui lòng nhập tên sữa cần tìm kiếm!</p>";
                    }
                }
                ?>
            </td>
        </tr>
    </table>
</form>


