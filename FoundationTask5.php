<?php

// Program that generates and prints a Fibonacci sequence up to a given maximum value.
function generateFibonacciSequence(int $maxValue): array {
    $fibonacciSequence = []; // Storing the Fibonacci sequence into an array

    // While Loop
    $i = 0; // Sequence starts at 0.
    while (calculateFibonacci($i) <= $maxValue) {
        $fibonacciSequence[] = calculateFibonacci($i); // Adds a number to the Fibonacci sequence array
        $i++;
    }

    return $fibonacciSequence;
}

// Recursive function to calculate Fibonacci number at a given index
function calculateFibonacci(int $n): int {
    // Base Case - includes termination condition
    if ($n <= 1) {
        return $n;
    }
    // Recursive case
    return calculateFibonacci($n - 1) + calculateFibonacci($n - 2); // Indices of the Fibonacci sequence
}

// Check if the maxNumber parameter is set in the URL
if (isset($_POST['maxNumber'])) {
    // Get the user's input from the URL
    $maxValue = (int)$_POST['maxNumber'];

    // Fibonacci sequence generated based on the received user input
    $fibonacciSequence = generateFibonacciSequence($maxValue);

    // Fibonacci sequence displayed
    echo "The Fibonacci Sequence up to {$maxValue} is: " . implode(" ", $fibonacciSequence) . "\n";
} else {
    // If maxNumber is not provided, display a message
    echo "Please enter a maximum number in the form.";
}



