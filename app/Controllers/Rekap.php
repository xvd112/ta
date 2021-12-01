<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\KeluargaModel;
use App\Models\PendudukModel;
use App\Models\PerangkatModel;
use App\Models\AuthModel;
use App\Models\AlamatModel;
use App\Models\MohonModel;
use App\Models\AduanModel;
use App\Models\SuratModel;
use TCPDF;

class pdf extends TCPDF
{
    public function Header()
    {
        $this->data =  new AlamatModel();
        $x = $this->data->getAlamat();
        $kab = strtoupper($x->kab);
        $kec = strtoupper($x->kec);
        $nag = strtoupper($x->nagari);
        $image_file = @FCPATH . 'aset\img\logo.png';
        $this->SetY(10);
        $this->SetFont('times', 'B', 12);
        $isi_header = "
        <table>
            <tr>
                <td width=\"70\"><img src=\"" . $image_file . "\" width=\"80\" height=\"80\"></td>
                <td align=\"center\" style=\"font-size:17px\" width=\"90%\">
                    PEMERINTAHAN KABUPATEN " . $kab . "<br>
                    KECAMATAN " . $kec . "<br>
                    WALI NAGARI " . $nag . "
                </td>
            </tr>
            <tr>
                <td width=\"50%\">" . $x->alm . "</td>
                <td width=\"50%\" align=\"right\">Kode Pos : " . $x->kd_pos . "</td>
            </tr>
        </table>
        <hr>
        ";
        $this->writeHTML($isi_header, true, false, false, false, '');
    }
}

class Rekap extends Controller
{
    protected $model, $isi, $keluarga, $data;
    public function __construct()
    {
        helper('form');
        $this->model =  new PendudukModel();
        $this->keluarga =  new KeluargaModel();
        $this->perangkat =  new PerangkatModel();
        $this->user =  new AuthModel();
        $this->alm =  new AlamatModel();
        $this->mohon =  new MohonModel();
        $this->aduan =  new AduanModel();
        $this->surat =  new SuratModel();
    }

    public function index()
    {
        $request = \Config\Services::request();
        $tahun = $request->getPost('tahun');
        $bulan = $request->getPost('bulan');

        if ($tahun != NULL and $bulan != NULL) {
            $nama = [
                '', 'JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI',
                'JUNI', 'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER'
            ];
            $penduduk = $this->model->tot('penduduk', $tahun, $bulan);
            $gantiang = $this->model->tot('penduduk', $tahun, $bulan, 'Jorong Gantiang');
            $gunung = $this->model->tot('penduduk', $tahun, $bulan, 'Jorong Gunuang Rajo Utara');

            $data = [
                'title' => 'View Surat',
                'p' => $penduduk,
                'lk' => $this->model->totjekel('penduduk', 'Laki - Laki', $tahun, $bulan),
                'pr' => $this->model->totjekel('penduduk', 'Perempuan', $tahun, $bulan),
                'g' => $gantiang,
                'lk_g' => $this->model->totjekel('penduduk', 'Laki - Laki', $tahun, $bulan, 'Jorong Gantiang'),
                'pr_g' => $this->model->totjekel('penduduk', 'Perempuan', $tahun, $bulan, 'Jorong Gantiang'),
                'gru' => $gunung,
                'lk_gru' => $this->model->totjekel('penduduk', 'Laki - Laki', $tahun, $bulan, 'Jorong Gunuang Rajo Utara'),
                'pr_gru' => $this->model->totjekel('penduduk', 'Perempuan', $tahun, $bulan, 'Jorong Gunuang Rajo Utara'),
                'data' => $this->alm->getAlamat(),
                't' => $tahun,
                'b' => $nama[$bulan],
                'user' => $this->perangkat->getPerangkat(session()->get('id_datauser'), 'Perangkat Nagari'),
                'isi' => $this->user->getUser(session()->id),
                'title' => 'Data Laporan Penduduk',
                'ket' => [
                    'Rekap Data Penduduk',
                    '<li class="breadcrumb-item active">Rekap Data Penduduk</li>'
                ],
                'bln' => $bulan,
                'link' => 'index',
                'print' => 'print',
                'lap' => 'p',
                'tot_data' => $penduduk
            ];

            if ($penduduk == 0) {
                session()->setFlashdata('warning', 'Data tidak ada.');
            }
        } else {
            $data = [
                'user' => $this->perangkat->getPerangkat(session()->get('id_datauser'), 'Perangkat Nagari'),
                'isi' => $this->user->getUser(session()->id),
                'title' => 'Data Laporan Penduduk',
                'ket' => [
                    'Rekap Data Penduduk',
                    '<li class="breadcrumb-item active">Rekap Data Penduduk</li>'
                ],
                't' => $tahun,
                'bln' => $bulan,
                'link' => 'index',
                'print' => 'print',
                'lap' => 'p',
                'p' => '0',
                'tot_data' => '0'
            ];
        }
        return view('rekap/laporan', $data);
    }

    public function print($bulan, $tahun)
    {
        $nama = [
            '', 'JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI',
            'JUNI', 'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER'
        ];
        $data = array(
            'title' => 'View Surat',
            'p' => $this->model->tot('penduduk', $tahun, $bulan),
            'lk' => $this->model->totjekel('penduduk', 'Laki - Laki', $tahun, $bulan),
            'pr' => $this->model->totjekel('penduduk', 'Perempuan', $tahun, $bulan),
            'p_g' => $this->model->tot('penduduk', $tahun, $bulan, 'Jorong Gantiang'),
            'lk_g' => $this->model->totjekel('penduduk', 'Laki - Laki', $tahun, $bulan, 'Jorong Gantiang'),
            'pr_g' => $this->model->totjekel('penduduk', 'Perempuan', $tahun, $bulan, 'Jorong Gantiang'),
            'p_gru' => $this->model->tot('penduduk', $tahun, $bulan, 'Jorong Gunuang Rajo Utara'),
            'lk_gru' => $this->model->totjekel('penduduk', 'Laki - Laki', $tahun, $bulan, 'Jorong Gunuang Rajo Utara'),
            'pr_gru' => $this->model->totjekel('penduduk', 'Perempuan', $tahun, $bulan, 'Jorong Gunuang Rajo Utara'),
            'data' => $this->alm->getAlamat(),
            't' => $tahun,
            'b' => $nama[$bulan]
        );
        $html = view('rekap/penduduk', $data);
        $pdf = new pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);
        $pdf->SetFont('times', '', 12);
        $pdf->setHeaderMargin(20);
        $pdf->setPrintHeader(true);
        $pdf->setPrintFooter(true);
        $pdf->SetMargins(20, 40, 20, true);
        $pdf->AddPage();
        $pdf->writeHTML($html);
        $this->response->setContentType('application/pdf');
        $pdf->Output('penduduk.pdf', 'I');
    }

    public function keluarga()
    {
        $request = \Config\Services::request();
        $tahun = $request->getPost('tahun');
        $bulan = $request->getPost('bulan');

        if ($tahun != NULL and $bulan != NULL) {
            $nama = [
                '', 'JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI',
                'JUNI', 'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER'
            ];
            $keluarga = $this->keluarga->count($tahun, $bulan);
            $gantiang = $this->keluarga->countid('Jorong Gantiang', $tahun, $bulan);
            $gunung = $this->keluarga->countid('Jorong Gunuang Rajo Utara', $tahun, $bulan);

            $data = [
                'title' => 'View Surat',
                'k' => $keluarga,
                'kg' => $gantiang,
                'kr' => $gunung,
                'g' => $this->model->tot('penduduk', $tahun, $bulan, 'Jorong Gantiang'),
                'gru' => $this->model->tot('penduduk', $tahun, $bulan, 'Jorong Gunuang Rajo Utara'),
                'data' => $this->alm->getAlamat(),
                't' => $tahun,
                'b' => $nama[$bulan],
                'user' => $this->perangkat->getPerangkat(session()->get('id_datauser'), 'Perangkat Nagari'),
                'isi' => $this->user->getUser(session()->id),
                'title' => 'Data Laporan Keluarga',
                'ket' => [
                    'Rekap Data Keluarga',
                    '<li class="breadcrumb-item active">Rekap Data Keluarga</li>'
                ],
                'bln' => $bulan,
                'link' => 'keluarga',
                'print' => 'printkk',
                'lap' => 'k',
                'tot_data' => $keluarga
            ];

            if ($keluarga == 0) {
                session()->setFlashdata('warning', 'Data tidak ada.');
            }
        } else {
            $data = [
                'user' => $this->perangkat->getPerangkat(session()->get('id_datauser'), 'Perangkat Nagari'),
                'isi' => $this->user->getUser(session()->id),
                'title' => 'Data Laporan Keluarga',
                'ket' => [
                    'Rekap Data Keluarga',
                    '<li class="breadcrumb-item active">Rekap Data Keluarga</li>'
                ],
                't' => $tahun,
                'bln' => $bulan,
                'link' => 'keluarga',
                'print' => 'printkk',
                'lap' => 'k',
                'k' => '0',
                'tot_data' => '0'
            ];
        }
        return view('rekap/laporan', $data);
    }

    public function printkk($bulan, $tahun)
    {
        $nama = [
            '', 'JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI',
            'JUNI', 'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER'
        ];
        $data = array(
            'title' => 'View Surat',
            'k' => $this->keluarga->count($tahun, $bulan),
            'g' => $this->model->tot('penduduk', $tahun, $bulan, 'Jorong Gantiang'),
            'gru' => $this->model->tot('penduduk', $tahun, $bulan, 'Jorong Gunuang Rajo Utara'),
            'kg' => $this->keluarga->countid('Jorong Gantiang', $tahun, $bulan),
            'kr' => $this->keluarga->countid('Jorong Gunuang Rajo Utara', $tahun, $bulan),
            'data' => $this->alm->getAlamat(),
            't' => $tahun,
            'b' => $nama[$bulan]
        );
        $html = view('rekap/keluarga', $data);
        $pdf = new pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);
        $pdf->SetFont('times', '', 12);
        $pdf->setHeaderMargin(20);
        $pdf->setPrintHeader(true);
        $pdf->setPrintFooter(true);
        $pdf->SetMargins(20, 40, 20, true);
        $pdf->AddPage();
        $pdf->writeHTML($html);
        $this->response->setContentType('application/pdf');
        $pdf->Output('keluarga.pdf', 'I');
    }

    public function mohon()
    {
        $request = \Config\Services::request();
        $tahun = $request->getPost('tahun');
        $bulan = $request->getPost('bulan');

        if ($tahun != NULL and $bulan != NULL) {
            $nama = [
                '', 'JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI',
                'JUNI', 'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER'
            ];

            $srt = array('SKU', 'SKTM', 'SKM', 'SKPO');
            $m = 0;
            for ($i = 0; $i < 4; $i++) {
                $mohon[$i] = $this->mohon->countjenis($srt[$i], $bulan, $tahun);
                $m = $m + $mohon[$i];
                $terima[$i] = $this->mohon->ket('Diterima', $srt[$i], $bulan, $tahun);
                $tolak[$i] = $this->mohon->ket('Ditolak', $srt[$i], $bulan, $tahun);
                $belum[$i] = $this->mohon->ket('Belum Diperiksa', $srt[$i], NULL, NULL);
            }

            $data = [
                'title' => 'View Surat',
                'm' => $m,
                'terima' => $this->mohon->countall('Diterima', $bulan, $tahun),
                'tolak' => $this->mohon->countall('Ditolak', $bulan, $tahun),
                'belum' => $this->mohon->countall('Belum Diperiksa', NULL, NULL),
                'sku' => $mohon[0],
                'terima_sku' => $terima[0],
                'tolak_sku' => $tolak[0],
                'belum_sku' => $belum[0],
                'sktm' => $mohon[1],
                'terima_sktm' => $terima[1],
                'tolak_sktm' => $tolak[1],
                'belum_sktm' => $belum[1],
                'skm' => $mohon[2],
                'terima_skm' => $terima[2],
                'tolak_skm' => $tolak[2],
                'belum_skm' => $belum[2],
                'skpo' => $mohon[3],
                'terima_skpo' => $terima[3],
                'tolak_skpo' => $tolak[3],
                'belum_skpo' => $belum[3],
                'data' => $this->alm->getAlamat(),
                't' => $tahun,
                'b' => $nama[$bulan],
                'user' => $this->perangkat->getPerangkat(session()->get('id_datauser'), 'Perangkat Nagari'),
                'isi' => $this->user->getUser(session()->id),
                'title' => 'Data Laporan Permohonan Surat',
                'ket' => [
                    'Rekap Data Permohonan Surat',
                    '<li class="breadcrumb-item active">Rekap Data Permohonan Surat</li>'
                ],
                'bln' => $bulan,
                'link' => 'mohon',
                'print' => 'printm',
                'lap' => 'm',
                'tot_data' => $m
            ];

            if ($m == 0) {
                session()->setFlashdata('warning', 'Data tidak ada.');
            }
        } else {
            $data = [
                'user' => $this->perangkat->getPerangkat(session()->get('id_datauser'), 'Perangkat Nagari'),
                'isi' => $this->user->getUser(session()->id),
                'title' => 'Data Laporan Permohonan Surat',
                'ket' => [
                    'Rekap Data Permohonan Surat',
                    '<li class="breadcrumb-item active">Rekap Data Permohonan Surat</li>'
                ],
                't' => $tahun,
                'bln' => $bulan,
                'link' => 'mohon',
                'print' => 'printm',
                'lap' => 'm',
                'm' => '0',
                'tot_data' => '0'
            ];
        }
        return view('rekap/laporan', $data);
    }

    public function printm($bulan, $tahun)
    {
        $nama = [
            '', 'JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI',
            'JUNI', 'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER'
        ];

        $srt = array('SKU', 'SKTM', 'SKM', 'SKPO');
        $m = 0;
        for ($i = 0; $i < 4; $i++) {
            $mohon[$i] = $this->mohon->countjenis($srt[$i], $bulan, $tahun);
            $m = $m + $mohon[$i];
            $terima[$i] = $this->mohon->ket('Diterima', $srt[$i], $bulan, $tahun);
            $tolak[$i] = $this->mohon->ket('Ditolak', $srt[$i], $bulan, $tahun);
            $belum[$i] = $this->mohon->ket('Belum Diperiksa', $srt[$i], NULL, NULL);
        }

        $data = array(
            'title' => 'View Surat',
            'm' => $m,
            'terima' => $this->mohon->countall('Diterima', $bulan, $tahun),
            'tolak' => $this->mohon->countall('Ditolak', $bulan, $tahun),
            'belum' => $this->mohon->countall('Belum Diperiksa', NULL, NULL),
            'sku' => $mohon[0],
            'terima_sku' => $terima[0],
            'tolak_sku' => $tolak[0],
            'belum_sku' => $belum[0],
            'sktm' => $mohon[1],
            'terima_sktm' => $terima[1],
            'tolak_sktm' => $tolak[1],
            'belum_sktm' => $belum[1],
            'skm' => $mohon[2],
            'terima_skm' => $terima[2],
            'tolak_skm' => $tolak[2],
            'belum_skm' => $belum[2],
            'skpo' => $mohon[3],
            'terima_skpo' => $terima[3],
            'tolak_skpo' => $tolak[3],
            'belum_skpo' => $belum[3],
            'data' => $this->alm->getAlamat(),
            't' => $tahun,
            'b' => $nama[$bulan]
        );
        $html = view('rekap/mohon', $data);
        $pdf = new pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);
        $pdf->SetFont('times', '', 12);
        $pdf->setHeaderMargin(20);
        $pdf->setPrintHeader(true);
        $pdf->setPrintFooter(true);
        $pdf->SetMargins(20, 40, 20, true);
        $pdf->AddPage();
        $pdf->writeHTML($html);
        $this->response->setContentType('application/pdf');
        $pdf->Output('permohonan surat.pdf', 'I');
    }

    public function aduan()
    {
        $request = \Config\Services::request();
        $tahun = $request->getPost('tahun');
        $bulan = $request->getPost('bulan');

        if ($tahun != NULL and $bulan != NULL) {
            $nama = [
                '', 'JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI',
                'JUNI', 'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER'
            ];

            $data = [
                'title' => 'View Surat',
                'a' => $this->aduan->count($bulan, $tahun),
                'belum' => $this->aduan->countket('Belum Diproses', NULL, NULL),
                'selesai' => $this->aduan->countket('Selesai', $bulan, $tahun),
                'data' => $this->alm->getAlamat(),
                't' => $tahun,
                'b' => $nama[$bulan],
                'user' => $this->perangkat->getPerangkat(session()->get('id_datauser'), 'Perangkat Nagari'),
                'isi' => $this->user->getUser(session()->id),
                'title' => 'Data Laporan Aduan',
                'ket' => [
                    'Rekap Data Aduan',
                    '<li class="breadcrumb-item active">Rekap Data Aduan</li>'
                ],
                'bln' => $bulan,
                'link' => 'aduan',
                'print' => 'printa',
                'lap' => 'a',
                'tot_data' => $this->aduan->count($bulan, $tahun)
            ];

            if ($this->aduan->count($bulan, $tahun) == 0) {
                session()->setFlashdata('warning', 'Data tidak ada.');
            }
        } else {
            $data = [
                'user' => $this->perangkat->getPerangkat(session()->get('id_datauser'), 'Perangkat Nagari'),
                'isi' => $this->user->getUser(session()->id),
                'title' => 'Data Laporan Aduan',
                'ket' => [
                    'Rekap Data Aduan',
                    '<li class="breadcrumb-item active">Rekap Data Aduan</li>'
                ],
                't' => $tahun,
                'bln' => $bulan,
                'link' => 'aduan',
                'print' => 'printa',
                'lap' => 'a',
                'a' => '0',
                'tot_data' => '0'
            ];
        }
        return view('rekap/laporan', $data);
    }

    public function printa($bulan, $tahun)
    {
        $nama = [
            '', 'JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI',
            'JUNI', 'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER'
        ];

        $data = array(
            'title' => 'View Surat',
            'a' => $this->aduan->count($bulan, $tahun),
            'belum' => $this->aduan->countket('Belum Diproses', NULL, NULL),
            'selesai' => $this->aduan->countket('Selesai', $bulan, $tahun),
            'data' => $this->alm->getAlamat(),
            't' => $tahun,
            'b' => $nama[$bulan]
        );
        $html = view('rekap/aduan', $data);
        $pdf = new pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);
        $pdf->SetFont('times', '', 12);
        $pdf->setHeaderMargin(20);
        $pdf->setPrintHeader(true);
        $pdf->setPrintFooter(true);
        $pdf->SetMargins(20, 40, 20, true);
        $pdf->AddPage();
        $pdf->writeHTML($html);
        $this->response->setContentType('application/pdf');
        $pdf->Output('aduan.pdf', 'I');
    }

    public function surat()
    {
        $request = \Config\Services::request();
        $tahun = $request->getPost('tahun');
        $bulan = $request->getPost('bulan');

        if ($tahun != NULL and $bulan != NULL) {
            $nama = [
                '', 'JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI',
                'JUNI', 'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER'
            ];

            $srt = array('SKU', 'SKTM', 'SKM', 'SKPO');
            for ($i = 0; $i < 4; $i++) {
                $surat[$i] = $this->surat->countket($srt[$i], $bulan, $tahun);
            }

            $data = [
                'title' => 'View Surat',
                's' => $this->surat->count($bulan, $tahun),
                'sku' => $surat[0],
                'sktm' => $surat[1],
                'skm' => $surat[2],
                'skpo' => $surat[3],
                'data' => $this->alm->getAlamat(),
                't' => $tahun,
                'b' => $nama[$bulan],
                'user' => $this->perangkat->getPerangkat(session()->get('id_datauser'), 'Perangkat Nagari'),
                'isi' => $this->user->getUser(session()->id),
                'title' => 'Data Laporan Surat',
                'ket' => [
                    'Rekap Data Surat',
                    '<li class="breadcrumb-item active">Rekap Data Surat</li>'
                ],
                'bln' => $bulan,
                'link' => 'surat',
                'print' => 'prints',
                'lap' => 's',
                'tot_data' => $this->surat->count($bulan, $tahun)
            ];

            if ($this->surat->count($bulan, $tahun) == 0) {
                session()->setFlashdata('warning', 'Data tidak ada.');
            }
        } else {
            $data = [
                'user' => $this->perangkat->getPerangkat(session()->get('id_datauser'), 'Perangkat Nagari'),
                'isi' => $this->user->getUser(session()->id),
                'title' => 'Data Laporan Surat',
                'ket' => [
                    'Rekap Data Surat',
                    '<li class="breadcrumb-item active">Rekap Data Surat</li>'
                ],
                't' => $tahun,
                'bln' => $bulan,
                'link' => 'surat',
                'print' => 'prints',
                'lap' => 's',
                's' => '0',
                'tot_data' => '0'
            ];
        }
        return view('rekap/laporan', $data);
    }

    public function prints($bulan, $tahun)
    {
        $nama = [
            '', 'JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI',
            'JUNI', 'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER'
        ];
        $srt = array('SKU', 'SKTM', 'SKM', 'SKPO');
        for ($i = 0; $i < 4; $i++) {
            $surat[$i] = $this->surat->countket($srt[$i], $bulan, $tahun);
        }

        $data = array(
            'title' => 'View Surat',
            's' => $this->surat->count($bulan, $tahun),
            'sku' => $surat[0],
            'sktm' => $surat[1],
            'skm' => $surat[2],
            'skpo' => $surat[3],
            'data' => $this->alm->getAlamat(),
            't' => $tahun,
            'b' => $nama[$bulan]
        );
        $html = view('rekap/surat', $data);
        $pdf = new pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);
        $pdf->SetFont('times', '', 12);
        $pdf->setHeaderMargin(20);
        $pdf->setPrintHeader(true);
        $pdf->setPrintFooter(true);
        $pdf->SetMargins(20, 40, 20, true);
        $pdf->AddPage();
        $pdf->writeHTML($html);
        $this->response->setContentType('application/pdf');
        $pdf->Output('surat.pdf', 'I');
    }
}
