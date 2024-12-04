<?php 
$n = rand(-50, 50);
echo "Giá trị n được tạo ra là $n. <br>";

if ($n < 0) {
    $n = -$n; 
    echo "Giá trị sau khi thay đổi là $n.<br>";
} else {
    echo "$n là số dương.<br>";
}

// Tạo mảng
for ($i = 0; $i < $n; $i++) {
    $array[$i] = rand(-100, 100);
}
echo "Mảng được tạo: ";
echo implode(", ", $array);

// Sắp xếp mảng tăng dần bằng thuật toán bubble sort
for ($i = 0; $i < $n - 1; $i++) {
    for ($j = 0; $j < $n - 1 - $i; $j++) {
        if ($array[$j] > $array[$j + 1]) {
            // Hoán đổi các phần tử
            $temp = $array[$j];
            $array[$j] = $array[$j + 1];
            $array[$j + 1] = $temp;
        }
    }
}

echo "<br>Mảng sau khi sắp xếp tăng dần: ";
echo implode(", ", $array);

// Tính tổng vị trí lẻ
$sum = 0;
for ($i = 1; $i < $n; $i += 2) { 
    $sum += $array[$i];
}

echo "<br>Tổng các phần tử ở vị trí lẻ: $sum";
?>
