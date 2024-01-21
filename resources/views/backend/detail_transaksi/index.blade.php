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
                    <a href="{{ url('transaksi') }}" style="text-decoration: none;">
                        <h3 class="font-weight-bold text-dark">
                            <i class="bi bi-arrow-left"></i> Detail Transaksi
                        </h3>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 px-1 mt-3">
            <div class="card">
                <div class="card-body">
                    <form id="transaksi" method="POST" action="{{ url('update2-detail-transaksi') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{ @$data[0]->id }}">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>No Transaksi</label>
                                    <input name="customer" id="customer" type="text" placeholder="Customer" readonly
                                        class="form-control form-control-sm" value="{{ @$data[0]->no_transaksi }}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Customer</label>
                                    <input name="customer" id="customer" type="text" placeholder="Customer"
                                        class="form-control form-control-sm" value="{{ @$data[0]->customer }}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Tanggal Transaksi</label>
                                    <input name="tanggal_transaksi" id="tanggal_transaksi" type="datetime-local"
                                        placeholder="Tanggal Transaksi" class="form-control form-control-sm"
                                        value="{{ @$data[0]->tanggal_transaksi }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" id="status" class="form-control form-control-sm" required>
                                        <option>--PILIH STATUS--</option>
                                        <option {{ @$data[0]->status == 'LUNAS' ? 'selected' : '' }}>LUNAS</option>
                                        <option {{ @$data[0]->status == 'BELUM LUNAS' ? 'selected' : '' }}>BELUM LUNAS
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">No. Telp</label>
                                    <input value="{{ @$data[0]->no_telp }}" name="no_telp" id="no_telp" type="number"
                                        placeholder="No. Telp" class="form-control form-control-sm" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                                    <a href="{{ url('export-transaksi') }}/?id={{ @$data[0]->id }}"
                                        style="border-radius: 8px;">
                                        <button type="button" class="btn btn-sm btn-danger">
                                            <i class="bi bi-file-earmark-pdf"></i> Cetak
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table bg-white table-striped" style="width: 100%;">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Keterangan</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
                                    <th width="5%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($data[0]->keterangan))
                                    @php
                                        @$dataArray = unserialize(@$data[0]->keterangan);
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
                                            <td>
                                                @if (count($item) >= 3)
                                                    @php
                                                        // Hitung indeks-indeks yang akan dihapus
                                                        $index1 = $k * 3;
                                                        $index2 = $k * 3 + 1;
                                                        $index3 = $k * 3 + 2;
                                                    @endphp

                                                    <a href="#"
                                                        onclick="hapusData({{ $index1 }}, {{ $index2 }}, {{ $index3 }}, {{ $data[0]->id }})"
                                                        class="" style="border-radius: 8px;">
                                                        <i class="bi bi-trash text-danger" style="font-size: 1.5rem;"></i>
                                                    </a>
                                                @endif
                                            </td>
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
                                        <td></td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{ @$data->links() }}
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form">
                    @csrf
                    <div class="modal-header p-3">
                        <h5 class="modal-title m-2" id="exampleModalLabel">Transaksi Form</h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id" value="{{ @$data[0]->id }}">
                        <div class="form-group">
                            <label>Keterangan</label>
                            <?php $biaya = DB::table('biayas')
                                ->where('biaya_untuk', @$data[0]->jenis_transaksi)
                                ->get(); ?>
                            <input placeholder="Cari atau Ketik untuk Menambahkan Data Baru"
                                class="form-control form-control-sm" oninput="pilihKeterangan()" list="keterangans"
                                id="keterangan" name="keterangan" autocomplete="off">
                            <datalist id="keterangans">
                                @foreach ($biaya as $item)
                                    <option data-value2="{{ $item->biaya }}" value="{{ $item->nama_biaya }}">
                                @endforeach
                            </datalist>
                        </div>
                        <div class="form-group">
                            <label>Harga</label>
                            <input name="harga" id="harga" type="number" placeholder="Harga"
                                class="form-control form-control-sm" required>
                        </div>
                        <div class="form-group">
                            <label>Jumlah</label>
                            <input name="jumlah" id="jumlah" type="number" placeholder="Jumlah"
                                class="form-control form-control-sm" required>
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
        function pilihKeterangan() {
            // Ambil nilai dari elemen input
            var inputValue = document.getElementById("keterangan").value;

            // Cari option yang sesuai dengan nilai
            var dataList = document.getElementById("keterangans");
            var selectedOption;
            for (var i = 0; i < dataList.options.length; i++) {
                if (dataList.options[i].value === inputValue) {
                    selectedOption = dataList.options[i];
                    break;
                }
            }

            // Jika ditemukan, setel nilai pada elemen dengan id "harga"
            if (selectedOption) {
                document.getElementById("harga").value = selectedOption.getAttribute("data-value2");
            }
        }

        form.onsubmit = (e) => {

            let formData = new FormData(form);

            e.preventDefault();

            document.getElementById("tombol_kirim").disabled = true;

            axios({
                    method: 'post',
                    url: formData.get('id') == '' ? '/store-detail-transaksi' : '/update-detail-transaksi',
                    data: formData,
                })
                .then(function(res) {
                    //handle success         
                    if (res.data.responCode == 1) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: res.data.respon,
                            timer: 3000,
                            showConfirmButton: false
                        })

                        location.reload();

                    } else {

                        console.log('terjadi error');
                    }

                    document.getElementById("tombol_kirim").disabled = false;
                })
                .catch(function(res) {
                    document.getElementById("tombol_kirim").disabled = false;
                    //handle error
                    console.log(res);
                });
        }

        hapusData = (index1, index2, index3, id) => {
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
                    axios.post('/delete-detail-transaksi', {
                            index1,
                            index2,
                            index3,
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
