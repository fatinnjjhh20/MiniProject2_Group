<?php
require_once 'config/database.php';

$message = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashing kata laluan
    $role     = $_POST['role'];

    try {
        // Menggunakan Prepared Statement untuk mengelakkan SQL Injection
        $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $stmt->execute([$username, $password, $role]);
        $message = "<div class='alert alert-success'>Pendaftaran berjaya! Sila <a href='index.php'>Log Masuk</a>.</div>";
    } catch (PDOException $e) {
        $message = "<div class='alert alert-danger'>Ralat: Nama pengguna mungkin telah wujud.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Pendaftaran Pengguna</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 400px;">
        <h3 class="text-center mb-4">Daftar Akaun</h3>
        <?php echo $message; ?>
        <form action="register.php" method="POST" class="p-4 bg-white shadow rounded">
            <div class="mb-3">
                <label class="form-label">Nama Pengguna</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Kata Laluan</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Peranan (Role)</label>
                <select name="role" class="form-control">
                    <option value="Student">Student</option>
                    <option value="Admin">Admin</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Daftar</button>
            <p class="mt-3 text-center"><small>Sudah ada akaun? <a href="index.php">Log Masuk</a></small></p>
        </form>
    </div>
</body>
</html>