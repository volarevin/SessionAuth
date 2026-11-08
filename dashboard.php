<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit();
}

$session_id = session_id();
$joined_date = date("M d, Y"); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Roboto, sans-serif;
            color: #334155;
        }

        .navbar {
            background-color: #000000;
            padding: 16px 0;
        }

        .navbar-content {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .navbar-title {
            color: #ffffff;
            font-size: 1.25rem;
            font-weight: 700;
            margin-right: 10px;
        }

        .dashboard-link {
            color: #ffffff;
            text-decoration: none;
            font-weight: 600;
        }

        .dashboard-link:hover {
            color: #e5e7eb;
        }

        .navbar-account {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-left: auto;
        }

        .profile-tag {
            background-color: #ffffff;
            color: #1e293b;
            padding: 6px 16px;
            border-radius: 6px;
            font-weight: 500;
        }

        .logout-btn {
            background-color: #ef4444;
            color: white !important;
            padding: 6px 18px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.2s;
        }

        .logout-btn:hover {
            background-color: #dc2626;
        }

        .session-message {
            color: #475569;
            font-size: 0.95rem;
            line-height: 1.6;
            margin: 0;
        }

        .session-function {
            color: #ec4899;
        }

        .welcome-card h1 {
            color: #2563eb;
        }

        .welcome-card {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 40px;
            margin-bottom: 30px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .welcome-card p {
            color: #64748b;
            font-size: 1.1rem;
            margin-bottom: 25px;
        }

        .explore-btn {
            background-color: #3b82f6;
            color: white !important;
            padding: 10px 24px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            transition: background-color 0.2s;
        }

        .explore-btn:hover {
            background-color: #2563eb;
        }

        
        .info-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }

        @media (max-width: 768px) {
            .info-row {
                grid-template-columns: 1fr;
            }
        }

        .info-card {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            position: relative;
            overflow: hidden;
        }

        
        .card-status {
            border-left: 0;
        }

        .card-details {
            border-left: 0;
        }

        .card-session {
            border-left: 0;
        }

        .info-card h5 {
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .card-status h5 {
            color: #16a34a;
        }

        .card-details h5 {
            color: #0891b2;
        }

        .card-session h5 {
            color: #ca8a04;
        }

        .info-row p {
            margin: 8px 0;
            font-size: 0.95rem;
        }

        .info-row p strong {
            color: #475569;
            display: inline-block;
            min-width: 100px;
        }

        .status-badge {
            background-color: #d1fae5;
            color: #065f46;
            padding: 6px 16px;
            border-radius: 20px;
            font-weight: 600;
            display: inline-block;
            font-size: 0.9rem;
        }

        .session-id {
            font-family: monospace;
            color: #475569;
            font-size: 0.9rem;
        }

        .session-note {
            font-size: 0.75rem;
            margin: 18px 0 0;
        }

        .demo-message-wrapper {
            overflow: hidden;
            margin: 28px 0 20px;
            white-space: nowrap;
        }

        .demo-message {
            color: #334155;
            display: inline-block;
            animation: move-demo-message 24s linear infinite;
        }

        @keyframes move-demo-message {
            from {
                transform: translateX(100vw);
            }
            to {
                transform: translateX(-100%);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .demo-message {
                animation: none;
                transform: translateX(0);
            }
        }
    </style>
</head>
<body>
<nav class="navbar">
    <div class="container px-4 px-lg-5 navbar-content">
        <span class="navbar-title">SessionAuthSystem</span>
        <a href="dashboard.php" class="dashboard-link">Dashboard</a>
        <div class="navbar-account">
            <span class="profile-tag"><?php echo htmlspecialchars($_SESSION["username"]); ?></span>
            <a href="logout.php" class="logout-btn">Log Out</a>
        </div>
    </div>
</nav>

<div class="container px-4 px-lg-5">

    <br>
    <div class="welcome-card">

            <h1>Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h1>
        <p>This page is protected and only visible to logged-in users.</p>
        <a href="#" class="explore-btn">EXPLORE DASHBOARD</a>
    </div>

   
    <div class="info-row">
        <div class="info-card card-status">
            <h5>Account Status</h5>
            <p class="session-message">your session is active and protected against session fixation using <code>session_regenerate_id(true).</code></p>
        </div>

    
        <div class="info-card card-details">
            <h5>User Details</h5>
            <p><strong>Username:</strong> <?php echo htmlspecialchars($_SESSION["username"]); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION["email"]); ?></p>
        </div>

        <div class="info-card card-session">
            <h5>Active Session ID</h5>
            <p class="session-id"><strong>Current Session ID:</strong> <code><?php echo htmlspecialchars($session_id); ?></code></p>
            <p class="session-note">Generated after login call to <code>session_regenerate_id()</code></p>
        </div>
    </div>

    <div class="demo-message-wrapper" aria-label="Dashboard demonstration message">
        <p class="demo-message">This is a demo dashboard. You can login to see regeneration in action.</p>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
