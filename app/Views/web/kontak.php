<?= $this->extend('web/template'); ?>
<?= $this->section('content'); ?>

<main id="main">
  <section style="padding: 40px; background: #f8fcfd;">
    <div class="card">
      <div class="card-body">
        <table class="table">
          <tr>
            <td>Alamat</td>
            <td> : </td>
            <td><a href="<?= $data->map_kantor; ?>" target="_blank"><?= $data->alm; ?>, Nagari <?= $data->nagari; ?>, Kec. <?= $data->kec; ?>, Kab. <?= $data->kab; ?>, <?= $data->prov; ?>, Indonesia, <?= $data->kd_pos; ?></a></td>
          </tr>
          <tr>
            <td>No. Telepon / WA</td>
            <td> : </td>
            <td><a href="tel:<?= $data->telp; ?>"><?= $data->telp; ?></a></td>
          </tr>
          <tr>
            <td>Instagram</td>
            <td> : </td>
            <td><a href="<?= $data->ig; ?>" target="_blank"><?= $data->ig; ?></a></td>
          </tr>
          <tr>
            <td>Twitter</td>
            <td> : </td>
            <td><a href="<?= $data->twit; ?>" target="_blank"><?= $data->twit; ?></a></td>
          </tr>
          <tr>
            <td>Facebook</td>
            <td> : </td>
            <td><a href="<?= $data->fb; ?>" target="_blank"><?= $data->fb; ?></a></td>
          </tr>
          <tr>
            <td>Email</td>
            <td> : </td>
            <td><a href="mailto:<?= $data->email; ?>"><?= $data->email; ?></a></td>
          </tr>
        </table>
      </div>
    </div>
    <h1 align="center" style="padding: 20px;"><b>PETA</b></h1>
    <div class="card" align="center">
      <?= $data->map_wilayah; ?>
    </div>
  </section>
</main>
<?= $this->endSection(); ?>