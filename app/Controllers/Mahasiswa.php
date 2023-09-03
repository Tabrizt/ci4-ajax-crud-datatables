<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MahasiswaModel;
use App\Models\ProdiModel;


class Mahasiswa extends BaseController
{
  protected $mahasiswa;
  protected $prodi;
  protected $validation;

  public function __construct()
  {
    $this->mahasiswa = new MahasiswaModel();
    $this->prodi = new ProdiModel();
    $this->validation = \Config\Services::validation();
  }

  public function index()
  {
    $data = [
      'title' => 'Home | Datatables',
      'prodi' => $this->prodi->findAll()
    ];

    return view('mahasiswa/index', $data);
  }

  public function getAll()
  {
    $response = $data['data'] = array();

    $result = $this->mahasiswa->getAll();
    // var_dump($result);
    // die();
    //select()->findAll();
    $no = 1;
    foreach ($result as $key => $value) {
      $ops = '<tr>';
      $ops .= '<a class="btn btn-success" onClick="EditMahasiswa(' . $value->id . ')"><i class="fas fa-pencil-alt"></i></a>';
      $ops .= '<a class="btn btn-danger text-white" onClick="HapusMahasiswa(' . $value->id . ')"><i class="fas fa-trash-alt"></i></a>';
      $ops .= '</tr>';
      $img = '<img src="/img/' . $value->foto . '" style="width: 100px;" />';
      $data['data'][$key] = array(
        $no,
        $value->nama,
        $value->nim,
        $value->jen_kel,
        $value->kelas,
        $value->nama_prodi,
        $img,
        $ops
      );
      $no++;
    }
    return $this->response->setJSON($data);
  }

  public function getOne()
  {
    $id = $this->request->getPost('id');

    if ($this->validation->check($id, 'required|numeric')) {

      $data = $this->mahasiswa->where('id', $id)->first();

      return $this->response->setJSON($data);
    } else {
      throw new \CodeIgniter\Exceptions\PageNotFoundException();
    }
  }

  public function TambahMahasiswa()
  {
    if ($this->request->isAJAX()) {

      $valid = $this->validate([
        'nama_mhs' => [
          'label' => 'Nama Mahasiswa',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong!!'
          ]
        ],

        'nim_mhs' => [
          'label' => 'Nomor Induk Mahasiswa',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong!!'
          ]
        ],

        'jenkel_mhs' => [
          'label' => 'Jenis Kelamin',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} harus dipilih!!'
          ]
        ],

        'prodi_mhs' => [
          'label' => 'Program Studi',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} harus dipilih!!'
          ]
        ],

        'kelas_mhs' => [
          'label' => 'Kelas',
          'rules' => 'required',
          'errors' => [
            'required' => '{field} tidak boleh kosong!!'
          ]
        ],

        'foto_mhs' => [
          'label' => 'Foto',
          'rules' => 'max_size[foto_mhs,5120]|is_image[foto_mhs]|mime_in[foto_mhs,image/jpg,image/jpeg,image/png]',
          'errors' => [
            'max_size' => 'Ukuran {field} terlalu besar!!',
            'is_image' => 'Yang anda pilih bukan {field}!!',
            'mime_in' => 'Yang anda pilih bukan {field}!!',
          ]
        ],
      ]);

      if (!$valid) {
        $msg = [
          'error' => [
            'nama_mhs' => $this->validation->getError('nama_mhs'),
            'nim_mhs' => $this->validation->getError('nim_mhs'),
            'jenkel_mhs' => $this->validation->getError('jenkel_mhs'),
            'prodi_mhs' => $this->validation->getError('prodi_mhs'),
            'kelas_mhs' => $this->validation->getError('kelas_mhs'),
            'foto_mhs' => $this->validation->getError('foto_mhs')
          ]
        ];

        echo json_encode($msg);
      } else {
        // ambil gambar
        $fileFoto = $this->request->getFile('foto_mhs');

        if ($fileFoto->getError() == 4) {
          $namaFoto = 'default.jpg';
        } else {
          // generate nama sampul
          $namaFoto = $fileFoto->getRandomName();

          // pindahkan file ke folder img
          $fileFoto->move('img', $namaFoto);
        }

        // var_dump($namaFoto);
        // die();

        $simpandata = [
          'nama' => $this->request->getPost('nama_mhs'),
          'nim' => $this->request->getPost('nim_mhs'),
          'jen_kel' => $this->request->getPost('jenkel_mhs'),
          'kelas' => $this->request->getPost('kelas_mhs'),
          'prodi' => $this->request->getPost('prodi_mhs'),
          'foto' => $namaFoto,
        ];

        $status = $this->mahasiswa->TambahDataMahasiswa($simpandata);

        if ($status) {
          $respon = [
            'status' => true,
            'msg' => 'Data anda berhasil ditambah!!'
          ];
        } else {
          $respon = [
            'status' => false,
            'msg' => 'Maaf, data anda gagal ditambah!!'
          ];
        }

        echo json_encode($respon);
      }
    }
  }

  public function UpdateMahasiswa()
  {
    if ($this->request->isAJAX()) {

      $id = $this->request->getPost('id');

      $valid = $this->validate([
        'foto_mhs' => [
          'label' => 'Foto',
          'rules' => 'max_size[foto_mhs,5120]|is_image[foto_mhs]|mime_in[foto_mhs,image/jpg,image/jpeg,image/png]',
          'errors' => [
            'max_size' => 'Ukuran {field} terlalu besar!!',
            'is_image' => 'Yang anda pilih bukan {field}!!',
            'mime_in' => 'Yang anda pilih bukan {field}!!',
          ]
        ],
      ]);

      if (!$valid) {
        $msg = [
          'error' => [
            'u_foto_mhs' => $this->validation->getError('foto_mhs'),
          ]
        ];
        echo json_encode($msg);
      } else {
        // ambil gambar
        $fileFoto = $this->request->getFile('foto_mhs');

        if ($fileFoto->getError() == 4) {
          $namaFoto = $this->request->getPost('ofoto_mhs');
          // var_dump($namaFoto);
          // die();
        } else {
          // generate nama sampul
          $namaFoto = $fileFoto->getRandomName();

          // pindahkan file ke folder img
          $fileFoto->move('img', $namaFoto);

          // hapus file lama
          // unlink('img/' . $this->request->getPost('ofoto_mhs'));
        }


        // $kelas = $this->request->getPost('kelas_mhs');
        // var_dump($kelas);
        // die();

        $ubahdata = [
          'nama' => $this->request->getPost('nama_mhs'),
          'nim' => $this->request->getPost('nim_mhs'),
          'jen_kel' => $this->request->getPost('jenkel_mhs'),
          'kelas' => $this->request->getPost('kelas_mhs'),
          'prodi' => $this->request->getPost('prodi_mhs'),
          'foto' => $namaFoto,
        ];

        $status = $this->mahasiswa->UpdateDataMahasiswa($id, $ubahdata);

        if ($status) {
          $respon = [
            'status' => true,
            'msg' => 'Data anda berhasil diubah!!'
          ];
        } else {
          $respon = [
            'status' => false,
            'msg' => 'Maaf, data anda gagal diubah!!'
          ];
        }

        echo json_encode($respon);
      }
    }
  }

  public function HapusMahasiswa()
  {
    if ($this->request->isAJAX()) {
      $id = $this->request->getPost('id');

      $status = $this->mahasiswa->HapusDataMahasiswa($id);

      if ($status) {
        $respon = [
          'status' => true,
          'msg' => 'Data anda berhasil dihapus!!'
        ];
      } else {
        $respon = [
          'status' => false,
          'msg' => 'Maaf, data anda gagal dihapus!!'
        ];
      }

      echo json_encode($respon);
    }
  }
}
