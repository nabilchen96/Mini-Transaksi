@extends('backend.app')
@push('style')
    <style>
        .act-btn {
            display: block;
            width: 50px;
            height: 50px;
            line-height: 50px;
            text-align: center;
            color: white;
            font-size: 30px;
            font-weight: bold;
            border-radius: 50%;
            -webkit-border-radius: 50%;
            text-decoration: none;
            transition: ease all 0.3s;
            position: fixed;
            right: 30px;
            bottom: 30px;
            text-decoration: none !important;
            z-index: 9;
        }

        .act-btn:hover {
            background: white;
        }

        th,
        td {
            white-space: nowrap !important;
        }

        .button-container {
            overflow-x: auto;
            white-space: nowrap;
            display: flex;
        }

        .btn {
            flex: 0 0 auto;
            margin-right: 8px;
        }
    </style>
@endpush
@section('content')
    <a style="margin-bottom: 50px;" data-toggle="modal" data-target="#modal" href="#" class="bg-primary act-btn">
        +
    </a>
    <div class="row" style="margin-top: -200px;">
        <div class="col-md-12 px-1">
            <div class="row">
                <div class="col-12 col-xl-8 mb-xl-0">
                    <h3 class="font-weight-bold">Transaksi Masuk</h3>
                </div>
            </div>
        </div>
    </div>
    <form>
        <div class="row">
            <div class="col-12 px-1">
                <button type="button" data-toggle="modal" data-target="#filter" class="mb-2 mt-2 btn btn-sm btn-primary">
                    <i class="bi bi-search"></i>
                </button>
                <div class="modal fade" id="filter" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="formX">
                                <div class="modal-header p-3">
                                    <h5 class="modal-title m-2" id="exampleModalLabel">Filter Form</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Tanggal Mulai <sup class="text-danger">*</sup></label>
                                        <input name="tgl_awal" value="{{ Request('tgl_awal') ?? date('Y-m-d') }}"
                                            id="tgl_awal" type="date" class="form-control form-control-sm">
                                    </div>
                                    <div class="form-group">
                                        <label>Tanggal Mulai <sup class="text-danger">*</sup></label>
                                        <input name="tgl_akhir" value="{{ Request('tgl_akhir') ?? date('Y-m-d') }}"
                                            id="tgl_akhir" type="date" class="form-control form-control-sm">
                                    </div>
                                    {{-- <div class="form-group">
                                        <label>Jenis Transaksi <sup class="text-danger">*</sup></label>
                                        <select name="jenis" class="form-control" id="transaksi" required>
                                            <option value="">--JENIS TRANSAKSI--</option>
                                            <option>--PILIH JENIS HARGA UNTUK--</option>
                                            <option>PEMBELIAN BARANG/JASA</option>
                                            <option>PENJUALAN BARANG/JASA</option>
                                            <option>SEMUANYA</option>
                                        </select>
                                    </div> --}}
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Status</label>
                                        <select name="status" id="status" required class="form-control form-control-sm"
                                            required>
                                            <option>--PILIH STATUS--</option>
                                            <option>LUNAS</option>
                                            <option>BELUM LUNAS</option>
                                            <option>SEMUA STATUS</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer p-3 d-flex align-items-end d-flex align-items-end">
                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-danger btn-sm mr-1"
                                            data-dismiss="modal">Close</button>
                                        <button id="tombol_kirim" class="btn btn-primary btn-sm">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="accordion" id="accordionExample">
        <div class="row">
            <div class="col-12 px-1">
                @foreach ($data as $k => $item)
                    <div class="card shadow mb-3">
                        <div class="card-body" style="padding: 1.25rem;">
                            <div class=""
                                style="border-bottom-left-radius: 0 !important; border-bottom-right-radius: 0 !important;"
                                id="headingOne">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p>
                                            <span class="badge bg-info text-white" style="border-radius: 5px;">
                                                {{ @$item->no_transaksi ?? '' }}
                                            </span>
                                        </p>
                                        <p><i class="bi bi-person"></i>
                                            <span class="text-danger">
                                                {{ @$item->customer ?? 'Jhon Due' }}
                                            </span>
                                        </p>
                                        <p><i class="bi bi-calendar3"></i>
                                            <span>
                                                {{ date('d/m/Y H:i', strtotime(@$item->tanggal_transaksi)) }}
                                            </span>
                                        </p>
                                        <p><i class="bi bi-repeat"></i>
                                            <span>
                                                {{-- {{ @$item->jenis_transaksi }} --}}
                                                {{ $item->status }}
                                            </span>
                                        </p>
                                        <p><i class="bi bi-phone-vibrate"></i>
                                            <span>
                                                {{-- {{ @$item->jenis_transaksi }} --}}
                                                {{ $item->no_telp }}
                                            </span>
                                        </p>
                                        <div class="d-flex">
                                            @if (!empty($item->keterangan))
                                                @php
                                                    @$dataArray = unserialize(@$item->keterangan);
                                                    $groupedData = array_chunk(@$dataArray, 3);
                                                    $total = 0;
                                                @endphp
                                                @foreach ($groupedData as $j)
                                                    @php
                                                        $total += @$j[1] * @$j[2];
                                                    @endphp
                                                @endforeach
                                            @endif
                                            <div>
                                                <p><b>Total Bayar</b></p>
                                                <h4>
                                                    Rp. {{ number_format(@$item->total) }}

                                                </h4>
                                            </div>

                                        </div>
                                    </div>
                                    <p data-toggle="collapse" data-target="#collapse{{ @$k + 1 }}">
                                        <i class="bi bi-chevron-down"></i>
                                    </p>
                                </div>
                            </div>
                            <div id="collapse{{ @$k + 1 }}" class="collapse" aria-labelledby="headingOne"
                                data-parent="#accordionExample">
                                <div id="collapse{{ @$k + 1 }}" class="mt-4 collapse" aria-labelledby="headingOne"
                                    data-parent="#accordionExample">
                                    <a href="{{ url('export-transaksi') }}/?id={{ @$item->id }}" class="badge bg-danger text-white my-2" style="border-radius: 8px;">
                                        <i class="bi bi-file-earmark-pdf"></i>
                                    </a>
                                    <a href="{{ url('detail-transaksi') }}?id={{ @$item->id }}"
                                        class="badge bg-success text-white my-2" style="border-radius: 8px;">
                                        <i class="bi bi-grid"></i>
                                    </a>
                                    <a href="#" onclick="hapusData({{ @$item->id }})"
                                        class="badge bg-danger text-white my-2" style="border-radius: 8px;">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                    <div class="table-responsive">
                                        <table class="table bg-white table-striped" style="width: 100%;">
                                            <thead class="bg-primary text-white">
                                                <tr>
                                                    <th width="5%">No</th>
                                                    <th>KETERANGAN</th>
                                                    <th>HARGA</th>
                                                    <th>JUMLAH</th>
                                                    <th>TOTAL</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (!empty($item->keterangan))
                                                    @php
                                                        @$dataArray = unserialize(@$item->keterangan);
                                                        $groupedData = array_chunk(@$dataArray, 3);
                                                        $total = 0;
                                                    @endphp
                                                    @foreach ($groupedData as $k => $item)
                                                        <tr>
                                                            <td>{{ $k + 1 }}</td>
                                                            <td>{{ $item[0] }}</td>
                                                            <td>Rp. {{ number_format($item[1]) }}</td>
                                                            <td>{{ @$item[2] }}</td>
                                                            <td>Rp. {{ number_format(@$item[1] * @$item[2]) }}</td>
                                                        </tr>
                                                        @php
                                                            $total += @$item[1] * @$item[2];
                                                        @endphp
                                                    @endforeach
                                                    <tr>
                                                        <td colspan="3"></td>
                                                        <td>
                                                            <b>Total</b>
                                                        </td>
                                                        <td>Rp. {{ number_format($total) }}</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{ $data->links() }}
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form" method="POST" action="{{ url('store-transaksi') }}">
                    @csrf
                    <div class="modal-header p-3">
                        <h5 class="modal-title m-2" id="exampleModalLabel">Transaksi Form</h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label>Customer</label>
                            <input name="customer" id="customer" placeholder="Customer"
                                class="form-control form-control-sm" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tanggal Transaksi</label>
                            <input name="tanggal_transaksi" id="tanggal_transaksi" type="datetime-local"
                                placeholder="Nama Lengkap" class="form-control form-control-sm" required>
                        </div>
                        {{-- <div class="form-group">
                            <label for="exampleInputEmail1">Jenis Transaksi</label>
                            <select name="jenis_transaksi" id="jenis_transaksi" class="form-control form-control-sm"
                                required>
                                <option>--PILIH JENIS HARGA UNTUK--</option>
                                <option>PEMBELIAN BARANG/JASA</option>
                                <option>PENJUALAN BARANG/JASA</option>
                            </select>
                        </div> --}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">No. Telp</label>
                            <input name="no_telp" id="no_telp" type="number"
                                placeholder="No. Telp" class="form-control form-control-sm" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Status</label>
                            <select name="status" id="status" required class="form-control form-control-sm"
                                required>
                                <option>--PILIH STATUS--</option>
                                <option>LUNAS</option>
                                <option>BELUM LUNAS</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer p-3 d-flex align-items-end d-flex align-items-end">
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-danger btn-sm mr-1" data-dismiss="modal">Close</button>
                            <button id="tombol_kirim" class="btn btn-primary btn-sm">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        hapusData = (id) => {
            Swal.fire({
                title: "Yakin hapus data?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonColor: '#3085d6',
                cancelButtonText: "Batal"

            }).then((result) => {

                if (result.value) {
                    axios.post('/delete-transaksi', {
                            id
                        })
                        .then((response) => {
                            if (response.data.responCode == 1) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    timer: 2000,
                                    showConfirmButton: false
                                })

                                location.reload();

                            } else {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Gagal...',
                                    text: response.data.respon,
                                })
                            }
                        }, (error) => {
                            console.log(error);
                        });
                }

            });
        }
    </script>
@endpush
