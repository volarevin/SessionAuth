<?php
session_start();
include "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $login = trim($_POST["login"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare(
        "SELECT * FROM users WHERE email = ? OR username = ? LIMIT 1"
    );

    if (!$stmt) {
        $error = "Login is temporarily unavailable. Please check the users table structure.";
    } else {
        $stmt->bind_param("ss", $login, $login);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($user = $result->fetch_assoc()) {
            if (password_verify($password, $user["password_hash"])) {
                session_regenerate_id(true);

                $_SESSION["user_id"] = $user["id"];
                $_SESSION["username"] = $user["username"];
                $_SESSION["email"] = $user["email"];

                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Invalid email/username or password!";
            }
        } else {
            $error = "Invalid email/username or password!";
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
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
            <h2 class="text-center mb-4 fw-bold text-dark">Login</h2>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($error); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

                <form method="POST">
                <div class="mb-3">
                <label for="login" class="form-label">Email or Username</label>
                <input type="text" class="form-control form-control-lg" id="login" name="login" required>
                </div>

                <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control form-control-lg" id="password" name="password" required>
      </div>

     <div class="d-grid mb-4">
      <button type="submit" class="btn btn-primary btn-lg">Login</button>
     </div>

     <p class="text-center mb-0">
         Don't have an account? 
        <a href="register.php" class="text-primary fw-bold text-decoration-none">Register</a>
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
