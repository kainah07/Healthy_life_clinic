<?php 

// Count total providers
$query_total_providers = "SELECT COUNT(*) AS total FROM providers";
$result_total_providers = mysqli_query($conn, $query_total_providers);
$count_providers =  mysqli_fetch_assoc($result_total_providers);
$total_providers = $count_providers['total'];

// Count total patients
$query_total_patients = "SELECT COUNT(*) AS total FROM patients";
$result_total_patients = mysqli_query($conn, $query_total_patients);
$count_patients = mysqli_fetch_assoc($result_total_patients);
$total_patients = $count_patients['total'];

// Count new appointments 
$query_new_appointments = "SELECT COUNT(*) AS total FROM appointments WHERE DATE('appointment_date')";

$result_new_appointments = mysqli_query($conn, $query_new_appointments);
$count_new_appointments = mysqli_fetch_assoc($result_new_appointments);
$total_new_appointments = $count_new_appointments['total'];

?>