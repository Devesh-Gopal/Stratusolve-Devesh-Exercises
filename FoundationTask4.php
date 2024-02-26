<?php

class ItemOwners {
    public static function groupByOwners($ItemsArr)
    {
        // Grouped items are stored in the empty array
        $key = array();

        foreach ($ItemsArr as $item => $value)
        {
            // Checks to see whether the value(owner) exists in the array, if the value does not exist, an empty array is created for the value(owner)
            // isset checks to see a specific key exists before accessing it
            if (!isset($key[$value]))
            {
                $key[$value] = array();
            }

            // Grouping the items by their respective owner
            $key[$value][] = $item;
        }
        // Grouped array is returned
        return $key;
    }
}

$ItemsArr = array
(
    "Baseball Bat" => "John",
    "Golf ball" => "Stan",
    "Tennis Racket" => "John"
);

echo json_encode(ItemOwners::groupByOwners($ItemsArr));


