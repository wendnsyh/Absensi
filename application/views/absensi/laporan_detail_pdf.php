<!DOCTYPE html>
<html>

<head>
    <title>Detail Absensi <?= $absensi['nama'] ?></title>
    <style type="text/css">
        .table-data {
            width: 100%;
            border-collapse: collapse;
        }

        .table-data tr th,
        .table-data tr td {
            border: 1px solid black;
            font-size: 11pt;
            font-family: Verdana;
            padding: 10px;
        }

        .table-data th {
            background-color: #f2f2f2;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        h3 {
            font-family: Verdana;
        }

        p {
            font-family: Verdana;
            font-size: 11pt;
            line-height: 1.5;
        }
    </style>
</head>

<body>
    <div class="header">
        <h3>Laporan Detail Absensi</h3>
    </div>
    <hr><?php
        date_default_timezone_set('Asia/Jakarta');
        ?>

    <p><strong>Nama:</strong> <?= $absensi['nama']; ?></p>
    <p><strong>NIP:</strong> <?= $absensi['nip']; ?></p>
    <p><strong>Tanggal Cetak:</strong> <?= date('d M Y H:i:s'); ?></p>

    <table class="table-data">
        <thead>
            <tr>
                <th style="width: 20%;">Kategori</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Total Tidak Hadir</td>
                <td>
                    <?php
                    $total_tidak_hadir = $absensi['sakit'] + $absensi['izin'] + $absensi['alfa'] + $absensi['cuti'] + $absensi['dinas_luar'];
                    if ($total_tidak_hadir > 0) {
                        echo $total_tidak_hadir . ' hari';
                    } else {
                        echo '0 hari';
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td>Total Terlambat</td>
                <td>
                    <?php
                    $total_telat = $absensi['terlambat_kurang_30'] + $absensi['terlambat_30_90'] + $absensi['terlambat_lebih_90'];
                    if ($total_telat > 0) {
                        echo $total_telat . ' kali';
                    } else {
                        echo '0 kali';
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td>Total Tidak Fingerprint</td>
                <td><?= ($absensi['tidak_finger_masuk'] + $absensi['tidak_finger_pulang']) ?: 0; ?> kali</td>
            </tr>
            <tr>
                <td>Sakit</td>
                <td><?= $absensi['sakit'] ?: 0; ?> kali</td>
            </tr>
            <tr>
                <td>Izin</td>
                <td><?= $absensi['izin'] ?: 0; ?> kali</td>
            </tr>
            <tr>
                <td>Alfa</td>
                <td><?= $absensi['alfa'] ?: 0; ?> kali</td>
            </tr>
            <tr>
                <td>Dinas Luar</td>
                <td><?= $absensi['dinas_luar'] ?: 0; ?> kali</td>
            </tr>
            <tr>
                <td>Cuti</td>
                <td><?= $absensi['cuti'] ?: 0; ?> kali</td>
            </tr>
        </tbody>
    </table>
</body>

</html>