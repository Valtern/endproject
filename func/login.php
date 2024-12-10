<?php
session_start();
require_once 'connection.php';

function loginUser($email, $password) {
    global $conn;
    
    // Sanitize inputs
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);
    
    // Check credentials in acc_log
    $query = "SELECT * FROM acc_log WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['email'] = $email;
        $_SESSION['accLevel'] = $user['accLevel'];
        
        // Get user details based on accLevel
        switch ($user['accLevel']) {
            case 1: // Admin
                $details = mysqli_query($conn, "SELECT * FROM admin WHERE email = '$email'");
                $redirect = 'admin/dashboard.php';
                break;
            case 2: // Dosen
                $details = mysqli_query($conn, "SELECT * FROM dosen WHERE email = '$email'");
                $redirect = 'dosen/dashboard.php';
                break;
            case 3: // Mahasiswa
                $details = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE email = '$email'");
                $redirect = 'mahasiswa/dashboard.php';
                break;
            default:
                return ['status' => 'error', 'message' => 'Invalid account level'];
        }
        
        if ($details && mysqli_num_rows($details) > 0) {
            $userDetails = mysqli_fetch_assoc($details);
            $_SESSION['user_id'] = $userDetails['id'];
            $_SESSION['nama_lengkap'] = $userDetails['nama_lengkap'];
            
            return ['status' => 'success', 'redirect' => $redirect];
        }
    }
    
    return ['status' => 'error', 'message' => 'Invalid email or password'];
}

// Handle login request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    $result = loginUser($email, $password);
    
    if ($result['status'] === 'success') {
        header("Location: ../" . $result['redirect']);
        exit();
    } else {
        header("Location: ../index.php?error=" . urlencode($result['message']));
        exit();
    }
}
?>