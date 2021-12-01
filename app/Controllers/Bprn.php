<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\PerangkatModel;
use App\Models\PendudukModel;
use App\Models\AuthModel;

class Bprn extends Controller
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
            'Data Badan Permusyawaratan Rakyat Nagari (BPRN)', '<li class="breadcrumb-item active"><a href="' . base_url() . '/bprn/index">Data Badan Permusyawaratan Rakyat Nagari (BPRN)</a></li>'
        ];
        $perangkat = $this->model->getPerangkat(false, 'BPRN');
        $p = NULL;
        for ($i = 0; $i < count($perangkat); $i++) {
            if ($this->penduduk->cari($perangkat[$i]['nik']) != NULL) {
                $p[$i] = true;
            } else {
                $p[$i] = false;
            }
        }
        $data = [
            'title' => 'Data Badan Permusyawaratan Rakyat Nagari (BPRN)',
            'ket' => $ket,
            'link' => 'bprn',
            'perangkat' => $perangkat,
            'p' => $p,
            'user' => $this->model->getPerangkat(session()->get('id_datauser'), 'Perangkat Nagari'),
            'isi' => $this->user->getUser(session()->id)
        ];
        return view('perangkat/index', $data);
    }

    public function view($id_pemerintahan)
    {
        $data = $this->model->getPerangkat($id_pemerintahan, 'BPRN');
        $ket = [
            'View Data : ' . $data->nama, '<li class="breadcrumb-item active"><a href="' . base_url() . '/bprn/index">Data Badan Permusyawaratan Rakyat Nagari (BPRN)</a></li>',
            '<li class="breadcrumb-item active">View Data</li>'
        ];
        $data = [
            'title' => 'View Data : ' . $data->nama,
            'ket' => $ket,
            'link' => 'bprn',
            'perangkat' => $this->model->getPerangkat($id_pemerintahan, 'BPRN'),
            'user' => $this->model->getPerangkat(session()->get('id_datauser'), 'Perangkat Nagari'),
            'isi' => $this->user->getUser(session()->id)
        ];
        return view('perangkat/view', $data);
    }

    public function input()
    {
        $jabatan = array(
            "Ketua BPRN", "Wakil Ketua BPRN", "Sekretaris BPRN", "Anggota"
        );

        $x = 0;
        for ($i = 0; $i < count($jabatan) - 1; $i++) {
            if ($this->model->jabatan('BPRN', $jabatan[$i]) == NULL) {
                $rev[$x] = $jabatan[$i];
                $x++;
            } else {
                continue;
            }
        }
        if ($x < count($jabatan)) {
            $rev[$x] = 'Anggota';
        }

        $ket = [
            'Tambah Data Badan Permusyawaratan Rakyat Nagari (BPRN)',
            '<li class="breadcrumb-item active"><a href="' . base_url() . '/bprn/index">Data Badan Permusyawaratan Rakyat Nagari (BPRN)</a></li>',
            '<li class="breadcrumb-item active">Tambah Data</li>'
        ];
        $data = [
            'title' => 'Tambah Data Badan Permusyawaratan Rakyat Nagari (BPRN)',
            'ket' => $ket,
            'link' => 'bprn',
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
                return redirect()->to(base_url() . '/bprn/input');
            }
        }

        $nik = $request->getPost('nik');
        $tgl_lantik = $request->getPost('tgl_lantik');
        $jbtn = $request->getPost('jabatan');
        $cek = $this->model->caridata('BPRN', $jbtn, $tgl_lantik, NULL, $nik);
        // dd($cek);
        if ($cek != NULL) {
            session()->setFlashdata('error', 'Data sudah ada');
            return redirect()->to(base_url() . '/bprn/input');
        }

        $file = $request->getFile('foto');
        if ($file->getError() == 4) {
            $nm = "default.jpg";
        } else {
            $nm = $file->getRandomName();
            $file->move('perangkat', $nm);
        }

        $data = array(
            'no' => date('y', strtotime($request->getPost('tgl_lantik'))) . '-02-' . $jbtn,
            'nik' => $nik,
            'nama' => $request->getPost('nama'),
            'jabatan' => $jbtn,
            'status' => 'BPRN',
            'foto' => $nm,
            'tgl_lantik' => $request->getPost('tgl_lantik'),
            'telp' => $request->getPost('telp'),
            'jekel' => $request->getPost('jekel'),
            'tgl_update' => date('Y-m-d')
        );
        $this->model->savePerangkat($data);
        session()->setFlashdata('pesan_perangkat', 'Data BPRN berhasi ditambahkan.');
        return redirect()->to(base_url() . '/bprn/index');
    }

    public function edit($id_pemerintahan)
    {
        $getperangkat = $this->model->getPerangkat($id_pemerintahan, 'BPRN');
        if (isset($getperangkat)) {
            $jabatan = array(
                "Ketua BPRN", "Wakil Ketua BPRN", "Sekretaris BPRN", "Anggota"
            );
            $ket = [
                'Edit ' . $getperangkat->nama,
                '<li class="breadcrumb-item active"><a href="' . base_url() . '/bprn/index">Data Badan Permusyawaratan Rakyat Nagari (BPRN)</a></li>',
                '<li class="breadcrumb-item active">Edit Data</li>'
            ];
            $data = [
                'title' => 'Edit ' . $getperangkat->nama,
                'ket' => $ket,
                'link' => 'bprn',
                'perangkat' => $getperangkat,
                'jabatan' => $jabatan,
                'user' => $this->model->getPerangkat(session()->get('id_datauser'), 'Perangkat Nagari'),
                'isi' => $this->user->getUser(session()->id)
            ];
            return view('perangkat/edit', $data);
        } else {
            session()->setFlashdata('warning_perangkat', 'Data BPRN tidak ditemukan.');
            return redirect()->to(base_url() . '/bprn/index');
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
                return redirect()->to(base_url() . '/bprn/edit/' . $id_pemerintahan);
            }
        }

        $nik = $request->getPost('nik');
        $tgl_lantik = $request->getPost('tgl_lantik');
        $jbtn = $request->getPost('jabatan');
        $berhenti = $request->getPost('tgl_berhenti');
        if ($berhenti == NULL or $berhenti == '0000-00-00') {
            $berhenti = NULL;
        }
        $cek = $this->model->caridata('BPRN', $jbtn, $tgl_lantik, $berhenti, $nik);
        // dd($cek);
        if ($cek != NULL) {
            session()->setFlashdata('error', 'Data sudah ada');
            return redirect()->to(base_url() . '/bprn/edit/' . $id_pemerintahan);
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
            'no' => date('y', strtotime($tgl_lantik)) . '-02-' . $request->getPost('jabatan'),
            'nik' => $nik,
            'nama' => $request->getPost('nama'),
            'jabatan' => $request->getPost('jabatan'),
            'status' => 'BPRN',
            'foto' => $nm,
            'tgl_lantik' => $tgl_lantik,
            'tgl_berhenti' => $berhenti,
            'telp' => $request->getPost('telp'),
            'jekel' => $request->getPost('jekel'),
            'tgl_update' => date('Y-m-d')
        );
        $this->model->editPerangkat($data, $id_pemerintahan);
        session()->setFlashdata('pesan_perangkat', 'Data BPRN Berhasi Diedit.');
        return redirect()->to(base_url() . '/bprn/index');
    }

    public function delete($id_pemerintahan)
    {
        $getPerangkat = $this->model->getPerangkat($id_pemerintahan, 'BPRN');
        if (isset($getPerangkat)) {
            $this->model->hapusPerangkat($id_pemerintahan);
            session()->setFlashdata('pesan_perangkat', 'Data BPRN : ' . $getPerangkat->nama . ' berhasi dihapus.');
            return redirect()->to(base_url() . '/bprn/index');
        } else {
            session()->setFlashdata('warning_perangkat', 'Data BPRN tidak ditemukan.');
            return redirect()->to(base_url() . '/bprn/index');
        }
    }

    public function hapusbanyak()
    {
        $request = \Config\Services::request();
        $id_pemerintahan = $request->getPost('id_pemerintahan');
        if ($id_pemerintahan == null) {
            session()->setFlashdata('warning_perangkat', 'Data KAN belum dipilih, silahkan pilih data terlebih dahulu.');
            return redirect()->to(base_url() . '/bprn/index');
        }

        $jmldata = count($id_pemerintahan);
        for ($i = 0; $i < $jmldata; $i++) {
            $this->model->hapusPerangkat($id_pemerintahan[$i]);
        }

        session()->setFlashdata('pesan_perangkat', 'Data BPRN berhasil dihapus sebanyak ' . $jmldata . ' data.');
        return redirect()->to(base_url() . '/bprn/index');
    }

    public function import()
    {
        $ket = [
            'Import Data Badan Permusyawaratan Rakyat Nagari (BPRN)', '<li class="breadcrumb-item active"><a href="' . base_url() . '/bprn/index">Data Badan Permusyawaratan Rakyat Nagari (BPRN)</a></li>',
            '<li class="breadcrumb-item active">Import Data</li>'
        ];
        $data = [
            'title' => 'Import Data Badan Permusyawaratan Rakyat Nagari (BPRN)',
            'ket' => $ket,
            'link' => 'bprn',
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
            return redirect()->to(base_url() . '/bprn/import');
        }
        $spreadsheet = $render->load($file);
        $sheet = $spreadsheet->getActiveSheet()->toArray();

        foreach ($sheet as $x => $excel) {
            if ($x == 0) {
                continue;
            }

            // if (count($excel) != 8) {
            //     session()->setFlashdata('warning_perangkat', 'Data tidak lengkap / Format salah');
            //     return redirect()->to(base_url() . '/bprn/import');
            // }

            if ($excel[5] == '' or $excel[5] == '0000-00-00' or $excel[5] == '-') {
                $berhenti = NULL;
                $ket = 'Menjabat';
                $jabatan = $this->model->cek('BPRN', $excel[3], $excel[4], '0000-00-00');
                if ($jabatan != NULL) {
                    if ($excel[3] != 'Anggota') {
                        if ($excel[3] == $jabatan['jabatan'] and $excel[2] == $jabatan['nama']) {
                            continue;
                        }
                    } else {
                        $dup = $this->model->duplikat('BPRN', 'Anggota', $excel[4], '0000-00-00');
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
                }
            } else {
                $berhenti = $excel[5];
                $ket = 'Berhenti';
            }

            $jabatan = $this->model->cek('BPRN', $excel[3], $excel[4], $berhenti);
            if ($jabatan != NULL) {
                if ($excel[3] != 'Anggota') {
                    if ($excel[3] == $jabatan['jabatan'] and $excel[2] == $jabatan['nama']) {
                        continue;
                    }
                } else {
                    $dup = $this->model->duplikat('BPRN', 'Anggota', $excel[4], $berhenti);
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
                'no' => date('y', strtotime($excel[4])) . '-02-' . $excel[3],
                'nik' => $nik,
                'nama' => $excel[2],
                'jabatan' => $excel[3],
                'status' => 'BPRN',
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

        session()->setFlashdata('pesan_perangkat', 'Data BPRN berhasil diimport.');
        return redirect()->to(base_url() . '/bprn/index');
    }
}
