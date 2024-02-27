<?php

//program that generates and prints a fibonacci sequence up to a given maximum value.
function generateFibonacci($maxValue) {
    $fibonacciSequence = []; //Storing the fibonacci sequence into an array

    //While Loop
    $i = 0; // Sequence starts at 0.
    while (fibonacci($i) <= $maxValue) {
        $fibonacciSequence[] = fibonacci($i); // adds a number to the fibonacci sequence array
        $i++;
    }

    return $fibonacciSequence;
}

// Recursive function to calculate Fibonacci number at a given index
function fibonacci($n) {
    //Base Case - includes termination condition
    if ($n <= 1) {
        return $n;
    }
    //Recursive case
    return fibonacci($n - 1) + fibonacci($n - 2); //Indices of the fibonacci sequence
}

// Check if the maxNumber parameter is set in the URL
if (isset($_POST['maxNumber'])) {
    // Get the user's input from the URL
    $maxValue = (int)$_POST['maxNumber'];

    // Fibonacci sequence generated based on the received user input
    $fibonacciSequence = generateFibonacci($maxValue);

    // Fibonacci sequence displayed
    echo " The Fibonacci Sequence up to {$maxValue} is: " . implode(" ", $fibonacciSequence) . "\n";
} else {
    // If maxNumber is not provided, display a message
    echo "Please enter a maximum number in the form.";
}

