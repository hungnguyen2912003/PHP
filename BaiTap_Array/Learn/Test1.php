<?php
    $arr = ['nva', 3 => 'abc', 'x' => 5];
//    var_dump($arr);
    $arr[] = 10;
//    echo "<br>";
//    var_dump($arr);
    $arr[3] = 100;
//    echo "<br>";
//    var_dump($arr);
    foreach ($arr as $key => $value) {
        echo "$key: $value" . "<br>";
    }

//    $number = range(0, 10, 2);
//    print_r($number);
////    for ($i = 0; $i < count($number); $i++) {
////        echo $number[$i] . "<br>";
////    }
//    echo "<br>";
//    $n = $number;
//    print_r($n);
?>
