<?php
include 'config.php';

// Retrieve the specialization from the GET request, if provided
$specialization = isset($_GET['specialization']) ? $_GET['specialization'] : '';
// Prepare the SQL query to fetch provider details
$query = "SELECT provider_id, first_name, last_name FROM providers";
if (!empty($specialization)) {
    $query .= " WHERE specialization LIKE ?";
}
$stmt = $conn->prepare($query);
// If a specialization is provided, filter providers by specialization
if (!empty($specialization)) {
    $likeSpecialization = "%$specialization%";
    $stmt->bind_param("s", $likeSpecialization);
}

$stmt->execute();
$result = $stmt->get_result();

$available_providers= [];
while ($row = $result->fetch_assoc()) {
    $available_providers[] = $row;
}

$stmt->close();
$conn->close();

// Set response header to JSON and return provider data as JSON
header('Content-Type: application/json');
echo json_encode($available_providers);
?>
