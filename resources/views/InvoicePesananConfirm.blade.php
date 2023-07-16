<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    {{-- <title>Document</title> --}}
    <style type="text/css">

        .grid-container{
            margin: 30px;
            /* display: grid;
            grid-template-columns: repeat(5, 1fr);
            grid-template-rows: 1fr repeat(3, 0.5fr);
            grid-column-gap: 0px;
            grid-row-gap: 10px; */
        }

        .grid-1{
            grid-area: 1 / 2 / 2 / 5;
        }

        .grid-2{
            grid-area: 2 / 2 / 3 / 5;
        }
        
        .grid-3{
            margin-top: 6px;
            grid-area: 3 / 2 / 4 / 5;
        }

        .grid-4{
            margin-top: 6px;
            grid-area: 4 / 3 / 5 / 4;
        }

        .flex-class{
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .title{
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin: 2px 0 !important;
        }

        .sub-title{
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin: 2px 0 !important;
        }

        .regular-text{
            font-size: 16px;
            color: #666;
            margin: 2px 0 !important;
        }

        .bold-regular-text{
            font-weight: bold;
            font-size: 16px;
            color: #333;
            margin: 2px 0 !important;
        }

        .button-border{
            background: #fff;
            cursor: pointer;
        }

        .anchor-link{
            border: 2px solid #19A7CE;
            border-radius: 6px;
            text-decoration: none;
            font-size: 18px;
            padding: 18px 24px;
            color: #19A7CE !important;
            font-weight: bold;
            font-style: normal;
        }

        .anchor-link:hover{
            text-decoration: none;
            color: #19A7CE !important;
        }

    </style>
</head>
    <body style="width:100%;font-family:helvetica, 'helvetica neue', arial, verdana, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0;"> 
        <div class="es-wrapper-color grid-container" style="background-color:#FAFAFA">
            <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top;">
                <tr class="border-collapse">
                    <td align="center" style="padding: 0px">
                        <table class="table table-borderless" cellspacing="0" cellpadding="0">
                            <tr class="border-collapse">
                                <td align="center" style="padding: 0px">
                                    <table class="table table-borderless" cellspacing="0" cellpadding="0">
                                        <tr class="border-collapse" >
                                            <td align="center" style="padding: 0px">
                                                <table class="table table-borderless">
                                                    <tr class="border-collapse">
                                                        <td align="center" style="padding: 0px">
                                                            <img src="https://i.ibb.co/yPQkjvt/Frame-1.png" alt="" height="150">
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>                    
                                        </tr>
                                        <tr class="border-collapse" style="margin: 6px 0px !important;">
                                            <td align="center" style="padding: 0px">
                                                <table class="table table-borderless">
                                                    <tr class="border-collapse">
                                                        <td align="center" style="Margin:0;padding-top:10px;padding-bottom:20px;padding-left:20px;padding-right:20px;background-color:transparent;background-position:left top;" >
                                                            <table class="table table-borderless">
                                                                <tr class="border-collapse" style="margin: 0; padding: 0;">
                                                                    <td align="center" style="margin: 0 !important; padding: 4px !important;">
                                                                        <p class="sub-title">Halo, {{ $user->name }}</p>
                                                                        {{-- <p class="sub-title">Halo,</p> --}}
                                                                    </td>
                                                                </tr>
                                                                <tr class="border-collapse" style="margin: 0 !important; padding: 0 !important;">
                                                                    <td align="center" style="margin: 0 !important; padding: 0 !important;">
                                                                        <p class="title">Pesanan Anda Sudah Dikonfirmasi</p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr class="border-collapse" style="margin: 6px 0px !important;">
                                                        <td align="center" style="Margin:0;padding-top:10px;padding-bottom:20px;padding-left:20px;padding-right:20px;background-color:transparent;background-position:left top;" >
                                                            <table class="table table-borderless">
                                                                <tr class="border-collapse" style="margin: 0; padding: 0;">
                                                                    <td align="center" style="margin: 0 !important; padding: 0 !important;">
                                                                        <table class="table table-borderless">
                                                                            <tr class="border-collapse" style="margin: 0; padding: 0;">
                                                                                <td align="center" style="margin: 0 !important; padding: 0 !important;">
                                                                                    {{-- <p class="bold-regular-text">Nomor Pesanan: {{ $kosBooking->kode }}</p> --}}
                                                                                    {{-- <p class="bold-regular-text">Nomor Pesanan: </p> --}}
                                                                                    <p>
                                                                                        <span class="regular-text">Nomor Pesanan: </span>
                                                                                        <span class="bold-regular-text">{{ $kosBooking->kode }}</span>
                                                                                    </p>
                                                                                </td>
                                                                            </tr>
                                                                            <tr class="border-collapse" style="margin: 0; padding: 0;">
                                                                                <td align="center" style="margin: 0 !important; padding: 0 !important;">
                                                                                    <span>
                                                                                        <p>
                                                                                            <span class="regular-text">Tanggal Pesan: </span>
                                                                                            <span class="bold-regular-text">{{ $tanggal }}</span>
                                                                                        </p>
                                                                                        {{-- <p class="bold-regular-text">{{ $tanggal }}</p> --}}
                                                                                        {{-- <p class="bold-regular-text">tanggal...</p> --}}
                                                                                    </span>
                                                                                </td>
                                                                            </tr>
                                                                            <tr class="border-collapse" style="margin: 0; padding: 0;">
                                                                                <td align="center" style="margin: 0 !important; padding: 0 !important;">
                                                                                    {{-- <p class="bold-regular-text">Nomor Kamar: {{ $nomor_kamar }}</p> --}}
                                                                                    <p>
                                                                                        <span class="regular-text">Nomor Kamar: </span>
                                                                                        <span class="bold-regular-text">{{ $nomor_kamar }}</span>
                                                                                    </p>
                                                                                </td>
                                                                            </tr>
                                                                            <tr class="border-collapse" style="margin: 0; padding: 0;">
                                                                                <td align="center" style="margin: 0 !important; padding: 0 !important;">
                                                                                    {{-- <p class="bold-regular-text">Total Biaya: Rp{{ number_format($kosBooking->total_price, 0,",",".") }} </p> --}}
                                                                                    <p>
                                                                                        <span class="regular-text">Total Biaya: </span>
                                                                                        <span class="bold-regular-text">Rp{{ number_format($kosBooking->total_price, 0,",",".") }}</span>
                                                                                    </p>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
   </body>
</html>

