<?php 
include 'config.php';
include 'queries.php';
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
            <a href="admin_dashboard.php">
              <i class="bi bi-house icon"></i>
              <span class="text nav-text">Dashboard</span>
            </a>
          </li>

          <li class="nav-link">
            <a href="manage_patients.php">
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
        <div class="d-flex align-items-center">
          <i class="bi bi-list mx-3 toggle"></i>
         <form action="" method="GET" class="d-flex" role="search">
          <div class="input-group m-3">
            <i class="bi bi-search input-group-text search-icon"></i>
            <input class="form-control" type="search" name="search" id="search" 
                placeholder="Search patients..." aria-label="Search"
                value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button class="btn btn-primary btn-sm">Search</button>            
          </div>          
        </form>

        </div>
        <div class="me-5">
          <p class="mt-3 fs-4">Manage Patients</p>
        </div>
        
      </div>

      <section class="container-fluid my-5 px-5">
        <div class="card p-3 edit-con mb-3">
          <p class="fs-4 fw-medium">Add/Edit Patient</p>
          <form method="POST" action="manage_patients.php">
            <input type="hidden" name="id" id="patient_id">
            <div class="row gap-3 mx-auto py-5">
              <div class="col-2">
                 <label for="first_name" class="form-label">First Name:</label>
                 <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name" required>
              </div>
              
              <div class="col-2">
                <label for="last_name" class="form-label">Last Name:</label>
                <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name" required>
              </div>

               <div class="col-2">
                 <label for="email" class="form-label">Email:</label>
                  <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
              </div>

               <div class="col-2">
                <label for="phone" class="form-label">Phone:</label>
                <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone">
              </div>

              <div class="col-2">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
              </div>

              <div class="col-1 text-end m-0 p-0">
                    <button type="submit" class="btn btn-success save-button w-100">Save</button>
                </div>

            </div>
          </form>
        </div>

        <div class="card patients-list-con p-3 ">
          <p class="fs-4 fw-medium">Patients</p>
          <div class="table-responsive">
          <table class="table">
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['patient_id']; ?></td>
                <td><?php echo $row['first_name']; ?></td>
                <td><?php echo $row['last_name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td>
                    <a href='view_patient.php?id=<?php echo $row['patient_id']; ?>' class='btn btn-info mb-lg-0 mb-2'>View</a>
                    <button class='btn btn-warning mb-lg-0 mb-2' onclick="editPatient(<?php echo $row['patient_id']; ?>, '<?php echo $row['first_name']; ?>', '<?php echo $row['last_name']; ?>', '<?php echo $row['email']; ?>', '<?php echo $row['phone']; ?>')">Edit</button>
                    <form method="POST" action="manage_patients.php" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $row['patient_id']; ?>">
                        <button class='btn btn-danger mb-lg-0 mb-2' type="submit" name="delete">Delete</button>
                    </form>
                </td>
            </tr>
            <?php } ?>
            </table>
          </div>
        </div>
      
      </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
    <script src="components/admin_dashboard.js"></script>

    <script>
        function editPatient(id, firstName, lastName, email, phone) {
            document.getElementById('patient_id').value = id;
            document.getElementById('first_name').value = firstName;
            document.getElementById('last_name').value = lastName;
            document.getElementById('email').value = email;
            document.getElementById('phone').value = phone;
        }
        
    </script>

  </body>
  
</html>