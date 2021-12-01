<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Rekap Keluarga</title>
    <link rel="SHORTCUT ICON" href="<?php echo base_url() ?>/aset/img/logo.png">
</head>

<body>
    <h2 style="text-align: center;"><u><b>LAPORAN <?= $b; ?> <?= $t; ?></b></u></h2>
    <h3>Jumlah Kepala Keluarga : <b><?= $k; ?></b></h3>
    <table border="1" style="padding:10;">
        <tr>
            <td><b>Jumlah Laki - Laki</b></td>
            <td><?= $kg; ?></td>
            <td> dari <?= $g; ?> penduduk</td>
        </tr>
        <tr>
            <td><b>Jumlah Perempuan</b></td>
            <td><?= $kr; ?></td>
            <td> dari <?= $gru; ?> penduduk</td>
        </tr>
    </table>

</body>

</html>