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

/*
$query_new_patients = "SELECT COUNT(*) AS total FROM patients 
WHERE MONTH(appointment_date) = MONTH(CURDATE()) AND YEAR(appointment_date) = YEAR(CURDATE())";

$result_new_patients = mysqli_query($conn, $query_new_patients);
$count_new_patients = mysqli_fetch_assoc($result_new_patients);
$total_new_patients = $count_new_patients['total'];
*/

$query_monthly = "
    SELECT MONTH(appointment_date) AS month_num, COUNT(*) AS total
    FROM appointments
    GROUP BY MONTH(appointment_date)
    ORDER BY month_num
";
$result_monthly = mysqli_query($conn, $query_monthly);

$monthly_counts = array_fill(1, 12, 0); // start with 0 for all 12 months

while ($row = mysqli_fetch_assoc($result_monthly)) {
    $monthly_counts[(int)$row['month_num']] = (int)$row['total'];
}

$monthly_json = json_encode(array_values($monthly_counts));
?>