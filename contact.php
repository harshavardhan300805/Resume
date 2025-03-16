<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "contact_form";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure all fields are present
    if (!isset($_POST['name'], $_POST['email'], $_POST['subject'], $_POST['message'])) {
        die(json_encode(["status" => "error", "message" => "Missing form fields."]));
    }

    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $subject = $conn->real_escape_string($_POST['subject']);
    $message = $conn->real_escape_string($_POST['message']);

    // Validate fields (Basic Example)
    if (empty($name) || empty($email) || empty($message)) {
        die(json_encode(["status" => "error", "message" => "Please fill all required fields."]));
    }

    // Insert data into database
    $sql = "INSERT INTO messages (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" =>"Message sent successfully!"]);
    } else {
        echo json_encode(["status" =>"Error: "]);
    }
}

$conn->close();
?>
