<?php
function addAll($array)
{
    // Base Case - checks if the array is empty (termination condition)
    if (empty($array)) {
        return 0;
    }

    // Array is calculated and element is then removed from the array
    $total = array_sum($array);
    array_shift($array);

    // Recursive case
    return $total + addAll($array);
}

$Array = [1, 1, 1, 1, 1]; //5+4+3+2+1=15
echo addAll($Array); // Displays 15 as the output
