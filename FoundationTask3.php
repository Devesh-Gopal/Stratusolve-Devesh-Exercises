<?php
// Determine if a given string is a palindrome or not.
class Palindrome {
    public static function isPalindrome($word)
    {
        //Spaces are removed and lowercase is done to ignore character case(String Cleaning)
        $word = str_replace(' ', '', strtolower($word));

        //Cleaned word must be identical to its reverse. strrev- used to reverse a string
        return $word === strrev($word);
    }
}

if (Palindrome::isPalindrome('Never Odd Or Even'))
{
    echo 'Palindrome';
} else
    {
        echo 'Not palindrome';
    }

