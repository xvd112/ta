<!-- Admin -->
<?php if (session()->get('level') == 1 and session()->id_datauser != '0') : ?>
    <li class="nav-item">
        <a href="<?= base_url(); ?>/home" class="nav-link">
            <i class="nav-icon fas fa-home"></i>
            <p>
                Beranda
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= base_url(); ?>/profile/index" class="nav-link">
            <i class="nav-icon fas fa-user"></i>
            <p>
                Profile
            </p>
        </a>
    </li>
    <div class="dropdown-divider"></div>
    <li class="nav-item">
        <a href="<?= base_url(); ?>/rekap/index" class="nav-link">
            <i class="nav-icon fas fa-file"></i>
            <p>Rekap Data Penduduk</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= base_url(); ?>/rekap/keluarga" class="nav-link">
            <i class="nav-icon fas fa-file"></i>
            <p>Rekap Data Keluarga</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= base_url(); ?>/rekap/mohon" class="nav-link">
            <i class="nav-icon fas fa-file"></i>
            <p>Rekap Data Permohonan Surat</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= base_url(); ?>/rekap/aduan" class="nav-link">
            <i class="nav-icon fas fa-file"></i>
            <p>Rekap Data Aduan</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= base_url(); ?>/rekap/surat" class="nav-link">
            <i class="nav-icon fas fa-file"></i>
            <p>Rekap Data Surat</p>
        </a>
    </li>
    <div class="dropdown-divider"></div>
<?php endif; ?>