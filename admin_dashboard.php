<?php 
include 'config.php';
include 'queries.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/admin_dashboard.css">
   
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>
  </head>
  <body>
    <nav class="sidebar close">
    <header>
      <a href="index.html" class="image-text ps-3 nav-link">
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
          <li class="nav-link active">
            <a href="admin_dashboard.php">
              <i class="bi bi-house icon"></i>
              <span class="text nav-text">Dashboard</span>
            </a>
          </li>

          <li class="nav-link">
            <a href="manage_patients.php">
              <i class="bi bi-person-vcard icon"></i>
              <span class="text nav-text">Patients</span>
            </a>
          </li>

          <li class="nav-link">
            <a href="manage_providers.php">
              <i class="bi bi-heart-pulse icon"></i>
              <span class="text nav-text">Providers</span>
            </a>
          </li>

          <li class="nav-link">
            <a href="list_appointment.php">
              <i class="bi bi-clipboard2-pulse icon"></i>
              <span class="text nav-text">Appointments</span>
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
        <p class="fs-4 m-0">Admin Dashboard</p>

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
      <section class="container-fluid my-5 px-lg-5 px-3">
        <div class="row mb-3">
          <div class="col-lg-6 row pe-0">

            <div class="col-lg-6 col-md-6 mb-3">
              <div class="card p-3">
                <p class="fs-5">Providers</p>
                <p class=""><?php echo $total_providers; ?></p>
              </div>
            </div>

           <div class="col-lg-6 col-md-6 mb-3">
              <div class="card p-3">
                <p class="fs-5">Total Patients</p>
                <p class=""><?php echo $total_patients; ?></p>
              </div>
            </div>

            <div class="col-lg-6 col-md-6 mb-3">
              <div class="card p-3">
                <p class="fs-5">New Patients</p>
                <p class="">0</p>
              </div>
            </div>

            <div class="col-lg-6 col-md-6 mb-3">
              <div class="card p-3">
                <p class="fs-5">Appointments Today</p>
                <p class=""><?php echo $total_new_appointments?></p>
              </div>
            </div>
            
          </div>


          <div class="col-lg-6 pe-lg-0">
            <div class="card monthly-card p-3">
              <p class="fs-5">Monthly Appointments</p>
              <div id="bar-chart-monthly" class="chart-container-monthly"></div>
            </div>
          </div>
        </div>

        <div class="row me-2">
          <div class="col-lg-9 mb-3 pe-0">
            <div class="card p-3">
              <p class="fs-5">Appointments Per Day</p>
              <div id="line-chart" class="chart-container"></div>
            </div>
          </div>

          <div class="col-lg-3 pe-0 mb-3">
            <div class="card p-3">
              <p class="fs-5">Top Services</p>
              <div id="pie-chart" class="chart-container"></div>
            </div>
          </div>
        </div>

        <div>

        </div>
        
      </section>
    </main>

    <nav class="navbar-bottom">
      <ul>
        <li class="active">
          <a href="">
            <i class="bi bi-house icon-m"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <li>
          <a href="">
            <i class="bi bi-person-vcard"></i>
            <p>Patients</p>
          </a>
        </li>

        <li>
          <a href="">
            <i class="bi bi-heart-pulse"></i>
            <p>Providers</p>
          </a>
        </li>

        <li>
          <a href="">
            <i class="bi bi-clipboard2-pulse"></i>
            <p>Appointments</p>
          </a>
        </li>
      </ul>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
    <script>
      var monthlyData = <?php echo $monthly_json; ?>; 
      var thisWeekData = <?php echo $this_week_json; ?>;
      var lastWeekData = <?php echo $last_week_json; ?>;
      var serviceData = <?php echo $service_json; ?>;
    </script>
    <script src="components/charts.js"></script>
    <script src="components/admin_dashboard.js"></script>
  
  </body>  
</html>

<?php
mysqli_close($conn);
?>