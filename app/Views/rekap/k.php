<?php if ($k != 0) { ?>
    <h2 style="text-align: center;"><u><b>LAPORAN <?= $b; ?> <?= $t; ?></b></u></h2>
    <br>
    <h3>Jumlah Kepala Keluarga : <b><?= $k; ?></b></h3>
    <table class="table table-bordered">
        <tr>
            <td><b>Jorong Gantiang</b></td>
            <td><?= $kg; ?></td>
            <td> dari <?= $g; ?> penduduk</td>
        </tr>
        <tr>
            <td><b>Jorong Gunung Rajo Utara</b></td>
            <td><?= $kr; ?></td>
            <td> dari <?= $gru; ?> penduduk</td>
        </tr>
    </table>
<?php } ?>