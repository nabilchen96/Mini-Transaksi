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
                    <h3 class="font-weight-bold">Daftar Harga</h3>
                </div>
            </div>
        </div>
    </div>
    <form>
        <div class="row">
            <div class="col-12 px-1">
                <div class="input-group mb-3 mt-3">
                    <select name="q" id="q" style="border: none;" class="form-control">
                        <option value="">TAMPILKAN SEMUANYA</option>
                        <option>PEMBELIAN BARANG/JASA</option>
                        <option>PENJUALAN BARANG/JASA</option>
                    </select>
                    <button onclick="showLoadingIndicator()" type="submit" style="border: none; height: 38px;"
                        class="input-group-text bg-primary text-white" id="basic-addon2">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-12 px-1">
            <div class="table-responsive">
                <table class="table bg-white table-striped" style="width: 100%;">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Harga / Biaya</th>
                            <th>Harga / Biaya Untuk</th>
                            <th>Harga / Biaya</th>
                            <th width="5%"></th>
                            <th width="5%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $k => $item)
                            <tr>
                                <td>{{ $k + 1 }}</td>
                                <td>
                                    <div style="white-space: normal !important; word-wrap: break-word;">
                                        {{ $item->nama_biaya }}
                                    </div>
                                </td>
                                <td>{{ $item->biaya_untuk }}</td>
                                <td>Rp. {{ number_format($item->biaya) }}</td>
                                <td>
                                    <a data-toggle="modal" data-target="#modal" data-item="{{ json_encode($item) }}"
                                        href="javascript:void(0)">
                                        <i class="bi bi-grid text-success" style="font-size: 1.5rem;"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="#" onclick="hapusData({{ $item->id }})">
                                        <i style="font-size: 1.5rem;" class="bi bi-trash text-danger"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $data->links() }}
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form">
                    <div class="modal-header p-3">
                        <h5 class="modal-title m-2" id="exampleModalLabel">Harga Form</h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label>Judul Harga / Biaya <sup>*</sup></label>
                            <input name="nama_biaya" id="nama_biaya" type="text" placeholder="nama Harga / Biaya"
                                class="form-control form-control-sm" required>
                        </div>
                        <div class="form-group">
                            <label>Jenis Harga / Biaya <sup>*</sup></label>
                            <select name="biaya_untuk" id="biaya_untuk" placeholder="nama Harga / Biaya"
                                class="form-control form-control-sm" required>
                                <option>--PILIH JENIS HARGA UNTUK--</option>
                                <option>PEMBELIAN BARANG/JASA</option>
                                <option>PENJUALAN BARANG/JASA</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Harga / Biaya <sup>*</sup></label>
                            <input name="biaya" id="biaya" type="number" placeholder="Harga / Biaya"
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
        form.onsubmit = (e) => {

            let formData = new FormData(form);

            e.preventDefault();

            document.getElementById("tombol_kirim").disabled = true;

            axios({
                    method: 'post',
                    url: formData.get('id') == '' ? '/store-biaya' : '/update-biaya',
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
                    axios.post('/delete-biaya', {
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

        $('#modal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('item') // Extract info from data-* attributes

            console.log(recipient);

            document.getElementById("form").reset();
            document.getElementById('id').value = ''
            $('.error').empty();

            if (recipient) {
                var modal = $(this);
                modal.find('#id').val(recipient.id);
                modal.find('#nama_biaya').val(recipient.nama_biaya);
                modal.find('#biaya_untuk').val(recipient.biaya_untuk);
                modal.find('#biaya').val(recipient.biaya);
            }
        })
    </script>
@endpush
