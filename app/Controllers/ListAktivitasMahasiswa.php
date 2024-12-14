<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ListAktivitasMahasiswa as ModelsListAktivitasMahasiswa;

class ListAktivitasMahasiswa extends BaseController
{
    public function index()
    {
        $data = [
            'list_aktivitas_mahasiswa' => $this->getListAktivitasMahasiswa()
        ];
        return view('list_aktivitas_mahasiswa', $data);
    }

    public function getListAktivitasMahasiswa()
    {
        $listAktivitasMahasiswa = new ModelsListAktivitasMahasiswa();
        return $listAktivitasMahasiswa->findAll();
    }

    public function save()
    {
        $validation =  \Config\Services::validation();
        $validation->setRules([
            'nm_asaldata' => 'required'
        ]);

        $isValid = $validation->withRequest($this->request)->run();

        if ($isValid) {
            $idAktivitas = $this->request->getPost('id_aktivitas');

            $listAktivitasMahasiswa = new ModelsListAktivitasMahasiswa();

            $data = [
                'id_aktivitas' => $listAktivitasMahasiswa->generateUUID(),
                'nm_asaldata' => $this->request->getPost('nm_asaldata'),
                'asal_data' => $this->request->getPost('asal_data'),
                'program_mbkm' => $this->request->getPost('program_mbkm'),
                'nama_program_mbkm' => $this->request->getPost('nama_program_mbkm'),
                'jenis_anggota' => $this->request->getPost('jenis_anggota'),
                'nama_jenis_anggota' => $this->request->getPost('nama_jenis_anggota'),
                'id_jenis_aktivitas' => $this->request->getPost('id_jenis_aktivitas'),
                'nama_jenis_aktivitas' => $this->request->getPost('nama_jenis_aktivitas'),
                'id_prodi' => $this->request->getPost('id_prodi'),
                'nama_prodi' => $this->request->getPost('nama_prodi'),
                'id_semester' => $this->request->getPost('id_semester'),
                'nama_semester' => $this->request->getPost('nama_semester'),
                'judul' => $this->request->getPost('judul'),
                'keterangan' => $this->request->getPost('keterangan'),
                'lokasi' => $this->request->getPost('lokasi'),
                'sk_tugas' => $this->request->getPost('sk_tugas'),
                'sumber_data' => $this->request->getPost('sumber_data'),
                'tanggal_sk_tugas' => $this->request->getPost('tanggal_sk_tugas'),
                'tanggal_mulai' => $this->request->getPost('tanggal_mulai'),
                'tanggal_selesai' => $this->request->getPost('tanggal_selesai'),
                'untuk_kampus_merdeka' => $this->request->getPost('untuk_kampus_merdeka'),
                'status_sync' => $this->request->getPost('status_sync'),
            ];

            if (empty($idAktivitas)) {
                $listAktivitasMahasiswa->insert($data);
            } else {
                $listAktivitasMahasiswa->update($idAktivitas, $data);
            }

            return redirect()->to('table/list-aktivitas-mahasiswa');
        } else {
            echo view('list_aktivitas_mahasiswa', [
                'errors' => $validation->getErrors(),
                'list_aktivitas_mahasiswa' => $this->getListAktivitasMahasiswa()
            ]);
        }
    }

    public function delete($id)
    {
        $listAktivitasMahasiswa = new ModelsListAktivitasMahasiswa();
        $listAktivitasMahasiswa->delete($id);
        return redirect()->to('table/list-aktivitas-mahasiswa');
    }
}
