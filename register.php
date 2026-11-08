<?php
session_start();
include "db.php";

$message = "";
$alertClass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($username === "" || $email === "" || $password === "") {
        $message = "Username, email, and password are required.";
        $alertClass = "alert-danger";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare(
            "INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)"
        );

        if (!$stmt) {
            $message = "Registration failed. Please check the users table structure.";
            $alertClass = "alert-danger";
        } else {
            $stmt->bind_param("sss", $username, $email, $hashed_password);

            if ($stmt->execute()) {
                $message = "Registration successful! You can now login.";
                $alertClass = "alert-success";
            } else {
                $message = "Username or email already exists, or registration failed.";
                $alertClass = "alert-danger";
            }

            $stmt->close();
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f4f8;
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 2rem 0;
        }
    </style>
</head>
<body>

<div class="container">
 <div class="row justify-content-center">
<div class="col-md-5 col-sm-8">
<div class="card border-0 shadow-lg rounded-4">
<div class="card-body p-4 p-sm-5">
<h2 class="text-center mb-4 fw-bold text-dark">Register</h2>

    <?php if (!empty($message)): ?>
<div class="alert <?php echo $alertClass; ?> alert-dismissible fade show" role="alert">
    <?php echo htmlspecialchars($message); ?>
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
    <?php endif; ?>

     <form method="POST">
<div class="mb-3">
<label for="username" class="form-label">Username</label>
    <input type="text" class="form-control form-control-lg" id="username" name="username" required>
         </div>

    <div class="mb-3">
   <label for="email" class="form-label">Email Address</label>
    <input type="email" class="form-control form-control-lg" id="email" name="email" required> </div>

     <div class="mb-3">
 <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control form-control-lg" id="password" name="password" required>
    </div>


    <div class="d-grid mb-4">
    <button type="submit" class="btn btn-primary btn-lg">Register</button>
    </div>

    <p class="text-center mb-0">
     Already have an account? 
     <a href="index.php" class="text-primary fw-bold text-decoration-none">Login</a>
     </p>
    </form>
    </div>
    </div>
    </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
