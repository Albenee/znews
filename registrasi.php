<?php
include "koneksi.php"; // Pastikan file koneksi.php terhubung ke database

// Inisialisasi variabel agar tidak error
$nama = $email = $password = $confirm = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama     = mysqli_real_escape_string($con, $_POST['nama']);
    $email    = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $confirm  = mysqli_real_escape_string($con, $_POST['confirm']);

    if ($password !== $confirm) {
        $error = "Konfirmasi password tidak cocok!";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $cek = mysqli_query($con, "SELECT * FROM users WHERE email='$email'");
        if (mysqli_num_rows($cek) > 0) {
            $error = "Email sudah terdaftar!";
        } else {
            $query = mysqli_query($con, "INSERT INTO users (username, email, password) VALUES ('$nama', '$email', '$hash')");
            if ($query) {
                echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location.href='login.php';</script>";
                exit;
            } else {
                $error = "Registrasi gagal. Coba lagi.";
            }
        }
    }
}
?>
<!-- Mulai dari HTML -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register - News Website</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"/>
  <style>
    body { font-family: "Roboto", sans-serif; }
    .register-container { display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 20px; }
    .card { max-width: 400px; width: 100%; padding: 20px; border-radius: 8px; }
    .card-header { background-color: #0b192c; color: white; text-align: center; }
  </style>
</head>
<body>
  <div class="register-container">
    <div class="card shadow-lg">
      <div class="card-header">
        <h3>Register</h3>
      </div>
      <div class="card-body">
        <form method="POST" action="">
          <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
          <?php endif; ?>

          <div class="mb-3">
            <label for="nama" class="form-label">Full Name</label>
            <input type="text" name="nama" class="form-control" id="nama"
                   value="<?= htmlspecialchars($nama) ?>" required>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" name="email" class="form-control" id="email"
                   value="<?= htmlspecialchars($email) ?>" required>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="password" required>
          </div>

          <div class="mb-3">
            <label for="confirm" class="form-label">Confirm Password</label>
            <input type="password" name="confirm" class="form-control" id="confirm" required>
          </div>

          <div class="d-grid">
            <button type="submit" class="btn btn-primary">Register</button>
          </div>
        </form>

        <div class="text-center mt-3">
          <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
