<?php

namespace App\Http\Controllers\Hr;

use App\Repositories\Hr\RequestWorkshiftPermanentRepository;
use App\Http\Controllers\AppBaseController;
use App\Repositories\Base\BusinessUnitRepository;
use App\Repositories\Base\CompanyRepository;
use App\Repositories\Base\DepartmentRepository;
use App\Repositories\Hr\EmployeeSupervisorRepository;
use App\Repositories\Hr\JobLevelRepository;
use App\Repositories\Hr\JobTitleRepository;
use App\Repositories\Hr\PayrollPeriodGroupRepository;
use App\Repositories\Hr\ShiftmentGroupRepository;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Exception;
use Illuminate\Http\Request;
use Flash;

class RequestWorkshiftPermanentController extends AppBaseController
{
    /** @var  RequestWorkshiftPermanentRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = RequestWorkshiftPermanentRepository::class;
    }

    public function index(Request $request)
    {        
        if ($request->ajax()) {            
            $error = [];
            $shiftmentGroupNew = $request->get('shiftment_group_id_destination');
            $shiftmentGroupCurrent = $request->get('shiftment_group_id');
            $startDate = $request->get('start_from');                        
            $employeeFilter =  $request->get('employee_id');          

            if(empty($employeeFilter)){
                $error[] = 'employee must filled';
            }

            if(empty($startDate)){
                $error[] = 'start_from must filled';
            }

            if(empty($shiftmentGroupNew)){
                $error[] = 'new shiftment group must filled';
            }

            // if(empty($shiftmentGroupCurrent)){
            //     $error[] = 'current shiftment group must filled';
            // }

            if(!empty($error)){                
                return $this->sendError($error);
            }
            $startDate = createLocalFormatDate($startDate);  
            $endDate = Carbon::parse($startDate->format('Y-m-d'))->addDays(8); 
            $filterData = [
                'startDate' => $startDate,
                'endDate' => $endDate, 
                'employeeFilter' => $employeeFilter,                
                'shiftmentGroupNew' => $shiftmentGroupNew                
            ];
            $datas = $this->getRepositoryObj()->list($filterData);                 
            
            return view('hr.request_workshift_permanent/list')
                ->with([
                    'workshifts' => $datas['workshifts'], 
                    'employees' => $datas['employees'], 
                    'startDate' => $startDate->format('Y-m-d'), 
                    'endDate' => $endDate->format('Y-m-d'),
                    'periodRange' => CarbonPeriod::create($startDate, $endDate)                    
                ]);
        }

        return view('hr.request_workshift_permanent.index')->with($this->getOptionItems());
    }    

    /**
     * Store a newly created PayrollPeriod in storage.
     *
     * @param CreatePayrollPeriodRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $payrollPeriod = $this->getRepositoryObj()->create($input);
        
        if($payrollPeriod instanceof Exception){                                    
            return redirect()->back()->withInput()->withErrors(['error', $payrollPeriod->getMessage()]);
        }
        
        Flash::success(__('messages.saved', ['model' => __('models/payrollPeriods.singular')]));

        return redirect(route('hr.requestWorkshiftPermanents'.'.index'));
    }

    private function getOptionItems()
    {        
        $payrollGroup = new PayrollPeriodGroupRepository();        
        $company = new CompanyRepository();
        $department = new DepartmentRepository();
        $businessUnit = new BusinessUnitRepository();        
        $jobLevel = new JobLevelRepository();
        $jobTitle = new JobTitleRepository();
        $employee = new EmployeeSupervisorRepository();        
        $shiftmentGroup = new ShiftmentGroupRepository();
        $minDate = localFormatDate(Carbon::now()->subMonth()->format('Y-m-d'));
        return [
            'payrollGroupItems' => ['' => __('crud.option.fingerprintDevice_placeholder')] + $payrollGroup->pluck(),                        
            'companyItems' => ['' => __('crud.option.company_placeholder')] + $company->pluck(),
            'departmentItems' => ['' => __('crud.option.department_placeholder')] + $department->pluck(),
            'businessUnitItems' => $businessUnit->pluck(),            
            'joblevelItems' =>  $jobLevel->pluck(),
            'jobtitleItems' =>  $jobTitle->pluck(),
            'supervisorItems' => ['' => __('crud.option.supervisor_placeholder')] + $employee->allQuery()->supervisor()->get()->pluck('code_name','id')->toArray(),
            'shiftmentGroupItems' => ['' => __('crud.option.supervisor_placeholder')] + $shiftmentGroup->pluck(),
            'minDate' => $minDate
        ];        
        
        return [
            
        ];
    }
}
