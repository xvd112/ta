<!-- Admin -->
<?php if (session()->get('level') == 1 and session()->id_datauser == '0') : ?>
    <li class="nav-item">
        <a href="<?= base_url(); ?>/user/index" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>
                User
            </p>
        </a>
    </li>
    <div class="dropdown-divider"></div>
    <li class="nav-item">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-balance-scale"></i>
            <p>
                Laporan Rekap Data
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="<?= base_url(); ?>/rekap/index" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Rekap Data Penduduk</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>/rekap/mohon" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Rekap Data Permohonan Surat</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>/rekap/aduan" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Rekap Data Aduan</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>/rekap/surat" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Rekap Data Surat</p>
                </a>
            </li>
        </ul>
    </li>
    <div class="dropdown-divider"></div>
<?php endif; ?>