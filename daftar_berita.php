<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Daftar Berita - News Website</title>
    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
      rel="stylesheet"
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
    <!-- Container for News List -->
    <div class="container news-list-section">
      <h1 class="text-center mb-5">Daftar Berita</h1>

      <!-- Grid for News Items -->
      <div class="row">
        <?php
include "koneksi.php";

$per_halaman = 6;
$halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$mulai = ($halaman > 1) ? ($halaman * $per_halaman) - $per_halaman : 0;

// Hitung total data
$result = mysqli_query($con, "SELECT COUNT(*) AS total FROM berita");
$total_data = mysqli_fetch_assoc($result)['total'];
$total_halaman = ceil($total_data / $per_halaman);

// Ambil data sesuai halaman
$query = mysqli_query($con, "SELECT * FROM berita ORDER BY tanggal DESC LIMIT $mulai, $per_halaman");

while ($row = mysqli_fetch_array($query)) {
?>
  <div class="col-md-4 news-item">
    <img src="dfoto/<?php echo $row[1]; ?>" alt="News Image 1" />
    <h5><?php echo $row[2]; ?></h5>
    <p><?php echo substr($row[3], 0, 100); ?>...</p>
    <a href="detail_berita.php?id=<?php echo $row[0]; ?>" class="btn btn-primary">Baca Selengkapnya</a>
  </div>
<?php } ?>

      </div>
      <!-- Pagination -->
      <nav aria-label="Page navigation">
  <ul class="pagination justify-content-center">
    <?php if ($halaman > 1) { ?>
      <li class="page-item">
        <a class="page-link" href="?halaman=<?php echo $halaman - 1; ?>">Previous</a>
      </li>
    <?php } else { ?>
      <li class="page-item disabled"><span class="page-link">Previous</span></li>
    <?php } ?>

    <?php for ($i = 1; $i <= $total_halaman; $i++) { ?>
      <li class="page-item <?php if ($halaman == $i) echo 'active'; ?>">
        <a class="page-link" href="?halaman=<?php echo $i; ?>"><?php echo $i; ?></a>
      </li>
    <?php } ?>

    <?php if ($halaman < $total_halaman) { ?>
      <li class="page-item">
        <a class="page-link" href="?halaman=<?php echo $halaman + 1; ?>">Next</a>
      </li>
    <?php } else { ?>
      <li class="page-item disabled"><span class="page-link">Next</span></li>
    <?php } ?>
  </ul>
</nav>
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
