<?php
session_start();
if (!isset($_SESSION['level']) || $_SESSION['level'] !== 'users') {
  header('Location: login.php');
  exit;
}
include "koneksi.php";
?>
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
      .news-title { color: #0d47a1; font-weight: 700; }
      .news-content { color: #333; font-size: 1.08rem; }
      .card, .bg-white.rounded.shadow-sm { border: none; border-radius: 18px; box-shadow: 0 2px 16px rgba(33, 150, 243, 0.08); }
      .card-img-top, .img-fluid.rounded.mb-3.shadow-sm { border-radius: 18px 18px 0 0; height: 180px; object-fit: cover; }
      .card-title { font-size: 1.15rem; font-weight: 600; color: #0d47a1; }
      .btn-primary { background: #1976d2; border: none; border-radius: 20px; font-weight: 600; }
      .btn-primary:hover { background: #0d47a1; }
      .footer { background: #0d47a1; color: #fff; padding: 32px 0 16px 0; margin-top: 3rem; border-radius: 32px 32px 0 0; }
      .footer a { color: #fff; text-decoration: underline; }
      .footer a:hover { color: #90caf9; }
      .comment-list .d-flex { background: #f8fafc; border-radius: 12px; padding: 1rem; margin-bottom: 1rem; box-shadow: 0 1px 6px rgba(33,150,243,0.04); }
      .comment-list .fw-bold { color: #1976d2; }
      .related-news-title { color: #1976d2; font-weight: 700; }
      .related-news .card { border-radius: 14px; }
    </style>
  </head>

  <body>
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
      <div class="container">
        <a class="navbar-brand" href="indexx.php">Z News</a>
        <!-- Search form start -->
        <form class="d-flex ms-3 rounded shadow-sm bg-white px-2 py-1" id="form-search-berita" style="max-width:320px;min-width:200px;" autocomplete="off" onsubmit="return false;">
          <input class="form-control me-2 border-0" type="search" name="cari" id="input-cari" placeholder="Cari berita..." aria-label="Search" style="max-width:160px; background:transparent;">
          <button class="btn btn-primary px-3" type="submit"><i class="fas fa-search"></i></button>
        </form>
        <!-- Search form end -->
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
                <li><a class="dropdown-item bg-danger text-white fw-bold" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
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

    <!-- Container for News Detail / Search Result -->

      <div class="row">
        <div class="col-lg-8 mb-4">
          <!-- Title and Meta Info -->
          <div class="p-4 bg-white rounded shadow-sm mb-4">
            <h1 class="news-title mb-2" style="font-size:2.1rem;font-weight:700;line-height:1.2; color:#2c3e50;">
              <?= htmlspecialchars($data['judul']) ?>
            </h1>
            <div class="d-flex align-items-center mb-3" style="font-size:0.97rem; color:#888;">
              <span class="me-3"><i class="fas fa-calendar-alt me-1"></i> <?= date('d F Y', strtotime($data['tanggal'])) ?></span>
              <span><i class="fas fa-user me-1"></i> Penulis: Admin</span>
            </div>
            <img src="dfoto/<?= htmlspecialchars($data['foto']) ?>" class="img-fluid rounded mb-3 shadow-sm" alt="News Image" style="max-height:350px;object-fit:cover;width:100%;">
            <div class="news-content mb-3" style="font-size:1.08rem; color:#333;">
              <p><?= nl2br(htmlspecialchars($data['isi'])) ?></p>
            </div>
            <!-- Social Share Buttons -->
            <div class="news-actions mb-3">
              <span class="me-2">Bagikan:</span>
              <a href="https://wa.me/6281276106643" class="btn btn-success btn-sm rounded-circle me-1" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
              <a href="#" class="btn btn-primary btn-sm rounded-circle me-1" title="Facebook"><i class="fab fa-facebook"></i></a>
              <a href="#" class="btn btn-info btn-sm rounded-circle" title="Twitter"><i class="fab fa-twitter"></i></a>
            </div>
          </div>
          <!-- Comment Section -->
          <div class="p-4 bg-white rounded shadow-sm mb-4">
            <h4 class="mb-3" style="font-weight:600;">Komentar</h4>
            <?php
            // Proses simpan komentar
            if (
              $_SERVER['REQUEST_METHOD'] === 'POST' &&
              isset($_POST['isi_komentar']) &&
              isset($_SESSION['username']) &&
              trim($_POST['isi_komentar']) !== ''
            ) {
              $isi_komentar = mysqli_real_escape_string($con, trim($_POST['isi_komentar']));
              $nama = mysqli_real_escape_string($con, $_SESSION['username']);
              // Simpan ke tabel komen (id_berita, nama, isi, tanggal)
              mysqli_query($con, "INSERT INTO komen (nama, isi, tanggal) VALUES ('$nama', '$isi_komentar', NOW())");
              echo '<div class="alert alert-success">Komentar berhasil dikirim.</div>';
            }
            ?>
            <form class="comment-form" method="post" action="">
              <div class="mb-3">
                <textarea class="form-control" name="isi_komentar" rows="4" placeholder="Tulis komentar Anda..." required></textarea>
              </div>
              <button type="submit" class="btn btn-primary mb-2">Kirim</button>
            </form>
            <hr />
            <div class="daftar-komentar mt-3">
              <h5 class="mb-3" style="font-size:1.1rem;font-weight:500;">Komentar Pengunjung</h5>
              <?php
              $qKomentar = mysqli_query($con, "SELECT * FROM komen ORDER BY tanggal DESC");
              if (mysqli_num_rows($qKomentar) > 0) {
                while ($km = mysqli_fetch_assoc($qKomentar)) {
              ?>
                <div class="d-flex mb-3 align-items-start">
                  <img src="img/undraw_profile.svg" class="rounded-circle me-2" style="width:40px;height:40px;object-fit:cover;" alt="User">
                  <div class="flex-grow-1">
                    <div class="fw-bold" style="font-size:1rem; color:#2c3e50;"> <?= htmlspecialchars($km['nama']) ?> </div>
                    <div style="font-size:0.95rem; color:#555;"> <?= nl2br(htmlspecialchars($km['isi'])) ?> </div>
                    <div style="font-size:0.85rem; color:#aaa;"> <?= date('d M Y H:i', strtotime($km['tanggal'])) ?> </div>
                  </div>
                </div>
              <?php }
              } else {
                echo '<div class="text-muted">Belum ada komentar.</div>';
              }
              ?>
            </div>
          </div>
        </div>

        <!-- Sidebar: Related News -->
        <div class="col-lg-4">
          <div class="p-4 bg-white rounded shadow-sm mb-4">
            <h3 class="related-news-title mb-3" id="sidebar-title" style="font-size:1.2rem;font-weight:600;">Berita Terkait</h3>
            <div class="related-news" id="sidebar-related-news">
            <?php
              $cari = isset($_GET['cari']) ? trim($_GET['cari']) : '';
              if ($cari !== '') {
                $cari_esc = mysqli_real_escape_string($con, $cari);
                $berita_terkait = mysqli_query($con, "SELECT * FROM berita WHERE (judul LIKE '%$cari_esc%' OR isi LIKE '%$cari_esc%') AND id != $id ORDER BY tanggal DESC LIMIT 5");
              } else {
                $berita_terkait = mysqli_query($con, "SELECT * FROM berita WHERE id != $id ORDER BY RAND() LIMIT 3");
              }
              if (mysqli_num_rows($berita_terkait) > 0) {
                while ($r = mysqli_fetch_assoc($berita_terkait)) {
            ?>
              <div class="card mb-3 border-0 shadow-sm">
                <img src="dfoto/<?= htmlspecialchars($r['foto']) ?>" class="card-img-top" alt="Related News" style="height:120px;object-fit:cover;">
                <div class="card-body p-2">
                  <h5 class="card-title mb-2" style="font-size:1rem;line-height:1.2; color:#2c3e50;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;"> <?= htmlspecialchars($r['judul']) ?> </h5>
                  <a href="detail_berita.php?id=<?= $r['id'] ?>" class="btn btn-outline-primary btn-sm w-100">Baca Selengkapnya</a>
                </div>
              </div>
            <?php }
              } else {
                echo '<div class="alert alert-warning text-center">Tidak ada berita ditemukan.</div>';
              }
            ?>
            </div>
          </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
      const form = document.getElementById('form-search-berita');
      const input = document.getElementById('input-cari');
      const sidebar = document.getElementById('sidebar-related-news');
      const sidebarTitle = document.getElementById('sidebar-title');
      form.addEventListener('submit', function(e) {
        e.preventDefault();
        const keyword = input.value.trim();
        if (keyword === '') {
          sidebarTitle.textContent = 'Berita Terkait';
          window.location.href = 'detail_berita.php?id=<?=$id?>';
          return;
        }
        sidebarTitle.textContent = 'Hasil Pencarian';
        window.location.href = 'detail_berita.php?id=<?=$id?>&cari=' + encodeURIComponent(keyword);
      });
    });
    </script>

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
