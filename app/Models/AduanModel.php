<?php

namespace App\Models;

use CodeIgniter\Model;

class AduanModel extends Model
{
    protected $table = 'aduan';

    public function getAduan($id = false, $id_aduan = false, $hasil = false)
    {
        if ($id != false and $id_aduan == false and $hasil == false) {
            return $this->where('id_user', $id)->orderBy('id_aduan', 'DESC')->findAll();
        } elseif ($id == false and $id_aduan == false and $hasil != false) {
            return $this->where('ket', $hasil)->orderBy('id_aduan', 'DESC')->findAll();
        } elseif ($id == false and $id_aduan != false and $hasil == false) {
            return $this->where('id_aduan', $id_aduan)->get()->getRow();
        }
    }

    public function saveAduan($data)
    {
        $builder = $this->db->table($this->table);
        return $builder->insert($data);
    }

    public function editAduan($data, $id_aduan)
    {
        $builder = $this->db->table($this->table);
        $builder->where('id_aduan', $id_aduan);
        return $builder->update($data);
    }

    public function hapusAduan($id_aduan)
    {
        $builder = $this->db->table($this->table);
        return $builder->delete(['id_aduan' => $id_aduan]);
    }

    public function count($year, $bulan)
    {
        return $this->db->table('aduan')->where("year(tgl_aduan)", $year)->where("month(tgl_aduan)", $bulan)->countAllResults();
    }

    public function countket($ket, $bulan, $year)
    {
        return $this->db->table('aduan')->where('ket', $ket)->where("year(tgl_respon)", $year)->where("month(tgl_respon)", $bulan)->countAllResults();
    }
}
