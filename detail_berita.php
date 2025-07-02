<?php
include "koneksi.php"; // koneksi ke database

// ambil ID dari URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// cek data
$ambil = mysqli_query($con, "SELECT * FROM berita WHERE id = $id") or die(mysqli_error($con));
$data = mysqli_fetch_assoc($ambil);

// jika data tidak ditemukan
if (!$data) {
  echo "<h2 class='text-center text-danger mt-5'>Berita tidak ditemukan</h2>";
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Detail Berita - News Website</title>
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
  </head>

  <body>
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
              <a class="nav-link" href="indexx.php">Home</a>
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

    <!-- Container for News Detail -->
    <div class="container news-header">
      <div class="row">
        <div class="col-lg-8">
          <!-- Title and Meta Info -->
          <h1 class="news-title">
  <?= $data['judul'] ?>
</h1>
<p class="news-meta">
  <span><i class="fas fa-calendar-alt"></i> <?= date('d F Y', strtotime($data['tanggal'])) ?></span>
  <span><i class="fas fa-user"></i> Penulis: Admin</span>
</p>
<img src="dfoto/<?= $data['foto'] ?>" class="news-image" alt="News Image" />
<div class="news-content">
  <p><?= nl2br($data['isi']) ?></p>
</div>


          <!-- Social Share Buttons -->
          <div class="news-actions">
            <p>Bagikan Berita Ini:</p>
            <a
              href="https://wa.me/6281276106643"
              class="btn btn-success btn-social"
              ><i class="fab fa-whatsapp"></i> WhatsApp</a
            >
            <a href="#" class="btn btn-primary btn-social"
              ><i class="fab fa-facebook"></i> Facebook</a
            >
            <a href="#" class="btn btn-info btn-social"
              ><i class="fab fa-twitter"></i> Twitter</a
            >
          </div>

          <!-- Comment Section -->
          <div class="comment-section">
            <h4>Komentar</h4>
            <form class="comment-form">
              <div class="mb-3">
                <textarea
                  class="form-control"
                  rows="5"
                  placeholder="Write your comment..."
                ></textarea>
              </div>
              <button type="submit" class="btn btn-primary mb-5">Kirim</button>
            </form>
          </div>
        </div>

        <!-- Sidebar: Related News -->
        <div class="col-lg-4">
          <h3 class="related-news-title">Berita Terkait</h3>
<div class="related-news">
<?php
$berita_terkait = mysqli_query($con, "SELECT * FROM berita WHERE id != $id ORDER BY RAND() LIMIT 3");
while ($r = mysqli_fetch_assoc($berita_terkait)) {
?>
  <div class="card mb-3">
    <img src="dfoto/<?= $r['foto'] ?>" class="card-img-top" alt="Related News" />
    <div class="card-body">
      <h5 class="card-title"><?= $r['judul'] ?></h5>
      <a href="detail_berita.php?id=<?= $r['id'] ?>" class="btn btn-primary">Baca Selengkapnya</a>
    </div>
  </div>
<?php } ?>
</div>

        </div>
      </div>
    </div>

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
