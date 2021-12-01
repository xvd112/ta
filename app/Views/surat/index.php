<?= $this->extend('template/index'); ?>

<?= $this->section('content'); ?>

<!-- Main content -->
<section class="content">
    <?= form_open($link . '/hapusbanyak', ['class' => 'formhapus']) ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <?php if (session()->getFlashdata('pesan_surat')) : ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('pesan_surat'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php elseif (session()->getFlashdata('danger_surat')) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('danger_surat'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php elseif (session()->getFlashdata('warning_surat')) : ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('warning_surat'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-newspaper mr-1"></i>
                            <?= $ket[0]; ?>
                        </h3>
                        <?php if (session()->jabatan == 'Kasi Tata Usaha dan Umum' and $link == 'sku') { ?>
                            <div class="card-tools">
                                <ul class="nav nav-pills ml-auto">
                                    <li class="nav-item">
                                        <button type="button" style="margin-left: 10px;" class="btn btn-success">
                                            <a href="<?php echo base_url($link . '/input'); ?>" style="color: white;">
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
                        <?php } ?>
                        <?php if (session()->jabatan == 'Kasi Kesejahteraan' and $link != 'sku') { ?>
                            <div class="card-tools">
                                <ul class="nav nav-pills ml-auto">
                                    <li class="nav-item">
                                        <button type="button" style="margin-left: 10px;" class="btn btn-success">
                                            <a href="<?php echo base_url($link . '/input'); ?>" style="color: white;">
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
                        <?php } ?>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <?= $this->include('template/tgl'); ?>
                        <table id="example2" class="table table-bordered table-hover">
                            <thead class="thead-dark" style="text-align: center;">
                                <tr>
                                    <th>
                                        <input type="checkbox" id="centangsemua">
                                    </th>
                                    <th style="text-align:center">No</th>
                                    <th style="text-align:center">Tanggal Surat</th>
                                    <th style="text-align:center">Nama</th>
                                    <?php if ($link == 'sku') { ?>
                                        <th style="text-align:center">Jenis Usaha</th>
                                    <?php } ?>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($surat as $data) {
                                ?>
                                    <tr>
                                        <td style="text-align: center;">
                                            <input type="checkbox" id="check" name="id_surat[]" class="centang" value="<?= $data['id_surat']; ?>">
                                        </td>
                                        <td><?= $no; ?></td>
                                        <td><?= tgl_indo($data['tgl_surat']); ?></td>
                                        <td><?= $data['nama']; ?></td>
                                        <?php if ($link == 'sku') { ?>
                                            <td><?= $data['tambahan']; ?></td>
                                        <?php } ?>
                                        <td style="text-align: center;">
                                            <a href="<?php echo base_url($link . '/view/' . $data['id_surat']); ?>" style="color: black;">
                                                <li class="far fa-eye"></li>
                                            </a>
                                            <?php if (session()->jabatan == 'Kasi Tata Usaha dan Umum' and $link == 'sku') { ?>
                                                <a href="<?php echo base_url($link . '/edit/' . $data['id_surat']); ?>" style="color: black;">
                                                    <li class="far fa-edit"></li>
                                                </a>
                                                <a href="<?php echo base_url($link . '/delete/' . $data['id_surat']); ?>" onclick="javascript:return confirm('Apakah Anda Yakin Ingin Menghapus Data Ini?')" style="color: black;">
                                                    <li class="far fa-trash-alt"></li>
                                                </a>
                                            <?php } ?>
                                            <?php if (session()->jabatan == 'Kasi Kesejahteraan' and $link != 'sku') { ?>
                                                <a href="<?php echo base_url($link . '/edit/' . $data['id_surat']); ?>" style="color: black;">
                                                    <li class="far fa-edit"></li>
                                                </a>
                                                <a href="<?php echo base_url($link . '/delete/' . $data['id_surat']); ?>" onclick="javascript:return confirm('Apakah Anda Yakin Ingin Menghapus Data Ini?')" style="color: black;">
                                                    <li class="far fa-trash-alt"></li>
                                                </a>
                                            <?php } ?>
                                            <a href="<?php echo base_url($link . '/print/' . $data['id_surat']); ?>" target="_blank" style="color: black;">
                                                <li class="fas fa-print"></li>
                                            </a>
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