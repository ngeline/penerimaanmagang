<?php

namespace App\Models;

use CodeIgniter\Model;
use Ramsey\Uuid\Uuid;

class PengajuanAnggotaAnggotaModel extends Model
{
    protected $allowedFields;

    public function __construct()
    {
        parent::__construct();
        // Get all the field names from the table
        $fields = $this->db->getFieldNames('pengajuan_anggota');

        // Build the allowedFields array
        foreach ($fields as $field) {
            if ($field != 'id') {
                $this->allowedFields[] = $field;
            }
        }
    }

    protected $table            = 'pengajuan_anggota';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getPengajuanAnggota($id)
    {
        return $this->where(['id' => $id])->first();
    }

    public function getPengajuanAnggotas()
    {
        return $this->findAll();
    }

    public function insertPengajuanAnggota($data)
    {
        $data['id'] = Uuid::uuid4()->toString();
        return $this->save($data);
    }

    public function updatePengajuanAnggota($data, $id)
    {
        return $this->update($id, $data);
    }

    public function deletePengajuanAnggota($id)
    {
        return $this->delete($id);
    }
}
