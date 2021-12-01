<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Rekap Penduduk</title>
    <link rel="SHORTCUT ICON" href="<?php echo base_url() ?>/aset/img/logo.png">
</head>

<body>
    <h2 style="text-align: center;"><u><b>LAPORAN <?= $b; ?> <?= $t; ?></b></u></h2>
    <h3>Jumlah Permohonan Masuk : <b><?= $m; ?></b></h3>
    <table border="1" style="padding:10;">
        <tr>
            <td><b>Jumlah Diterima</b></td>
            <td><?= $terima; ?></td>
        </tr>
        <tr>
            <td><b>Jumlah Ditolak</b></td>
            <td><?= $tolak; ?></td>
        </tr>
        <tr>
            <td><b>Jumlah Belum Diperiksa</b></td>
            <td><?= $belum; ?></td>
        </tr>
    </table>

    <h3>Jumlah Permohonan SKU : <b><?= $sku; ?></b></h3>
    <table border="1" style="padding:10;">
        <tr>
            <td><b>Jumlah Diterima</b></td>
            <td><?= $terima_sku; ?></td>
        </tr>
        <tr>
            <td><b>Jumlah Ditolak</b></td>
            <td><?= $tolak_sku; ?></td>
        </tr>
        <tr>
            <td><b>Jumlah Belum Diperiksa</b></td>
            <td><?= $belum_sku; ?></td>
        </tr>
    </table>

    <h3>Jumlah Permohonan SKTM : <b><?= $sktm; ?></b></h3>
    <table border="1" style="padding:10;">
        <tr>
            <td><b>Jumlah Diterima</b></td>
            <td><?= $terima_sktm; ?></td>
        </tr>
        <tr>
            <td><b>Jumlah Ditolak</b></td>
            <td><?= $tolak_sktm; ?></td>
        </tr>
        <tr>
            <td><b>Jumlah Belum Diperiksa</b></td>
            <td><?= $belum_sktm; ?></td>
        </tr>
    </table>

    <h3>Jumlah Permohonan SKM : <b><?= $skm; ?></b></h3>
    <table border="1" style="padding:10;">
        <tr>
            <td><b>Jumlah Diterima</b></td>
            <td><?= $terima_skm; ?></td>
        </tr>
        <tr>
            <td><b>Jumlah Ditolak</b></td>
            <td><?= $tolak_skm; ?></td>
        </tr>
        <tr>
            <td><b>Jumlah Belum Diperiksa</b></td>
            <td><?= $belum_skm; ?></td>
        </tr>
    </table>
    <br><br><br><br>
    <h3>Jumlah Permohonan SKPO : <b><?= $skpo; ?></b></h3>
    <table border="1" style="padding:10;">
        <tr>
            <td><b>Jumlah Diterima</b></td>
            <td><?= $terima_skpo; ?></td>
        </tr>
        <tr>
            <td><b>Jumlah Ditolak</b></td>
            <td><?= $tolak_skpo; ?></td>
        </tr>
        <tr>
            <td><b>Jumlah Belum Diperiksa</b></td>
            <td><?= $belum_skpo; ?></td>
        </tr>
    </table>
</body>

</html>