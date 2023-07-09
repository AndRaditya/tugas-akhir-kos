<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    {{-- <title>Document</title> --}}
    <style type="text/css">
        .title{
            font-family: Arial, Helvetica, sans-serif !important;
            font-size: 32px !important;
            font-weight: bold
        }

        .sub-title{
            font-family: Arial, Helvetica, sans-serif !important;
            font-size: 24px !important; 
        }

        .table-title{
            font-family: Arial, Helvetica, sans-serif !important;
            font-weight: bold;
            font-size: 24px !important;
        }

        
        hr {
            border: none;
            height: 1px;
            /* Set the hr color */
            color: #333;  /* old IE */
            background-color: #333;  /* Modern Browsers */
        }

        th, td{
            vertical-align: middle !important;
        }
    </style>
</head>
<body>
    <p class="title">Laporan Harian Semua Transaksi
    </p>
    <p class="sub-title">Rentang Tanggal: {{ $date_mulai }} &ndash; {{ $date_selesai }}</p>
    <br>
    <p class="table-title">Transaksi Masuk</p>
    {{-- @if(!$data_masuk->isEmpty()) --}}
    @if(count($data_masuk) > 0)
        <table class='table table-sm table-bordered'>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Total Transaksi</th>
                    <th>Nilai</th>
                    <th>Biaya Tambahan</th>
                    <th>Total Nilai</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data_masuk as $doc_masuk)
                <tr>
                    <td>{{ $doc_masuk['tanggal'] }}</td>
                    <td>{{ $doc_masuk['total_transaksi'] }}</td>
                    <td>Rp{{ number_format($doc_masuk['nilai'], 0,",",".") }}</td>
                    <td>Rp{{ number_format($doc_masuk['biaya_tambahan'], 0,",",".") }}</td>
                    <td>Rp{{ number_format($doc_masuk['total_nilai'], 0,",",".") }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr rowspan="2">
                    <th colspan="4" >Total</th>
                    <th colspan="1" >Rp{{ number_format($total_harga_masuk, 0,",",".") }}</th>
                </tr>
            </tfoot>
        </table>
    @else
        <hr>
        <p class="sub-title">Data Kosong</p>
        <br>
    @endif

    <br>
    <hr>
    <br>
    <p class="table-title">Transaksi Keluar</p>
    {{-- @if(!$data_keluar->isEmpty()) --}}
    @if(count($data_keluar) > 0)
        <table class='table table-sm table-bordered'>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Total Transaksi</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data_keluar as $doc_keluar)
                <tr>
                    <td>{{ $doc_keluar['tanggal'] }}</td>
                    <td>{{ $doc_keluar['total_transaksi'] }}</td>
                    <td>Rp{{ number_format($doc_keluar['nilai'], 0,",",".") }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr rowspan="2">
                    <th colspan="2" >Total</th>
                    <th colspan="1" >Rp{{ number_format($total_harga_keluar, 0,",",".") }}</th>
                </tr>
            </tfoot>
        </table>
    @else
        <hr>
        <p class="sub-title">Data Kosong</p>
    @endif

</body>
</html>