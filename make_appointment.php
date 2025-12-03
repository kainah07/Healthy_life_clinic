<?php
session_start();
include 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Restrict access to logged-in users who are not admins
if (!isset($_SESSION['user_id']) || (isset($_SESSION['is_admin']) && $_SESSION['is_admin'])) {
    echo "<script>alert('Access denied. Only patients can make appointments.'); window.location.href = 'login.php';</script>";
    exit;
}

$patient_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['make_appointment'])) {
    $provider_id = intval($_POST['provider_id']);
    $appointment_datetime = $_POST['appointment_datetime'];
    $reason = trim($_POST['reason']);

    // Validate required fields
    if (empty($provider_id) || empty($appointment_datetime) || empty($reason)) {
        echo "<script>alert('All fields are required.'); window.location.href = 'make_appointment.php';</script>";
        exit;
    }

    if (strlen($reason) > 255) {
        echo "<script>alert('Reason is too long. Max 255 characters.'); window.location.href = 'make_appointment.php';</script>";
        exit;
    }

    // Extract date and time
    $datetime_parts = explode(' ', $appointment_datetime);
    $appointment_date = $datetime_parts[0] ?? null;
    $appointment_time = isset($datetime_parts[1]) ? date("H:i:s", strtotime($datetime_parts[1])) : null;

    if (!$appointment_date || !$appointment_time) {
        echo "<script>alert('Invalid date format.'); window.location.href = 'make_appointment.php';</script>";
        exit;
    }

    // Ensure appointment is in the future
    $appointment_datetime_obj = new DateTime("$appointment_date $appointment_time");
    $current_datetime = new DateTime();

    if ($appointment_datetime_obj < $current_datetime) {
        echo "<script>alert('Appointments must be scheduled for future dates.'); window.location.href = 'make_appointment.php';</script>";
        exit;
    }

    // Ensure business hours (9 AM - 6 PM)
    $business_start = new DateTime('09:00');
    $business_end = new DateTime('18:00');
    $appointment_time_obj = new DateTime($appointment_time);

    if ($appointment_time_obj < $business_start || $appointment_time_obj > $business_end) {
        echo "<script>alert('Appointments must be scheduled during business hours (9 AM - 6 PM).'); window.location.href = 'make_appointment.php';</script>";
        exit;
    }

    // Insert into database
    $query = "INSERT INTO appointments (patient_id, provider_id, appointment_date, appointment_time, reason, status) 
              VALUES (?, ?, ?, ?, ?, 'Scheduled')";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iisss", $patient_id, $provider_id, $appointment_date, $appointment_time, $reason);

    if ($stmt->execute()) {
        echo "<script>alert('Appointment successfully scheduled!'); window.location.href = 'patient_dashboard.php';</script>";
    } else {
        echo "<script>alert('Error scheduling appointment.');</script>";
    }

    $stmt->close();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make an Appointment</title>

    <link rel="stylesheet" href="css/forms.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
  </head>

  <body class="vh-100 d-flex justify-content-center align-items-center">

    <div class="bg-light text-light p-lg-5 p-md-5 p-4 rounded-4 shadow-lg bg-opacity-25 m-3">
      <h1 class="text-center mb-lg-5 m-4 mt-lg-0 mt-md-0 border-bottom border-3 pb-3">Make an Appointment</h1>
      <form action="make_appointment.php" method="POST">
        <div class="row align-items-end">
          <div class="mb-3 col-lg-6 pe-lg-0">
          <label for="specialization" class="form-label">Specialization:</label>
          <input type="text" name="specialization" id="specialization" placeholder="Enter specialization" class="form-control">
          </div>

          <div class="mb-3 col-lg-6 mx-lg-0">
            <button type="button" class="btn btn-secondary px-lg-4" id="searchButton">Search Providers</button>
            <button type="reset" class="btn btn-danger" id="resetButton">Reset</button>
          </div>
        </div>
        

        <div class="mb-3">
          <select name="provider_id" id="provider_id" class="form-select" required>
            <option value="">Select Provider</option>
          </select>
        </div>

        <div>
          <label for="appointment_datetime">Date and Time:</label>
            <input type="text" id="appointment_datetime" name="appointment_datetime" class="form-control" required>
        </div>

        <div>
          <label for="reason">Reason:</label>
          <textarea name="reason" id="reason" class="form-control" rows="2" maxlength="255" required></textarea>
        </div>

        <div class="text-center mt-4 ">
          <button type="submit" name="make_appointment" class="btn btn-primary  w-100">Submit</button>  
        </div>
        
      </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="components/appointment.js"></script>
  </body>
</html>