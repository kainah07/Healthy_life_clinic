<?php
include 'config.php';
include 'queries.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['delete'])) {
      // DELETE provider
      $id = intval($_POST['id']);
      $query_providers = "DELETE FROM providers WHERE provider_id = $id";
      if (mysqli_query($conn, $query_providers)) {
          $_SESSION['message'] = "Provider deleted successfully";
          $_SESSION['msg_type'] = "danger";
      } else {
          $_SESSION['message'] = "Error deleting provider: " . mysqli_error($conn);
          $_SESSION['msg_type'] = "danger";
      }
      header("Location: manage_providers.php");
      exit;
  } else {
      // SANITIZE input
      $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
      $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
      $specialization = mysqli_real_escape_string($conn, $_POST['specialization']);

      // UPDATE
      if (isset($_POST['id']) && $_POST['id'] !== '') {
          $id = intval($_POST['id']);
          $query_providers = "UPDATE providers SET first_name='$first_name', last_name='$last_name', specialization='$specialization' WHERE provider_id=$id";
          $successMsg = "Provider updated successfully";
      } else {
          // INSERT
          $query_providers = "INSERT INTO providers (first_name, last_name, specialization) VALUES ('$first_name', '$last_name', '$specialization')";
          $successMsg = "Provider added successfully";
      }

      if (mysqli_query($conn, $query_providers)) {
          $_SESSION['message'] = $successMsg;
          $_SESSION['msg_type'] = "success";
      } else {
          $_SESSION['message'] = "Error: " . mysqli_error($conn);
          $_SESSION['msg_type'] = "danger";
      }

      header("Location: manage_providers.php");
      exit;
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Providers</title>

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
                placeholder="Search providers..." aria-label="Search"
                value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button class="btn btn-primary btn-sm">Search</button>            
          </div>          
        </form>
      </div>
      <div class="me-5">
        <p class="mt-3 fs-4">Manage Providers</p>
      </div>
    </div>

    <section class="container-fluid my-5 px-5">
      <?php if (isset($_SESSION['message'])): ?>
          <div class="alert alert-<?php echo $_SESSION['msg_type']; ?> alert-dismissible fade show" role="alert">
              <?php echo $_SESSION['message']; ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php unset($_SESSION['message']); ?>
      <?php endif; ?>

      <div class="card p-3 edit-con mb-3">
        <p class="fs-4 fw-medium">Add/Edit Provider</p>
        <form method="POST" action="manage_providers.php">
          <input type="hidden" name="id" id="provider_id">
          <div class="row gap-3 mx-auto py-5">
           <div class="col-lg-auto">
              <label for="first_name" class="form-label">First Name:</label>
              <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name" required>
            </div>
            <div class="col-lg-auto">
                <label for="last_name" class="form-label">Last Name:</label>
                <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name" required>
            </div>
            <div class="col-lg-auto">
                <label for="specialization" class="form-label">Specialization:</label>
                <input type="text" class="form-control" name="specialization" id="specialization" placeholder="Specialization" required>
            </div>
           
            <div class="col-auto text-end m-0 p-0">
                    <button type="submit" class="btn btn-success save-button w-100">Save</button>
                </div>
          </div>
        </form>
      </div>

      <div class="card patients-list-con p-3 ">
        <p class="fs-4 fw-medium">Providers</p>
        <div class="table-responsive">
          <table class="table">
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Specialization</th>
                <th>Actions</th>
            </tr>
            <?php if (mysqli_num_rows($result_providers) > 0) { ?>
              <?php while($row = mysqli_fetch_assoc($result_providers)) { ?>
                <tr>
                  <td><?php echo $row['provider_id']; ?></td>
                  <td><?php echo $row['first_name'];?></td>
                  <td><?php echo $row['last_name'];?></td>
                  <td><?php echo $row['specialization'];?></td>
                  <td>
                    <a href='view_provider.php?id=<?php echo $row['provider_id']; ?>' class='btn btn-info mb-lg-0 mb-2'>View</a>
                    <button class='btn btn-warning mb-lg-0 mb-2' onclick="editProvider(<?php echo $row['provider_id']; ?>, '<?php echo $row['first_name']; ?>', '<?php echo $row['last_name']; ?>', '<?php echo $row['specialization']; ?>')">Edit</button>
                    <form method="POST" action="manage_providers.php" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $row['provider_id']; ?>">
                        <button class='btn btn-danger mb-lg-0 mb-2' type="submit" name="delete">Delete</button>
                    </form>
                  </td>
                </tr>
              <?php } ?>
            <?php } else { ?>
              <tr>
                  <td colspan="6" class="text-center text-danger">No providers found.</td>
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
        function editProvider(id, firstName, lastName, specialization) {
            document.getElementById('provider_id').value = id;
            document.getElementById('first_name').value = firstName;
            document.getElementById('last_name').value = lastName;
            document.getElementById('specialization').value = specialization;
        }
    </script>
</body>
</html>