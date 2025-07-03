<?php
session_start();
if (!isset($_SESSION['level']) || $_SESSION['level'] !== 'users') {
  header('Location: login.php');
  exit;
}
include "koneksi.php";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Daftar Berita - News Website</title>
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
      .news-list-section h1 { color: #1976d2; font-weight: 700; }
      .news-item { display: flex; flex-direction: column; align-items: center; margin-bottom: 2rem; }
      .news-item img { border-radius: 18px 18px 0 0; height: 180px; object-fit: cover; width: 100%; box-shadow: 0 2px 16px rgba(33, 150, 243, 0.08); }
      .news-item h5 { font-size: 1.15rem; font-weight: 600; color: #0d47a1; margin-top: 1rem; }
      .news-item p { color: #444; font-size: 1rem; margin-bottom: 0.7rem; }
      .news-item .btn-primary { background: #1976d2; border: none; border-radius: 20px; font-weight: 600; }
      .news-item .btn-primary:hover { background: #0d47a1; }
      .pagination .page-link { border-radius: 12px; margin: 0 2px; color: #1976d2; font-weight: 600; }
      .pagination .page-item.active .page-link { background: #1976d2; color: #fff; border: none; }
      .footer { background: #0d47a1; color: #fff; padding: 32px 0 16px 0; margin-top: 3rem; border-radius: 32px 32px 0 0; }
      .footer a { color: #fff; text-decoration: underline; }
      .footer a:hover { color: #90caf9; }
    </style>
  </head>

  <body>
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
      <div class="container">
        <a class="navbar-brand" href="indexx.php">Z News</a>
        <!-- Search form start -->
        <form class="d-flex ms-3" method="get" action="#Berita" id="form-search-berita">
          <input class="form-control me-2" type="search" name="cari" placeholder="Cari berita..." aria-label="Search" style="max-width:160px;">
          <button class="btn btn-outline-light" type="submit"><i class="fas fa-search"></i></button>
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


$where = '';
$cari = isset($_GET['cari']) ? mysqli_real_escape_string($con, $_GET['cari']) : '';
if ($cari != '') {
  $where = "WHERE judul LIKE '%$cari%' OR isi LIKE '%$cari%'";
}
// Hitung total data
$result = mysqli_query($con, "SELECT COUNT(*) AS total FROM berita $where");
$total_data = mysqli_fetch_assoc($result)['total'];
$total_halaman = ceil($total_data / $per_halaman);

// Ambil data sesuai halaman & pencarian
$query = mysqli_query($con, "SELECT * FROM berita $where ORDER BY tanggal DESC LIMIT $mulai, $per_halaman");

if ($cari != '' && mysqli_num_rows($query) == 0) {
  echo '<div class="col-12"><div class="alert alert-warning text-center">Berita tidak ditemukan.</div></div>';
}
while ($row = mysqli_fetch_array($query)) {
?>
  <div class="col-md-4 col-12 d-flex justify-content-center mb-4">
    <div class="card" style="width:100%; max-width: 370px; border-radius:18px; box-shadow: 0 2px 16px rgba(33,150,243,0.08);">
      <img src="dfoto/<?php echo $row[1]; ?>" class="card-img-top" alt="News Image" style="border-radius:18px 18px 0 0; height:180px; object-fit:cover;">
      <div class="card-body">
        <h5 class="card-title"><?php echo $row[2]; ?></h5>
        <p class="card-text"><?php echo substr($row[3], 0, 100); ?>...</p>
        <a href="detail_berita.php?id=<?php echo $row[0]; ?>" class="btn btn-primary">Baca Selengkapnya</a>
      </div>
    </div>
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
