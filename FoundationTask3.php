<?php
// Determines if a given string is a palindrome or not.
class Palindrome {
    public static function checkIfPalindrome(string $word): bool {
        // Remove non-alphanumeric characters, convert to lowercase.
        $cleanedWord = preg_replace("/[^a-zA-Z0-9]/", '', strtolower($word));

        // Cleaned word must be identical to its reverse. strrev is used to reverse a string.
        return $cleanedWord === strrev($cleanedWord);
    }
}

if (Palindrome::checkIfPalindrome('No, Mel Gibson is a casino’s big lemon')) {
    echo 'Palindrome';
} else {
    echo 'Not palindrome';
}





