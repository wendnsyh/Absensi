<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
        }

        th {
            background: #eee;
        }

        h3 {
            text-align: center;
            margin-bottom: 5px;
        }

        p {
            text-align: center;
            margin-top: 0;
        }
    </style>
</head>

<body>

    <h3>LAPORAN ABSENSI PEGAWAI</h3>
    <p>Periode: <?= $periode; ?></p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NIP</th>
                <th>Total Hari Kerja</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($laporan as $r): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $r->nama_pegawai; ?></td>
                    <td><?= $r->nip; ?></td>
                    <td style="text-align:center"><?= $r->total_hari; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>

</html>