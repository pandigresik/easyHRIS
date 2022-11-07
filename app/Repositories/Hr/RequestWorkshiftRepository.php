<?php

namespace App\Repositories\Hr;

use App\Models\Hr\RequestWorkshift;
use App\Models\Hr\Shiftment;
use App\Models\Hr\Workshift;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Exception;

/**
 * Class RequestWorkshiftRepository
 * @package App\Repositories\Hr
 * @version October 31, 2022, 10:11 am WIB
*/

class RequestWorkshiftRepository extends BaseRepository
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

    public function create($input)
    {
        $this->model->getConnection()->beginTransaction();
        try {
            $workDate = generatePeriod($input['work_date']);
            unset($input['work_date']);
            foreach(CarbonPeriod::create($workDate['startDate'], $workDate['endDate']) as $date){
                $model = $this->generateWorkshift($input, $date->format('Y-m-d'));
            }
            $this->model->getConnection()->commit();
            return $model;
        } catch (\Exception $e) {
            $this->model->getConnection()->rollBack();
            return $e;
        }
    }

    private function generateWorkshift($input, $workDate){
        $input['status'] = RequestWorkshift::INITIAL_STATE;            
        $input['work_date'] = $workDate;
            $employeeId = $input['employee_id'];
            $shiftmentOrigin = Workshift::select(['shiftment_id'])->where(['work_date' => $workDate, 'employee_id' => $employeeId])->first();
            if(!$shiftmentOrigin){
                throw new Exception('Jadwal kerja untuk tanggal tersebut tidak ditemukan');
            }
            $shiftmentId = $input['shiftment_id'];
            $newShiftmentId = Shiftment::with(['schedules' => function($q) use($workDate){
                $workDay = Carbon::parse($workDate)->dayOfWeek;
                return $q->where(['work_day' => $workDay]);
            }])->find($shiftmentId);
                        
            $input['start_hour'] = $workDate.' '.$newShiftmentId->schedules->first()->getRawOriginal('start_hour');
            $input['end_hour'] = $newShiftmentId->schedules->first()->getRawOriginal('start_hour') > $newShiftmentId->schedules->first()->getRawOriginal('end_hour') ? Carbon::parse($workDate)->addDay()->format('Y-m-d').' '.$newShiftmentId->schedules->first()->getRawOriginal('end_hour') : $workDate.' '.$newShiftmentId->schedules->first()->getRawOriginal('end_hour');
            $input['shiftment_id_origin'] = $shiftmentOrigin->shiftment_id;
            $model = parent::create($input);
            if($model->getRawOriginal('status') == RequestWorkshift::APPROVE_STATE){
                $this->updateWorkshift($model);
            }
        return $model;
    }

    public function update($input, $id)
    {
        $this->model->getConnection()->beginTransaction();
        try{
            $query = $this->model->newQuery();
            $model = $query->findOrFail($id);
            $changeWorkshift = false;
            $shiftmentChange = false;
            if($model->getRawOriginal('work_date') != $input['work_date']){
                $changeWorkshift = true;
            }

            if($model->getRawOriginal('shiftment_id') != $input['shiftment_id']){
                $changeWorkshift = true;
                $shiftmentChange = true;
            }

            if($model->getRawOriginal('employee_id') != $input['employee_id']){
                $changeWorkshift = true;
            }

            if($changeWorkshift){
                $workDate = $input['work_date'];
                $employeeId = $input['employee_id'];                
                $shiftmentOrigin = Workshift::select(['shiftment_id'])->where(['work_date' => $workDate, 'employee_id' => $employeeId])->first();
                if(!$shiftmentOrigin){
                    throw new Exception('Jadwal kerja untuk tanggal tersebut tidak ditemukan');
                }

                if($shiftmentChange){
                    $shiftmentId = $input['shiftment_id'];
                    $newShiftmentId = Shiftment::with(['schedules' => function($q) use($workDate){
                        $workDay = Carbon::parse($workDate)->dayOfWeek;
                        return $q->where(['work_day' => $workDay]);
                    }])->find($shiftmentId);
                                
                    $input['start_hour'] = $workDate.' '.$newShiftmentId->schedules->first()->getRawOriginal('start_hour');
                    $input['end_hour'] = $newShiftmentId->schedules->first()->getRawOriginal('start_hour') > $newShiftmentId->schedules->first()->getRawOriginal('end_hour') ? Carbon::parse($workDate)->addDay()->format('Y-m-d').' '.$newShiftmentId->schedules->first()->getRawOriginal('end_hour') : $workDate.' '.$newShiftmentId->schedules->first()->getRawOriginal('end_hour');
                }
            }
                        
            $model->fill($input);            
            $model->save();
            if($model->getRawOriginal('status') == RequestWorkshift::APPROVE_STATE){
                $this->updateWorkshift($model);
            }
            $this->model->getConnection()->commit();
            return $model;
        } catch (\Exception $e) {
            $this->model->getConnection()->rollBack();
            return $e;
        }
    }

    private function updateWorkshift($model){
        $workshift = Workshift::where(['employee_id' => $model->employee_id, 'work_date' => $model->getRawOriginal('work_date')])->first();
        $workshift->shiftment_id = $model->shiftment_id;
        $workshift->start_hour = $model->getRawOriginal('start_hour');
        $workshift->end_hour = $model->getRawOriginal('end_hour');
        $workshift->save();
    }
}
