<?php

namespace App\Models;

use CodeIgniter\Model;
use Ramsey\Uuid\Uuid;

class KepalaDinasModel extends Model
{
    protected $allowedFields;

    public function __construct()
    {
        parent::__construct();
        // Get all the field names from the table
        $fields = $this->db->getFieldNames('kepala_dinas');

        // Build the allowedFields array
        foreach ($fields as $field) {
            if ($field != 'id') {
                $this->allowedFields[] = $field;
            }
        }
    }

    protected $table            = 'kepala_dinas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getKepalaDinas($id)
    {
        return $this->where(['id' => $id])->first();
    }

    public function getKepalaDinass()
    {
        return $this->findAll();
    }

    public function insertKepalaDinas($data)
    {
        $data['id'] = Uuid::uuid4()->toString();
        return $this->save($data);
    }

    public function updateKepalaDinas($data, $id)
    {
        return $this->update($id, $data);
    }

    public function deleteKepalaDinas($id)
    {
        return $this->delete($id);
    }
}
