<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KepalaDinasModel;

class KepalaDinasController extends BaseController
{
    public function index()
    {
        $data['activePage'] = 'adminDinas';
        $model = new KepalaDinasModel();
        $data['list'] = $model->orderBy('updated_at', 'desc')->findAll();

        return view('admin/dinas/index', $data);
    }

    public function update()
    {
        $data = $this->request->getPost();

        $id = $data['id'];

        $ttd = $this->request->getFile('ttd');

        $validation =  \Config\Services::validation();

        if ($ttd->isValid()) {
            $validation->setRules([
                'nama'  => [
                    'label' => 'Nama Kepala Dinas',
                    'rules' => 'required'
                ],
                'nip'  => [
                    'label' => 'NIP Kepala Dinas',
                    'rules' => 'required'
                ],
                'ttd'  => [
                    'label' => 'Tanda Tangan Kepala Dinas',
                    'rules' => 'uploaded[ttd]|max_size[ttd,1024]|ext_in[ttd,png]'
                ],
            ]);
        } else {
            $validation->setRules([
                'nama'  => [
                    'label' => 'Nama Kepala Dinas',
                    'rules' => 'required'
                ],
                'nip'  => [
                    'label' => 'NIP Kepala Dinas',
                    'rules' => 'required'
                ],
            ]);
        }

        if (!$validation->run($_POST)) {
            $errors = $validation->getErrors();
            $arr = implode("<br>", $errors);
            session()->setFlashdata("warning", $arr);
            return redirect()->to(base_url('admin/kepala-dinas'));
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
                'kepala_dinas' => $data['nama'],
                'nip' => $data['nip'],
                'ttd' => $name,
            ];
        } else {
            $data = [
                'kepala_dinas' => $data['nama'],
                'nip' => $data['nip'],
            ];
        }

        $model = new KepalaDinasModel();
        $model->updateKepalaDinas($data, $id);

        session()->setFlashdata("success", 'Berhasil memperbarui data!');
        return redirect()->to(base_url('admin/kepala-dinas'));
    }
}
