<?php 
session_start();
if (!isset($_SESSION['level']) || $_SESSION['level'] !== 'admin') {
  header('Location: login.php');
  exit;
}
include "koneksi.php";

$var = $_GET["d"];

$daftar = [
    'users' => ['username', 'email', 'password', 'level'],
    'berita' => ['foto', 'judul', 'isi', 'tanggal'],
    'tim' => ['foto', 'nama', 'nim']
];

if (!array_key_exists($var, $daftar)) {
    die("Tabel tidak valid!");
}

$pilih = $daftar[$var];

// Ambil struktur kolom
$struktur = mysqli_query($con, "SHOW COLUMNS FROM $var");
$tipe_kolom = [];
while ($row = mysqli_fetch_assoc($struktur)) {
    $tipe_kolom[$row['Field']] = $row['Type'];
}

if (isset($_POST['simpan'])) {
    $fields = [];
    $values = [];

    foreach ($pilih as $field) {
        // Jika kolom adalah foto
        if ($field === 'foto' && isset($_FILES['foto']['name']) && $_FILES['foto']['name'] != "") {
            $nama_file = $_FILES['foto']['name'];
            $tmp_name = $_FILES['foto']['tmp_name'];
            $lokasi = "dfoto/" . basename($nama_file);
            move_uploaded_file($tmp_name, $lokasi);
            $fields[] = $field;
            $values[] = "'$nama_file'";
        } elseif ($field === 'password') {
            $raw = $_POST[$field];
            $hash = password_hash($raw, PASSWORD_DEFAULT);
            $fields[] = $field;
            $values[] = "'" . mysqli_real_escape_string($con, $hash) . "'";
        } else {
            $value = mysqli_real_escape_string($con, $_POST[$field]);
            $fields[] = $field;
            $values[] = "'$value'";
        }
    }

    $insert_query = "INSERT INTO $var (" . implode(",", $fields) . ") VALUES (" . implode(",", $values) . ")";
    mysqli_query($con, $insert_query) or die(mysqli_error($con));

    echo "<script>alert('Data berhasil ditambahkan')</script>";
    echo "<meta http-equiv=refresh content=0;URL='{$var}.php'>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Edit Data</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>

<div class="container">
  <h2>Form Edit Data <?= ucfirst($var) ?></h2>
  <hr>
  <form enctype="multipart/form-data" method="POST">
   <?php 
    foreach ($pilih as $field) {
        $label = ucfirst($field);
        $tipe = $tipe_kolom[$field];

        $input = "<input type='text' class='form-control' id='$field' name='$field' placeholder='Masukkan $label'>";

        if (preg_match('/int|float|double/', $tipe)) {
            $input = "<input type='number' class='form-control' id='$field' name='$field' placeholder='Masukkan $label'>";
        } elseif (preg_match('/date/', $tipe)) {
            $input = "<input type='date' class='form-control' id='$field' name='$field'>";
        } elseif (preg_match('/text/', $tipe)) {
            $input = "<textarea class='form-control' id='$field' name='$field' placeholder='Masukkan $label'></textarea>";
        } elseif (preg_match('/enum\((.+)\)/', $tipe, $matches)) {
            $options = str_getcsv($matches[1], ',', "'");
            $input = "<select class='form-control' id='$field' name='$field'>";
            foreach ($options as $opt) {
                $input .= "<option value='$opt'>$opt</option>";
            }
            $input .= "</select>";
        } elseif ($field === 'password') {
            $input = "<input type='password' class='form-control' id='$field' name='$field' placeholder='Masukkan $label'>";
        } elseif ($field === 'foto') {
            $input = "<input type='file' class='form-control' id='$field' name='$field'>";
        }

        echo "
        <div class='form-group'>
            <label for='$field'>$label</label>
            $input
        </div>
        ";
    }
    ?>
    <input type="submit" class="btn btn-primary" value="Tambah" name="simpan">
  </form>
</div>

<script src="assets/js/jquery-2.2.3.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>
