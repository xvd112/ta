<?= $this->extend('template/index'); ?>

<?= $this->section('content'); ?>

<!-- Main content -->
<section class="content">
    <?= form_open('galeri/hapusbanyak', ['class' => 'formhapus']) ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <?php if (session()->getFlashdata('pesan_galeri')) : ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('pesan_galeri'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php elseif (session()->getFlashdata('danger_galeri')) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('danger_galeri'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php elseif (session()->getFlashdata('warning_galeri')) : ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('warning_galeri'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-newspaper mr-1"></i>
                            <?= $ket[0]; ?>
                        </h3>
                        <div class="card-tools">
                            <ul class="nav nav-pills ml-auto">
                                <li class="nav-item">
                                    <button type="button" style="margin-left: 10px;" class="btn btn-success">
                                        <a href="<?php echo base_url('galeri/input'); ?>" style="color: white;">
                                            <i class="far fa-plus-square"> Tambah Data</i>
                                        </a>
                                    </button>
                                </li>

                                <li class="nav-item">
                                    <button type="submit" style="margin-left: 10px;" class="btn btn-danger tombolHapusBanyak" onclick="javascript:return confirm('Apakah ingin menghapus data ini ?')">
                                        <i class="far fa-trash-alt"> Hapus Data Terpilih</i>
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead class="thead-dark" style="text-align: center;">
                                <tr>
                                    <th>
                                        <input type="checkbox" id="centangsemua">
                                    </th>
                                    <th style="text-align:center">No</th>
                                    <th style="text-align:center;">Jenis Foto</th>
                                    <th style="text-align:center; width: 50%;">Foto</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($galeri as $data) {
                                ?>
                                    <tr>
                                        <td style="text-align: center;">
                                            <input type="checkbox" id="check" name="id_galeri[]" class="centang" value="<?= $data['id_galeri']; ?>">
                                        </td>
                                        <td><?= $no; ?></td>
                                        <td><?= $data['jenis']; ?></td>
                                        <td>
                                            <img width="50%" src="<?= base_url(); ?>/aset/img/<?= $data['foto']; ?>" alt="">
                                        </td>
                                        <td style="text-align: center;">
                                            <a href="<?php echo base_url('galeri/edit/' . $data['id_galeri']); ?>" style="color: black;">
                                                <li class="far fa-edit"></li>
                                            </a>
                                            <?php if ($data['id_galeri'] > 15) { ?>
                                                <a href="<?php echo base_url('galeri/delete/' . $data['id_galeri']); ?>" onclick="javascript:return confirm('Apakah Anda Yakin Ingin Menghapus Data Ini?')" style="color: black;">
                                                    <li class="far fa-trash-alt"></li>
                                                </a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php $no++;
                                }
                                ?>
                            </tbody>
                        </table>
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