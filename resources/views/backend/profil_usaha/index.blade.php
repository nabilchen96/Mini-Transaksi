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
    </style>
@endpush
@section('content')
    <div class="row" style="margin-top: -200px;">
        <div class="col-md-12 px-1">
            <div class="row">
                <div class="col-12 col-xl-8 mb-xl-0">
                    <h3 class="font-weight-bold">Data Profil Usaha</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 px-1 mt-3">
            <div class="card">
                <div class="card-body">
                    <form id="form">
                        <input type="hidden" name="id" id="id" value="{{ @$data->id }}">
                        <div class="form-group">
                            <label>Nama Usaha <sup class="text-center">*</sup></label>
                            <input value="{{ @$data->nama_usaha }}" name="nama_usaha" id="nama_usaha" type="text" placeholder="Nama Usaha"
                                class="form-control form-control-sm" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Alamat</label>
                            <textarea name="alamat" id="alamat" cols="30" rows="5" class="form-control form-control-sm" required
                            placeholder="Alamat Usaha">{{ @$data->alamat }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>No Telpon</label>
                            <input name="no_telp" value="{{ @$data->no_telp }}" id="no_telp" placeholder="Nomor Telpon"
                                class="form-control form-control-sm" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control form-control-sm"
                            placeholder="Keterangan">{{ @$data->keterangan }}</textarea>
                        </div>
                        <div class="form-group">
                            <button id="tombol_kirim" class="btn btn-primary btn-sm">Submit</button>
                        </div>
                    </form>
                </div>
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
                    url: '/store-profil-usaha',
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
    </script>
@endpush
