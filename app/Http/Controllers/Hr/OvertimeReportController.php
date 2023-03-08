<?php

namespace App\Http\Controllers\Hr;

use App\Repositories\Hr\OvertimeReportRepository;

use App\Http\Controllers\AppBaseController;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class OvertimeReportController extends AppBaseController
{
    /** @var  OvertimeReportRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = OvertimeReportRepository::class;
    }

    public function index(Request $request)
    {        
        if ($request->ajax()) {            
            $period = generatePeriodFromString($request->get('period'));            
            $startDate = $period['startDate'];
            $endDate = $period['endDate'];
            $filterEmployee = $request->get('employee_id');
            $dataResult = $this->getRepositoryObj()->list($startDate->format('Y-m-d'), $endDate->format('Y-m-d'), $filterEmployee);
            $view = 'list';  

            return view('hr.overtime_report.'.$view)
                ->with([
                    'datas' => $dataResult['datas'], 
                    'employees' => $dataResult['employees'],
                    'startDate' => $startDate->format('Y-m-d'), 
                    'endDate' => $endDate->format('Y-m-d'),
                    'period' => CarbonPeriod::create($startDate, $endDate),
                    'excel' => false
                ]);
        }

        $downloadXls = $request->get('download_xls');
        if ($downloadXls) {
            $period = generatePeriodFromString($request->get('period'));            
            $startDate = $period['startDate'];
            $endDate = $period['endDate'];
            $filterEmployee = $request->get('employee_id');
            $dataResult = $this->getRepositoryObj()->list($startDate->format('Y-m-d'), $endDate->format('Y-m-d'), $filterEmployee);
            $view = 'hr.overtime_report.list';            
            
            $dataExcel = [
                'datas' => $dataResult['datas'], 
                'employees' => $dataResult['employees'],
                'view' => $view,                
                'startDate' => $startDate->format('Y-m-d'), 
                'endDate' => $endDate->format('Y-m-d'),
                'period' => CarbonPeriod::create($startDate, $endDate)
            ];
            return $this->exportExcel($dataExcel);
        }

        return view('hr.overtime_report.index')->with($this->getOptionItems());
    }

    private function exportExcel($data)
    {        
        
        $collection = $data['datas'];
        $view = $data['view'];
        $startDate = $data['startDate'];
        $endDate = $data['endDate'];
        $employees = $data['employees'];
        $period = $data['period'];

        $modelEksport = '\\App\Exports\\Hr\\OvertimeReportExport';
        $fileName = 'rekap_overtime_'.$startDate.'_'.$endDate;

        return (new $modelEksport($collection))
            ->setView($view)
            ->setStartDate($startDate)
            ->setEndDate($endDate)
            ->setEmployees($employees)
            ->setPeriod($period)->download($fileName.'.xls');
    }

    private function getOptionItems()
    {        
        return [];
    }
}
