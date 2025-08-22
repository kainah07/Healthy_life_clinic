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

// Count total appointments per month
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


// Count total appointments this week
$query_this_week = "
    SELECT DAYOFWEEK(appointment_date) AS day_num, COUNT(*) AS total
    FROM appointments
    WHERE YEARWEEK(appointment_date, 1) = YEARWEEK(CURDATE(), 1)
    GROUP BY day_num
";
$result_this_week = mysqli_query($conn, $query_this_week);

$this_week_counts = array_fill(1, 7, 0); // Sunday=1, Saturday=7
while ($row = mysqli_fetch_assoc($result_this_week)) {
    $this_week_counts[(int)$row['day_num']] = (int)$row['total'];
}

// Count total appointments last week
$query_last_week = "
    SELECT DAYOFWEEK(appointment_date) AS day_num, COUNT(*) AS total
    FROM appointments
    WHERE YEARWEEK(appointment_date, 1) = YEARWEEK(CURDATE(), 1) - 1
    GROUP BY day_num
";
$result_last_week = mysqli_query($conn, $query_last_week);

$last_week_counts = array_fill(1, 7, 0);
while ($row = mysqli_fetch_assoc($result_last_week)) {
    $last_week_counts[(int)$row['day_num']] = (int)$row['total'];
}

// Convert Sunday-started arrays into Monday-started for chart
function reorder_week($data) {
    return array_merge(array_slice($data, 1), array_slice($data, 0, 1));
}

$this_week_ordered = reorder_week($this_week_counts);
$last_week_ordered = reorder_week($last_week_counts);

// JSON encode for JS
$this_week_json = json_encode(array_values($this_week_ordered));
$last_week_json = json_encode(array_values($last_week_ordered));

// Count services by provider specialization
$query_services = "
    SELECT providers.specialization AS service, COUNT(*) AS total
    FROM appointments
    JOIN providers ON appointments.provider_id = providers.provider_id
    GROUP BY providers.specialization
";
$result_services = mysqli_query($conn, $query_services);

$service_data = [];
while ($row = mysqli_fetch_assoc($result_services)) {
    $service_data[] = [
        "name"  => $row["service"],
        "value" => (int)$row["total"]
    ];
}

$service_json = json_encode($service_data);


// Patients search
$search_patients = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : "";
$query_patients = "SELECT * FROM patients";

if (!empty($search_patients)) {
    $query_patients .= " WHERE first_name LIKE '%$search_patients%' 
                         OR last_name LIKE '%$search_patients%' 
                         OR email LIKE '%$search_patients%' 
                         OR phone LIKE '%$search_patients%' 
                         OR patient_id LIKE '%$search_patients%'";
}

$result_patients = mysqli_query($conn, $query_patients);
if (!$result_patients) {
    die("Error fetching patients: " . mysqli_error($conn));
}


// Providers search
$search_providers = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : "";
$query_providers = "SELECT * FROM providers";

if (!empty($search_providers)) {
    $query_providers .= " WHERE first_name LIKE '%$search_providers%' 
                          OR last_name LIKE '%$search_providers%' 
                          OR specialization LIKE '%$search_providers%' 
                          OR provider_id LIKE '%$search_providers%'";
}

$result_providers = mysqli_query($conn, $query_providers);
if (!$result_providers) {
    die("Error fetching providers: " . mysqli_error($conn));
}

// Appointments search
$search_appointments = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : "";
$query_appointments = "
    SELECT a.*, 
           p.first_name AS patient_first_name, p.last_name AS patient_last_name,
           pr.first_name AS provider_first_name, pr.last_name AS provider_last_name
    FROM appointments a
    JOIN patients p ON a.patient_id = p.patient_id
    JOIN providers pr ON a.provider_id = pr.provider_id
";

if (!empty($search_appointments)) {
    $query_appointments .= " WHERE a.reason LIKE '%$search_appointments%' 
                          OR a.appointment_id LIKE '%$search_appointments%' 
                          OR p.first_name LIKE '%$search_appointments%' 
                          OR p.last_name LIKE '%$search_appointments%' 
                          OR pr.first_name LIKE '%$search_appointments%' 
                          OR pr.last_name LIKE '%$search_appointments%'";
}

$result_appointments = mysqli_query($conn, $query_appointments);

if (!$result_appointments) {
    echo "Error fetching appointments: " . mysqli_error($conn);
    exit;
}
?>