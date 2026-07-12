<?php

session_start();
require_once __DIR__ . '/db.php';

if (isset($_SESSION['student_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
        $error = 'Enter a valid email and password.';
    } else {
        $statement = $pdo->prepare(
            'SELECT id, full_name, email, password_hash
             FROM students
             WHERE email = :email
             LIMIT 1'
        );

        $statement->execute([
            'email' => $email
        ]);

        $student = $statement->fetch();

        if (
            $student &&
            password_verify($password, $student['password_hash'])
        ) {
            session_regenerate_id(true);

            $_SESSION['student_id'] = $student['id'];
            $_SESSION['student_name'] = $student['full_name'];

            header('Location: dashboard.php');
            exit;
        }

        $error = 'Invalid email or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Student Portal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="site-header">
    <div class="container nav">
        <a class="brand" href="index.php">Student Portal</a>
        <nav>
            <a href="register.php">Register</a>
        </nav>
    </div>
</header>

<main class="form-page container">
    <section class="form-card compact">
        <h1>Student Login</h1>
        <p class="subtext">Sign in to view your dashboard.</p>

        <?php if (isset($_GET['registered'])): ?>
            <div class="alert success">
                Registration successful. You can now log in.
            </div>
        <?php endif; ?>

        <?php if ($error !== ''): ?>
            <div class="alert error">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <label for="email">Email</label>
            <input
                id="email"
                name="email"
                type="email"
                value="<?php echo htmlspecialchars($email); ?>"
                required
            >

            <label for="password">Password</label>
            <input
                id="password"
                name="password"
                type="password"
                required
            >

            <button class="btn full-width" type="submit">
                Login
            </button>
        </form>

        <p class="form-footer">
            New student?
            <a href="register.php">Create an account</a>
        </p>
    </section>
</main>

</body>
</html>