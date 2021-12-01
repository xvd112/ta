<?= $this->extend('web/template'); ?>
<?= $this->section('content'); ?>

<main id="main">
  <section style="padding: 40px; background: #f8fcfd;">
    <div class="card">
      <div class="card-body">
        <table class="table">
          <tr>
            <td>No. Telepon / WA</td>
            <td> : </td>
            <td><a href="tel:<?= $data->telp; ?>"><i class="fab fa-whatsapp"></i> <?= $data->telp; ?></a></td>
          </tr>
          <tr>
            <td>Instagram</td>
            <td> : </td>
            <td><a href="<?= $data->ig; ?>"><i class="fab fa-instagram"></i> <?= $data->ig; ?></a></td>
          </tr>
          <tr>
            <td>Facebook</td>
            <td> : </td>
            <td><a href="<?= $data->fb; ?>"><i class="fab fa-facebook"></i> <?= $data->fb; ?></a></td>
          </tr>
          <tr>
            <td>Twitter</td>
            <td> : </td>
            <td><a href="<?= $data->twit; ?>"><i class="fab fa-twitter"></i> <?= $data->twit; ?></a></td>
          </tr>
        </table>
      </div>
    </div>
  </section>
</main>
<?= $this->endSection(); ?>