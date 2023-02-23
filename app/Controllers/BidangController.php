<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BidangModel;

class BidangController extends BaseController
{
    public function __construct()
    {
        helper(['form', 'url', 'validation', 'session']);
    }

    public function index()
    {
        $data['activePage'] = 'adminBidang';
        $model = new BidangModel();
        $data['list'] = $model->where('status_hapus', 'tidak')->orderBy('updated_at', 'desc')->findAll();
        return view('admin/bidang/index', $data);
    }

    public function update()
    {
        $data = $this->request->getPost();

        $id = $data['id'];

        $ttd = $this->request->getFile('ttd');

        $validation =  \Config\Services::validation();

        if ($ttd->isValid()) {
            $validation->setRules([
                'singkatan'  => [
                    'label' => 'Singkatan Bidang',
                    'rules' => 'required'
                ],
                'kepala'  => [
                    'label' => 'Kepala Bidang',
                    'rules' => 'required'
                ],
                'nip'  => [
                    'label' => 'NIP Kepala Bidang',
                    'rules' => 'required'
                ],
                'ttd'  => [
                    'label' => 'Tanda Tangan Kepala Bidang',
                    'rules' => 'uploaded[ttd]|max_size[ttd,1024]|ext_in[ttd,png]'
                ],
                'keterangan' => [
                    'label' => 'Keterangan',
                    'rules' => 'required'
                ],
            ]);
        } else {
            $validation->setRules([
                'singkatan'  => [
                    'label' => 'Singkatan Bidang',
                    'rules' => 'required'
                ],
                'kepala'  => [
                    'label' => 'Kepala Bidang',
                    'rules' => 'required'
                ],
                'nip'  => [
                    'label' => 'NIP Kepala Bidang',
                    'rules' => 'required'
                ],
                'keterangan' => [
                    'label' => 'Keterangan',
                    'rules' => 'required'
                ],
            ]);
        }

        if (!$validation->run($_POST)) {
            $errors = $validation->getErrors();
            $arr = implode("<br>", $errors);
            session()->setFlashdata("warning", $arr);
            return redirect()->to(base_url('admin/bidang'));
        }

        // Check if the file was uploaded successfully
        if ($ttd->isValid() && !$ttd->hasMoved()) {
            // Move the file to a new location
            $name =  time() . $ttd->getName();

            $image = \Config\Services::image();

            $image->withFile($ttd)
                ->resize(150, 75, false, 'height')
                ->save(FCPATH . '/assets/file/ttd/' . $name);
        }

        if ($ttd->isValid()) {
            $data = [
                'singkatan_bidang' => $data['singkatan'],
                'kepala_bidang' => $data['kepala'],
                'nip' => $data['nip'],
                'ttd' => $name,
                'keterangan' => $data['keterangan']
            ];
        } else {
            $data = [
                'singkatan_bidang' => $data['singkatan'],
                'kepala_bidang' => $data['kepala'],
                'nip' => $data['nip'],
                'keterangan' => $data['keterangan']
            ];
        }

        $model = new BidangModel();
        $model->updateBidang($data, $id);

        session()->setFlashdata("success", 'Berhasil memperbarui data!');
        return redirect()->to(base_url('admin/bidang'));
    }
}
