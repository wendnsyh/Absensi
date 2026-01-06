<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Detail Laporan Absensi</title>
</head>

<body>

    <!-- ================= HEADER ================= -->
    <table width="100%" cellpadding="4">
        <tr>
            <td width="70%">
                <h2 style="margin:0;">DETAIL LAPORAN ABSENSI</h2>
                <small>
                    Periode: <?= date('F Y', strtotime("$tahun-$bulan-01")) ?>
                </small>
            </td>
            <td width="30%" align="right">
                <small>
                    Dicetak:<br>
                    <?= date('d M Y H:i') ?>
                </small>
            </td>
        </tr>
    </table>

    <hr>

    <!-- ================= PEGAWAI ================= -->
    <table width="100%" cellpadding="4" style="margin-bottom:10px;">
        <tr>
            <td width="15%">Nama</td>
            <td width="2%">:</td>
            <td width="33%"><?= htmlspecialchars($pegawai->nama_pegawai ?? '-') ?></td>

            <td width="15%">NIP</td>
            <td width="2%">:</td>
            <td width="33%"><?= $pegawai->nip ?? '-' ?></td>
        </tr>
    </table>

    <!-- ================= TABLE ================= -->
    <table width="100%" border="1" cellpadding="4" cellspacing="0">
        <thead>
            <tr style="background-color:#eeeeee;">
                <th width="12%">Tanggal</th>
                <th width="10%">Hari</th>
                <th width="10%">Jam In</th>
                <th width="10%">Jam Out</th>
                <th width="18%">Kategori</th>
                <th width="20%">Status Pulang</th>
                <th width="20%">Bukti</th>
            </tr>
        </thead>
        <tbody>

            <?php if (empty($detail)): ?>
                <tr>
                    <td colspan="7" align="center">Tidak ada data</td>
                </tr>
            <?php else: ?>
                <?php foreach ($detail as $d): ?>
                    <tr>
                        <td><?= date('d M Y', strtotime($d->tanggal)) ?></td>
                        <td><?= $d->hari ?? '-' ?></td>
                        <td align="center"><?= $d->jam_in ?: '-' ?></td>
                        <td align="center"><?= $d->jam_out ?: '-' ?></td>
                        <td><?= $d->kategori ?? $d->keterangan ?? '-' ?></td>
                        <td><?= $d->status_pulang ?? '-' ?></td>
                        <td align="center">
                            <?php if (!empty($d->bukti)): ?>
                                <img src="<?= base_url($d->bukti) ?>" width="60">
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>

        </tbody>
    </table>

    <!-- ================= FOOTER ================= -->
    <br><br>
    <table width="100%">
        <tr>
            <td width="70%"></td>
            <td width="30%" align="center">
                <small>
                    Mengetahui,<br><br><br>
                    _______________________<br>
                    Admin Absensi
                </small>
            </td>
        </tr>
    </table>

</body>

</html>