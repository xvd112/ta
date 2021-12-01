<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\PerangkatModel;
use App\Models\PendudukModel;
use App\Models\AuthModel;

class Kan extends Controller
{
    protected $model;
    public function __construct()
    {
        helper('form');
        $this->model =  new PerangkatModel();
        $this->penduduk =  new PendudukModel();
        $this->user =  new AuthModel();
    }

    public function index()
    {
        $ket = [
            'Data Kerapatan Adat Nagari (KAN)', '<li class="breadcrumb-item active"><a href="' . base_url() . '/kan/index">Data Kerapatan Adat Nagari (KAN)</a></li>'
        ];
        $perangkat = $this->model->getPerangkat(false, 'KAN');
        $p = NULL;
        for ($i = 0; $i < count($perangkat); $i++) {
            if ($this->penduduk->cari($perangkat[$i]['nik']) != NULL) {
                $p[$i] = true;
            } else {
                $p[$i] = false;
            }
        }
        $data = [
            'title' => 'Data Kerapatan Adat Nagari (KAN)',
            'ket' => $ket,
            'link' => 'kan',
            'perangkat' => $perangkat,
            'p' => $p,
            'user' => $this->model->getPerangkat(session()->get('id_datauser'), 'Perangkat Nagari'),
            'isi' => $this->user->getUser(session()->id)
        ];
        return view('perangkat/index', $data);
    }

    public function view($id_pemerintahan)
    {
        $data = $this->model->getPerangkat($id_pemerintahan, 'KAN');
        $ket = [
            'View Data : ' . $data->nama, '<li class="breadcrumb-item active"><a href="' . base_url() . '/kan/index">Data Kerapatan Adat Nagari (KAN)</a></li>',
            '<li class="breadcrumb-item active">View Data</li>'
        ];
        $data = [
            'title' => 'View Data : ' . $data->nama,
            'ket' => $ket,
            'link' => 'kan',
            'perangkat' => $this->model->getPerangkat($id_pemerintahan, 'KAN'),
            'user' => $this->model->getPerangkat(session()->get('id_datauser'), 'Perangkat Nagari'),
            'isi' => $this->user->getUser(session()->id)
        ];
        return view('perangkat/view', $data);
    }

    public function input()
    {
        $jabatan = array(
            "Ketua", "Sekretaris", "Bendahara",
            "Seksi Sako & Pusako", "Seksi Adat & Sarak",
            "Seksi Permainan Anak Nagari"
        );

        $x = 0;
        for ($i = 0; $i < count($jabatan) - 3; $i++) {
            if ($this->model->jabatan('KAN', $jabatan[$i]) == NULL) {
                $rev[$x] = $jabatan[$i];
                $x++;
            } else {
                continue;
            }
        }
        if ($x <= (count($jabatan) - 3)) {
            $rev[$x] = $jabatan[3];
            $rev[$x + 1] = $jabatan[4];
            $rev[$x + 2] = $jabatan[5];
        }

        $ket = [
            'Tambah Data Kerapatan Adat Nagari (KAN)',
            '<li class="breadcrumb-item active"><a href="' . base_url() . '/kan/index">Data Kerapatan Adat Nagari (KAN)</a></li>',
            '<li class="breadcrumb-item active">Tambah Data</li>'
        ];
        $data = [
            'title' => 'Tambah Data Kerapatan Adat Nagari (KAN)',
            'ket' => $ket,
            'link' => 'kan',
            'jabatan' => $rev,
            'user' => $this->model->getPerangkat(session()->get('id_datauser'), 'Perangkat Nagari'),
            'isi' => $this->user->getUser(session()->id)
        ];
        return view('perangkat/input', $data);
    }

    public function add()
    {
        $request = \Config\Services::request();

        if ($request->getPost('nik') != NULL) {
            $request = \Config\Services::request();
            $validation = \Config\Services::validation();
            $validation->setRules([
                'nik' => [
                    'label' => 'NIK',
                    'rules' => 'min_length[16]|max_length[16]|numeric',
                    'errors' => [
                        'min_length' => 'NIK minimal 16 angka',
                        'max_length' => 'NIK max 16 angka',
                        'numeric'  => 'NIK harus angka'
                    ]
                ]
            ]);
            if (!$validation->withRequest($request)->run()) {
                session()->setFlashdata('error', $validation->listErrors());
                return redirect()->to(base_url() . '/kan/input');
            }
        }

        $nik = $request->getPost('nik');
        $tgl_lantik = $request->getPost('tgl_lantik');
        $jbtn = $request->getPost('jabatan');
        $cek = $this->model->caridata('KAN', $jbtn, $tgl_lantik, NULL, $nik);
        // dd($cek);
        if ($cek != NULL) {
            session()->setFlashdata('error', 'Data sudah ada');
            return redirect()->to(base_url() . '/kan/input');
        }

        $file = $request->getFile('foto');
        if ($file->getError() == 4) {
            $nm = "default.jpg";
        } else {
            $nm = $file->getRandomName();
            $file->move('perangkat', $nm);
        }

        $data = array(
            'no' => date('y', strtotime($request->getPost('tgl_lantik'))) . '-03-' . $jbtn,
            'nik' => $nik,
            'nama' => $request->getPost('nama'),
            'jabatan' => $jbtn,
            'status' => 'KAN',
            'foto' => $nm,
            'tgl_lantik' => $request->getPost('tgl_lantik'),
            'telp' => $request->getPost('telp'),
            'jekel' => $request->getPost('jekel'),
            'tgl_update' => date('Y-m-d')
        );
        $this->model->savePerangkat($data);
        session()->setFlashdata('pesan_perangkat', 'Data KAN berhasi ditambahkan.');
        return redirect()->to(base_url() . '/kan/index');
    }

    public function edit($id_pemerintahan)
    {
        $getperangkat = $this->model->getPerangkat($id_pemerintahan, 'KAN');
        if (isset($getperangkat)) {
            $jabatan = array(
                "Ketua", "Sekretaris", "Bendahara",
                "Seksi Sako & Pusako", "Seksi Adat & Sarak", "Seksi Permainan Anak Nagari"
            );
            $ket = [
                'Edit ' . $getperangkat->nama,
                '<li class="breadcrumb-item active"><a href="' . base_url() . '/kan/index">Data Kerapatan Adat Nagari (KAN)</a></li>',
                '<li class="breadcrumb-item active">Edit Data</li>'
            ];
            $data = [
                'title' => 'Edit ' . $getperangkat->nama,
                'ket' => $ket,
                'link' => 'kan',
                'perangkat' => $getperangkat,
                'jabatan' => $jabatan,
                'user' => $this->model->getPerangkat(session()->get('id_datauser'), 'Perangkat Nagari'),
                'isi' => $this->user->getUser(session()->id)
            ];
            return view('perangkat/edit', $data);
        } else {
            session()->setFlashdata('warning_perangkat', 'Data KAN tidak ditemukan.');
            return redirect()->to(base_url() . '/kan');
        }
    }

    public function update()
    {
        $request = \Config\Services::request();
        $id_pemerintahan = $request->getPost('id_pemerintahan');

        if ($request->getPost('nik') != NULL) {
            $request = \Config\Services::request();
            $validation = \Config\Services::validation();
            $validation->setRules([
                'nik' => [
                    'label' => 'NIK',
                    'rules' => 'min_length[16]|max_length[16]|numeric',
                    'errors' => [
                        'min_length' => 'NIK minimal 16 angka',
                        'max_length' => 'NIK max 16 angka',
                        'numeric'  => 'NIK harus angka'
                    ]
                ]
            ]);
            if (!$validation->withRequest($request)->run()) {
                session()->setFlashdata('error', $validation->listErrors());
                return redirect()->to(base_url() . '/kan/edit/' . $id_pemerintahan);
            }
        }

        $nik = $request->getPost('nik');
        $tgl_lantik = $request->getPost('tgl_lantik');
        $jbtn = $request->getPost('jabatan');
        $berhenti = $request->getPost('tgl_berhenti');
        if ($berhenti == NULL or $berhenti == '0000-00-00') {
            $berhenti = NULL;
        }
        $cek = $this->model->caridata('KAN', $jbtn, $tgl_lantik, $berhenti, $nik);
        // dd($cek);
        if ($cek != NULL) {
            session()->setFlashdata('error', 'Data sudah ada');
            return redirect()->to(base_url() . '/kan/edit/' . $id_pemerintahan);
        }

        $file = $request->getFile('foto');
        if ($file->getError() == 4) {
            $nm = $request->getPost('lama');
        } else {
            $nm = $file->getRandomName();
            $file->move('perangkat', $nm);
            if ($request->getPost('lama') != 'default.jpg') {
                unlink('perangkat/' . $request->getPost('lama'));
            }
        }

        if ($request->getPost('tgl_berhenti') == NULL or $request->getPost('tgl_berhenti') == '0000-00-00') {
            $berhenti = '';
        } else {
            $berhenti = $request->getPost('tgl_berhenti');
        }

        $data = array(
            'no' => date('y', strtotime($tgl_lantik)) . '-03-' . $jbtn,
            'nik' => $nik,
            'nama' => $request->getPost('nama'),
            'jabatan' => $jbtn,
            'status' => 'KAN',
            'foto' => $nm,
            'tgl_berhenti' => $berhenti,
            'tgl_lantik' => $tgl_lantik,
            'telp' => $request->getPost('telp'),
            'jekel' => $request->getPost('jekel'),
            'tgl_update' => date('Y-m-d')
        );
        $this->model->editPerangkat($data, $id_pemerintahan);
        session()->setFlashdata('pesan_perangkat', 'Data perangkat Berhasi Diedit.');
        return redirect()->to(base_url() . '/kan/index');
    }

    public function delete($id_pemerintahan)
    {
        $getPerangkat = $this->model->getPerangkat($id_pemerintahan, 'KAN');
        if (isset($getPerangkat)) {
            $this->model->hapusPerangkat($id_pemerintahan);
            session()->setFlashdata('pesan_perangkat', 'Data KAN : ' . $getPerangkat->nama . ' berhasi dihapus.');
            return redirect()->to(base_url() . '/kan/index');
        } else {
            session()->setFlashdata('warning_perangkat', 'Data KAN tidak ditemukan.');
            return redirect()->to(base_url() . '/kan/index');
        }
    }

    public function hapusbanyak()
    {
        $request = \Config\Services::request();
        $id_pemerintahan = $request->getPost('id_pemerintahan');
        if ($id_pemerintahan == null) {
            session()->setFlashdata('warning_perangkat', 'Data KAN belum dipilih, silahkan pilih data terlebih dahulu.');
            return redirect()->to(base_url() . '/kan/index');
        }

        $jmldata = count($id_pemerintahan);
        for ($i = 0; $i < $jmldata; $i++) {
            $this->model->hapusPerangkat($id_pemerintahan[$i]);
        }

        session()->setFlashdata('pesan_perangkat', 'Data KAN berhasil dihapus sebanyak ' . $jmldata . ' data.');
        return redirect()->to(base_url() . '/kan/index');
    }

    public function import()
    {
        $ket = [
            'Import Data Kerapatan Adat Nagari (KAN)', '<li class="breadcrumb-item active"><a href="' . base_url() . '/kan/index">Data Kerapatan Adat Nagari (KAN)</a></li>',
            '<li class="breadcrumb-item active">Import Data</li>'
        ];
        $data = [
            'title' => 'Import Data Kerapatan Adat Nagari (KAN)',
            'ket' => $ket,
            'link' => 'kan',
            'perangkat' => $this->model->getPerangkat(false, 'KAN'),
            'user' => $this->model->getPerangkat(session()->get('id_datauser'), 'Perangkat Nagari'),
            'isi' => $this->user->getUser(session()->id)
        ];
        return view('perangkat/import', $data);
    }

    public function proses()
    {
        $request = \Config\Services::request();
        $file = $request->getFile('file_excel');
        $ext = $file->getClientExtension();
        if ($ext == 'xls') {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } elseif ($ext == 'xlsx') {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        } else {
            session()->setFlashdata('warning_perangkat', 'Ekstensi file salah, silahkan masukkan file berekstensi .xls atau .xlsx.');
            return redirect()->to(base_url() . '/kan/import');
        }
        $spreadsheet = $render->load($file);
        $sheet = $spreadsheet->getActiveSheet()->toArray();

        foreach ($sheet as $x => $excel) {
            if ($x == 0) {
                continue;
            }

            if (count($excel) != 8) {
                session()->setFlashdata('warning_perangkat', 'Data tidak lengkap / Format salah');
                return redirect()->to(base_url() . '/kan/import');
            }

            if ($excel[5] == '' or $excel[5] == '0000-00-00' or $excel[5] == '-') {
                $berhenti = NULL;
                $ket = 'Menjabat';
                $jabatan = $this->model->cek('KAN', $excel[3], $excel[4], '0000-00-00');
                if ($jabatan != NULL) {
                    if ($excel[3] == 'Seksi Sako & Pusako') {
                        $dup = $this->model->duplikat('KAN', 'Seksi Sako & Pusako', $excel[4], '0000-00-00');
                        $jml = 0;
                        for ($i = 0; $i < count($dup); $i++) {
                            if ($excel[3] == $dup[$i]['jabatan'] and $excel[2] == $dup[$i]['nama']) {
                                $jml++;
                            }
                        }
                        if ($jml != 0) {
                            continue;
                        }
                    }
                    if ($excel[3] == 'Seksi Adat & Sarak') {
                        $dup = $this->model->duplikat('KAN', 'Seksi Adat & Sarak', $excel[4], '0000-00-00');
                        $jml2 = 0;
                        for ($i = 0; $i < count($dup); $i++) {
                            if ($excel[3] == $dup[$i]['jabatan'] and $excel[2] == $dup[$i]['nama']) {
                                $jml2++;
                            }
                        }
                        if ($jml2 != 0) {
                            continue;
                        }
                    }
                    if ($excel[3] == 'Seksi Permainan Anak Nagari') {
                        $dup = $this->model->duplikat('KAN', 'Seksi Permainan Anak Nagari', $excel[4], '0000-00-00');
                        $jml3 = 0;
                        for ($i = 0; $i < count($dup); $i++) {
                            if ($excel[3] == $dup[$i]['jabatan'] and $excel[2] == $dup[$i]['nama']) {
                                $jml3++;
                            }
                        }
                        if ($jml3 != 0) {
                            continue;
                        }
                    }
                    if ($excel[3] != 'Seksi Permainan Anak Nagari' or $excel[3] != 'Seksi Sako & Pusako' or $excel[3] != 'Seksi Adat & Sarak') {
                        if ($excel[3] == $jabatan['jabatan'] and $excel[2] == $jabatan['nama']) {
                            continue;
                        }
                    }
                }
            } else {
                $berhenti = $excel[5];
                $ket = 'Berhenti';
            }

            $jabatan = $this->model->cek('KAN', $excel[3], $excel[4], $berhenti);
            if ($jabatan != NULL) {
                if ($excel[3] == 'Seksi Sako & Pusako') {
                    $dup = $this->model->duplikat('KAN', 'Seksi Sako & Pusako', $excel[4], $berhenti);
                    $jml = 0;
                    for ($i = 0; $i < count($dup); $i++) {
                        if ($excel[3] == $dup[$i]['jabatan'] and $excel[2] == $dup[$i]['nama']) {
                            $jml++;
                        }
                    }
                    if ($jml != 0) {
                        continue;
                    }
                }
                if ($excel[3] == 'Seksi Adat & Sarak') {
                    $dup = $this->model->duplikat('KAN', 'Seksi Adat & Sarak', $excel[4], $berhenti);
                    $jml2 = 0;
                    for ($i = 0; $i < count($dup); $i++) {
                        if ($excel[3] == $dup[$i]['jabatan'] and $excel[2] == $dup[$i]['nama']) {
                            $jml2++;
                        }
                    }
                    if ($jml2 != 0) {
                        continue;
                    }
                }
                if ($excel[3] == 'Seksi Permainan Anak Nagari') {
                    $dup = $this->model->duplikat('KAN', 'Seksi Permainan Anak Nagari', $excel[4], $berhenti);
                    $jml3 = 0;
                    for ($i = 0; $i < count($dup); $i++) {
                        if ($excel[3] == $dup[$i]['jabatan'] and $excel[2] == $dup[$i]['nama']) {
                            $jml3++;
                        }
                    }
                    if ($jml3 != 0) {
                        continue;
                    }
                }
                if ($excel[3] != 'Seksi Permainan Anak Nagari' or $excel[3] != 'Seksi Sako & Pusako' or $excel[3] != 'Seksi Adat & Sarak') {
                    if ($excel[3] == $jabatan['jabatan'] and $excel[2] == $jabatan['nama']) {
                        continue;
                    }
                }
            }

            if ($excel[7] == 'L') {
                $excel[7] = 'Laki - Laki';
            } elseif ($excel[7] == 'P') {
                $excel[7] = 'Perempuan';
            }

            if ($excel[1] == '-' or $excel[1] == '0000000000000000') {
                $nik = '';
            } else {
                $nik = $excel[1];
            }

            $data = array(
                'no' => date('y', strtotime($excel[4])) . '-03-' . $excel[3],
                'nik' => $nik,
                'nama' => $excel[2],
                'jabatan' => $excel[3],
                'status' => 'KAN',
                'foto' => 'default.jpg',
                'tgl_lantik' => $excel[4],
                'tgl_berhenti' => $berhenti,
                'telp' => $excel[6],
                'jekel' => $excel[7],
                'tgl_update' => date('Y-m-d'),
                'ket' => $ket
            );
            $this->model->savePerangkat($data);
        }

        session()->setFlashdata('pesan_perangkat', 'Data KAN berhasil diimport.');
        return redirect()->to(base_url() . '/kan/index');
    }
}
