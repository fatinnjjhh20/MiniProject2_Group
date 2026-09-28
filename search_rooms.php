<?php
require_once 'config/database.php';

$query = isset($_GET['q']) ? trim($_GET['q']) : '';

if ($query !== '') {
    $stmt = $pdo->prepare("SELECT * FROM rooms WHERE room_name LIKE ? ORDER BY id DESC");
    $stmt->execute(["%$query%"]);
} else {
    $stmt = $pdo->query("SELECT * FROM rooms ORDER BY id DESC");
}
$rooms = $stmt->fetchAll();

if (count($rooms) > 0) {
    foreach ($rooms as $row) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . htmlspecialchars($row['room_name']) . "</td>";
        echo "<td>" . $row['capacity'] . "</td>";
        echo "<td>" . htmlspecialchars($row['status']) . "</td>";
        echo "<td><a href='manage_rooms.php?delete=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick=\"return confirm('Adakah anda pasti 
        mahu padam?')\">Padam</a></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5' class='text-center'>Tiada rekod ditemui.</td></tr>";
}
?>