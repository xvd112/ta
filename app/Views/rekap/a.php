<?php if ($a != 0) { ?>
    <h2 style="text-align: center;"><u><b>LAPORAN <?= $b; ?> <?= $t; ?></b></u></h2>
    <br>
    <h3>Jumlah Aduan : <b><?= $a; ?></b></h3>
    <table class="table table-bordered">
        <tr>
            <td><b>Jumlah Sudah Diproses</b></td>
            <td><?= $selesai; ?></td>
        </tr>
        <tr>
            <td><b>Jumlah Belum Diproses</b></td>
            <td><?= $belum; ?></td>
        </tr>
    </table>
<?php } ?>