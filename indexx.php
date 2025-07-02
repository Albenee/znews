<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>News Website</title>
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

    <link rel="stylesheet" href="css/style.css" />
    <!-- Custom CSS -->
  </head>
  <body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
      <div class="container">
        <a class="navbar-brand" href="#">Z News</a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
          aria-controls="navbarNav"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="daftar_berita.php">Berita</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="tentang_kami.php">Tentang Kami</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#footerContact">Kontak</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="login.php">Login</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
      <div class="container">
        <h1>Selamat Datang di Portal Berita Kami</h1>
        <p class="lead">
          Dapatkan berita terbaru dan terpopuler dari berbagai kategori
        </p>
        <a href="#" class="btn btn-primary">Berita Terbaru</a>
      </div>
    </section>

    <!-- Berita Terkini Section -->
<?php include "koneksi.php"; ?>

<section class="container mt-5">
  <h2 class="text-center mb-4">Berita Terkini</h2>
  <div class="row">
    <?php
    $query = mysqli_query($con, "SELECT * FROM berita ORDER BY tanggal DESC LIMIT 6");
    while ($row = mysqli_fetch_array($query)) {
    ?>
      <div class="col-md-4 col-12 d-flex justify-content-center mb-4">
        <div class="card">
          <img src="dfoto/<?php echo $row[1]; ?>" class="card-img-top" alt="News Image">
          <div class="card-body">
            <h5 class="card-title"><?php echo $row[2]; ?></h5>
            <p class="card-text"><?php echo substr($row[3], 0, 100); ?>...</p>
            <a href="detail_berita.php?id=<?php echo $row[0]; ?>" class="btn btn-primary">Baca Selengkapnya</a>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
</section>

    <!-- Footer -->
    <footer class="footer" id="footerContact">
      <div class="container">
        <div
          class="d-flex flex-column flex-md-row justify-content-between align-items-center"
        >
          <!-- Left Side: Copyright and Links -->
          <div class="footer-left text-center text-md-start mb-3 mb-md-0">
            <p>&copy; 2025 Z News- All Rights Reserved</p>
            <p>
              <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a>
            </p>
          </div>

          <!-- Right Side: Contact Information -->
          <div class="footer-right text-center text-md-start">
            <p><strong>Kontak:</strong></p>
            <p>Meltina</p>
            <p><a href="https://wa.me/6282172151933">082172151933</a></p>
            <p><a href="">Meltina@gmail.com</a></p>
          </div>
        </div>
      </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
