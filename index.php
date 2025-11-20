<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Inventaris - Pertamina RU II</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">
    
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container main-container">
        
        <div class="header-section">
            <div class="row align-items-center">
                <div class="col-md-9">
                    <div class="d-flex align-items-center">
                        <img src="assets/logo.png" alt="Logo Pertamina" class="header-logo">
                        
                        <div>
                            <h1 class="company-title">Kilang Pertamina Internasional</h1>
                            <div class="company-subtitle">RU II Sei Pakning &mdash; Sistem Inventaris</div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 text-end text-white-50">
                    <div class="fw-bold"><i class="fas fa-calendar-alt me-2"></i> <?= date('d F Y'); ?></div>
                    <small>Managed by IT Dept</small>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <?php
            // Query Data Statistik
            $total_alat = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tbl_alat"));
            $tersedia = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tbl_alat WHERE status_alat='Tersedia'"));
            $dipinjam = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tbl_alat WHERE status_alat='Dipinjam'"));
            $rusak = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tbl_alat WHERE kondisi IN ('Rusak Ringan', 'Rusak Berat')"));
            ?>
            <div class="col-md-3 mb-3">
                <div class="stats-card primary">
                    <div class="icon"><i class="fas fa-box"></i></div>
                    <h3><?= $total_alat; ?></h3>
                    <p>Total Alat</p>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stats-card success">
                    <div class="icon"><i class="fas fa-check-circle"></i></div>
                    <h3><?= $tersedia; ?></h3>
                    <p>Tersedia</p>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stats-card warning">
                    <div class="icon"><i class="fas fa-hand-holding"></i></div>
                    <h3><?= $dipinjam; ?></h3>
                    <p>Sedang Dipinjam</p>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stats-card danger">
                    <div class="icon"><i class="fas fa-exclamation-triangle"></i></div>
                    <h3><?= $rusak; ?></h3>
                    <p>Rusak</p>
                </div>
            </div>
        </div>

        <div class="action-buttons d-flex justify-content-between mb-4">
            <a href="tambah.php" class="btn btn-modern btn-primary">
                <i class="fas fa-plus-circle me-2"></i> Tambah Alat Baru
            </a>
            <a href="data_pinjam.php" class="btn btn-modern btn-dark">
                <i class="fas fa-history me-2"></i> Riwayat Peminjaman
            </a>
        </div>

        <div class="table-card">
            <div class="card-header">
                <i class="fas fa-list me-2"></i> Daftar Inventaris Alat
            </div>
            <div class="card-body p-0">
                <table id="tabelAlat" class="table table-hover mb-0 dt-responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 10%">Gambar</th>
                            <th style="width: 25%">Informasi Alat</th>
                            <th style="width: 12%">Kategori</th>
                            <th style="width: 12%">Kondisi</th>
                            <th style="width: 12%">Status</th>
                            <th style="width: 24%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $query = mysqli_query($koneksi, "SELECT * FROM tbl_alat ORDER BY id_alat DESC");
                        while ($data = mysqli_fetch_array($query)) {
                        ?>
                        <tr>
                            <td class="fw-bold"><?= $no++; ?></td>
                            <td>
                                <img src="uploads/<?= $data['gambar']; ?>" class="product-img" alt="Foto Alat">
                            </td>
                            <td>
                                <div class="fw-bold text-dark mb-1"><?= $data['nama_alat']; ?></div>
                                <small class="text-muted">
                                    <i class="fas fa-barcode me-1"></i> <?= $data['kode_alat']; ?>
                                </small>
                            </td>
                            <td><span class="badge bg-secondary"><?= $data['kategori']; ?></span></td>
                            <td>
                                <?php 
                                if($data['kondisi'] == 'Baik') {
                                    echo '<span class="badge-modern bg-success">Baik</span>';
                                } elseif($data['kondisi'] == 'Rusak Ringan') {
                                    echo '<span class="badge-modern bg-warning text-dark">Rusak Ringan</span>';
                                } else {
                                    echo '<span class="badge-modern bg-danger">Rusak Berat</span>';
                                }
                                ?>
                            </td>
                            <td>
                                <?php if($data['status_alat'] == 'Tersedia'): ?>
                                    <span class="badge-modern bg-success">
                                        <i class="fas fa-check me-1"></i> Tersedia
                                    </span>
                                <?php else: ?>
                                    <span class="badge-modern bg-danger">
                                        <i class="fas fa-times me-1"></i> Dipinjam
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($data['status_alat'] == 'Tersedia' && $data['kondisi'] == 'Baik'): ?>
                                    <a href="pinjam.php?id=<?= $data['id_alat']; ?>" class="btn btn-action btn-success" title="Pinjam Alat">
                                        <i class="fas fa-hand-holding"></i>
                                    </a>
                                <?php else: ?>
                                    <button class="btn btn-action btn-secondary" disabled title="Tidak Tersedia">
                                        <i class="fas fa-ban"></i>
                                    </button>
                                <?php endif; ?>
                                
                                <a href="edit.php?id=<?= $data['id_alat']; ?>" class="btn btn-action btn-warning" title="Edit Data">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="hapus.php?id=<?= $data['id_alat']; ?>" class="btn btn-action btn-danger" 
                                   onclick="return confirm('Yakin ingin menghapus alat ini?')" title="Hapus Data">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap5.min.js"></script>
    
    <script>
        $(document).ready(function () {
            // Inisialisasi DataTables dengan fitur Responsive
            $('#tabelAlat').DataTable({
                "language": { "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json" }, // Bahasa Indonesia
                "responsive": true, // Aktifkan Mode Mobile
                "autoWidth": false,
                "pageLength": 10,
                "columnDefs": [
                    { "responsivePriority": 1, "targets": 0 }, // Kolom No selalu muncul
                    { "responsivePriority": 2, "targets": 2 }, // Kolom Nama Alat selalu muncul
                    { "responsivePriority": 3, "targets": -1 } // Kolom Aksi selalu muncul
                ]
            });
        });
    </script>
</body>
</html>