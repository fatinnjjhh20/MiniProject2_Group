<?php
session_start();
require_once 'config/database.php';

// Pastikan pengguna telah log masuk
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$message = "";

// Proses Tambah Rekod (Create) menggunakan Prepared Statement
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_room'])) {
    $room_name = trim($_POST['room_name']);
    $capacity  = intval($_POST['capacity']);
    $status    = trim($_POST['status']);

    if (!empty($room_name) && $capacity > 0) {
        $stmt = $pdo->prepare("INSERT INTO rooms (room_name, capacity, status) VALUES (?, ?, ?)");
        $stmt->execute([$room_name, $capacity, $status]);
        $message = "<div class='alert alert-success'>Bilik berjaya ditambah!</div>";
    } else {
        $message = "<div class='alert alert-danger'>Sila isi maklumat dengan betul.</div>";
    }
}

// Proses Padam Rekod (Delete) menggunakan Prepared Statement
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $pdo->prepare("DELETE FROM rooms WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: manage_rooms.php");
    exit();
}

// Ambil Senarai Asal Bilik (Read)
$stmt = $pdo->query("SELECT * FROM rooms ORDER BY id DESC");
$rooms = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Urus Bilik - CRUD & AJAX</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <!-- Navbar / Menu Navigasi -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">Sistem Tempahan Bilik</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">Utama</a></li>
                    <li class="nav-item"><a class="nav-link active" href="manage_rooms.php">Urus Bilik</a></li>
                    <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Log Keluar</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Modul Pengurusan Bilik (CRUD & AJAX)</h2>
        <?php echo $message; ?>

        <!-- Borang Tambah Bilik -->
        <div class="card my-4 shadow-sm">
            <div class="card-header bg-primary text-white">Tambah Bilik Baharu</div>
            <div class="card-body">
                <form action="manage_rooms.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nama Bilik</label>
                        <input type="text" name="room_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kapasiti</label>
                        <input type="number" name="capacity" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control">
                            <option value="Tersedia">Tersedia</option>
                            <option value="Diselenggara">Diselenggara</option>
                        </select>
                    </div>
                    <button type="submit" name="add_room" class="btn btn-success">Tambah Rekod</button>
                </form>
            </div>
        </div>

        <!-- Kotak Carian AJAX (Live Search) -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <input type="text" id="searchBox" class="form-control" placeholder="Cari nama bilik secara langsung (AJAX)..." 
                onkeyup="liveSearch()">
            </div>
        </div>

        <!-- Jadual Paparan Data (Read) -->
        <div class="card shadow-sm">
            <div class="card-header bg-secondary text-white">Senarai Bilik Berdaftar</div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Bilik</th>
                            <th>Kapasiti</th>
                            <th>Status</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($rooms) > 0): ?>
                            <?php foreach ($rooms as $row): ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo htmlspecialchars($row['room_name']); ?></td>
                                    <td><?php echo $row['capacity']; ?></td>
                                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                                    <td>
                                        <a href="manage_rooms.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" 
                                        onclick="return confirm('Adakah anda pasti mahu padam?')">Padam</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">Tiada rekod ditemui.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Skrip JavaScript AJAX -->
    <script>
    function liveSearch() {
        let query = document.getElementById('searchBox').value;
        let xhr = new XMLHttpRequest();
        
        xhr.open('GET', 'search_rooms.php?q=' + encodeURIComponent(query), true);
        xhr.onload = function() {
            if (this.status === 200) {
                // Kemaskini isi jadual secara dinamik tanpa muat semula halaman
                document.querySelector('table tbody').innerHTML = this.responseText;
            }
        };
        xhr.send();
    }
    </script>
</body>
</html>