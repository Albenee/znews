<?php
include "koneksi.php";

$id = $_GET['id'];
$d = $_GET['d'];

$daftar_foto = [
    'berita' => 'foto',
    // Tambah tabel lain jika ada kolom foto
];

// Ambil nama file foto jika ada
if (array_key_exists($d, $daftar_foto)) {
    $foto_field = $daftar_foto[$d];

    $ambil = mysqli_query($con, "SELECT $foto_field FROM $d WHERE id = '$id'") or die(mysqli_error($con));
    $data = mysqli_fetch_assoc($ambil);

    if ($data && !empty($data[$foto_field])) {
        $foto_path = "dfoto/" . $data[$foto_field];
        if (file_exists($foto_path)) {
            unlink($foto_path); // Hapus file foto dari folder
        }
    }
}

// Hapus data dari database
$hapus = mysqli_query($con, "DELETE FROM $d WHERE id='$id'");

if ($hapus) {
    echo "<script>alert('Data berhasil dihapus')</script>";
    echo "<meta http-equiv=refresh content=1;URL='{$d}.php'>";
} else {
    echo "Data gagal dihapus. Silakan coba lagi.";
    echo "<meta http-equiv=refresh content=1;URL='{$d}.php'>";
}
?>
