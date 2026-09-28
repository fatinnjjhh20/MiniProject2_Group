<?php
session_start();
require_once 'config/database.php';

$error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Tetapkan data sesi
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Nama pengguna atau kata laluan tidak sah.";
    }
}
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Log Masuk Sistem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 400px;">
        <h3 class="text-center mb-4">Log Masuk Sistem</h3>
        <?php if(!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <form action="index.php" method="POST" class="p-4 bg-white shadow rounded">
            <div class="mb-3">
                <label class="form-label">Nama Pengguna</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Kata Laluan</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Log Masuk</button>
            <p class="mt-3 text-center"><small>Belum ada akaun? <a href="register.php">Daftar di sini</a></small></p>
        </form>
    </div>
</body>
</html>