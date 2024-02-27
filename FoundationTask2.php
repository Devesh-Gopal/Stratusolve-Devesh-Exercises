<?php
//program that generates and prints a fibonacci sequence up to a given maximum value.

//Recursive function
    function Fibonacci($n)
    {
        //Base Case - includes termination condition
        if ($n <= 1)
        {
            return $n;
        }

        //Recursive case
        return Fibonacci($n - 1) + Fibonacci($n - 2); //Indices of the fibonacci sequence
    }

    $maxValue = 35;
    $fibonacciSequence = []; //Storing the fibonacci sequence into an array

    // For loop to generate the fibonacci sequence
    for ($i = 0; Fibonacci($i) <= $maxValue; $i++)
    {
        $fibonacciSequence[] = Fibonacci($i); //adds a number to the fibonacci sequence array
    }

    echo "Fibonacci Sequence: " . implode(" ", $fibonacciSequence) . "\n";


