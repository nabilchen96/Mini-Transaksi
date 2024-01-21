<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $harian = DB::table('transaksis')
            ->whereDate('tanggal_transaksi', now()->toDateString())
            ->where('jenis_transaksi', 'PENJUALAN BARANG/JASA')
            ->sum('total');

        $bulanan = DB::table('transaksis')
            ->whereMonth('tanggal_transaksi', now()->month)
            ->whereYear('tanggal_transaksi', now()->year)
            ->where('jenis_transaksi', 'PENJUALAN BARANG/JASA')
            ->sum('total');

        $tahunan = DB::table('transaksis')
            ->whereYear('tanggal_transaksi', now()->year)
            ->where('jenis_transaksi', 'PENJUALAN BARANG/JASA')
            ->sum('total');

        $total_pendapatan = DB::table('transaksis')
            ->where('jenis_transaksi', 'PENJUALAN BARANG/JASA')
            ->sum('total');

        return view('backend.dashboard', [
            'harian' => $harian,
            'bulanan' => $bulanan,
            'tahunan' => $tahunan, 
            'total_pendapatan' => $total_pendapatan
        ]);
    }
}