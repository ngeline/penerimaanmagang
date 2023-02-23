<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BidangModel;

class BidangController extends BaseController
{
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

        $validation =  \Config\Services::validation();
        $validation->setRules([
            'keterangan' => [
                'label' => 'Keterangan',
                'rules' => 'required'
            ],
        ]);

        if (!$validation->run($_POST)) {
            $errors = $validation->getErrors();
            $arr = implode("<br>", $errors);
            session()->setFlashdata("warning", $arr);
            return redirect()->to(base_url('admin/bidang'));
        }

        $data = [
            'keterangan' => $data['keterangan']
        ];

        $model = new BidangModel();
        $model->updateBidang($data, $id);

        session()->setFlashdata("success", 'Berhasil memperbarui data!');
        return redirect()->to(base_url('admin/bidang'));
    }
}
