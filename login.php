<?php
session_start();
include "koneksi.php";

if (isset($_POST['login'])) {
  $email = mysqli_real_escape_string($con, $_POST['email']);
  $password = mysqli_real_escape_string($con, $_POST['password']);

  $query = mysqli_query($con, "SELECT * FROM users WHERE email='$email' AND password='$password'");
  $data = mysqli_fetch_assoc($query);
  // proses login...
  $_SESSION['login_success'] = true;

  if ($data['level'] == 'admin') {
    header("Location: index.php");
    exit;
  } else {
    header("Location: indexx.php");
    exit;
  }


  if ($data) {
    $_SESSION['id'] = $data['id'];
    $_SESSION['username'] = $data['username'];
    $_SESSION['level'] = $data['level'];
echo "<script>console.log('Login berhasil dengan level: {$data['level']}');</script>";

    if ($data['level'] == 'admin') {
      header("Location:index.php");
      exit;
    } elseif ($data['level'] == 'users') {
      header("Location:indexx.php");
      exit;
    }
  } else {
    echo "<script>alert('Login gagal! Email atau password salah.');</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - News Website</title>
    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <!-- Font Awesome for icons -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />

    <style>
      body {
        font-family: "Roboto", sans-serif;
      }

      /* Flexbox untuk memusatkan form */
      .login-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh; /* Menjaga agar form login berada di tengah secara vertikal */
        padding: 20px; /* Jaga jarak jika layar kecil */
        position: relative;
      }

      /* Batasi tinggi form agar tidak terlalu panjang */
      .card {
        max-width: 400px;
        width: 100%;
        padding: 20px;
        border-radius: 8px;
      }

      /* Sesuaikan tampilan tombol login */
      .btn-social {
        width: 100%;
        margin-bottom: 10px;
      }

      .btn-social i {
        margin-right: 8px;
      }

      .card-header {
        background-color: #0b192c;
        color: white;
        text-align: center;
      }
    </style>
  </head>

  <body>
    <div class="login-container">
      <div class="card shadow-lg">
        <div class="card-header">
          <h3>Login</h3>
        </div>
        <div class="card-body">
<form method="POST" action="">
  <div class="mb-3">
    <label for="email" class="form-label">Email address</label>
    <input
      type="email"
      class="form-control"
      id="email"
      name="email"
      required
      placeholder="Enter your email"
    />
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input
      type="password"
      class="form-control"
      id="password"
      name="password"
      required
      placeholder="Enter your password"
    />
  </div>
  <div class="d-grid">
    <button type="submit" class="btn btn-primary" name="login">Login</button>
  </div>
</form>

          <div class="text-center mt-3">
            <a href="#">Forgot password?</a>
          </div>
          <hr />
          <div class="text-center">
            <p>Login with Social Media</p>
            <a href="#" class="btn btn-danger btn-social"
              ><i class="fab fa-google"></i>Login with Google</a
            >
            <a href="#" class="btn btn-primary btn-social"
              ><i class="fab fa-facebook-f"></i>Login with Facebook</a
            >
          </div>
          <div class="text-center mt-3">
            <p>Don't have an account? <a href="registrasi.php">Sign up</a></p>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
