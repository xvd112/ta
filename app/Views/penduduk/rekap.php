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
    <h3>Jumlah Penduduk : <b><?= $p; ?></b></h3>
    <table border="1" style="padding:10;">
        <tr>
            <td><b>Jumlah Laki - Laki</b></td>
            <td><?= $lk; ?></td>
        </tr>
        <tr>
            <td><b>Jumlah Perempuan</b></td>
            <td><?= $pr; ?></td>
        </tr>
    </table>

    <h3>Jumlah Penduduk Jorong Gantiang : <b><?= $p_g; ?></b></h3>
    <table border="1" style="padding:10;">
        <tr>
            <td><b>Jumlah Laki - Laki</b></td>
            <td><?= $lk_g; ?></td>
        </tr>
        <tr>
            <td><b>Jumlah Perempuan</b></td>
            <td><?= $pr_g; ?></td>
        </tr>
    </table>

    <h3>Jumlah Penduduk Jorong Gunuang Rajo Utara : <b><?= $p_gru; ?></b></h3>
    <table border="1" style="padding:10;">
        <tr>
            <td><b>Jumlah Laki - Laki</b></td>
            <td><?= $lk_gru; ?></td>
        </tr>
        <tr>
            <td><b>Jumlah Perempuan</b></td>
            <td><?= $pr_gru; ?></td>
        </tr>
    </table>

</body>

</html>