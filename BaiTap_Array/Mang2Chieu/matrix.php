<?php
if (isset($_POST['rows']) && isset($_POST['columns'])) {
    $rows = intval($_POST['rows']);
    $columns = intval($_POST['columns']);

    // Generate matrix with random integers between -1000 and 1000
    $matrix = [];
    for ($i = 0; $i < $rows; $i++) {
        for ($j = 0; $j < $columns; $j++) {
            $matrix[$i][$j] = rand(-1000, 1000);
        }
    }

    // Display the matrix
    echo "Matrix:\n";
    for ($i = 0; $i < $rows; $i++) {
        for ($j = 0; $j < $columns; $j++) {
            echo $matrix[$i][$j] . "\t";
        }
        echo "\n";
    }

    // Display elements from even rows and odd columns
    echo "\nElements in even rows and odd columns:\n";
    for ($i = 1; $i < $rows; $i += 2) { // Even rows (index 1, 3, ...)
        for ($j = 0; $j < $columns; $j += 2) { // Odd columns (index 0, 2, ...)
            echo $matrix[$i][$j] . "\t";
        }
        echo "\n";
    }

    // Calculate the sum of elements that are multiples of 10
    $sum = 0;
    for ($i = 0; $i < $rows; $i++) {
        for ($j = 0; $j < $columns; $j++) {
            if ($matrix[$i][$j] % 10 == 0) {
                $sum += $matrix[$i][$j];
            }
        }
    }
    echo "\nSum of elements that are multiples of 10: $sum\n";
}
?>
