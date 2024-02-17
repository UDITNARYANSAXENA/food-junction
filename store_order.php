<?php
// Assuming you have a MySQL database connection already established

$conn = new $mysqli('localhost','root','','onlinefood');
// Check if the request is received via POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data sent from JavaScript
    $address = $_POST['address'];
    $note = $_POST['note'];
    $cart = $_POST['cart']; // Assuming this is an array containing cart details

    // Example: Insert data into the database
    $stmt = $mysqli->prepare("INSERT INTO orders (address, note, cart_details) VALUES (?, ?, ?)");
    $cartDetails = json_encode($cart); // Convert cart details to JSON string for storage

    // Bind parameters and execute the query
    $stmt->bind_param("sss", $address, $note, $cartDetails);
    $stmt->execute();

    // Check if the query executed successfully
    if ($stmt->affected_rows > 0) {
        // Data inserted successfully
        echo json_encode(['success' => true, 'message' => 'Data stored in the database']);
    } else {
        // Failed to insert data
        echo json_encode(['success' => false, 'message' => 'Failed to store data']);
    }

    // Close the statement and database connection
    $stmt->close();
    $mysqli->close();
} else {
    // If the request method is not POST
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
