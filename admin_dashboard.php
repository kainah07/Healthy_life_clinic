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
              <i class="bi bi-person-lines-fill icon"></i>
              <span class="text nav-text">Patients</span>
            </a>
          </li>

          <li class="nav-link">
            <a href="">
              <i class="bi bi-clipboard2-pulse icon"></i>
              <span class="text nav-text">Providers</span>
            </a>
          </li>

        </ul>
      </div>

      <div class="bottom-content">
        <li class="">
          <a href="">
            <i class="bi bi-box-arrow-left icon"></i>
            <span class="text nav-text">Logout</span>
          </a>
        </li>

        <li class="mode">
          <div class="moon-sun">
            <i class="bi bi-moon icon moon"></i>
            <i class="bi bi-sun icon sun"></i>
          </div>
          <span class="mode-text text">Dark Mode</span>
          <div class="toggle-switch">
            <span class="switch"></span>
          </div>
        </li>
      </div>
    </div>
  </nav>
  
  <main>
      <div class="dashboard-top-nav">
        <i class="bi bi-list mx-3 toggle"></i>
        <form action="" class="d-flex" role="search">
          <div class="input-group m-3">
            <i class="bi bi-search input-group-text search-icon"></i>
            <input class="form-control" type="search" name="search" id="search" placeholder="Search" aria-label="Search">
             <button class="btn  btn-primary btn-sm">Search</button>
          </div>          
        </form>
      </div>

      <section class="container-fluid my-5 px-5">
        <div class="row mb-3">
          <div class="col-6 row">

            <div class="col-6 mb-3">
              <div class="card p-3">
                <p class="fs-5">Providers</p>
                <p class=""><?php echo $total_providers; ?></p>
              </div>
            </div>

           <div class="col-6 mb-3">
              <div class="card p-3">
                <p class="fs-5">Total Patients</p>
                <p class=""><?php echo $total_patients; ?></p>
              </div>
            </div>

            <div class="col-6 mb-3">
              <div class="card p-3">
                <p class="fs-5">Appointments Today</p>
                <p class=""><?php echo $total_new_appointments?></p>
              </div>
            </div>

            <div class="col-6 mb-3">
              <div class="card p-3">
                <p class="fs-5">New Patients</p>
                <p class="">0</p>
              </div>
            </div>
            
          </div>


          <div class="col-6">
            <div class="card monthly-card p-3">
              <p class="fs-5">Monthly Appointments</p>
              <div id="bar-chart-monthly" class="chart-container-monthly"></div>
            </div>
          </div>
        </div>

        <div class="row me-2">
          <div class="col-9">
            <div class="card p-3">
              <p class="fs-5">Appointments Per Day</p>
              <div id="line-chart" class="chart-container"></div>
            </div>
          </div>

          <div class="col-3">
            <div class="card p-3">
              <p class="fs-5">Top Services</p>
              <div id="pie-chart" class="chart-container"></div>
            </div>
          </div>
        </div>
        
      </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
    <script>var monthlyData = <?php echo $monthly_json; ?>; </script>
    <script src="components/charts.js"></script>
    <script src="components/admin_dashboard.js"></script>
    

  </body>
  
</html>