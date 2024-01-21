<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\ProfilUsaha;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfilUsahaController extends Controller
{
    public function index(){

        $data = DB::table('profil_usahas')->first();

        return view('backend.profil_usaha.index', [
            'data'  => $data
        ]);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'nama_usaha' => 'required',
        ]);

        if ($validator->fails()) {
            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];
        } else {
            $data = ProfilUsaha::updateOrCreate(
            [
                'id' => $request->id
            ],
            [
                'nama_usaha' => $request->nama_usaha,
                'alamat' => $request->alamat,
                'keterangan' => $request->keterangan, 
                'no_telp' => $request->no_telp
            ]);

            $data = [
                'responCode' => 1,
                'respon' => 'Data Sukses Ditambah'
            ];
        }

        return response()->json($data);
    }
}
