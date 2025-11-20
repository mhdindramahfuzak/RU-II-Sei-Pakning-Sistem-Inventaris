<?php
include 'koneksi.php';

if (isset($_GET['id_pinjam']) && isset($_GET['id_alat'])) {
    $id_pinjam = $_GET['id_pinjam'];
    $id_alat = $_GET['id_alat'];
    $tgl_kembali = date('Y-m-d');

    // 1. Update tabel pinjam (set tgl_kembali dan status)
    $query_pinjam = "UPDATE tbl_pinjam SET tgl_kembali='$tgl_kembali', status_pinjam='Kembali' WHERE id_pinjam='$id_pinjam'";
    
    // 2. Update tabel alat (set status jadi Tersedia lagi)
    $query_alat = "UPDATE tbl_alat SET status_alat='Tersedia' WHERE id_alat='$id_alat'";

    if (mysqli_query($koneksi, $query_pinjam) && mysqli_query($koneksi, $query_alat)) {
        echo "<script>alert('Alat berhasil dikembalikan!'); window.location='data_pinjam.php';</script>";
    } else {
        echo "Gagal: " . mysqli_error($koneksi);
    }
}
?>