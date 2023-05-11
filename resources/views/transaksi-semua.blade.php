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
    </style>
</head>
<body>
    <p class="title">Semua Transaksi</p>
    <p class="sub-title">Rentang Tanggal: {{ $date_mulai }} &ndash; {{ $date_selesai }}</p>
    <br>
    <p class="table-title">Transaksi Masuk</p>
    @if(!$data_masuk->isEmpty())
        <table class='table table-sm table-bordered'>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Deskripsi</th>
                    <th>Nilai</th>
                    <th>Total Nilai</th>
                    <th>Nomor Kamar</th>
                    <th>Biaya Tambahan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data_masuk as $doc_masuk)
                <tr>
                    <td>{{ $doc_masuk->no }}</td>
                    <td>{{ $doc_masuk->tanggal }}</td>
                    <td>{{ $doc_masuk->desc }}</td>
                    <td>Rp{{ number_format($doc_masuk->nilai, 0,",",".") }}</td>
                    <td>Rp{{ number_format($doc_masuk->total_nilai, 0,",",".") }}</td>
                    <td>{{ $doc_masuk->nomor_kamar }}</td>

                    @forelse($doc_masuk->biaya_tambahan as $biaya_tambahan)
                        @foreach($doc_masuk->biaya_tambahan as $biaya)
                            <td>{{ $biaya->name }}, {{ $biaya->desc }}, Rp{{ number_format($biaya->nilai, 0,",",".") }}</td>
                        @endforeach
                    @empty
                        <td>&ndash;</td>
                    @endforelse
                </tr>
                @endforeach
            </tbody>
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
    @if(!$data_keluar->isEmpty())
        <table class='table table-sm table-bordered'>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Deskripsi</th>
                    <th>Nilai</th>

                </tr>
            </thead>
            <tbody>
                @foreach($data_keluar as $doc_keluar)
                <tr>
                    <td>{{ $doc_keluar->no }}</td>
                    <td>{{ $doc_keluar->tanggal }}</td>
                    <td>{{ $doc_keluar->desc }}</td>
                    <td>Rp{{ number_format($doc_keluar->nilai, 0,",",".") }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <hr>
        <p class="sub-title">Data Kosong</p>
    @endif

</body>
</html>

