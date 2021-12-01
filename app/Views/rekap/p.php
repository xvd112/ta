<?php if ($p != 0) { ?>
    <h2 style="text-align: center;"><u><b>LAPORAN <?= $b; ?> <?= $t; ?></b></u></h2>
    <br>
    <h3>Jumlah Penduduk : <b><?= $p; ?></b></h3>
    <table class="table table-bordered">
        <tr>
            <td><b>Jumlah Laki - Laki</b></td>
            <td><?= $lk; ?></td>
        </tr>
        <tr>
            <td><b>Jumlah Perempuan</b></td>
            <td><?= $pr; ?></td>
        </tr>
    </table>

    <h3>Jumlah Penduduk Jorong Gantiang : <b><?= $g; ?></b></h3>
    <table class="table table-bordered">
        <tr>
            <td><b>Jumlah Laki - Laki</b></td>
            <td><?= $lk_g; ?></td>
        </tr>
        <tr>
            <td><b>Jumlah Perempuan</b></td>
            <td><?= $pr_g; ?></td>
        </tr>
    </table>

    <h3>Jumlah Penduduk Jorong Gunuang Rajo Utara : <b><?= $gru; ?></b></h3>
    <table class="table table-bordered">
        <tr>
            <td><b>Jumlah Laki - Laki</b></td>
            <td><?= $lk_gru; ?></td>
        </tr>
        <tr>
            <td><b>Jumlah Perempuan</b></td>
            <td><?= $pr_gru; ?></td>
        </tr>
    </table>
<?php } ?>