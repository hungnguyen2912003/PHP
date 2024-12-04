<?php
session_start();
$msg = "";
$tenBaiHat = "";
$xepHang = "";

if (!isset($_SESSION['songList'])) {
    $_SESSION['songList'] = [];
}

if (isset($_POST['resetSession'])) {
    session_unset();
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Xử lý ghi vào file
if (isset($_POST['ghiFile'])) {
    $filename = "danh_sach_bai_hat.txt";
    $fileContent = "";
    foreach ($_SESSION['songList'] as $song) {
        $fileContent .= "Tên bài hát: " . $song['tenBaiHat'] . " - Xếp hạng: " . $song['xepHang'] . "\n";
    }

    // Ghi nội dung vào file
    if (file_put_contents($filename, $fileContent) !== false) {
        $msg = "Danh sách bài hát đã được ghi vào file: $filename";
    } else {
        $msg = "Lỗi: Không thể ghi vào file.";
    }
}

if (isset($_POST['themBaiHat'])) {
    if (!empty($_POST['tenBaiHat']) && !empty($_POST['xepHang'])) {
        $tenBaiHat = $_POST['tenBaiHat'];
        $xepHang = $_POST['xepHang'];
        if (ctype_digit($xepHang)) {
            $found = false;
            foreach ($_SESSION['songList'] as &$song) {
                if ($song['xepHang'] === $xepHang) {
                    $song['tenBaiHat'] = $tenBaiHat;
                    $found = true;
                    $msg = "Bài hát đã được cập nhật vào danh sách.";
                    break;
                }
            }
            if (!$found) {
                $_SESSION['songList'][] = [
                    'tenBaiHat' => $tenBaiHat,
                    'xepHang' => $xepHang
                ];
                $msg = "Bài hát đã được thêm vào danh sách.";
            }
        } else {
            $msg = "Vui lòng nhập số xếp hạng là số nguyên.";
        }
    } else {
        $msg = "Vui lòng nhập tên bài hát và xếp hạng.";
    }
}

$ds = "";
if (isset($_POST['hienThiDS'])) {
    if (!empty($_SESSION['songList'])) {
        usort($_SESSION['songList'], function($a, $b) {
            return $a['xepHang'] <=> $b['xepHang'];
        });

        foreach ($_SESSION['songList'] as $song) {
            $ds .= "Xếp hạng: " . $song['xepHang'] . " - Tên bài hát: " . $song['tenBaiHat'] . "\n";
        }
    } else {
        $msg = "Danh sách trống.";
    }
}
?>

<style>
    table {
        width: 600px;
        margin: 0 auto;
        border: 1px solid black;
        border-radius: 10px;
        font-size: 16px;
        padding: 5px;
    }
    td {
        padding: 5px;
    }
    textarea {
        width: 100%;
        height: 200px;
        resize: none;
        overflow: scroll;
    }
    input[type=text] {
        width: 100%;
        height: 30px;
    }
    input[type=submit] {
        width: 130px;
        height: 30px;
    }
</style>

<form method="POST" action="">
    <table>
        <tr>
            <td colspan="2" style="text-align:center; font-size: 36px; font-weight: bold;">
                XẾP HẠNG BÀI HÁT
            </td>
        </tr>
        <tr>
            <td style="width: 120px;">
                <label>Nhập tên bài hát:</label>
            </td>
            <td>
                <input type="text" name="tenBaiHat" value="<?php echo $tenBaiHat; ?>"/>
            </td>
        </tr>
        <tr>
            <td style="width: 120px;">
                <label>Nhập xếp hạng:</label>
            </td>
            <td>
                <input type="text" name="xepHang" value="<?php echo $xepHang; ?>"/>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;">
                <input type="submit" name="themBaiHat" value="Thêm bài hát"/>
                <input type="submit" name="hienThiDS" value="Hiển thị danh sách"/>
                <input type="submit" name="ghiFile" value="Ghi vào file"/>
                <input type="submit" name="resetSession" value="Xoá danh sách"/>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <textarea readonly><?php echo $ds; ?></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="font-weight: bold; text-align: center; color: red;">
                <?php echo $msg; ?>
            </td>
        </tr>
    </table>
</form>
