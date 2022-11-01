<?php

namespace App\Repositories\Hr;

use App\Models\Hr\Employee;
use App\Models\Hr\Payroll;
use App\Models\Hr\PayrollPeriod;
use App\Repositories\BaseRepository;
use Carbon\Carbon;

/**
 * Class PayrollPeriodRepository
 * @package App\Repositories\Hr
 * @version October 31, 2022, 3:14 pm WIB
*/

class PayrollPeriodRepository extends BaseRepository
{
    protected $payrollPeriod;
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'name',
        'year',
        'month',
        'start_period',
        'end_period',
        'closed'
    ];


    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PayrollPeriod::class;
    }

    /**
     * Create model record.
     *
     * @param array $input
     *
     * @return Model
     */
    public function create($input)
    {
        $this->model->getConnection()->beginTransaction();
        
        try {
            $periods = $this->splitPeriod($input['range_period']);
            foreach($periods as $period){
                $this->calculatePayroll($input['company_id'], $period, $this->getPayrollPeriod());
            }
            $this->model->getConnection()->commit();            
            return $this->model;
        } catch (\Exception $e) {
            $this->model->getConnection()->rollBack();
            return $e;
        }        
    }

    private function calculatePayroll($companyId, $period, $payrollPeriod){
        // create payrollPeriod if not exists
        $startDateObj = Carbon::parse($period['start_period']);
        $period['company_id'] = $companyId;
        $period['type_period'] = $payrollPeriod;
        $period['year'] = $startDateObj->format('Y');
        $period['month'] = $startDateObj->format('m'); 
        $period['name'] = 'Periode gaji '. localFormatDate($period['start_period']).' sd '.localFormatDate($period['end_period']);
        $periodPayroll = PayrollPeriod::firstOrNew($period);
        $periodPayroll->save();
        $workDayCount = 8;
        // get list employee
        $employees = Employee::select(['id', 'code'])->with(['salaryBenefits' => function($q){
            $q->with(['component']);
        }])->where(['payroll_period' => $payrollPeriod])->get();
        \Log::error($employees);
        foreach($employees as $employee){            
            $this->calculateEmployeePayroll($workDayCount, $employee, $periodPayroll);
        }
    }

    private function calculateEmployeePayroll($workDayCount, $employee, $periodPayroll){ 
        \Log::error('employee '. $employee->full_name);       
        $detail = [];
        $takeHomePay = 0;
        foreach($employee->salaryBenefits as $benefit){
            if($benefit->component->fixed){
                $tmp = [
                    'benefit_value' => $benefit->getRawOriginal('benefit_value'),
                    'component_id' => $benefit->component_id,
                    'sign_value' => $benefit->component->state == 'p' ? 1 : -1, 
                ];
            }else{
                $tmp = [
                    'benefit_value' => $this->calculateComponent($workDayCount, $employee->id, $benefit->getRawOriginal('benefit_value'), $benefit->component->code),
                    'component_id' => $benefit->component_id,
                    'sign_value' => $benefit->component->state == 'p' ? 1 : -1, 
                ];
            }
            $takeHomePay += $tmp['sign_value'] * $tmp['benefit_value'];
            $detail[] = $tmp;            
        }
        $payroll = Payroll::create([
            'payroll_period_id' => $periodPayroll->id,
            'employee_id' => $employee->id,
            'take_home_pay' => $takeHomePay
        ]);
        \Log::error($payroll);
        $payroll->payrollDetails()->saveMany($detail);
    }

    private function calculateComponent($workDayCount, $employeeId, $value, $code){
        return $workDayCount * $value;
    }

    /** jika endDate melewati endOfMonth dari startDate maka split berdasarkan bulannya */
    private function splitPeriod($rangePeriod){
        $resultPeriod = [];
        $period = generatePeriod($rangePeriod);
        $startDate = $period['startDate'];
        $endOfMonthStartDate = Carbon::parse($startDate)->endOfMonth()->format('Y-m-d');
        $endDate = $period['endDate'];

        if($endDate > $endOfMonthStartDate){
            $resultPeriod[] = ['start_period' => $startDate, 'end_period' => $endOfMonthStartDate];
            $resultPeriod[] = ['start_period' => substr($endDate, 0, 7).'-01' , 'end_period' => $endDate];
        }else{
            $resultPeriod[] = ['start_period' => $startDate, 'end_period' => $endDate];
        }
        return $resultPeriod;
    }

    /**
     * Get the value of payrollPeriod
     */ 
    public function getPayrollPeriod()
    {
        return $this->payrollPeriod;
    }

    /**
     * Set the value of payrollPeriod
     *
     * @return  self
     */ 
    public function setPayrollPeriod($payrollPeriod)
    {
        $this->payrollPeriod = $payrollPeriod;

        return $this;
    }
}
