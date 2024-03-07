<?php
// Generates and prints a Fibonacci sequence up to a given maximum value.

// Recursive function
function generateFibonacci(Int $n): Int {
    // Base Case - includes termination condition
    if ($n <= 1) {
        return $n;
    }

    // Recursive case
    return generateFibonacci($n - 1) + generateFibonacci($n - 2); // Indices of the Fibonacci sequence
}

$maxValue = 55;
$fibonacciSequence = []; // Storing the Fibonacci sequence into an array

// While loop
$i = 0; // Sequence starts at 0.
while (generateFibonacci($i) <= $maxValue) {
    $fibonacciSequence[] = generateFibonacci($i); // Adds a number to the Fibonacci sequence array
    $i++;
}

echo "Fibonacci Sequence: " . implode(" ", $fibonacciSequence) . "\n";