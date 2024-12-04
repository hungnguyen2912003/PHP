<?php

    $list = array("CNTT" => array("KTPM" => array("Name" => "Lê Thị Bích Hằng","GioiTinh" => "Nữ"), "HTTH" => array("Name" => "Phạm Thị Thu Thuý", "GioiTinh" => "Nữ"), "MTT" => array("Name" => "Phạm Văn Nam", "GioiTinh" => "Nam")), "NN" => array("PD" => "Thu", "DL" => "Khanh"));

    foreach($list as $Khoa => $value){
        echo "<h2>$Khoa</h2><ul>";

        foreach($value as $gv => $name){
//            echo "<li>$gv - $name</li>\n";

            foreach ($name as $i){
                echo "<li>$i</li>\n";
            }
        }
        echo "</ul>";
    }
?>