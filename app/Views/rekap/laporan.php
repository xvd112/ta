<?= $this->extend('template/index'); ?>

<?= $this->section('content'); ?>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <form method="post" action="<?= base_url('rekap/' . $link); ?>">
                            <div class="row mb-3">
                                <label for="tahun" class="col-sm-2 col-form-label">Tahun</label>
                                <div class="col-sm-3">
                                    <select class="form-control select2bs4" name="tahun" id="tahun" required style="background:lightgrey">
                                        <option value="">Pilih Tahun </option>
                                        <?php
                                        $x = 2021;
                                        $jml = date('Y') - 2021;
                                        for ($i = 0; $i < $jml + 1; $i++) {
                                        ?>
                                            <option <?php if ($t == $x) {
                                                        echo 'selected';
                                                    } ?> value="<?php echo $x ?>"><?php echo $x ?></option>
                                        <?php $x++;
                                        } ?>
                                    </select>
                                </div>
                                <label for="bulan" class="col-sm-2 col-form-label">Bulan</label>
                                <div class="col-sm-3">
                                    <select class="form-control select2bs4" name="bulan" id="bulan" required style="background:lightgrey">
                                        <option value="">Pilih Bulan </option> -->
                                        <?php
                                        $data = [
                                            '', 'Januari', 'Februari', 'Maret', 'April', 'Mei',
                                            'Juni', 'Juli', 'Agustus', 'September', 'Oktober',
                                            'November', 'Desember'
                                        ];
                                        for ($i = 1; $i < count($data); $i++) {
                                        ?>
                                            <option <?php if ($bln == $i) {
                                                        echo 'selected';
                                                    } ?> value="<?php echo $i ?>"><?php echo $data[$i] ?></option>
                                        <?php }  ?>
                                    </select>
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                        </form>
                        <?php if ($tot_data != 0) { ?>
                            <div class="col">
                                <button type="button" class="btn" style="background:grey; margin-left:10px">
                                    <a target="_blank" href="<?php echo base_url('/rekap/' . $print . '/' . $bln . '/' . $t); ?>" style="color: white;">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </button>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('warning')) : ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('warning'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <?= $this->include('rekap/' . $lap); ?>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->

<!-- /.content -->
<?= $this->endSection(); ?>