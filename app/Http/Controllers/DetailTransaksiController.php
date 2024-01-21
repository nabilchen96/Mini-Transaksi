<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Validator;

class DetailTransaksiController extends Controller
{
    public function index(Request $request)
    {

        $data = Request('id');

        $data = DB::table('transaksis as p')->orderBy('p.id', 'DESC')
            ->where('id', $data)
            ->paginate(10);

        return view('backend.detail_transaksi.index', [
            'data' => $data
        ]);
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

            // Ambil data transaksi yang sudah ada
            $trk = Transaksi::find($request->id);

            // Unserialize data yang sudah ada
            $existingData = $trk->keterangan ? unserialize($trk->keterangan) : [];

            // Tambahkan data baru ke dalam array
            $newData = [
                $request->keterangan,
                $request->harga,
                $request->jumlah,
            ];

            // Gabungkan data yang sudah ada dengan data baru
            $combinedData = array_merge($existingData, $newData);

            // Update data keterangan
            $trk->update([
                'keterangan' => serialize($combinedData),
                'total' => $trk->total + ($request->harga * $request->jumlah)
            ]);

            $data = [
                'responCode' => 1,
                'respon' => 'Data Sukses Disimpan'
            ];

        }

        return response()->json($data);
    }

    public function update2(Request $request)
    {

        $data = Transaksi::updateOrcreate(
            [
                'id' => $request->id
            ],
            [
                'customer' => $request->customer,
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'jenis_transaksi' => 'PENJUALAN BARANG/JASA',
                'no_telp' => $request->no_telp,
                'status' => $request->status
            ]
        );

        return back();
    }

    public function delete(Request $request)
    {

        // Ambil data transaksi yang sudah ada
        $transaksi = Transaksi::find($request->id);

        // Unserialize data yang sudah ada
        $keteranganArray = unserialize($transaksi->keterangan);

        // Hapus elemen dengan indeks tertentu dari array

        $harga = $keteranganArray[$request->index2];
        $jumlah = $keteranganArray[$request->index3];

        unset($keteranganArray[$request->index1]);
        unset($keteranganArray[$request->index2]);
        unset($keteranganArray[$request->index3]);

        // Serialize kembali data keterangan yang sudah diubah
        $transaksi->update([
            'keterangan' => serialize($keteranganArray),
            'total' => $transaksi->total - ($harga * $jumlah)
        ]);

        $data = [
            'responCode' => 1,
            'respon' => 'Data Sukses Dihapus'
        ];

        return response()->json($data);
    }

}
