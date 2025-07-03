<?php
session_start();
if (!isset($_SESSION['level']) || $_SESSION['level'] !== 'users') {
  header('Location: login.php');
  exit;
}
include "koneksi.php";

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['id_user'])) {
    $komentar = mysqli_real_escape_string($con, $_POST['komentar']);
    $id_user = $_SESSION['id_user'];
    mysqli_query($con, "INSERT INTO komentar (id_berita, id_user, komentar) VALUES ($id, $id_user, '$komentar')");
}?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>News Website</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="css/style.css" />
    <style>
      body { background: #f6f8fa; }
      .navbar { background: linear-gradient(90deg, #0d47a1 60%, #1976d2 100%); }
      .navbar .navbar-brand { font-weight: bold; font-size: 1.7rem; letter-spacing: 1px; }
      .navbar .form-control { border-radius: 20px; }
      .navbar .btn { border-radius: 20px; }
      .hero { background: linear-gradient(120deg, #1976d2 60%, #42a5f5 100%); color: #fff; padding: 60px 0 40px 0; border-radius: 0 0 32px 32px; box-shadow: 0 4px 24px rgba(33, 150, 243, 0.08); margin-bottom: 2rem; }
      .hero h1 { font-size: 2.5rem; font-weight: 700; }
      .hero .lead { font-size: 1.2rem; }
      .hero .btn-primary { background: #fff; color: #1976d2; border: none; font-weight: 600; border-radius: 24px; padding: 10px 28px; transition: 0.2s; }
      .hero .btn-primary:hover { background: #1976d2; color: #fff; border: 1px solid #fff; }
      .main h2 { color: #1976d2; font-weight: 700; }
      .card { border: none; border-radius: 18px; box-shadow: 0 2px 16px rgba(33, 150, 243, 0.08); transition: transform 0.15s; }
      .card:hover { transform: translateY(-6px) scale(1.03); box-shadow: 0 6px 32px rgba(33, 150, 243, 0.13); }
      .card-img-top { border-radius: 18px 18px 0 0; height: 180px; object-fit: cover; }
      .card-title { font-size: 1.15rem; font-weight: 600; color: #0d47a1; }
      .card-text { color: #444; font-size: 1rem; }
      .btn-primary { background: #1976d2; border: none; border-radius: 20px; font-weight: 600; }
      .btn-primary:hover { background: #0d47a1; }
      .footer { background: #0d47a1; color: #fff; padding: 32px 0 16px 0; margin-top: 3rem; border-radius: 32px 32px 0 0; }
      .footer a { color: #fff; text-decoration: underline; }
      .footer a:hover { color: #90caf9; }
    </style>
  </head>
  <body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
      <div class="container">
        <a class="navbar-brand" href="#">Z News</a>
        <form class="d-flex ms-3" method="get" action="#Berita" id="form-search-berita">
          <input class="form-control me-2" type="search" name="cari" placeholder="Cari berita..." aria-label="Search" style="max-width:160px;">
          <button class="btn btn-outline-light" type="submit"><i class="fas fa-search"></i></button>
        </form>
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
          <ul class="navbar-nav ms-auto align-items-center">
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
            <?php
            if (isset($_SESSION['username'])) {
              include_once "koneksi.php";
              $username = $_SESSION['username'];
              $qUser = mysqli_query($con, "SELECT * FROM users WHERE username = '" . mysqli_real_escape_string($con, $username) . "' LIMIT 1");
              $userData = mysqli_fetch_assoc($qUser);
              $namaTampil = isset($userData['username']) ? $userData['username'] : $username;
              $fotoTampil = isset($userData['foto']) && $userData['foto'] ? 'dfoto/' . $userData['foto'] : 'img/undraw_profile.svg';
            ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="<?php echo htmlspecialchars($fotoTampil); ?>" alt="Avatar" class="rounded-circle me-2" style="width:32px;height:32px;object-fit:cover;">
                <span><?php echo htmlspecialchars($namaTampil); ?></span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <li><a class="dropdown-item bg-danger" href="login.php"><i class="fas fa-sign-out-alt me-2 text-black"></i>Logout</a></li>
              </ul>
            </li>
            <?php } else { ?>
            <li class="nav-item">
              <a class="nav-link" href="login.php">Login</a>
            </li>
            <?php } ?>
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
      <a href="#Berita" class="btn btn-primary" id="btn-berita-terbaru">Berita Terbaru</a>
      </div>
    </section>

    <!-- Berita Terkini Section -->
<?php include "koneksi.php"; ?>
<section id="Berita" class="main container mt-5">
  <h2 class="text-center mb-4">Berita Terkini</h2>
  <div class="row">
    <?php
    $where = '';
    $cari = isset($_GET['cari']) ? mysqli_real_escape_string($con, $_GET['cari']) : '';
    if ($cari != '') {
      $where = "WHERE judul LIKE '%$cari%' OR isi LIKE '%$cari%'";
    }
    $query = mysqli_query($con, "SELECT * FROM berita $where ORDER BY tanggal DESC LIMIT 6");
    if ($cari != '' && mysqli_num_rows($query) == 0) {
      echo '<div class="col-12"><div class="alert alert-warning text-center">Berita tidak ditemukan.</div></div>';
    }
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
    <script>
    // Scroll ke section Berita dengan offset header saat klik tombol Berita Terbaru
    document.addEventListener('DOMContentLoaded', function() {
      var btn = document.getElementById('btn-berita-terbaru');
      if(btn) {
        btn.addEventListener('click', function(e) {
          e.preventDefault();
          var target = document.getElementById('Berita');
          if(target) {
            var y = target.getBoundingClientRect().top + window.pageYOffset - 80; // offset header
            window.scrollTo({top: y, behavior: 'smooth'});
          }
        });
      }
    });
    </script>
  </body>
</html>
