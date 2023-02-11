<?php

namespace App\Models;

use CodeIgniter\Model;
use Ramsey\Uuid\Uuid;

class AbsensiModel extends Model
{
    protected $allowedFields;

    public function __construct()
    {
        parent::__construct();
        // Get all the field names from the table
        $fields = $this->db->getFieldNames('absensi');

        // Build the allowedFields array
        foreach ($fields as $field) {
            if ($field != 'id') {
                $this->allowedFields[] = $field;
            }
        }
    }

    protected $table            = 'absensi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getAbsensi($id)
    {
        return $this->where(['id' => $id])->first();
    }

    public function getAbsensis()
    {
        return $this->findAll();
    }

    public function insertAbsensi($data)
    {
        $data['id'] = Uuid::uuid4()->toString();
        return $this->save($data);
    }

    public function updateAbsensi($data, $id)
    {
        return $this->update($id, $data);
    }

    public function deleteAbsensi($id)
    {
        return $this->delete($id);
    }
}
