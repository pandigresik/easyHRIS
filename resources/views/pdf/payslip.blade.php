<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style type="text/css" media="all">
        .table {
            font-size: 85%;
            vertical-align: top;
        }

        .table-header td {
            padding: 4px 2px;
        }
    </style>

    <title>Slip Gaji</title>
</head>

<body>
    <div class="slip-gaji">
        <table class="table-header">
            <tr>
                <td>                    
                    <img width="118" height="46" src="{{ $base64 }}" />
                </td>
                <td>
                    <div style="font-size:120%">SLIP GAJI KARYAWAN</div>
                    <div style="font-size:120%">{{ $payroll->employee->company->name }}</div>
                </td>

            </tr>
        </table>
        <hr>
        <table class="table-header"  width="100%">
            <tbody>
                <tr>
                    <td width="50%">
                        <table>
                            <tr>
                                <td>NIK</td>
                                <td>: <strong>{{ $payroll->employee->code }}</strong></td>
                            </tr>
                            <tr>
                                <td>Nama</td>
                                <td>: <strong>{{ $payroll->employee->full_name }}</strong></td>
                            </tr>
                            <tr>
                                <td>Jabatan</td>
                                <td>: <strong>{{ $payroll->employee->jobtitle->name ?? '-' }}</strong></td>
                            </tr>
                        </table>
                    </td>
                    <td width="50%">
                        <table>
                            <tr>
                                <td>Periode</td>
                                <td>: <strong>{{ $payroll->payrollPeriod->range_period }}</strong></td>
                            </tr>
                            <tr>
                                <td>Tanggal Cetak</td>
                                <td>: <strong>{{ localFormatDate(date('Y-m-d')) }}</strong></td>
                            </tr>
                            <tr>
                                <td>Total Terima</td>
                                <td>: <strong>Rp. {{ $payroll->take_home_pay }}</strong></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <hr>
        <table class="table" cellspacing="10px" width="100%">
            <tr>
                <td>
                    <strong>Rincian Pendapatan</strong>
                </td>
                <td>
                    <strong>Rincian Potongan</strong>
                </td>
            </tr>
            <tr>
                <td width="50%" style="border: 1px solid gray; vertical-align: top">
                    <table class="table" width="100%">
                        <tbody>
                            @php
                            $pendapatan = $payroll->payrollDetails->filter(function($item){ return
                            $item->sign_value
                            > 0 ; });
                            $potongan = $payroll->payrollDetails->filter(function($item){ return
                            $item->sign_value < 0 ; }); @endphp @foreach($pendapatan as $no=> $g)
                                <tr>
                                    <td width="65%">{{ $g->component->name }}</td>
                                    <td width="5%">Rp</td>
                                    <td style="text-align:right">{{ $g->benefit_value }}</td>
                                </tr>
                                @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan=3><hr></td>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <td width="5%">Rp</td>
                                <td style="text-align:right">{{ localNumberFormat($pendapatan->sum( function($item){ return $item->getRawOriginal('benefit_value'); }), 0) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </td>

                <td width="50%" style="border: 1px solid gray; vertical-align: top">
                    <table class="table" width="100%">
                        <tbody>
                            @foreach($potongan as $no => $g)
                            <tr>
                                <td width="65%">{{ $g->component->name }}</td>
                                <td width="5%">Rp</td>
                                <td style="text-align:right">{{ $g->benefit_value }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                                <td colspan=3><hr></td>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <td width="5%">Rp</td>
                                <td style="text-align:right">{{ localNumberFormat($potongan->sum( function($item){ return $item->getRawOriginal('benefit_value'); }), 0) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
