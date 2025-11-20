<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $query = "DELETE FROM tbl_alat WHERE id_alat = '$id'";
    
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data Berhasil Dihapus!'); window.location='index.php';</script>";
    } else {
        echo "Gagal hapus: " . mysqli_error($koneksi);
    }
}
?>