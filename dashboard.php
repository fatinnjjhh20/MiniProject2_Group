<?php
session_start();
// Pastikan pengguna telah log masuk
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Sistem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <!-- Navbar / Menu Navigasi -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">Sistem Tempahan Bilik</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="dashboard.php">Utama</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_rooms.php">Urus Bilik (CRUD)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="logout.php">Log Keluar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Kandungan Dashboard -->
    <div class="container mt-5">
        <div class="p-5 bg-white shadow rounded">
            <h2>Selamat Datang, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
            <p class="lead">Anda log masuk sebagai: <strong><?php echo htmlspecialchars($_SESSION['role']); ?></strong></p>
            <hr>
            <p>Gunakan menu di atas untuk menguruskan modul sistem (CRUD) dan penerokaan data pangkalan data.</p>
            <a href="manage_rooms.php" class="btn btn-primary">Pergi ke Modul Urus Bilik</a>
        </div>
    </div>
</body>
</html>