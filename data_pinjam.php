<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman - Pertamina RU II</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">
    
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container main-container">
        
        <div class="header-section d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <img src="assets/logo.png" alt="Logo" class="header-logo" style="height: 50px; width:auto; margin-right: 15px;">
                <div>
                    <h2 class="mb-0 fw-bold" style="font-size: 1.5rem;">Riwayat Peminjaman</h2>
                    <p class="mb-0 small opacity-75">Kilang Pertamina Internasional RU II Sei Pakning</p>
                </div>
            </div>
            <div>
                <a href="index.php" class="btn btn-modern btn-secondary-modern">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>
        </div>

        <div class="table-card">
            <div class="card-header">
                <i class="fas fa-clipboard-list me-2"></i> Log Data Peminjaman
            </div>
            <div class="card-body p-0">
                <table id="tabelPinjam" class="table table-hover mb-0 dt-responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th>Nama Peminjam</th>
                            <th>Nama Alat</th>
                            <th>Tgl Pinjam</th>
                            <th>Tgl Kembali</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Query Join untuk mengambil nama alat dari tabel alat
                        $query = "SELECT tbl_pinjam.*, tbl_alat.nama_alat 
                                  FROM tbl_pinjam 
                                  JOIN tbl_alat ON tbl_pinjam.id_alat = tbl_alat.id_alat 
                                  ORDER BY id_pinjam DESC";
                        $sql = mysqli_query($koneksi, $query);
                        $no = 1;
                        while($row = mysqli_fetch_array($sql)) {
                        ?>
                        <tr>
                            <td class="fw-bold"><?= $no++; ?></td>
                            
                            <td>
                                <div class="fw-bold text-dark"><?= $row['nama_peminjam']; ?></div>
                            </td>
                            
                            <td>
                                <i class="fas fa-box text-secondary me-1"></i> <?= $row['nama_alat']; ?>
                            </td>
                            
                            <td><?= date('d/m/Y', strtotime($row['tgl_pinjam'])); ?></td>
                            
                            <td>
                                <?php if($row['tgl_kembali']): ?>
                                    <span class="text-success fw-bold">
                                        <?= date('d/m/Y', strtotime($row['tgl_kembali'])); ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            
                            <td>
                                <?php if($row['status_pinjam'] == 'Dipinjam'): ?>
                                    <span class="badge-modern bg-warning text-dark">
                                        <i class="fas fa-clock me-1"></i> Sedang Dipinjam
                                    </span>
                                <?php else: ?>
                                    <span class="badge-modern bg-success">
                                        <i class="fas fa-check-double me-1"></i> Sudah Kembali
                                    </span>
                                <?php endif; ?>
                            </td>
                            
                            <td>
                                <?php if($row['status_pinjam'] == 'Dipinjam'): ?>
                                    <a href="proses_kembali.php?id_pinjam=<?= $row['id_pinjam']; ?>&id_alat=<?= $row['id_alat']; ?>" 
                                       class="btn btn-action btn-primary" 
                                       style="background: var(--primary-color); color: white;"
                                       onclick="return confirm('Konfirmasi: Apakah alat ini benar-benar sudah dikembalikan?')"
                                       title="Proses Pengembalian">
                                       <i class="fas fa-undo me-1"></i> Terima Kembali
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted fst-italic">
                                        <small><i class="fas fa-lock me-1"></i> Selesai</small>
                                    </span>
                                <?php endif; ?>
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
            // Inisialisasi DataTables Responsive
            $('#tabelPinjam').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json"
                },
                "responsive": true,
                "order": [[0, "asc"]] // Urutkan berdasarkan No
            });
        });
    </script>
</body>
</html>