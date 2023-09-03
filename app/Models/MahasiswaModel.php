<?php

namespace App\Models;

use CodeIgniter\Model;

class MahasiswaModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tb_mhs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama', 'nim', 'jen_kel', 'kelas', 'prodi', 'foto'
    ];

    public function getAll()
    {
        $GetData = "SELECT tb_mhs.*, tb_prodi.prodi AS nama_prodi FROM tb_mhs LEFT JOIN tb_prodi ON tb_mhs.prodi = tb_prodi.id";
        $GetData = $this->db->query($GetData)->getResultObject();
        return $GetData;
        // return $this->db->table('tb_mhs')->join('tb_prodi', 'tb_prodi.id = tb_mhs.prodi')->get()->getResultObject();
    }

    public function TambahDataMahasiswa($simpandata)
    {
        return $this->db->table('tb_mhs')->insert($simpandata);
    }

    public function UpdateDataMahasiswa($id, $ubahdata)
    {
        return $this->update($id, $ubahdata);
    }

    public function HapusDataMahasiswa($id)
    {
        return $this->delete(["id" => $id]);
    }
}
