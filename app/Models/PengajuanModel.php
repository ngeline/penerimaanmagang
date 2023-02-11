<?php

namespace App\Models;

use CodeIgniter\Model;
use Ramsey\Uuid\Uuid;

class PengajuanModel extends Model
{
    protected $allowedFields;

    public function __construct()
    {
        parent::__construct();
        // Get all the field names from the table
        $fields = $this->db->getFieldNames('pengajuan');

        // Build the allowedFields array
        foreach ($fields as $field) {
            if ($field != 'id') {
                $this->allowedFields[] = $field;
            }
        }
    }

    protected $table            = 'pengajuan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getPengajuan($id)
    {
        return $this->where(['id' => $id])->first();
    }

    public function getPengajuans()
    {
        return $this->findAll();
    }

    public function insertPengajuan($data)
    {
        $data['id'] = Uuid::uuid4()->toString();
        return $this->save($data);
    }

    public function updatePengajuan($data, $id)
    {
        return $this->update($id, $data);
    }

    public function deletePengajuan($id)
    {
        return $this->delete($id);
    }
}
