<?php

namespace App\Models;

use CodeIgniter\Model;

class MohonModel extends Model
{
    protected $table = 'permohonan';

    public function getMohon($id = false, $id_permohonan = false, $hasil = false)
    {
        if ($id != false and $id_permohonan == false and $hasil == false) { // Semua data
            return $this->where('id_user', $id)->orderBy('id_permohonan', 'DESC')->findAll();
        } elseif ($id == false and $id_permohonan == false and $hasil != false) { // Semua data berdasarkan hasil
            return $this->db->table($this->table)
                ->join('penduduk', 'penduduk.id_penduduk = permohonan.id_penduduk')
                ->where('permohonan.ket', $hasil)
                ->orderBy('id_permohonan', 'DESC')
                ->get()->getResultArray();
            // return $this->where('ket', $hasil)->orderBy('id_permohonan', 'DESC')->findAll();
        } elseif ($id == false and $id_permohonan != false and $hasil == false) { // Salah satu data
            return $this->getWhere(['id_permohonan' => $id_permohonan])->getRow();
        }
    }

    public function saveMohon($data)
    {
        $builder = $this->db->table($this->table);
        return $builder->insert($data);
    }

    public function editMohon($data, $id_permohonan)
    {
        $builder = $this->db->table($this->table);
        $builder->where('id_permohonan', $id_permohonan);
        return $builder->update($data);
    }

    public function hapusMohon($id_permohonan)
    {
        $builder = $this->db->table($this->table);
        return $builder->delete(['id_permohonan' => $id_permohonan]);
    }

    // Count Mohon
    public function count($srt)
    {
        return $this->db->table('permohonan')->where('jenis', $srt)->countAllResults();
    }

    public function countjenis($srt, $bulan, $tahun)
    {
        return $this->db->table('permohonan')->where('jenis', $srt)->where('year(tgl_masuk) = ', $tahun)->where('month(tgl_masuk) = ', $bulan)->countAllResults();
    }

    public function countall($srt, $bulan, $tahun)
    {
        return $this->db->table('permohonan')->where('ket', $srt)->where('year(tgl_periksa) = ', $tahun)->where('month(tgl_periksa) = ', $bulan)->countAllResults();
    }

    public function ket($srt, $jen, $bulan, $tahun)
    {
        return $this->db->table('permohonan')->where('ket', $srt)->where('jenis', $jen)->where('year(tgl_periksa) = ', $tahun)->where('month(tgl_periksa) = ', $bulan)->countAllResults();
    }
}
