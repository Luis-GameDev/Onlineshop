<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_onlineshop";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get search query from AJAX request
if (isset($_GET['searchQuery'])) {
    $searchQuery = $_GET['searchQuery'];

    // Clean up the search query to prevent SQL injection
    $searchQuery = $conn->real_escape_string($searchQuery);

    // Query to search items from the database (modify as needed for your schema)
    $sql = "SELECT name, price FROM items WHERE name LIKE '%$searchQuery%' OR category LIKE '%$searchQuery%' LIMIT 10";

    // Execute the query
    $result = $conn->query($sql);

    // Check if any results are found
    if ($result->num_rows > 0) {
        // Output the results as a list of suggestions (div elements)
        while ($row = $result->fetch_assoc()) {
            $itemName = $row['name'];
            $itemPrice = $row['price'];

            // Output each item in a div, formatted as desired (with name and price)
            echo "<div class='search-item' data-name='" . htmlspecialchars($itemName) . "' data-price='" . htmlspecialchars($itemPrice) . "'>";
            echo htmlspecialchars($itemName) . " - " . number_format($itemPrice, 2) . "€";
            echo "</div>";
        }
    } 
}

$conn->close();
?>
