<?php

namespace App\Controllers;

use App\Models\AlamatModel;
use App\Models\GaleriModel;
use App\Models\PerangkatModel;
use App\Models\DataModel;
use App\Models\PotensiModel;
use App\Models\BeritaModel;
use App\Models\PendudukModel;

class Web extends BaseController
{
	public function __construct()
	{
		$this->alm =  new AlamatModel();
		$this->gal =  new GaleriModel();
		$this->perangkat =  new PerangkatModel();
		$this->data =  new DataModel();
		$this->potensi =  new PotensiModel();
		$this->berita =  new BeritaModel();
		$this->penduduk =  new PendudukModel();
	}

	public function index()
	{
		$x = [
			'icon' => $this->gal->gambar('Logo Icon')->x,
			'logo' => $this->gal->gambar('Logo Web')->x,
			'bg' => $this->gal->gambar('Bg Home')->x,
		];

		$kontak = $this->alm->getAlamat();
		$data = [
			'title' => 'Sistem Informasi Nagari',
			'link' => '',
			'judul' => 'Nagari Gunung Rajo',
			'gambar' => $x,
			'kontak' => $kontak,
			'ket' => $kontak->alm . ', Nagari ' . $kontak->nagari . ', Kec. ' . $kontak->kec . ', Kab. ' . $kontak->kab . ', ' . $kontak->prov . ', Indonesia, ' . $kontak->kd_pos,
			'direct' => $kontak->map_kantor,
			'wali' => $this->perangkat->wali(),
			'sambutan' => $this->data->getData(),
			'potensi' => $this->potensi->getPotensi(),
			'berita' => $this->berita->getBerita(false, 5)
		];
		// dd($this->perangkat->wali());
		return view('web/index', $data);
	}

	public function sambutan()
	{
		$x = [
			'icon' => $this->gal->gambar('Logo Icon')->x,
			'logo' => $this->gal->gambar('Logo Web')->x,
			'bg' => $this->gal->gambar('Bg Home')->x,
		];

		$kontak = $this->alm->getAlamat();
		$data = [
			'title' => 'Kata Sambutan',
			'link' => '',
			'judul' => 'Kata Sambutan',
			'gambar' => $x,
			'kontak' => $kontak,
			'wali' => $this->perangkat->wali(),
			'sambutan' => $this->data->getData(),
			'berita' => $this->berita->getBerita(false, 5)
		];
		return view('web/sambutan', $data);
	}

	public function isi($id_berita)
	{
		$data = $this->berita->getberita($id_berita);
		$x = [
			'icon' => $this->gal->gambar('Logo Icon')->x,
			'logo' => $this->gal->gambar('Logo Web')->x,
			'bg' => $this->gal->gambar('Bg Berita')->x,
		];

		$kontak = $this->alm->getAlamat();
		$data = [
			'title' => 'Berita' . $data->judul,
			'link' => '',
			'judul' => 'Isi Berita',
			'gambar' => $x,
			'kontak' => $kontak,
			'berita' => $this->berita->getBerita(false, 5),
			'data' => $this->berita->getBerita($id_berita)
		];
		return view('web/isiberita', $data);
	}

	public function sejarah()
	{
		$x = [
			'icon' => $this->gal->gambar('Logo Icon')->x,
			'logo' => $this->gal->gambar('Logo Web')->x,
			'bg' => $this->gal->gambar('Bg Sejarah')->x,
		];

		$kontak = $this->alm->getAlamat();
		$data = [
			'title' => 'Sejarah',
			'link' => 'web/sejarah',
			'judul' => 'Sejarah Nagari',
			'gambar' => $x,
			'kontak' => $kontak,
			'ket' => '',
			'direct' => '',
			'berita' => $this->berita->getBerita(false, 5),
			'data' => $this->data->getData(),
			'wali' => $this->perangkat->sejarah()
		];
		return view('web/sejarah', $data);
	}

	public function visi()
	{
		$x = [
			'icon' => $this->gal->gambar('Logo Icon')->x,
			'logo' => $this->gal->gambar('Logo Web')->x,
			'bg' => $this->gal->gambar('Bg Visi')->x,
		];

		$kontak = $this->alm->getAlamat();
		$data = [
			'title' => 'Visi & Misi',
			'link' => 'web/visi',
			'judul' => 'Visi & Misi',
			'gambar' => $x,
			'kontak' => $kontak,
			'ket' => '',
			'direct' => '',
			'berita' => $this->berita->getBerita(false, 5),
			'data' => $this->data->getData(),
		];
		return view('web/visi', $data);
	}

	public function wilayah()
	{
		$x = [
			'icon' => $this->gal->gambar('Logo Icon')->x,
			'logo' => $this->gal->gambar('Logo Web')->x,
			'bg' => $this->gal->gambar('Bg Wilayah')->x,
		];

		$kontak = $this->alm->getAlamat();
		$data = [
			'title' => 'Profile Wilayah',
			'link' => 'web/wilayah',
			'judul' => 'Profile Wilayah Administratif',
			'gambar' => $x,
			'kontak' => $kontak,
			'ket' => '',
			'direct' => '',
			'berita' => $this->berita->getBerita(false, 5),
			'alm' => $this->alm->getAlamat(),
			'data' => $this->data->getData(),
		];
		return view('web/wilayah', $data);
	}

	public function potensi()
	{
		$x = [
			'icon' => $this->gal->gambar('Logo Icon')->x,
			'logo' => $this->gal->gambar('Logo Web')->x,
			'bg' => $this->gal->gambar('Bg Home')->x,
		];

		$kontak = $this->alm->getAlamat();
		$data = [
			'title' => 'Potensi Nagari',
			'link' => '',
			'judul' => 'Potensi',
			'gambar' => $x,
			'kontak' => $kontak,
			'potensi' => $this->potensi->getPotensi(),
			'berita' => $this->berita->getBerita(false, 5)
		];
		return view('web/potensi', $data);
	}

	public function berita()
	{
		$x = [
			'icon' => $this->gal->gambar('Logo Icon')->x,
			'logo' => $this->gal->gambar('Logo Web')->x,
			'bg' => $this->gal->gambar('Bg Berita')->x,
		];

		$kontak = $this->alm->getAlamat();
		$data = [
			'title' => 'Berita',
			'link' => 'web/berita',
			'judul' => 'Berita',
			'gambar' => $x,
			'kontak' => $kontak,
			'ket' => '',
			'direct' => '',
			'berita' => $this->berita->getBerita(false, 5),
			'data' => $this->berita->orderBy('tgl_update', 'DESC')->paginate(10, 'data'),
			'pager' => $this->berita->pager
		];
		return view('web/berita', $data);
	}

	public function perangkat()
	{
		$x = [
			'icon' => $this->gal->gambar('Logo Icon')->x,
			'logo' => $this->gal->gambar('Logo Web')->x,
			'bg' => $this->gal->gambar('Bg Perangkat')->x,
		];

		$kontak = $this->alm->getAlamat();
		$data = [
			'title' => 'Perangkat Nagari',
			'link' => 'web/perangkat',
			'judul' => 'Perangkat Nagari',
			'gambar' => $x,
			'kontak' => $kontak,
			'ket' => '',
			'direct' => '',
			'berita' => $this->berita->getBerita(false, 5),
			'data' => $this->perangkat->data('Perangkat Nagari'),
		];
		return view('web/perangkat', $data);
	}

	public function kan()
	{
		$x = [
			'icon' => $this->gal->gambar('Logo Icon')->x,
			'logo' => $this->gal->gambar('Logo Web')->x,
			'bg' => $this->gal->gambar('Bg KAN')->x,
		];

		$kontak = $this->alm->getAlamat();
		$data = [
			'title' => 'KAN',
			'link' => 'web/kan',
			'judul' => 'KAN',
			'gambar' => $x,
			'kontak' => $kontak,
			'ket' => '',
			'direct' => '',
			'berita' => $this->berita->getBerita(false, 5),
			'data' => $this->perangkat->data('KAN'),
		];
		// dd($data);
		return view('web/perangkat', $data);
	}

	public function bprn()
	{
		$x = [
			'icon' => $this->gal->gambar('Logo Icon')->x,
			'logo' => $this->gal->gambar('Logo Web')->x,
			'bg' => $this->gal->gambar('Bg BPRN')->x,
		];

		$kontak = $this->alm->getAlamat();
		$data = [
			'title' => 'BPRN',
			'link' => 'web/bprn',
			'judul' => 'BPRN',
			'gambar' => $x,
			'kontak' => $kontak,
			'ket' => '',
			'direct' => '',
			'berita' => $this->berita->getBerita(false, 5),
			'data' => $this->perangkat->data('BPRN'),
		];
		return view('web/perangkat', $data);
	}

	public function bundo()
	{
		$x = [
			'icon' => $this->gal->gambar('Logo Icon')->x,
			'logo' => $this->gal->gambar('Logo Web')->x,
			'bg' => $this->gal->gambar('Bg Bundo')->x,
		];

		$kontak = $this->alm->getAlamat();
		$data = [
			'title' => 'Bundo Kanduang',
			'link' => 'web/bundo',
			'judul' => 'Bundo Kanduang',
			'gambar' => $x,
			'kontak' => $kontak,
			'ket' => '',
			'direct' => '',
			'berita' => $this->berita->getBerita(false, 5),
			'data' => $this->perangkat->data('Bundo Kanduang'),
		];
		return view('web/perangkat', $data);
	}

	public function ulama()
	{
		$x = [
			'icon' => $this->gal->gambar('Logo Icon')->x,
			'logo' => $this->gal->gambar('Logo Web')->x,
			'bg' => $this->gal->gambar('Bg Ulama')->x,
		];

		$kontak = $this->alm->getAlamat();
		$data = [
			'title' => 'Alim Ulama',
			'link' => 'web/ulama',
			'judul' => 'Alim Ulama',
			'gambar' => $x,
			'kontak' => $kontak,
			'ket' => '',
			'direct' => '',
			'berita' => $this->berita->getBerita(false, 5),
			'data' => $this->perangkat->data('Alim Ulama'),
		];
		return view('web/perangkat', $data);
	}

	public function cadiak()
	{
		$x = [
			'icon' => $this->gal->gambar('Logo Icon')->x,
			'logo' => $this->gal->gambar('Logo Web')->x,
			'bg' => $this->gal->gambar('Bg Cadiak')->x,
		];

		$kontak = $this->alm->getAlamat();
		$data = [
			'title' => 'Cadiak Pandai',
			'link' => 'web/cadiak',
			'judul' => 'Cadiak Pandai',
			'gambar' => $x,
			'kontak' => $kontak,
			'ket' => '',
			'direct' => '',
			'berita' => $this->berita->getBerita(false, 5),
			'data' => $this->perangkat->data('Cadiak Pandai'),
		];
		return view('web/perangkat', $data);
	}

	public function pemuda()
	{
		$x = [
			'icon' => $this->gal->gambar('Logo Icon')->x,
			'logo' => $this->gal->gambar('Logo Web')->x,
			'bg' => $this->gal->gambar('Bg Pemuda')->x,
		];

		$kontak = $this->alm->getAlamat();
		$data = [
			'title' => 'Pemuda',
			'link' => 'web/pemuda',
			'judul' => 'Pemuda',
			'gambar' => $x,
			'kontak' => $kontak,
			'ket' => '',
			'direct' => '',
			'berita' => $this->berita->getBerita(false, 5),
			'data' => $this->perangkat->data('Pemuda Nagari'),
		];
		return view('web/perangkat', $data);
	}

	public function data()
	{
		$x = [
			'icon' => $this->gal->gambar('Logo Icon')->x,
			'logo' => $this->gal->gambar('Logo Web')->x,
			'bg' => $this->gal->gambar('Bg Kontak')->x,
		];

		$kontak = $this->alm->getAlamat();
		$data = [
			'title' => 'Data Nagari',
			'link' => 'web/data',
			'judul' => 'Data Nagari',
			'gambar' => $x,
			'kontak' => $kontak,
			'ket' => '',
			'direct' => '',
			'berita' => $this->berita->getBerita(false, 5),
			'data' => '',
			'g' => $this->penduduk->tot('penduduk', false, false, 'Jorong Gantiang'),
			'gru' => $this->penduduk->tot('penduduk', false, false, 'Jorong Gunuang Rajo Utara'),
			'penduduk' => $this->penduduk->tot('penduduk')
		];

		$y = date('Y');
		$l = array($y - 4, $y - 3, $y - 2, $y - 1, $y);
		for ($i = 0; $i < 5; $i++) {
			$rubah[$i] = $this->penduduk->tot('penduduk', $l[$i]);
			$rubah_g[$i] = $this->penduduk->tot('penduduk', $l[$i], false, 'Jorong Gantiang');
			$rubah_gru[$i] = $this->penduduk->tot('penduduk', $l[$i], false, 'Jorong Gunuang Rajo Utara');
		}
		$data['rubah'] = $rubah;
		$data['rubah_g'] = $rubah_g;
		$data['rubah_gru'] = $rubah_gru;

		$pendidikan = [
			'Tidak/Belum Sekolah', 'Belum Tamat SD/Sederajat', 'SD/Sederajat', 'SLTP/Sederajat', 'SLTA/Sederajat', 'DI/DII', 'DIII/Akademik', 'S1', 'S2', 'S3',
		];
		for ($i = 0; $i < count($pendidikan); $i++) {
			$pen[$i] = $pendidikan[$i];
			$isi_p[$i] = $this->penduduk->count('pendidikan', $pen[$i]);
		}
		$data['pen'] = $pen;
		$data['isi_p'] = $isi_p;

		$pekerjaan = [
			'Belum/Tidak Bekerja', 'Mengurus Rumah Tangga', 'Pelajar/Mahasiswa', 'Pensiunan', 'Pegawai Negeri Sipil', 'Tentara Nasional Indonesia', 'Kepolisian RI',
			'Perdagangan', 'Petani/Pekebun', 'Peternak', 'Nelayan/Perikanan', 'Industri', 'Konstruksi', 'Transportasi', 'Karyawan Swasta', 'Karyawan BUMN', 'Karyawan BUMD',
			'Karyawan Honorer', 'Buruh Harian Lepas', 'Buruh Tani/Perkebunan', 'Buruh Nelayan/Perikanan', 'Buruh Peternakan', 'Pembantu Rumah Tangga', 'Tukang Cukur',
			'Tukang Listrik', 'Tukang Batu', 'Tukang Kayu', 'Tukang Sol Sepatu', 'Tukang Las/Pandai Besi', 'Tukang Jahit', 'Tukang Gigi', 'Penata Rias', 'Penata Busana',
			'Penata Rambut', 'Mekanik', 'Seniman', 'Tabib', 'Paraji', 'Perancang Busana', 'Penterjemah', 'Imam Masjid', 'Pendeta', 'Pastor', 'Wartawan', 'Ustadz/Mubaligh',
			'Juru Masak', 'Promotor Acara', 'Anggota DPR RI', 'Anggota DPD', 'Anggota BPK', 'Presiden', 'Wakil Presiden', 'Anggota Mahkamah Konstitusi',
			'Anggota Kabinet/Kementerian', 'Duta Besar', 'Gubernur', 'Wakil Gubenur', 'Bupati', 'Wakil Bupati', 'Walikota', 'Wakil Walikota', 'Anggota DPRD Prvinsi',
			'Anggota DPRD Kabupaten/Kota', 'Dosen', 'Guru', 'Guru Honorer', 'Pilot', 'Pengacara', 'Notaris', 'Arsitek', 'Akuntan', 'Konsultan', 'Dokter', 'Bidan', 'Perawat',
			'Apoteker', 'Psikiater/Psikolog', 'Penyiar Televisi', 'Penyiar Radio', 'Pelaut', 'Peneliti', 'Sopir', 'Pialang', 'Paranormal', 'Pedagang', 'Perangkat Desa',
			'Kepala Desa', 'Biarawati', 'Wiraswasta',
		];
		$c = 0;
		for ($i = 0; $i < count($pekerjaan); $i++) {
			if ($this->penduduk->count('kerja', $pekerjaan[$i]) != 0) {
				$kerja[$c]['nama'] = $pekerjaan[$i];
				$kerja[$c]['tot'] = $this->penduduk->count('kerja', $pekerjaan[$i]);
				$c++;
			}
		}
		$data['kerja'] = $kerja;

		$agama = [
			'Islam', 'Protestan', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu',
		];
		for ($i = 0; $i < count($agama); $i++) {
			$agm[$i] = $agama[$i];
			$isi_a[$i] = $this->penduduk->count('agama', $agm[$i]);
		}
		$data['agm'] = $agm;
		$data['isi_a'] = $isi_a;

		$data['laki'] = $this->penduduk->totjekel('penduduk', "Laki - Laki", false, false, false);
		$data['perempuan'] = $this->penduduk->totjekel('penduduk', "Perempuan", false, false, false);

		$data['laki_g'] = $this->penduduk->totjekel('penduduk', "Laki - Laki", false, false, 'Jorong Gantiang');
		$data['perempuan_g'] = $this->penduduk->totjekel('penduduk', "Perempuan", false, false, 'Jorong Gantiang');

		$data['laki_gru'] = $this->penduduk->totjekel('penduduk', "Laki - Laki", false, false, 'Jorong Gunuang Rajo Utara');
		$data['perempuan_gru'] = $this->penduduk->totjekel('penduduk', "Perempuan", false, false, 'Jorong Gunuang Rajo Utara');

		$data['umur'] = array(
			count($this->penduduk->jmlUmur(0, 5)),
			count($this->penduduk->jmlUmur(6, 12)),
			count($this->penduduk->jmlUmur(13, 16)),
			count($this->penduduk->jmlUmur(17, 25)),
			count($this->penduduk->jmlUmur(26, 35)),
			count($this->penduduk->jmlUmur(36, 45)),
			count($this->penduduk->jmlUmur(46, 55)),
			count($this->penduduk->jmlUmur(56, 65)),
			count($this->penduduk->jmlUmurTua(65)),
		);
		return view('web/data', $data);
	}

	public function kontak()
	{
		$x = [
			'icon' => $this->gal->gambar('Logo Icon')->x,
			'logo' => $this->gal->gambar('Logo Web')->x,
			'bg' => $this->gal->gambar('Bg Kontak')->x,
		];

		$kontak = $this->alm->getAlamat();
		$data = [
			'title' => 'Kontak',
			'link' => 'web/kontak',
			'judul' => 'Kontak',
			'gambar' => $x,
			'kontak' => $kontak,
			'ket' => '',
			'direct' => '',
			'data' => $this->alm->getAlamat(),
		];
		return view('web/kontak', $data);
	}

	public function sosmed()
	{
		$x = [
			'icon' => $this->gal->gambar('Logo Icon')->x,
			'logo' => $this->gal->gambar('Logo Web')->x,
			'bg' => $this->gal->gambar('Bg Kontak')->x,
		];

		$kontak = $this->alm->getAlamat();
		$data = [
			'title' => 'Sosial Media',
			'link' => 'web/sosmed',
			'judul' => 'Sosial Media',
			'gambar' => $x,
			'kontak' => $kontak,
			'ket' => '',
			'direct' => '',
			'data' => $this->alm->getAlamat(),
		];
		return view('web/sosmed', $data);
	}

	public function surat()
	{
		$x = [
			'icon' => $this->gal->gambar('Logo Icon')->x,
			'logo' => $this->gal->gambar('Logo Web')->x,
			'bg' => $this->gal->gambar('Bg Kontak')->x,
		];

		$kontak = $this->alm->getAlamat();
		$data = [
			'title' => 'Surat',
			'judul' => 'Surat',
			'gambar' => $x,
			'kontak' => $kontak,
			'ket' => '',
			'direct' => '',
			'berita' => $this->berita->getBerita(false, 5),
			'data' => $this->data->getData(),
		];
		return view('web/surat', $data);
	}
}
