<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="Description" content="Enter your description here" />
</head>

<body>
    <table style="width: 100%; border: 1px solid black;">
        <tr>
            <td colspan="2">
                <span style="font-size: 18px;">No. Transaksi:</span>
                <h2 style="padding-top: 0; margin-top: 0;">{{ $data->no_transaksi }}</h2>
            </td>
        </tr>
        <tr>
            <td style="width: 70%;">
                <?php $profil = DB::table('profil_usahas')->first(); ?>
                <h2>{{ $profil->nama_usaha }}</h2>
                <span>Phone: {{ $profil->no_telp }}</span><br>
                <span>Alamat: {{ $profil->alamat }}</span><br>
                <span>{{ $profil->keterangan }}</span>
            </td>
            <td style="width: 30%;">
                <h2>{{ $data->customer }}</h2>
                Tanggal: {{ date('d-m-Y H:i', strtotime($data->tanggal_transaksi)) }} <br>
                Telp: {{ $data->no_telp }}<br>
                Status: {{ $data->status }}
            </td>
        </tr>
    </table>
    <br>
    <table style="width: 100%; border: 1px solid black;">
        <thead>
            <tr>
                <th style="border: 1px solid black; width: 5px;">No</th>
                <th style="border: 1px solid black; text-align: start;">Keterangan</th>
                <th style="border: 1px solid black; text-align: start;">Harga</th>
                <th style="border: 1px solid black; width: 80px;">Jumlah</th>
                <th style="border: 1px solid black; width: 200px;">Total</th>
            </tr>
        </thead>
        <tbody>
            @if (!empty($data->keterangan))
                @php
                    @$dataArray = unserialize(@$data->keterangan);
                    $groupedData = array_chunk(@$dataArray, 3);
                    $total = 0;
                @endphp
                @foreach ($groupedData as $k => $item)
                    <tr>
                        <td style="border: 1px solid black;">{{ $k + 1 }}</td>
                        <td style="border: 1px solid black; text-align:center;">{{ $item[0] }}</td>
                        <td style="border: 1px solid black; text-align:center;">Rp. {{ number_format($item[1]) }}</td>
                        <td style="border: 1px solid black; text-align:center; width: 80px !important;">{{ @$item[2] }}</td>
                        <td style="border: 1px solid black; text-align:center; width: 80px !important;">Rp. {{ number_format(@$item[1] * @$item[2]) }}</td>
                    </tr>
                    @php
                        $total += @$item[1] * @$item[2];
                    @endphp
                @endforeach
                <tr>
                    <td colspan="3" style="border: 1px solid black;"></td>
                    <td style="border: 1px solid black; text-align: center; width: 80px !important;">
                        <b>Total</b>
                    </td>
                    <td style="border: 1px solid black; text-align:center; width: 80px !important;">Rp. {{ number_format($total) }}</td>
                </tr>
            @endif
        </tbody>
    </table>
</body>

</html>
