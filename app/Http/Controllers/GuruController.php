<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\GuruModel;

class GuruController extends Controller
{
    public function __construct()
    {
        $this->GuruModel = new GuruModel();
    }

    public function index()
    {
        $data = [
            'guru' => $this->GuruModel->allData(),
        ];

        return view('v_guru', $data);
    }

    public function detail($id_guru)
    {
        if (!$this->GuruModel->detailData($id_guru))
        {
            abort (404);
        }
        $data = [
            'guru' => $this->GuruModel->detailData($id_guru),
        ];

        return view('v_detailguru', $data);
    }

    public function add()
    {
        return view('v_addguru');
    }

    public function insert()
    {
        
        Request()->validate([
            'nip' => 'required|unique:tbl_guru,nip|min:4|max:255',
            'nama_guru' => 'required',
            'mapel' => 'required',
            'foto_guru' => 'required|mimes:jpg,jpeg,png|max:500000',
        ],[
            'nip.required' => 'wajib diisi!',
            'nip.unique' => 'Nip Ini Sudah Ada!',
            'nip.min' => 'minimal 5 karakter',
            'nip.max' => 'maksimal 255 karakter',
            'nama_guru.required' => 'wajib diisi!',
            'mapel.required' => 'wajib diisi!',
            'foto_guru.required' => 'wajib diisi!',
        ]);

        //jika validasi tidak ada maka lakukan simpan data

        //upload gambar
        $file = Request()->foto_guru;
        $fileName = Request()->nip.'.'.$file->extension();
        $file->move(public_path('foto_guru'),$fileName);

        $data = [
            'nip'=> Request()->nip,
            'nama_guru'=> Request()->nama_guru,
            'mapel'=> Request()->mapel,
            'foto_guru'=> $fileName,
        ];

        $this->GuruModel->addData($data);
        return redirect()->route('guru')->with('pesan','Data Berhasil Di Tambahkan !!!');

    }

    public function edit($id_guru)
    {
        if (!$this->GuruModel->detailData($id_guru))
        {
            abort (404);
        }
        $data = [
            'guru' => $this->GuruModel->detailData($id_guru),
        ];
        return view('v_editguru', $data);
    }

    public function update($id_guru)
    {
        
        Request()->validate([
            'nip' => 'required|min:4|max:255',
            'nama_guru' => 'required',
            'mapel' => 'required',
            'foto_guru' => 'mimes:jpg,jpeg,png|max:500000',
        ],[
            'nip.required' => 'wajib diisi!',            
            'nip.min' => 'minimal 5 karakter',
            'nip.max' => 'maksimal 255 karakter',
            'nama_guru.required' => 'wajib diisi!',
            'mapel.required' => 'wajib diisi!',
        ]);

        //jika validasi tidak ada maka lakukan simpan data
        if (Request ()->foto_guru <>""){
//upload gambar
//jika ingin ganti foto
$file = Request()->foto_guru;
$fileName = Request()->nip.'.'.$file->extension();
$file->move(public_path('foto_guru'),$fileName);

$data = [
    'nip'=> Request()->nip,
    'nama_guru'=> Request()->nama_guru,
    'mapel'=> Request()->mapel,
    'foto_guru'=> $fileName,
];
$this->GuruModel->editData($id_guru, $data);


        } else {
            //jika tidak ingin ganti foto
            $data = [
                'nip'=> Request()->nip,
                'nama_guru'=> Request()->nama_guru,
                'mapel'=> Request()->mapel,
                
            ];
            $this->GuruModel->editData($id_guru, $data);
        }
        
        return redirect()->route('guru')->with('pesan','Data Berhasil Di Ubah !!!');

    }

    public function delete($id_guru)
    {
        //hapus foto
        $guru = $this->GuruModel->detailData($id_guru);
        if($guru->foto_guru<>""){
            unlink(public_path('foto_guru').'/'.$guru->foto_guru);

        }
        $this->GuruModel->deleteData($id_guru);
        return redirect()->route('guru')->with('pesan','Data Berhasil Di Hapus !!!');
    }

}
