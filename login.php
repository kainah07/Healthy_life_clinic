<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $user_type = $_POST['user_type'];

    if (!in_array($user_type, ['admin', 'patient'])) {
        die("<p>Invalid user type.</p>");
    }

    // Determine the correct table
    $table = ($user_type === 'admin') ? 'admins' : 'patients';
    $id_column = ($user_type === 'admin') ? 'admin_id' : 'patient_id';

    $query = "SELECT * FROM $table WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['password'])) {
              $_SESSION['user_id'] = $row[$id_column];
              $_SESSION['is_admin'] = ($user_type === 'admin');

              // If patient login → store names
              if ($user_type === 'patient') {
                  $_SESSION['first_name'] = $row['first_name'];
                  $_SESSION['last_name']  = $row['last_name'];
              }

              // Redirect based on role
              header('Location: ' . ($user_type === 'admin' ? 'admin_dashboard.php' : 'patient_dashboard.php'));
              exit;

        } else {
            $error = "Invalid email or password.";
        }
    } else {
        $error = "No user found with that email.";
    }
}
?>

<?php
mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/forms.css">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  </head>
  <body class="d-flex justify-content-center align-items-center vh-100">
    <div class="login-container shadow-lg px-0 rounded-4 bg-light bg-opacity-25 mx-3  text-light">
      <div class="p-lg-5 p-md-5 p-3">
        <h1 class="text-center mb-lg-4 m-4 mt-lg-0 mt-md-0 border-bottom border-3 pb-3">Login</h1>
        <div class="text-center">
          <?php if (!empty($error)) echo "<p class='text-danger'>$error</p>"; ?>
        </div>
        <form action="login.php" method="POST">
          <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" name="email" id="email" placeholder="Email Address" class="form-control">
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
             <div class="input-group">
              <input type="password" class="form-control" name="password" id="patient_password" placeholder="Password" autocomplete="new-password">
               <span class="input-group-text" onclick="togglePassword('patient_password', this)" style="cursor: pointer;">
                <i class="bi bi-eye"></i>
              </span>
            </div>
          </div>
          <div class="mb-3">
            <label for="user_type">Login as:</label>
          </div>
          
          <div class="mb-3">
            <select name="user_type" id="user_type" class="form-select">
              <option value="admin">Admin</option>
              <option value="patient">Patient</option>
            </select>
          </div>
          
          <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
        <p class="mt-4 text-center">Don't have an account? <a href="register.html">Register</a></p>
      </div>
    </div>

    <script>
      function togglePassword(fieldId, el) {
        const input = document.getElementById(fieldId);
        const icon = el.querySelector("i");
        if (input.type === "password") {
          input.type = "text";
          icon.classList.remove("bi-eye");
          icon.classList.add("bi-eye-slash");
        } else {
          input.type = "password";
          icon.classList.remove("bi-eye-slash");
          icon.classList.add("bi-eye");
        }
      }
    </script>


  </body>
</html>