<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class TransaksiController extends Controller
{
    public function index()
    {

        $tgl_awal = Request('tgl_awal');
        $tgl_akhir = Request('tgl_akhir');
        $status = Request('status');

        $data = DB::table('transaksis as p');

        if ($tgl_awal && $tgl_akhir && $status != 'SEMUA STATUS') {

            $data = $data
                ->whereBetween(DB::raw('DATE(p.tanggal_transaksi)'), [
                    $tgl_awal,
                    $tgl_akhir
                ])
                ->where('jenis_transaksi', 'PENJUALAN BARANG/JASA')
                ->where('status', $status)
                ->orderBy('p.id', 'DESC')
                ->paginate(10);
        } else {
            $data = $data->orderBy('p.id', 'DESC')
                ->where('jenis_transaksi', 'PENJUALAN BARANG/JASA')
                ->paginate(10);
        }

        return view('backend.transaksi.index', [
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'customer' => 'required',
        ]);

        if ($validator->fails()) {
            $data = [
                'responCode' => 0,
                'respon' => $validator->errors()
            ];
        } else {

            //FORMAT NO TRANSAKSI
            $nomorTransaksi = $this->generateNomorUrut();

            $data = Transaksi::create([
                'customer' => $request->customer,
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'jenis_transaksi' => 'PENJUALAN BARANG/JASA',
                'keterangan' => '',
                'no_telp' => $request->no_telp,
                'no_transaksi' => $nomorTransaksi,
                'status' => $request->status
            ]);
        }


        return redirect('detail-transaksi?id=' . $data->id);
    }

    public function delete(Request $request)
    {

        $data = Transaksi::find($request->id)->delete();

        $data = [
            'responCode' => 1,
            'respon' => 'Data Sukses Dihapus'
        ];

        return response()->json($data);
    }

    public function exportPdf()
    {

        ini_set('max_execution_time', 600);

        $data = DB::table('transaksis')->where(
            'id',
            Request('id')
        )->where('jenis_transaksi', 'PENJUALAN BARANG/JASA')->first();

        $data = PDF::loadview('backend.transaksi.export_pdf', [
            'data' => $data,
        ]);

        return $data->download('laporan.pdf');
    }

    public function generateNomorUrut()
    {
        // Ambil tanggal saat ini
        $tanggal = now()->format('Y-m-d');

        // Query untuk mendapatkan nomor urut terakhir pada tanggal tertentu
        $maxNomor = DB::table('transaksis')
            ->max('no_transaksi');

        // Pisahkan nomor urut dari format
        $explodedNomor = explode('-', $maxNomor);

        // Ambil nomor urut dan formatnya
        $nomor = ($maxNomor !== null) ? (int) $explodedNomor[0] + 1 : 1;

        // Format nomor urut
        return sprintf("%03d-%06d", $nomor, now()->format('mY'));
    }
}
