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
    <p class="title">Transaksi Keluar</p>
    <p class="sub-title">Rentang Tanggal: {{ $date_mulai }} &ndash; {{ $date_selesai }}</p>
    <br>

    @if(!$data->isEmpty())
        <table class='table table-sm table-bordered'>
            {{-- width="100%" cellspacing="0" cellpadding="0" --}}
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Deskripsi</th>
                    <th>Nilai</th>

                </tr>
            </thead>
            <tbody>
                @foreach($data as $doc)
                <tr>
                    <td>{{ $doc->no }}</td>
                    <td>{{ $doc->tanggal }}</td>
                    <td>{{ $doc->desc }}</td>
                    <td>Rp{{ number_format($doc->nilai, 0,",",".") }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr rowspan="2">
                    <th colspan="2" >Total</th>
                    <th colspan="2" >Rp{{ number_format($total_harga, 0,",",".") }}</th>
                </tr>
            </tfoot>
        </table>
    @else
        <hr>
        <p class="sub-title">Data Kosong</p>
    @endif
</body>
</html>

