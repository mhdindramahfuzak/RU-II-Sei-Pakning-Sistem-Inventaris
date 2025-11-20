<?php 
include 'koneksi.php'; 

if (isset($_POST['simpan'])) {
    $kode = $_POST['kode_alat'];
    $nama = $_POST['nama_alat'];
    $kategori = $_POST['kategori'];
    $kondisi = $_POST['kondisi'];
    $lokasi = $_POST['lokasi'];
    $pj = $_POST['penanggung_jawab'];
    $tgl = $_POST['tanggal_input'];
    
    // Upload Gambar
    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];
    $path = "uploads/";
    
    // Cek folder upload (opsional, untuk keamanan)
    if (!is_dir($path)) { mkdir($path, 0777, true); }

    // Rename agar tidak duplikat
    $nama_baru = rand(1000,9999) . "_" . $gambar;
    
    if(move_uploaded_file($tmp, $path.$nama_baru)){
        $query = "INSERT INTO tbl_alat (kode_alat, nama_alat, gambar, kategori, kondisi, status_alat, lokasi, penanggung_jawab, tanggal_input) 
                  VALUES ('$kode', '$nama', '$nama_baru', '$kategori', '$kondisi', 'Tersedia', '$lokasi', '$pj', '$tgl')";
        
        if (mysqli_query($koneksi, $query)) {
            echo "<script>alert('Berhasil disimpan!'); window.location='index.php';</script>";
        } else {
            echo "Gagal DB: " . mysqli_error($koneksi);
        }
    } else {
        echo "Gagal Upload Gambar";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Alat Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <div class="form-header">
                <h2><i class="fas fa-plus-circle"></i> Tambah Alat Baru</h2>
                <p>Lengkapi formulir di bawah untuk menambahkan alat ke inventaris</p>
            </div>
            
            <div class="form-body">
                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                <i class="fas fa-barcode"></i> Kode Alat <span class="required-mark">*</span>
                            </label>
                            <input type="text" name="kode_alat" class="form-control" placeholder="Contoh: ALT-001" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                <i class="fas fa-box"></i> Nama Alat <span class="required-mark">*</span>
                            </label>
                            <input type="text" name="nama_alat" class="form-control" placeholder="Contoh: Laptop Dell" required>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">
                            <i class="fas fa-image"></i> Foto Alat <span class="required-mark">*</span>
                        </label>
                        <div class="upload-area" onclick="document.getElementById('fileInput').click()">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <h5>Klik atau Drop File Di Sini</h5>
                            <p class="text-muted mb-0">Format: JPG, JPEG, PNG (Max: 2MB)</p>
                        </div>
                        <input type="file" id="fileInput" name="gambar" class="d-none" required accept=".jpg, .jpeg, .png" 
                               onchange="showFileName(this)">
                        <small id="fileName" class="text-success fw-bold mt-2 d-none"></small>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                <i class="fas fa-tags"></i> Kategori <span class="required-mark">*</span>
                            </label>
                            <input type="text" name="kategori" class="form-control" placeholder="Contoh: Elektronik" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                <i class="fas fa-tools"></i> Kondisi <span class="required-mark">*</span>
                            </label>
                            <select name="kondisi" class="form-select" required>
                                <option value="">-- Pilih Kondisi --</option>
                                <option value="Baik">✅ Baik</option>
                                <option value="Rusak Ringan">⚠️ Rusak Ringan</option>
                                <option value="Rusak Berat">❌ Rusak Berat</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                <i class="fas fa-map-marker-alt"></i> Lokasi <span class="required-mark">*</span>
                            </label>
                            <input type="text" name="lokasi" class="form-control" placeholder="Contoh: Ruang IT Lantai 2" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                <i class="fas fa-user-tie"></i> Penanggung Jawab <span class="required-mark">*</span>
                            </label>
                            <input type="text" name="penanggung_jawab" class="form-control" placeholder="Contoh: John Doe" required>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">
                            <i class="fas fa-calendar"></i> Tanggal Input
                        </label>
                        <input type="date" name="tanggal_input" class="form-control" value="<?= date('Y-m-d'); ?>">
                    </div>   
                    <div class="d-grid gap-2 d-md-flex justify-content-md-between mt-4">
                        <a href="index.php" class="btn btn-modern btn-secondary-modern me-md-2">
                            <i class="fas fa-arrow-left"></i> Batal
                        </a>
                        <button type="submit" name="simpan" class="btn btn-modern btn-primary-modern">
                            <i class="fas fa-save"></i> Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        function showFileName(input) {
            const fileName = document.getElementById('fileName');
            if (input.files && input.files[0]) {
                fileName.textContent = '✓ File dipilih: ' + input.files[0].name;
                fileName.classList.remove('d-none');
            }
        }
        
        // Drag & Drop Logic
        const uploadArea = document.querySelector('.upload-area');
        const fileInput = document.getElementById('fileInput');
        
        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.style.borderColor = '#2563eb';
            uploadArea.style.background = '#eff6ff';
        });
        
        uploadArea.addEventListener('dragleave', () => {
            uploadArea.style.borderColor = '#e5e7eb';
            uploadArea.style.background = '#f9fafb';
        });
        
        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            fileInput.files = e.dataTransfer.files;
            showFileName(fileInput);
            uploadArea.style.borderColor = '#e5e7eb';
            uploadArea.style.background = '#f9fafb';
        });
    </script>
</body>
</html>