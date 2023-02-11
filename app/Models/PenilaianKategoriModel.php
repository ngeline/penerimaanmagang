<?php

namespace App\Models;

use CodeIgniter\Model;
use Ramsey\Uuid\Uuid;

class PenilaianKategoriModel extends Model
{
    protected $allowedFields;

    public function __construct()
    {
        parent::__construct();
        // Get all the field names from the table
        $fields = $this->db->getFieldNames('kategori_penilaian');

        // Build the allowedFields array
        foreach ($fields as $field) {
            if ($field != 'id') {
                $this->allowedFields[] = $field;
            }
        }
    }

    protected $table            = 'kategori_penilaian';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getKategoriPenilaian($id)
    {
        return $this->where(['id' => $id])->first();
    }

    public function getKategoriPenilaians()
    {
        return $this->findAll();
    }

    public function insertKategoriPenilaian($data)
    {
        $data['id'] = Uuid::uuid4()->toString();
        return $this->save($data);
    }

    public function updateKategoriPenilaian($data, $id)
    {
        return $this->update($id, $data);
    }

    public function deleteKategoriPenilaian($id)
    {
        return $this->delete($id);
    }
}
