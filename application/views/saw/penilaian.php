<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Input Penilaian Karyawan</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="<?= base_url('dashboard'); ?>">
                            <i class="flaticon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Input Penilaian</a>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <?= $this->session->flashdata('message'); ?>

                    <div class="card shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">Data Penilaian Karyawan</h4>
                            <div>
                                <button id="refreshHariKerja" type="button" class="btn btn-success btn-sm mr-2">
                                    <i class="fa fa-sync"></i> Refresh Hari Kerja
                                </button>
                                <button type="submit" form="formPenilaian" class="btn btn-primary btn-sm">
                                    <i class="fa fa-save"></i> Simpan Semua Nilai
                                </button>
                            </div>
                        </div>


                        <div class="card-body">
                            <form id="formPenilaian" method="post" action="<?= base_url('saw/simpan_semua_penilaian'); ?>">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped text-center">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>No</th>
                                                <th>NIP</th>
                                                <th>Nama</th>
                                                <th>Hari Kerja</th>
                                                <th>Skill</th>
                                                <th>Attitude</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($penilaian)): ?>
                                                <?php $no = 1; ?>
                                                <?php foreach ($penilaian as $p): ?>
                                                    <tr>
                                                        <td><?= $no++; ?></td>
                                                        <td>
                                                            <?= $p['nip']; ?>
                                                            <input type="hidden" name="nip[]" value="<?= $p['nip']; ?>">
                                                        </td>
                                                        <td><?= $p['nama']; ?></td>
                                                        <td><?= $p['hari_kerja']; ?></td>
                                                        <td>
                                                            <input type="number" name="skills[]" class="form-control text-center" min="0" max="100"
                                                                value="<?= $p['skills']; ?>" required>
                                                        </td>
                                                        <td>
                                                            <input type="number" name="attitude[]" class="form-control text-center" min="0" max="100"
                                                                value="<?= $p['attitude']; ?>" required>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="6" class="text-muted">Belum ada data penilaian.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert & Toastr -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "2000"
        };

        // Tombol Refresh Hari Kerja
        $('#refreshHariKerja').on('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Perbarui Hari Kerja?',
                text: "Data hari kerja akan dihitung ulang dari absensi.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, perbarui!',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#28a745'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= base_url('saw/refresh_hari_kerja'); ?>",
                        method: "POST",
                        dataType: "json",
                        beforeSend: function() {
                            toastr.info('Memperbarui data hari kerja...');
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                toastr.success('Hari kerja berhasil diperbarui!');
                                setTimeout(() => location.reload(), 1000);
                            } else {
                                toastr.error('Gagal memperbarui hari kerja.');
                            }
                        },
                        error: function() {
                            toastr.error('Terjadi kesalahan koneksi.');
                        }
                    });
                }
            });
        });

        // Konfirmasi sebelum simpan
        $('#formPenilaian').on('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Simpan Semua Penilaian?',
                text: "Pastikan semua nilai sudah benar.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, simpan!',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#007bff'
            }).then((result) => {
                if (result.isConfirmed) {
                    e.target.submit();
                }
            });
        });
    });
</script>