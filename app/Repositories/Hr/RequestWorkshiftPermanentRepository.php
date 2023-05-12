<?php

namespace App\Repositories\Hr;

use App\Jobs\AttendanceProcess;
use App\Models\Base\Setting;
use App\Models\Hr\RequestWorkshift;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Exception;

/**
 * Class RequestWorkshiftRepository
 * @package App\Repositories\Hr
 * @version October 31, 2022, 10:11 am WIB
*/

class RequestWorkshiftPermanentRepository extends BaseRepository
{    
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'employee_id',
        'shiftment_id',
        'shiftment_id_origin',
        'work_date',
        'status',
        'description'
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
        return RequestWorkshift::class;
    }

    public function list($filterData){
        $startDate = $filterData['startDate'];
        $employeeFilter = $filterData['employeeFilter'];
        $shiftmentGroupCurrent = $filterData['shiftmentGroupCurrent'];
        $shiftmentGroupNew = $filterData['shiftmentGroupNew'];
        
    }

    public function create($input)
    {
        $this->model->getConnection()->beginTransaction();
        try {
            $setting = Setting::where(['type' => 'approval'])->get()->keyBy('name');
            $workDate = generatePeriod($input['work_date']);
            unset($input['work_date']);
            $employees = $input['employee_id'];
            unset($input['employee_id']);            
            $this->setMaxStepApproval(intval($setting['max_approval_request_workshift']->value ?? 0));
            foreach($employees as $employeeId){
                foreach(CarbonPeriod::create($workDate['startDate'], $workDate['endDate']) as $date){
                    $model = $this->generateWorkshift($employeeId, $input, $date->format('Y-m-d'));
                }
            }            
            $this->model->getConnection()->commit();
            return $model;
        } catch (\Exception $e) {
            $this->model->getConnection()->rollBack();
            return $e;
        }
    }    

    private function generateJob($item, $delay = 2){
        // execute job attendance process after 30 seconds                
        if($item->getRawOriginal('status') == $item->getFinalState()){
            if($item->getRawOriginal('work_date') < Carbon::now()->format('Y-m-d')){
                AttendanceProcess::dispatch($item->employee_id, $item->getRawOriginal('work_date'), $item->getRawOriginal('work_date'))->delay(now()->addSeconds($delay));
            }
        }        
    }
}
