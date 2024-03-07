<?php
function calculateSumOfIntArray(array $intArray): int {
    // Base Case - checks if the array is empty (termination condition)
    if (empty($intArray)) {
        return 0;
    }

    // Array is calculated, and an element is then removed from the array
    $total = array_sum($intArray);
    array_shift($intArray);

    // Recursive case
    return $total + calculateSumOfIntArray($intArray);
}

$myIntArray = [1, 1, 1, 1, 1]; // 5 + 4 + 3 + 2 + 1 = 15
echo calculateSumOfIntArray($myIntArray); // Displays 15 as the output

