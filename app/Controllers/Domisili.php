<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\SuratModel;
use App\Models\PendudukModel;
use App\Models\AlamatModel;
use App\Models\KeluargaModel;
use App\Models\PerangkatModel;
use App\Models\AuthModel;
use App\Models\GaleriModel;
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

class Domisili extends Controller
{
    protected $model, $penduduk, $data, $keluarga, $perangkat;
    public function __construct()
    {
        helper('form');
        $this->model =  new SuratModel();
        $this->penduduk =  new PendudukModel();
        $this->data =  new AlamatModel();
        $this->keluarga =  new KeluargaModel();
        $this->perangkat =  new PerangkatModel();
        $this->user =  new AuthModel();
        $this->gal =  new GaleriModel();
    }

    public function index()
    {
        $ket = [
            'Data Surat Keterangan Domisili', '<li class="breadcrumb-item active"><a href="/domisili/index">Data Surat Keterangan Domisili</a></li>'
        ];
        $data = [
            'title' => 'Data Surat Keterangan Domisili',
            'ket' => $ket,
            'link' => 'domisili',
            'surat' => $this->model->getSurat(false, 'Domisili'),
            'user' => $this->perangkat->getPerangkat(session()->get('id_datauser'), 'Perangkat Nagari'),
            'isi' => $this->user->getUser(session()->id)
        ];
        return view('surat/index', $data);
    }

    // View detail data
    public function view($id_surat)
    {
        $x = $this->model->getSurat($id_surat, 'Domisili');
        $ket = [
            'View Data Surat Keterangan Domisili', '<li class="breadcrumb-item active"><a href="/domisili/index">Data Surat Keterangan Domisili</a></li>',
            '<li class="breadcrumb-item active">View Data</li>'
        ];
        $data = [
            'title' => 'View Data Surat Keterangan Domisili',
            'ket' => $ket,
            'link' => 'domisili',
            'surat' => $x,
            'data' => $this->data->getAlamat(),
            'gal' => $this->gal->getGaleri(2),
            'kk' => $this->keluarga->getKeluarga($x->id_keluarga),
            'ttd' => $this->perangkat->getPerangkat($x->id_pemerintahan, 'Perangkat Nagari'),
            'user' => $this->perangkat->getPerangkat(session()->get('id_datauser'), 'Perangkat Nagari'),
            'isi' => $this->user->getUser(session()->id),
            'jenis_s' => 'SURAT KETERANGAN Domisili',
            'label_s' => '/SKM/KESRA',
            'label' => 'Penghasilan Orang Tua'
        ];
        return view('surat/view', $data);
    }

    public function nama($id_penduduk)
    {
        $data = $this->penduduk->id($id_penduduk, 'id_penduduk');
        $json = array();
        $json['nama'] = $data->tambahan;
        return $this->response->setJson($json);
    }

    // Menampilkan form input
    public function input()
    {
        $ket = [
            'Tambah Data Surat Keterangan Domisili',
            '<li class="breadcrumb-item active"><a href="/domisili/index">Data Surat Keterangan Domisili</a></li>',
            '<li class="breadcrumb-item active">Tambah Data</li>'
        ];
        $data = [
            'title' => 'Tambah Data Surat Keterangan Domisili',
            'ket' => $ket,
            'link' => 'domisili',
            // 'label' => 'Penghasilan Orang Tua',
            'keluarga' => $this->keluarga->getKeluarga(),
            'ttd' => $this->perangkat->ttd(),
            'user' => $this->perangkat->getPerangkat(session()->get('id_datauser'), 'Perangkat Nagari'),
            'isi' => $this->user->getUser(session()->id)
        ];
        return view('surat/input', $data);
    }

    public function add()
    {
        $request = \Config\Services::request();
        $max = $this->model->no('Domisili');
        $data = array(
            'no_surat' => $max->x + 1,
            'id_penduduk' => $request->getPost('id_penduduk'),
            'id_pemerintahan' => $request->getPost('ttd'),
            'tujuan' => $request->getPost('tujuan'),
            'tgl_surat' => date('Y-m-d'),
            'jenis' => 'Domisili',
        );
        $this->model->saveSurat($data);
        return redirect()->to('domisili/index');
    }

    public function print($id_surat)
    {
        $x = $this->model->getSurat($id_surat, 'Domisili');
        $data = [
            'title' => 'View Data Surat Keterangan Domisili',
            'surat' => $x,
            'data' => $this->data->getAlamat(),
            'kk' => $this->keluarga->getKeluarga($x->id_keluarga),
            'ttd' => $this->perangkat->getPerangkat($x->id_pemerintahan, 'Perangkat Nagari'),
            'link' => 'Domisili'
        ];
        $html = view('surat/printdomisili', $data);
        $pdf = new pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, 'F4', true, 'UTF-8', false);
        $pdf->SetFont('times', '', 12);
        $pdf->setHeaderMargin(20);
        $pdf->setPrintHeader(true);
        $pdf->setPrintFooter(true);
        $pdf->SetMargins(20, 45, 20, true);
        $pdf->AddPage();
        $pdf->writeHTML($html);
        $this->response->setContentType('application/pdf');
        $pdf->Output('domisili.pdf', 'I');
    }

    ///edit data
    public function edit($id_surat)
    {
        $surat = $this->model->getSurat($id_surat, 'Domisili');
        if (isset($surat)) {
            $ket = [
                'Edit ' . $surat->tambahan,
                '<li class="breadcrumb-item active"><a href="/domisili/index">Data Surat Keterangan Domisili</a></li>',
                '<li class="breadcrumb-item active">Edit Data</li>'
            ];
            $x = $this->penduduk->getPenduduk($surat->id_penduduk);
            $data = [
                'title' => 'Edit ' . $surat->tambahan,
                'ket' => $ket,
                'link' => 'domisili',
                'label' => 'Penghasilan Orang Tua',
                'keluarga' => $this->keluarga->getKeluarga(),
                'surat' => $surat,
                'kel' => $x,
                'penduduk' => $this->penduduk->id_array($surat->id_keluarga, 'id_keluarga'),
                'ttd' => $this->perangkat->ttd(),
                'user' => $this->perangkat->getPerangkat(session()->get('id_datauser'), 'Perangkat Nagari'),
                'isi' => $this->user->getUser(session()->id)
            ];
            return view('surat/edit', $data);
        } else {
            session()->setFlashdata('warning_surat', 'Surat tanggal : ' . $surat->tambahan . ' Tidak Ditemukan.');
            return redirect()->to('domisili/index');
        }
    }

    public function update()
    {
        $request = \Config\Services::request();
        $id_surat = $request->getPost('id_surat');
        $max = $this->model->no('Domisili');
        $data = array(
            'no_surat' => $max->x + 1,
            'id_penduduk' => $request->getPost('id_penduduk'),
            'id_pemerintahan' => $request->getPost('ttd'),
            'tujuan' => $request->getPost('tujuan'),
            'tgl_surat' => date('Y-m-d'),
            'jenis' => 'Domisili',
        );
        $this->model->editSurat($data, $id_surat);
        session()->setFlashdata('pesan_surat', 'Data Surat Keterangan Domisili Berhasi Diedit.');
        return redirect()->to('domisili/index');
    }

    // Menghapus data
    public function delete($id_surat)
    {
        $surat = $this->model->getSurat($id_surat, 'Domisili');
        if (isset($surat)) {
            $this->model->hapusSurat($id_surat);
            session()->setFlashdata('danger_surat', 'Data Surat Keterangan Domisili : ' . $surat->tambahan . ' Berhasi Dihapus.');
            return redirect()->to('domisili/index');
        } else {
            session()->setFlashdata('warning_surat', 'Data Surat Keterangan Domisili : ' . $surat->tambahan . ' Tidak Ditemukan.');
            return redirect()->to('domisili/index');
        }
    }

    // Menghapus data pilihan
    public function hapusbanyak()
    {
        $request = \Config\Services::request();
        $id_surat = $request->getPost('id_surat');
        if ($id_surat == null) {
            session()->setFlashdata('warning_surat', 'Data Pejabat dan berita Desa Belum Dipilih, Silahkan Pilih Data Terlebih Dahulu.');
            $data['title'] = 'Data Surat Keterangan Domisili dan Pejabat Desa';
            return redirect()->to('domisili/index');
        }

        $jmldata = count($id_surat);
        $x = 0;
        for ($i = 0; $i < $jmldata; $i++) {
            $this->model->hapusSurat($id_surat[$i]);
            $x++;
        }

        session()->setFlashdata('pesan_surat', 'Data Pejabat dan berita Desa Berhasi Dihapus Sebanyak ' . $x . ' Data.');
        $data['title'] = 'Data Surat Keterangan Domisili dan Pejabat Desa';
        return redirect()->to('domisili/index');
    }
}
