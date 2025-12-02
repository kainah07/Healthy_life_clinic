<?php 
include 'config.php';
include 'queries.php'
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/admin_dashboard.css">
   
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"> 
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

            <li class="nav-link active">
              <a href="list_appointment.php">
                <i class="bi bi-clipboard2-pulse icon"></i>
                <span class="text nav-text">Appointments</span>
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

        </div>
      </div>
    </nav>

    <main>
      <div class="dashboard-top-nav">
        <div class="d-flex align-items-center">
          <i class="bi bi-list toggle d-none d-lg-block menu mx-2"></i>
         <form action="" method="GET" class="d-flex" role="search">
          <div class="input-group m-3">
            <i class="bi bi-search input-group-text search-icon"></i>
            <input class="form-control" type="search" name="search" id="search" 
                placeholder="Search appointments..." aria-label="Search"
                value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button class="btn btn-primary btn-sm">Search</button>            
          </div>          
        </form>

        </div>
        <div class="me-5">
          <p class="mt-3 fs-4">Appointment list</p>
        </div>
        
      </div>

      <section class= "container-fluid my-5 px-5">
        <div class="card p-3 appointments-con">
          <p class="fs-4 fw-medium">Appointments</p>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <th>ID</th>
                <th>Patients ID</th>
                <th>Provider ID</th>
                <th>Date</th>
                <th>Time</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Actions</th>
              </thead>
              <?php 
                if (mysqli_num_rows($result_patients) > 0) {
                  // Show the data in the table
                  while ($row = mysqli_fetch_assoc($result_appointments)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['appointment_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['patient_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['provider_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['appointment_date']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['appointment_time']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['reason']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                    echo "<td>
                            <a class='btn btn-info mb-lg-0 mb-2' href='view_appointment.php?id=" . htmlspecialchars($row['appointment_id']) . "'>View</a>
                            <a class='btn btn-warning mb-lg-0 mb-2' href='edit_appointment.php?id=" . htmlspecialchars($row['appointment_id']) . "'>Edit</a> 
                            <a class='btn btn-danger mb-lg-0 mb-2' href='delete_appointment.php?id=" . htmlspecialchars($row['appointment_id']) . "'>Delete</a>
                          </td>";
                    echo "</tr>";
                  }
                  mysqli_free_result($result_appointments);
                } else {
                  echo '<tr>
                          <td colspan="8" class="text-center text-danger">No patients found.</td>
                        </tr>';
                }
              ?>
            </table>
          </div>
          
        </div>
      </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
    <script src="components/admin_dashboard.js"></script>   

  </body>
</html>

<?php
mysqli_close($conn);
?>