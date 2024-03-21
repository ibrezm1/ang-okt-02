<?php
include '../config/db_config.php';

// Allow requests from any origin
header("Access-Control-Allow-Origin: *");

// Allow the following methods from any origin
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

// Allow the following headers from any origin
header("Access-Control-Allow-Headers: Content-Type");

// Allow cookies to be sent or received from the client
header("Access-Control-Allow-Credentials: true");

// Set the content type for all responses
header("Content-Type: application/json");

// Check if the request method is OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Respond with a 200 OK status code
    http_response_code(200);
    exit();
}

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["success" => false, "error" => "Connection failed: " . $conn->connect_error]));
}

// CRUD Operations
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if(isset($_GET['id'])) {
            // Retrieve guest by ID
            $id = $_GET['id'];
            $sql = "SELECT * FROM demo_guests WHERE guestId = $id";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $data = $result->fetch_assoc();
                echo json_encode(["success" => true, "data" => $data]);
            } else {
                echo json_encode(["success" => false, "error" => "Guest not found"]);
            }
        } else {
            // Retrieve all guests
            $sql = "SELECT * FROM demo_guests";
            $result = $conn->query($sql);
            $data = [];
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
            }
            echo json_encode(["success" => true, "data" => $data]);
        }
        break;
    case 'POST':
        // Create, Update, or Delete a guest based on the operation parameter
        $data = json_decode(file_get_contents('php://input'), true);
        $operation = $data['operation'];
        if ($operation === "create") {
            // Create a new guest
            $guestName = $data['guestName'];
            $checkInDate = $data['checkInDate'];
            $guestEmail = $data['guestEmail'];
            $roomNumber = $data['roomNumber'];
            $sql = "INSERT INTO demo_guests (guestName, checkInDate, guestEmail, roomNumber)
                    VALUES ('$guestName', '$checkInDate', '$guestEmail', '$roomNumber')";
            if ($conn->query($sql) === TRUE) {
                echo json_encode(["success" => true, "message" => "New record created successfully"]);
            } else {
                echo json_encode(["success" => false, "error" => "Error creating record: " . $conn->error]);
            }
        } elseif ($operation === "update") {
            // Update an existing guest
            $guestId = $data['guestId'];
            $guestName = $data['guestName'];
            $checkInDate = $data['checkInDate'];
            $guestEmail = $data['guestEmail'];
            $roomNumber = $data['roomNumber'];
            $sql = "UPDATE demo_guests SET guestName='$guestName', checkInDate='$checkInDate', guestEmail='$guestEmail', roomNumber='$roomNumber' WHERE guestId=$guestId";
            if ($conn->query($sql) === TRUE) {
                echo json_encode(["success" => true, "message" => "Record updated successfully"]);
            } else {
                echo json_encode(["success" => false, "error" => "Error updating record: " . $conn->error]);
            }
        } elseif ($operation === "delete") {
            // Delete a guest
            $guestId = $data['guestId'];
            $sql = "DELETE FROM demo_guests WHERE guestId=$guestId";
            if ($conn->query($sql) === TRUE) {
                echo json_encode(["success" => true, "message" => "Record deleted successfully"]);
            } else {
                echo json_encode(["success" => false, "error" => "Error deleting record: " . $conn->error]);
            }
        } else {
            echo json_encode(["success" => false, "error" => "Invalid operation"]);
        }
        break;
    default:
        // Invalid request method
        http_response_code(405);
        echo json_encode(["success" => false, "error" => "Method Not Allowed"]);
        break;
}

$conn->close();
?>