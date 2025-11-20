<?php
include 'koneksi.php';

$id_alat = $_GET['id'];
// Ambil info alat
$alat = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM tbl_alat WHERE id_alat='$id_alat'"));

if (isset($_POST['submit_pinjam'])) {
    $nama_peminjam = $_POST['nama_peminjam'];
    $tgl_pinjam = $_POST['tgl_pinjam'];
    $keterangan = $_POST['keterangan'];

    // 1. Simpan ke tabel pinjam
    $insert = "INSERT INTO tbl_pinjam (id_alat, nama_peminjam, tgl_pinjam, status_pinjam, keterangan) 
               VALUES ('$id_alat', '$nama_peminjam', '$tgl_pinjam', 'Dipinjam', '$keterangan')";
    
    // 2. Update status alat jadi 'Dipinjam'
    $update_alat = "UPDATE tbl_alat SET status_alat='Dipinjam' WHERE id_alat='$id_alat'";

    if (mysqli_query($koneksi, $insert) && mysqli_query($koneksi, $update_alat)) {
        echo "<script>alert('Alat berhasil dipinjam!'); window.location='data_pinjam.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Form Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-success text-white">Form Peminjaman</div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <img src="uploads/<?= $alat['gambar']; ?>" width="100" class="rounded">
                            <h5><?= $alat['nama_alat']; ?></h5>
                        </div>

                        <form method="POST">
                            <div class="mb-3">
                                <label>Nama Peminjam</label>
                                <input type="text" name="nama_peminjam" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Tanggal Pinjam</label>
                                <input type="date" name="tgl_pinjam" class="form-control" value="<?= date('Y-m-d'); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label>Keterangan / Keperluan</label>
                                <textarea name="keterangan" class="form-control" rows="3"></textarea>
                            </div>
                            <button type="submit" name="submit_pinjam" class="btn btn-success w-100">Konfirmasi Peminjaman</button>
                            <a href="index.php" class="btn btn-link w-100 text-center mt-2">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>