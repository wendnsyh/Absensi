<h3 style="text-align:center">LAPORAN ABSENSI</h3>
<p>Periode: <?= htmlspecialchars($periode) ?></p>

<table border="1" cellpadding="5" width="100%">
    <thead>
        <tr style="background:#f0f0f0">
            <th width="4%">No</th>
            <th width="15%">Nama</th>
            <th width="10%">NIP</th>
            <th width="10%">Tanggal</th>
            <th width="8%">Jam In</th>
            <th width="8%">Jam Out</th>
            <th width="15%">Status Pulang</th>
            <th width="20%">Bukti</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1;
        foreach ($laporan as $r): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $r['nama_pegawai'] ?></td>
                <td><?= $r['nip'] ?></td>
                <td><?= date('d-m-Y', strtotime($r['tanggal'])) ?></td>
                <td><?= $r['jam_in'] ?: '-' ?></td>
                <td><?= $r['jam_out'] ?: '-' ?></td>
                <td><?= $r['status_pulang'] ?: '-' ?></td>
                <td>
                    <?php if (!empty($r['bukti'])): ?>
                        <img src="<?= base_url($r['bukti']) ?>" width="80">
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>