<?php
class ItemOwners {
    public static function groupItemsByOwners(array $itemsArray): array {
        // Grouped items are stored in the empty array
        $groupedItems = array();

        foreach ($itemsArray as $item => $owner) {
            // Checks to see whether the value (owner) exists in the array
            // If the value does not exist, an empty array is created for the value (owner)
            // isset checks to see if a specific key exists before accessing it
            if (!isset($groupedItems[$owner])) {
                $groupedItems[$owner] = array();
            }

            // Grouping the items by their respective owner
            $groupedItems[$owner][] = $item;
        }

        // Grouped array is returned
        return $groupedItems;
    }
}

// Keys: items, Values: owners
$itemsArray = array(
    "Baseball Bat" => "John",
    "Golf ball" => "Stan",
    "Tennis Racket" => "John",
    "Another Tennis Racket" => "Stan" // corrected the duplicate key
);

echo json_encode(ItemOwners::groupItemsByOwners($itemsArray));

