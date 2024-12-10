<?php
session_start();
require_once '\laragon\www\endproject\connection.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);
ob_start();

function loginUser($email, $password) {
    global $conn;
    
    try {
        // Check acc_log table for credentials using prepared statement
        $query = "SELECT * FROM acc_log WHERE email = :email AND password = :password";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $accLevel = $user['accLevel'];
            
            // Check user type based on email
            switch($accLevel) {
                case 1: $table = "mahasiswa"; break;
                case 2: $table = "dosen"; break;
                case 3: $table = "admin"; break;
                default: return false;
            }
            
            $userQuery = "SELECT * FROM $table WHERE email = :email";
            $stmt = $conn->prepare($userQuery);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                $userData = $stmt->fetch(PDO::FETCH_ASSOC);
                
                $_SESSION['user_id'] = $userData['id'];
                $_SESSION['email'] = $email;
                $_SESSION['acc_level'] = $accLevel;
                $_SESSION['nama_lengkap'] = $userData['nama_lengkap'];
                
                return true;
            }
        }
        return false;
    } catch(PDOException $e) {
        return false;
    }
}

// Add redirect code here
if (isset($_POST['email']) && isset($_POST['password'])) {
    if (loginUser($_POST['email'], $_POST['password'])) {
        header("Location: dashboard.php");
        ob_end_flush();
        exit();
    } else {
        $_SESSION['error'] = "Invalid email or password";
        header("Location: index.php");
        ob_end_flush();
        exit();
    }
}
?>