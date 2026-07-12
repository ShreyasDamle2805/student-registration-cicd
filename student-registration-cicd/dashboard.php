<?php

session_start();

if (!isset($_SESSION['student_id'])) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/db.php';

$statement = $pdo->prepare(
    'SELECT full_name, email, usn, department, created_at
     FROM students
     WHERE id = :id
     LIMIT 1'
);

$statement->execute([
    'id' => $_SESSION['student_id']
]);

$student = $statement->fetch();

if (!$student) {
    session_unset();
    session_destroy();

    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Student Portal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="site-header">
    <div class="container nav">
        <a class="brand" href="index.php">Student Portal</a>

        <nav>
            <a class="btn small" href="logout.php">Logout</a>
        </nav>
    </div>
</header>

<main class="dashboard container">
    <section class="welcome-card">
        <span class="badge">Authenticated Student</span>

        <h1>
            Welcome,
            <?php echo htmlspecialchars($student['full_name']); ?>
        </h1>

        <p>Your details were loaded from the MySQL database.</p>
    </section>

    <section class="details-card">
        <h2>Student Details</h2>

        <div class="details-grid">
            <div>
                <span>Full Name</span>
                <strong>
                    <?php echo htmlspecialchars($student['full_name']); ?>
                </strong>
            </div>

            <div>
                <span>Email</span>
                <strong>
                    <?php echo htmlspecialchars($student['email']); ?>
                </strong>
            </div>

            <div>
                <span>USN</span>
                <strong>
                    <?php echo htmlspecialchars($student['usn']); ?>
                </strong>
            </div>

            <div>
                <span>Department</span>
                <strong>
                    <?php echo htmlspecialchars($student['department']); ?>
                </strong>
            </div>

            <div>
                <span>Registered On</span>
                <strong>
                    <?php echo htmlspecialchars($student['created_at']); ?>
                </strong>
            </div>
        </div>
    </section>
</main>

</body>
</html>