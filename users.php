<?php
session_start();
if (!isset($_SESSION['level']) || $_SESSION['level'] !== 'admin') {
  header('Location: login.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>Dashboard Admin</title>

    <!-- Custom fonts for this template-->
    <link
      href="vendor/fontawesome-free/css/all.min.css"
      rel="stylesheet"
      type="text/css"
    />
    <link
      href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
      rel="stylesheet"
    />

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet" />
  </head>

  <body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
      <!-- Sidebar -->
      <ul
        class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion"
        id="accordionSidebar"
        >
        <!-- Sidebar - Brand -->
        <a
          class="sidebar-brand d-flex align-items-center justify-content-center"
          href="index.php"
        >
          <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
          </div>
          <div class="sidebar-brand-text mx-3">Dashboard Pemilik</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0" />

        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
          <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a
          >
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider" />

        <!-- Heading -->
        <div class="sidebar-heading">Setting</div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
          <a
            class="nav-link collapsed"
            href="#"
            data-toggle="collapse"
            data-target="#collapseTwo"
            aria-expanded="true"
            aria-controls="collapseTwo"
          >
            <i class="fas fa-fw fa-cog"></i>
            <span>Data Website</span>
          </a>
          <div
            id="collapseTwo"
            class="collapse"
            aria-labelledby="headingTwo"
            data-parent="#accordionSidebar"
          >
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Data:</h6>
              <a class="collapse-item" href="users.php">User Login</a>
              <a class="collapse-item" href="berita.php">Berita</a>
              <a class="collapse-item" href="tim.php">Tim</a>
            </div>
          </div>
        </li>

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
          <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
      </ul>
      <!-- End of Sidebar -->

      <!-- Content Wrapper -->
      <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
          <!-- Topbar -->
          <nav
            class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow"
            >
            <!-- Sidebar Toggle (Topbar) -->
            <button
              id="sidebarToggleTop"
              class="btn btn-link d-md-none rounded-circle mr-3"
            >
              <i class="fa fa-bars"></i>
            </button>

            <!-- Topbar Search -->
            <form method="GET"
              class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">  
                <div class="input-group">
                  <input type="text" class="form-control bg-light border-0 small" aria-describedby="basic-addon2" placeholder="Cari user..." name="cari" value="<?php if(isset($_GET['cari'])) echo $_GET['cari']; ?>">

                <div class="input-group-append">
                  <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search fa-sm"></i>
                  </button>
                </div>
              </div>
            </form>

            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">
              <div class="topbar-divider d-none d-sm-block"></div>
              <!-- Nav Item - User Information -->
              <li class="nav-item dropdown no-arrow">
                <?php
                include_once "koneksi.php";
                $username = $_SESSION['username'];
                $qUser = mysqli_query($con, "SELECT * FROM users WHERE username = '" . mysqli_real_escape_string($con, $username) . "' LIMIT 1");
                $userData = mysqli_fetch_assoc($qUser);
                $namaTampil = isset($userData['username']) ? $userData['username'] : $username;
                $fotoTampil = isset($userData['foto']) && $userData['foto'] ? 'dfoto/' . $userData['foto'] : 'img/undraw_profile.svg';
                ?>
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    <?= htmlspecialchars($namaTampil) ?>
                  </span>
                  <img class="img-profile rounded-circle" src="<?= htmlspecialchars($fotoTampil) ?>" alt="Profile Picture" />
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                  <a class="dropdown-item" href="logout.php">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                  </a>
                </div>
              </li>
            </ul>
          </nav>
          <!-- End of Topbar -->

          <!-- Begin Page Content -->
          <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Tables Data User Login</h1>
                    <p class="mb-4">
                        Data ini digunakan untuk mengelola user yang dapat login ke dalam website ini.
                        Anda dapat menambah, mengedit, atau menghapus data user sesuai kebutuhan.
                    </p>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
<div class="card-body">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h6 class="m-0 font-weight-bold text-primary">Data User</h6>
    <a href="tambah.php?d=users" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> Tambah User</a>
  </div>
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle" id="dataTable" width="100%" cellspacing="0">
        <?php
include "koneksi.php";
$halaman = 5;
$page = isset($_GET["halaman"]) ? (int)$_GET["halaman"] : 1;
$mulai = ($page > 1) ? ($page * $halaman) - $halaman : 0;
$cari = isset($_GET['cari']) ? mysqli_real_escape_string($con, $_GET['cari']) : '';

if ($cari != '') {
    $result = mysqli_query($con, "SELECT * FROM users WHERE username LIKE '%$cari%' OR email LIKE '%$cari%'");
} else {
    $result = mysqli_query($con, "SELECT * FROM users");
}

$total = mysqli_num_rows($result);
$pages = ceil($total / $halaman);

if ($cari != '') {
    $query = mysqli_query($con, "SELECT * FROM users WHERE username LIKE '%$cari%' OR email LIKE '%$cari%' LIMIT $mulai, $halaman") or die(mysqli_error($con));
} else {
    $query = mysqli_query($con, "SELECT * FROM users LIMIT $mulai, $halaman") or die(mysqli_error($con));
}

$no = $mulai + 1;
?>
<thead class="table-primary">
    <tr>
        <th class="text-center">NO</th>
        <th>NAMA</th>
        <th>EMAIL</th>
        <th>PASSWORD</th>
        <th>LEVEL</th>
        <th class="text-center">AKSI</th>
    </tr>
</thead>
<tbody>
<?php while ($d = mysqli_fetch_array($query)) { ?>
<tr>
    <td class="text-center align-middle"><?= $no++ ?></td>
    <td class="align-middle"><i class="fas fa-user text-secondary"></i> <?= htmlspecialchars($d['username']) ?></td>
    <td class="align-middle"><a href="mailto:<?= htmlspecialchars($d['email']) ?>"><i class="fas fa-envelope text-info"></i> <?= htmlspecialchars($d['email']) ?></a></td>
    <td class="align-middle"><span class="badge bg-secondary" style="font-size:12px;">hash</span></td>
    <td class="align-middle"><span class="badge bg-primary text-uppercase text-white"><?= htmlspecialchars($d['level']) ?></span></td>
    <td class="text-center align-middle">
        <a href="edit.php?id=<?= $d['id'] ?>&d=users" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
        <a href="hapus.php?id=<?= $d['id'] ?>&d=users" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')"><i class="fas fa-trash"></i> Hapus</a>
    </td>
</tr>
<?php } ?>
</tbody>
                                  
                                </table>
                                <!-- Pagination -->
<nav aria-label="Page navigation">
  <ul class="pagination justify-content-center">
    <?php if ($page > 1) { ?>
      <li class="page-item">
        <a class="page-link" href="?halaman=<?= $page - 1 ?>&cari=<?= $cari ?>">Previous</a>
      </li>
    <?php } else { ?>
      <li class="page-item disabled"><span class="page-link">Previous</span></li>
    <?php } ?>

    <?php for ($i = 1; $i <= $pages; $i++) { ?>
      <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
        <a class="page-link" href="?halaman=<?= $i ?>&cari=<?= $cari ?>"><?= $i ?></a>
      </li>
    <?php } ?>

    <?php if ($page < $pages) { ?>
      <li class="page-item">
        <a class="page-link" href="?halaman=<?= $page + 1 ?>&cari=<?= $cari ?>">Next</a>
      </li>
    <?php } else { ?>
      <li class="page-item disabled"><span class="page-link">Next</span></li>
    <?php } ?>
  </ul>
</nav>

                            </div>
                        </div>
                    </div>

                </div>
          <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
          <div class="container my-auto">
            <div class="copyright text-center my-auto">
              <span>Copyright &copy; Your Website 2025</span>
            </div>
          </div>
        </footer>
        <!-- End of Footer -->
      </div>
      <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout langsung ke logout.php agar session benar-benar dihapus dan harus login ulang -->

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
  </body>
</html>
