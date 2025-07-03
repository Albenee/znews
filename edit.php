<?php 
session_start();
if (!isset($_SESSION['level']) || $_SESSION['level'] !== 'admin') {
  header('Location: login.php');
  exit;
}
include "koneksi.php";

$id = $_GET["id"];
$var = $_GET["d"];

$daftar = [
    'users' => ['id', 'username', 'email', 'password', 'level'],
    'berita' => ['id', 'foto', 'judul', 'isi', 'tanggal']
];

if (!array_key_exists($var, $daftar)) {
    die("Tabel tidak valid!");
}

$pilih = $daftar[$var];

// Ambil struktur kolom dari tabel
$struktur = mysqli_query($con, "SHOW COLUMNS FROM $var");
$tipe_kolom = [];
while ($row = mysqli_fetch_assoc($struktur)) {
    $tipe_kolom[$row['Field']] = $row['Type'];
}

// Ambil data berdasarkan ID
$ambil = mysqli_query($con, "SELECT * FROM $var WHERE id = $id") or die(mysqli_error($con));
$data = mysqli_fetch_assoc($ambil);

// Proses update data
if (isset($_POST['simpan'])) {
    $update_parts = [];

    foreach ($pilih as $index => $field) {
        if ($index == 0) continue; // skip id

        // Jika field adalah foto dan ada file baru
        if ($field == 'foto' && isset($_FILES['foto']) && $_FILES['foto']['name']) {
            $filename = $_FILES['foto']['name'];
            $tmpname = $_FILES['foto']['tmp_name'];
            move_uploaded_file($tmpname, "dfoto/$filename");
            $value = $filename;
        } else {
            $value = mysqli_real_escape_string($con, $_POST[$field]);
        }

        $update_parts[] = "$field = '$value'";
    }

    $update_query = "UPDATE $var SET " . implode(", ", $update_parts) . " WHERE {$pilih[0]} = '$id'";
    mysqli_query($con, $update_query) or die(mysqli_error($con));

    echo "<script>alert('Data berhasil diubah')</script>";
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
    foreach ($pilih as $index => $field) {
        if ($index == 0) {
            echo "<input type='hidden' name='$field' value='{$data[$field]}'>";
            continue;
        }

        $label = ucfirst($field);
        $tipe = $tipe_kolom[$field];
        $value = htmlspecialchars($data[$field]);

        if (preg_match('/int|float|double/', $tipe)) {
            $input = "<input type='number' class='form-control' id='$field' name='$field' value='$value'>";
        } elseif (preg_match('/date/', $tipe)) {
            $input = "<input type='date' class='form-control' id='$field' name='$field' value='$value'>";
        } elseif (preg_match('/text/', $tipe)) {
            $input = "<textarea class='form-control' id='$field' name='$field' rows='5'>$value</textarea>";
        } elseif (preg_match('/enum\((.+)\)/', $tipe, $matches)) {
            $options = str_getcsv($matches[1], ',', "'");
            $input = "<select class='form-control' id='$field' name='$field'>";
            foreach ($options as $opt) {
                $selected = ($opt == $value) ? "selected" : "";
                $input .= "<option value='$opt' $selected>$opt</option>";
            }
            $input .= "</select>";
        } elseif ($field === 'password') {
            $input = "<input type='text' class='form-control' id='$field' name='$field' value='$value'>";
        } elseif ($field === 'foto') {
            $input = "<br><img src='dfoto/$value' width='120' class='mb-2'/><br>";
            $input .= "<input type='file' class='form-control' id='$field' name='$field'>";
        } else {
            $input = "<input type='text' class='form-control' id='$field' name='$field' value='$value'>";
        }

        echo "
        <div class='form-group'>
            <label for='$field'>$label</label>
            $input
        </div>";
    }
    ?>
    <input type="submit" class="btn btn-primary" value="Update" name="simpan">
  </form>
</div>

<script src="assets/js/jquery-2.2.3.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>
