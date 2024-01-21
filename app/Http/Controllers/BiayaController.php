<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;
use App\Models\Biaya;
use Illuminate\Support\Facades\Validator;

class BiayaController extends Controller
{
    public function index(){

        $q = Request('q');
        $data = DB::table('biayas');

        if ($q) {
            $data = $data->where('biaya_untuk', 'like', '%' . $q . '%')
                    ->orderBy('id', 'DESC')
                    ->paginate(10);
        } else {
            $data = $data->orderBy('id', 'DESC')->paginate(10);
        }

        return view('backend.biaya.index', [
            'data'  => $data
        ]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nama_biaya' => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];
        } else {
            $data = Biaya::create([
                'nama_biaya' => $request->nama_biaya, 
                'biaya_untuk' => $request->biaya_untuk, 
                'biaya' => $request->biaya
            ]);

            $data = [
                'responCode' => 1,
                'respon' => 'Data Sukses Ditambah'
            ];
        }

        return response()->json($data);
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];
        } else {

            $user = Biaya::find($request->id);
            $data = $user->update([
                'nama_biaya' => $request->nama_biaya, 
                'biaya_untuk' => $request->biaya_untuk, 
                'biaya' => $request->biaya
            ]);

            $data = [
                'responCode' => 1,
                'respon' => 'Data Sukses Disimpan'
            ];
        }

        return response()->json($data);
    }

    public function delete(Request $request)
    {

        $data = Biaya::find($request->id)->delete();

        $data = [
            'responCode' => 1,
            'respon' => 'Data Sukses Dihapus'
        ];

        return response()->json($data);
    }
}
