<?php
  include 'config.php';

  if (!isset($_SESSION['user_id'])) {
      header('Location: login.php');
      exit();
  }

  // Ensure the session variable is set correctly
  $patient_id = $_SESSION['user_id'];
  $first_name = $_SESSION['first_name'];

  $query_appointments = "SELECT appointments.*, CONCAT (p.first_name, ' ', p.last_name) AS provider
            FROM appointments 
            JOIN providers p ON appointments.provider_id = p.provider_id
            WHERE appointments.patient_id = $patient_id 
            AND appointments.appointment_date >= CURDATE()"; // Future & today

  $result_appointments = mysqli_query($conn, $query_appointments);
  $upcoming_appointment = mysqli_num_rows($result_appointments);

  $query_medical_record = "SELECT appointments.*, CONCAT (p.first_name, ' ', p.last_name) AS provider, p.specialization
            FROM appointments 
            JOIN providers p ON appointments.provider_id = p.provider_id
            WHERE appointments.patient_id = $patient_id 
            AND appointments.appointment_date < CURDATE()"; // Past appointments

$result_medical_record = mysqli_query($conn, $query_medical_record);


?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patients dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/patient_dashboard.css">
    
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>
  </head>
  <body>
    <nav class="sidebar">
    <header>
      <a href="" class="image-text ps-3 nav-link">
        <span class="image">
          <img src="images/logo (1).png" alt="logo">
        </span>
        <div class="text header-text">
          <span class="name">Healthy Life </span>
          <span class="clinic">Clinic</span>
        </div>
      </a>
    </header>

    <div class="menu-bar">
      <div class="menu mt-2">
        <ul class="menu-links ">
          <li class="nav-link">
            <a href="">
              <i class="bi bi-house icon"></i>
              <span class="text nav-text">Dashboard</span>
            </a>
          </li>

          <li class="nav-link">
            <a href="manage_patients.html">
              <i class="bi bi-clipboard-heart icon"></i>
              <span class="text nav-text">Appointments</span>
            </a>
          </li>

          <li class="nav-link">
            <a href="">
              <i class="bi bi-calendar-event icon"></i>
              <span class="text nav-text">Book appointment</span>
            </a>
          </li>

        </ul>
      </div>

      <div class="bottom-content">
        <li class="">
          <a href="logout.php">
            <i class="bi bi-box-arrow-left icon"></i>
            <span class="text nav-text">Logout</span>
          </a>
        </li>
      </div>
    </div>
  </nav>
  
  <main>
         <nav class="navbar dashboard-top-nav shadow-sm">
      <div class="navbar-items-con container-fluid d-flex align-items-center justify-content-between">
        <i class="bi bi-list toggle d-none d-lg-block menu"></i>
        <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-controls="nav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <p class="fs-4 m-0">Patient Dashboard</p>

        <div class="collapse navbar-collapse menu-bar" id="nav">
         <ul class="navbar-nav">

           <li class="nav-item">
            <a href="logout.php" class="nav-link d-flex align-items-center">
              <i class="bi bi-box-arrow-left me-2"></i>
              <span class="text">Logout</span>
            </a>
          </li>
         </ul>
         
        </div>
      </div>
    </nav>

      <section class="container-fluid my-5 px-5">
            <div id="con" class="container-fluid bg-light p-lg-5 p-2">
      <div class="container m-lg-1 m-2">
        <h1 class="">Welcome, <?php echo htmlspecialchars($first_name); ?>!</h1>
        <p class="mt-3 fs-5 ">
          Good to see you! Stay on top of your schedule with quick access to your bookings.
        </p>
        <a href="make_appointment.php" class="btn btn-primary mb-2">Make an appointment</a>
      </div>

        <div class="container-fluid d-flex flex-column flex-lg-row justify-content-center align-lg-items-center align-items-start gap-lg-3">
        <div id="patientAppointmentCon" class="container card mt-4 shadow p-3 mb-5 rounded p-2">
          <h2 class="card-title">Your Appointments</h2>
          <p class="text-primary">You have <strong><?php echo $upcoming_appointment?></strong> upcoming appointment(s)!</p>
          <div class="card-body table-responsive border">
            <?php 
              if ($result_appointments->num_rows > 0): 
                while ($row = $result_appointments->fetch_assoc()): 
            ?>
            <div class="container">
              <p><strong><?php echo htmlspecialchars($row['provider']); ?></strong></p> 
              <p><?php echo date("F j, Y", strtotime($row['appointment_date'])); ?> at <?php echo date("g:i A", strtotime($row['appointment_time'])); ?> - <?php echo htmlspecialchars($row['reason']); ?></p>
            </div>
            <?php endwhile; ?>
            <?php else: ?>
            <p>No appointments found. <a href="make_appointment.php">Make an appointment now!</a></p>
            <?php endif; ?>

          </div>        
          <div class="mt-1 p-1">
            <a class="btn btn-outline-primary btn-sm" href="view_patient_appointments.php">View all</a>
          </div>
        </div>
             
        <div id="medicalRecordCon" class="container card mt-4 shadow p-3 mb-5 rounded p-2">
          <h2 class="card-title">Medical records</h2>
          <div class="card-body table-responsive">
            <?php if ($result_medical_record->num_rows > 0):  ?>
            <table class="table">
              <thead>
                <tr>
                <th scope="col">Doctor</th>
                <th scope="col">Specialization</th>
                <th scope="col">Date</th>
                <th scope="col">Time</th>
                <th scope="col">Record</th>
                </tr>
              </thead>
              <tbody>
                <?php  while ($row = mysqli_fetch_assoc($result_medical_record)) { ?>
                <tr class="">
                <td scope="row"><?php echo $row['provider']?></td>
                <td scope="row"><?php echo $row['specialization']?></td>
                <td scope="row"><?php echo $row['appointment_date']?></td>
                <td scope="row"><?php echo $row['appointment_time']?></td>
                <td scope="row"><?php echo $row['reason']?></td>
                </tr>

                <?php } ?>
              </tbody>
            </table>
            <?php else: ?>
            <p>No Medical record found. <a href="make_appointment.php">Make an appointment now!</a></p>
            <?php endif; ?>
          </div>

        </div>
      </div>

      
    </div>
      </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
    <script src="components/admin_dashboard.js"></script>

  </body>
  
</html>