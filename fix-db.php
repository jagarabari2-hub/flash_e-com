<?php

/**
 * Database Fix Script - Update Category Images
 * Run this once to fix the category images
 */

require_once 'config.php';

// Update category images to correct ones
$updates = [
    [1, 'Electronics.jpg', 'Electronics'],
    [2, 'Fashion.jpg', 'Fashion'],
    [3, 'HomeandGarden.jpg', 'Home & Garden'],
    [4, 'Books.jpg', 'Books'],
    [5, 'Sports.jpg', 'Sports'],
    [6, 'Beauty.jpg', 'Beauty'],
    [7, 'ToysAll.jpg', 'Toys'],
    [8, 'Automotive.jpg', 'Automotive'],
    [9, 'Pet Supplies.jpg', 'Pet Supplies'],
    [10, 'Kitchen.jpg', 'Kitchen'],
    [11, 'Furniture.jpg', 'Furniture'],
    [12, 'Gaming.jpg', 'Gaming'],
    [13, 'Office Supplies.jpg', 'Office Supplies'],
    [14, 'Travel.jpg', 'Travel'],
    [15, 'Fitness.jpg', 'Fitness'],
    [16, 'Music.jpg', 'Music'],
];

echo "Updating category images...<br>";

foreach ($updates as $data) {
    $cat_id = $data[0];
    $img = $data[1];
    $name = $data[2];

    $query = "UPDATE cat SET img = '" . sanitize($img) . "' WHERE cat_id = " . $cat_id;

    if (mysqli_query($con, $query)) {
        echo "✓ Updated: " . $name . " -> " . $img . "<br>";
    } else {
        echo "✗ Failed to update: " . $name . "<br>";
    }
}

echo "<hr>";
echo "Database update complete!<br>";
echo "<a href='index.php'>Return to Home</a>";
