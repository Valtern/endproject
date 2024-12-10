<?php
require_once 'func/login.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    if (loginUser($email, $password)) {
        // Redirect based on account level
        switch($_SESSION['acc_level']) {
            case 1:
                header("Location: mahasiswa/dashboard.php");
                break;
            case 2:
                header("Location: dosen/dashboard.php");
                break;
            case 3:
                header("Location: admin/dashboard.php");
                break;
        }
        exit();
    } else {
        $error = "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-sm navbar-secondary bg-secondary sticky-top py-0 mb-3">
        <nav class="nav navbar-nav">
            <a class="navbar-brand ms-4" href="index.php"><img src="img/brand1.png" class="" style="width: 182px; height: 29px;" alt=""></a>
        </nav>
        <a class="navbar-brand" href="#"><img src="" alt=""></a>
    </nav>

    <div class="ms-5">
        <h2><span class="badge badge-rounded-top bg-info badge-lg">Mahasiswa</span></h2>
    </div>

    <div class="d-block justify-content-center mt-5">
        <h2 class="text-center my-0"><strong>Welcome!</strong></h2>
        <h3 class="text-center">Masukkan detail akun anda!</h3>
    </div>

    <div class="d-flex justify-content-center">
      <div class="card" style="width: 600px;">
        <img class="card-img-top mx-auto d-block mt-4" src="img/brand1.png" style="width: 44%; height: 30%;" alt="Title" />
        <div class="card-body">
        <form method="POST" action="">
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input
            type="email"
            class="form-control"
            name="email"
            id="email"
            aria-describedby="emailHelpId"
            placeholder="username or email"
            required
        />
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input
            type="password"
            class="form-control"
            name="password"
            id="password"
            placeholder="password"
            required
        />
    </div>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <div class="form-check mb-3">
        <label class="form-check-label">
            <input type="checkbox" class="form-check-input" name="remember"> Remember me
        </label>
    </div>
    <button
        type="submit"
        class="btn btn-primary mx-auto d-block"
        >Masuk</button>
</form>
        </div>
      </div>
    </div>
        
</body>
</html>