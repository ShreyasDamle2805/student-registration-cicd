<?php

session_start();
require_once __DIR__ . '/db.php';

if (isset($_SESSION['student_id'])) {
    header('Location: dashboard.php');
    exit;
}

$errors = [];
$fullName = '';
$email = '';
$usn = '';
$department = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = trim($_POST['full_name'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $usn = strtoupper(trim($_POST['usn'] ?? ''));
    $department = trim($_POST['department'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if ($fullName === '') {
        $errors[] = 'Full name is required.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Enter a valid email address.';
    }

    if ($usn === '') {
        $errors[] = 'USN is required.';
    }

    if ($department === '') {
        $errors[] = 'Department is required.';
    }

    if (strlen($password) < 8) {
        $errors[] = 'Password must contain at least 8 characters.';
    }

    if ($password !== $confirmPassword) {
        $errors[] = 'Passwords do not match.';
    }

    if (!$errors) {
        $check = $pdo->prepare(
            'SELECT id
             FROM students
             WHERE email = :email OR usn = :usn
             LIMIT 1'
        );

        $check->execute([
            'email' => $email,
            'usn' => $usn
        ]);

        if ($check->fetch()) {
            $errors[] = 'Email or USN is already registered.';
        } else {
            $insert = $pdo->prepare(
                'INSERT INTO students
                 (full_name, email, usn, department, password_hash)
                 VALUES
                 (:full_name, :email, :usn, :department, :password_hash)'
            );

            $insert->execute([
                'full_name' => $fullName,
                'email' => $email,
                'usn' => $usn,
                'department' => $department,
                'password_hash' => password_hash(
                    $password,
                    PASSWORD_DEFAULT
                )
            ]);

            header('Location: login.php?registered=1');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Student Portal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="site-header">
    <div class="container nav">
        <a class="brand" href="index.php">Student Portal</a>
        <nav>
            <a href="login.php">Login</a>
        </nav>
    </div>
</header>

<main class="form-page container">
    <section class="form-card">
        <h1>Create Student Account</h1>
        <p class="subtext">Enter your details to register.</p>

        <?php if ($errors): ?>
            <div class="alert error">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="register.php">
            <label for="full_name">Full Name</label>
            <input
                id="full_name"
                name="full_name"
                type="text"
                value="<?php echo htmlspecialchars($fullName); ?>"
                required
            >

            <label for="email">Email</label>
            <input
                id="email"
                name="email"
                type="email"
                value="<?php echo htmlspecialchars($email); ?>"
                required
            >

            <label for="usn">USN</label>
            <input
                id="usn"
                name="usn"
                type="text"
                value="<?php echo htmlspecialchars($usn); ?>"
                required
            >

            <label for="department">Department</label>
            <select id="department" name="department" required>
                <option value="">Select department</option>

                <?php
                $departments = [
                    'Information Science',
                    'Computer Science',
                    'Artificial Intelligence',
                    'Electronics',
                    'Mechanical'
                ];

                foreach ($departments as $item):
                ?>
                    <option
                        value="<?php echo htmlspecialchars($item); ?>"
                        <?php echo $department === $item ? 'selected' : ''; ?>
                    >
                        <?php echo htmlspecialchars($item); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="password">Password</label>
            <input
                id="password"
                name="password"
                type="password"
                minlength="8"
                required
            >

            <label for="confirm_password">Confirm Password</label>
            <input
                id="confirm_password"
                name="confirm_password"
                type="password"
                minlength="8"
                required
            >

            <button class="btn full-width" type="submit">
                Register
            </button>
        </form>

        <p class="form-footer">
            Already registered?
            <a href="login.php">Login here</a>
        </p>
    </section>
</main>

</body>
</html>