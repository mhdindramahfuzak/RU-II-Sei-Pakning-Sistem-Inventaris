<?php 
include 'koneksi.php'; 
$id = $_GET['id'];
$data = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM tbl_alat WHERE id_alat='$id'"));

if (isset($_POST['update'])) {
    $kode = $_POST['kode_alat'];
    $nama = $_POST['nama_alat'];
    // ... ambil variabel lain ...
    $kategori = $_POST['kategori']; $kondisi = $_POST['kondisi']; 
    $lokasi = $_POST['lokasi']; $pj = $_POST['penanggung_jawab']; $tgl = $_POST['tanggal_input'];
    
    $gambar_lama = $_POST['gambar_lama'];
    
    // Cek apakah user ganti gambar?
    if ($_FILES['gambar']['name'] != "") {
        $gambar = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];
        $nama_baru = rand(1000,9999) . "_" . $gambar;
        move_uploaded_file($tmp, "uploads/" . $nama_baru);
        $gambar_db = $nama_baru;
    } else {
        $gambar_db = $gambar_lama; // Pakai gambar lama
    }

    $update = "UPDATE tbl_alat SET 
               kode_alat='$kode', nama_alat='$nama', gambar='$gambar_db', kategori='$kategori', 
               kondisi='$kondisi', lokasi='$lokasi', penanggung_jawab='$pj', tanggal_input='$tgl' 
               WHERE id_alat='$id'";
               
    if(mysqli_query($koneksi, $update)) {
        header("Location: index.php");
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-warning">Edit Alat</div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="gambar_lama" value="<?= $data['gambar']; ?>">
                    
                    <div class="mb-3 text-center">
                        <img src="uploads/<?= $data['gambar']; ?>" width="150" class="img-thumbnail mb-2">
                        <br>
                        <label>Ganti Foto (Kosongkan jika tidak ingin mengganti)</label>
                        <input type="file" name="gambar" class="form-control">
                    </div>
                    
                    <div class="mb-3">
                        <label>Kode Alat</label>
                        <input type="text" name="kode_alat" class="form-control" value="<?= $data['kode_alat']; ?>">
                    </div>
                    <div class="mb-3">
                        <label>Nama Alat</label>
                        <input type="text" name="nama_alat" class="form-control" value="<?= $data['nama_alat']; ?>">
                    </div>
                    <div class="mb-3"><input type="text" name="kategori" class="form-control" value="<?= $data['kategori']; ?>"></div>
                    <div class="mb-3">
                         <select name="kondisi" class="form-select">
                            <option value="Baik" <?= ($data['kondisi']=='Baik')?'selected':''; ?>>Baik</option>
                            <option value="Rusak Ringan" <?= ($data['kondisi']=='Rusak Ringan')?'selected':''; ?>>Rusak Ringan</option>
                            <option value="Rusak Berat" <?= ($data['kondisi']=='Rusak Berat')?'selected':''; ?>>Rusak Berat</option>
                        </select>
                    </div>
                    <div class="mb-3"><input type="text" name="lokasi" class="form-control" value="<?= $data['lokasi']; ?>"></div>
                    <div class="mb-3"><input type="text" name="penanggung_jawab" class="form-control" value="<?= $data['penanggung_jawab']; ?>"></div>
                    <div class="mb-3"><input type="date" name="tanggal_input" class="form-control" value="<?= $data['tanggal_input']; ?>"></div>

                    <button type="submit" name="update" class="btn btn-warning">Update</button>
                    <a href="index.php" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>