<?php
include 'db_config.php';
// Allow requests from any origin
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");
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
    $response = [
        "success" => false,
        "error" => "Connection failed: " . $conn->connect_error
    ];
    echo json_encode($response);
    exit();
}

// CRUD Operations
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // Retrieve all guests
        $sql = "SELECT * FROM demo_guests";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $data = [];
            while($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            echo json_encode(["success" => true, "data" => $data]);
        } else {
            echo json_encode(["success" => false, "error" => "No guests found"]);
        }
        break;
    case 'POST':
        // Create a new guest
        $data = json_decode(file_get_contents('php://input'), true);
        $guestName = $data['guestName'];
        $checkInDate = $data['checkInDate'];
        $guestEmail = $data['guestEmail'];
        $roomNumber = $data['roomNumber'];
        $sql = "INSERT INTO demo_guests (guestName, checkInDate, guestEmail, roomNumber)
                VALUES ('$guestName', '$checkInDate', '$guestEmail', '$roomNumber')";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["success" => true, "message" => "New record created successfully"]);
        } else {
            echo json_encode(["success" => false, "error" => "Error: " . $sql . "<br>" . $conn->error]);
        }
        break;
    case 'PUT':
        // Update an existing guest
        $data = json_decode(file_get_contents('php://input'), true);
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
        break;
    case 'DELETE':
        // Delete a guest
        $data = json_decode(file_get_contents('php://input'), true);
        $guestId = $data['guestId'];
        $sql = "DELETE FROM demo_guests WHERE guestId=$guestId";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["success" => true, "message" => "Record deleted successfully"]);
        } else {
            echo json_encode(["success" => false, "error" => "Error deleting record: " . $conn->error]);
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
