<?php

session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="site-header">
    <div class="container nav">
        <a class="brand" href="index.php">Student Portal</a>

        <nav>
            <?php if (isset($_SESSION['student_id'])): ?>
                <a href="dashboard.php">Dashboard</a>
                <a class="btn small" href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a class="btn small" href="register.php">Register</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<main class="hero container">
    <section class="hero-card">
        <span class="badge">PHP + MySQL on AWS</span>

        <h1>Student Registration and Login Portal</h1>

        <p>
            Register student details securely, log in and view the
            database-backed student dashboard.
        </p>

        <div class="hero-actions">
            <?php if (isset($_SESSION['student_id'])): ?>
                <a class="btn" href="dashboard.php">
                    Open Dashboard
                </a>
            <?php else: ?>
                <a class="btn" href="register.php">
                    Create Account
                </a>

                <a class="btn secondary" href="login.php">
                    Student Login
                </a>
            <?php endif; ?>
        </div>
    </section>
</main>

</body>
</html>