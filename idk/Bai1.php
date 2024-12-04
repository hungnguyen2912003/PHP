<?php

    /*
    Input: Nhập n ngẫu nhiên từ 1-100
    output: số chẵn trong khoảng từ 1->N
     */

    $n = rand(1,100);

    echo "Các số chẵn từ 1 đến $n: ";

    for($i = 0; $i < $n; $i++)
    {
        if($i % 2== 0){
            echo "$i ";
        }
    }

?>