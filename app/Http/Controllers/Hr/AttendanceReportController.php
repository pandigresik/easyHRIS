<?php

namespace App\Http\Controllers\Hr;

use App\Repositories\Hr\AttendanceReportRepository;

use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;

class AttendanceReportController extends AppBaseController
{
    /** @var  AttendanceReportRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = AttendanceReportRepository::class;
    }

    public function index(Request $request)
    {
        $absentReason = [
            'OK' => 'OK',
            // 'ABS' => 'ABSENT (PENGAJUAN HRD)',
            'ABSENT' => 'ABSENT',
            'INVALID' => 'INVALID',
            'LATEIN' => 'TERLAMBAT',
            'OFF' => 'DIRUMAHKAN',            
            'EARLYOUT' => 'PULANG CEPAT',
            'SKK' => 'SAKIT KECELAKAAN KERJA',
            'LK' => 'LUAR KOTA',
            'CK' => 'CUTI KHUSUS',
            'CT' => 'CUTI TAHUNAN',
            'SKT' => 'SAKIT'
        ];
        if ($request->ajax()) {            
            $period = generatePeriodFromString($request->get('period'));
            $grouping = $request->get('grouping');
            $startDate = $period['startDate'];
            $endDate = $period['endDate'];
            $datas = $this->getRepositoryObj()->list($startDate->format('Y-m-d'), $endDate->format('Y-m-d'), $grouping);
            $view = 'list_employee';
            if($grouping == 'date'){
                $view = 'list_date';
            }            

            return view('hr.attendance_report.'.$view)
                ->with(['datas' => $datas, 'startDate' => $startDate->format('Y-m-d'), 'endDate' => $endDate->format('Y-m-d'), 'absentReason' => $absentReason]);
        }

        $downloadXls = $request->get('download_xls');
        if ($downloadXls) {
            $period = generatePeriodFromString($request->get('period'));
            $grouping = $request->get('grouping');
            $startDate = $period['startDate'];
            $endDate = $period['endDate'];
            $datas = $this->getRepositoryObj()->list($startDate->format('Y-m-d'), $endDate->format('Y-m-d'), $grouping);
            $view = 'hr.attendance_report.list_employee';
            if($grouping == 'date'){
                $view = 'hr.attendance_report.list_date';
            }
            $dataExcel = [
                'datas' => $datas,
                'view' => $view,
                'absentReason' => $absentReason,
                'startDate' => $startDate->format('Y-m-d'), 
                'endDate' => $endDate->format('Y-m-d')
            ];
            return $this->exportExcel($dataExcel);
        }

        return view('hr.attendance_report.index')->with($this->getOptionItems());
    }

    private function exportExcel($data)
    {        
        
        $collection = $data['datas'];
        $view = $data['view'];
        $startDate = $data['startDate'];
        $endDate = $data['endDate'];
        $absentReason = $data['absentReason'];

        $modelEksport = '\\App\Exports\\Hr\\AttendanceReportExport';
        $fileName = 'rekap_absent_'.$startDate.'_'.$endDate;

        return (new $modelEksport($collection))
            ->setView($view)
            ->setStartDate($startDate)
            ->setEndDate($endDate)            
            ->setAbsentReason($absentReason)->download($fileName.'.xls');
    }

    private function getOptionItems()
    {        
        return [];
    }
}
