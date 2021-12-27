<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $data =[
            'nama_sekolah' => 'UIB',
            'alamat'        =>  'Jl. raya'

        ];
        return view('v_home',$data);
    }

    public function about($id)
    {
        return 'Ini halaman about<br>'.$id;
    }
}
