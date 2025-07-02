<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - News Website</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">Z News</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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

    <!-- Header Section -->
    <div class="about-header">
        <div class="container">
            <h1>Tentang Kami</h1>
            <p>Mengetahui lebih dalam tentang portal berita kami dan tujuan kami memberikan informasi yang akurat dan relevan.</p>
        </div>
    </div>

    <!-- About Section -->
    <div class="container about-section">
        <div class="row">
            <div class="col-lg-8 mx-auto about-description">
                <h2>Deskripsi Organisasi</h2>
                <p>
                    Kami adalah portal berita yang didedikasikan untuk memberikan informasi terbaru, akurat, dan relevan dari berbagai sektor, mulai dari politik, teknologi, pendidikan, hingga olahraga. Visi kami adalah menjadi sumber berita utama yang terpercaya bagi masyarakat, dengan fokus pada jurnalisme yang objektif dan independen.
                </p>
                <p>
                    Kami berkomitmen untuk menyampaikan berita dengan standar etika jurnalistik yang tinggi, serta memberikan platform untuk diskusi yang terbuka dan inklusif. Setiap berita yang kami sajikan telah melalui proses verifikasi untuk memastikan kebenaran dan relevansi informasi.
                </p>
            </div>
        </div>
    </div>

    <!-- Vision and Mission Section -->
    <div class="container vision-mission">
        <div class="row">
            <div class="col-lg-6">
                <h3>Visi</h3>
                <p>
                    Menjadi portal berita terdepan yang menyediakan informasi terkini, terpercaya, dan berkualitas, untuk mendukung masyarakat yang lebih cerdas dan kritis.
                </p>
            </div>
            <div class="col-lg-6">
                <h3>Misi</h3>
                <ul>
                    <li>Menyajikan berita yang faktual dan berimbang dari sumber terpercaya.</li>
                    <li>Membangun jurnalisme yang objektif, independen, dan bertanggung jawab.</li>
                    <li>Menyediakan platform yang mendukung partisipasi publik melalui opini dan diskusi.</li>
                    <li>Menggunakan teknologi untuk meningkatkan aksesibilitas informasi bagi masyarakat luas.</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Team Section -->
<!-- Team Section -->
<div class="container team-section">
    <h3 class="text-center">Anggota Tim Kami</h3>
    <div class="row text-center">
        <?php
        include "koneksi.php";
        $query = mysqli_query($con, "SELECT * FROM tim ORDER BY id ASC");
        while ($tim = mysqli_fetch_array($query)) {
        ?>
            <div class="col-lg-3 col-md-6 team-member mb-4">
                <img src="dfoto/<?php echo $tim['foto']; ?>" alt="<?php echo $tim['nama']; ?>" class="img-fluid rounded-circle mb-2" style="width:150px; height:150px; object-fit:cover;">
                <h5><?php echo $tim['nama']; ?></h5>
                <p><?php echo $tim['nim']; ?></p>
            </div>
        <?php } ?>
    </div>
</div>


    <footer class="footer" id="footerContact">
        <footer class="footer" id="footerContact">
            <div class="container">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                    <!-- Left Side: Copyright and Links -->
                    <div class="footer-left text-center text-md-start mb-3 mb-md-0">
                        <p>&copy; 2025 Z News- All Rights Reserved</p>
                        <p><a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a></p>
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
