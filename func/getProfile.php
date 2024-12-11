<?php
session_start();
require_once '../connection.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'User not logged in']);
    exit();
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

try {
    $query = "";
    switch ($role) {
        case 'admin':
            $query = "SELECT nama_lengkap, jenis_kelamin, no_hp, jurusan, prodi, profesi, email FROM admin WHERE id = ?";
            break;
        case 'dosen':
            $query = "SELECT nama_lengkap, jenis_kelamin, no_hp, jurusan, prodi, profesi, email FROM dosen WHERE id = ?";
            break;
        case 'mahasiswa':
            $query = "SELECT nim, nama_lengkap, jenis_kelamin, no_hp, no_hp_ortu, jurusan, prodi, kelas, email FROM mahasiswa WHERE id = ?";
            break;
    }

    $stmt = $koneksi->prepare($query);
    $stmt->execute([$user_id]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($data) {
        echo json_encode($data);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'User not found']);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>