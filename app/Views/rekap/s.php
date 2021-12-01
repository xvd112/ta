<?php if ($s != 0) { ?>
    <h2 style="text-align: center;"><u><b>LAPORAN <?= $b; ?> <?= $t; ?></b></u></h2>
    <br>
    <h3>Jumlah Semua Surat yang Dikeluarkan : <b><?= $s; ?></b></h3>
    <table class="table table-bordered">
        <tr>
            <td><b>SKU</b></td>
            <td><?= $sku; ?></td>
        </tr>
        <tr>
            <td><b>SKTM</b></td>
            <td><?= $sktm; ?></td>
        </tr>
        <tr>
            <td><b>SKM</b></td>
            <td><?= $skm; ?></td>
        </tr>
        <tr>
            <td><b>SKPO</b></td>
            <td><?= $skpo; ?></td>
        </tr>
    </table>
<?php } ?>