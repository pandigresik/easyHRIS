<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style type="text/css" media="all">
        @page {
            size: A4;
            margin: 0;
            orientation: landscape;
        }
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            background-color: blac;
            display: flex;
            justify-content: center;
            background-color: #313131;
        }

        .slip-gaji {
            width: 750px;
            min-height: 100vh;
            background-color: #fff;
            padding: 20px;
        }

        .slip-gaji .header {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            font-size: 14px;
        }

        .slip-gaji .content-body .data-karyawan,
        .slip-gaji .content-body .data-karyawan .left,
        .slip-gaji .content-body .data-karyawan .right,
        .slip-gaji .content-body .detail-fee,
        .slip-gaji .content-body .total-fee {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 10px 0;
            font-size: 12px;
        }

        .slip-gaji .content-body .data-karyawan .left .label,
        .slip-gaji .content-body .data-karyawan .right .label {
            font-size: 12px;
        }

        .slip-gaji .content-body .data-karyawan .label {
            margin-right: 10px;
        }

        .slip-gaji .content-body .detail-fee h3 {
            margin-bottom: 10px;
        }

        .slip-gaji .content-body .detail-fee .pendapatan {            
            padding: 20px;
            flex-basis: 50%;
            margin-right: 10px;
            border-radius: 5px;            
        }

        .slip-gaji .content-body .detail-fee .potongan {            
            padding: 20px;
            flex-basis: 50%;
            margin-left: 10px;
            border-radius: 5px;            
        }

        .slip-gaji .content-body .detail-fee th,
        .slip-gaji .content-body .detail-fee td {
            padding: 5px 10px;
            box-sizing: border-box;
        }        

        .slip-gaji .content-body .total-fee {
            align-items: center;
            flex-direction: column;
        }
    </style>

    <title>Slip Gaji</title>
</head>

<body>
    <div class="slip-gaji">
        <div class="header">
            <h2 class="pb-2" style="text-align: center;">Slip Gaji Karyawan</h2>
            <h3 class="brand-name" style="text-align: center;">{{$payroll->employee->company->name }}</h3>
            <h3>Periode {{ $payroll->payrollPeriod->range_period }}</h3>
        </div>        
        <div class="content-body">
            <div class="data-karyawan">
                <div class="left">
                    <div class="label" style="text-align: justify;">                        
                        <h4>NIK : <em>{{ $payroll->employee->code }}</em></h4>
                        <h4>Nama Karyawan : <em>{{ $payroll->employee->full_name }}</em></h4>
                        <h4>Jabatan : <em>{{ $payroll->employee->jobtitle->name }}</em></h4>
                        <h4>Tanggal Cetak : <em>{{ localFormatDate(date('Y-m-d')) }}</em></h4>
                    </div>
                </div>
            </div>
            <hr>            
            <div class="detail-fee">
                <div class="pendapatan">
                    <h3>Rincian Pendapatan</h3>
                    <table class="table">
                        <tbody>
                        @php
                        $pendapatan = $payroll->payrollDetails->filter(function($item){ return $item->sign_value > 0 ; });
                        $potongan = $payroll->payrollDetails->filter(function($item){ return $item->sign_value < 0 ; });                        
                        @endphp
                        @foreach($pendapatan as $no => $g)
                            <tr>                                
                                <td>{{ $g->component->name }}</td>                                
                                <td>Rp {{ $g->benefit_value }}</td>
                            </tr>
                            
                            @endforeach                
                        </tbody>
                    </table>
                </div>
                <br>
                <div class="potongan">
                    <h3>Rincian Potongan</h3>
                    <table class="table">
                        <tbody>
                        @foreach($potongan as $no => $g)
                            <tr>                                
                                <td>{{ $g->component->name }}</td>                                
                                <td>Rp {{ $g->benefit_value }}</td>
                            </tr>
                            
                            @endforeach                
                        </tbody>
                    </table>
                </div>
            </div>
            
            
        </div>
        <hr>
        <br>
        
    </div>
</body>

</html>
