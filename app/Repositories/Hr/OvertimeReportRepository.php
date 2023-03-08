<?php

namespace App\Repositories\Hr;

use App\Models\Hr\Employee;
use App\Models\Hr\Overtime;
use App\Repositories\BaseRepository;

/**
 * Class OvertimeRepository
 * @package App\Repositories\Hr
 * @version October 22, 2022, 8:16 am WIB
*/

class OvertimeReportRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'employee_id',                
        'overtime_date'        
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
        return Overtime::class;
    }

    public function list($startDate, $endDate, $filterEmployee){
        $result = ['datas' => [], 'employees' => []];        
        $datas = Overtime::employeeDescendants()->disableModelCaching()->whereStatus('A')->whereBetween('overtime_date', [$startDate, $endDate])->newQuery(); 
        if($filterEmployee){
            $datas->whereIn('employee_id', $filterEmployee);
        }
        $datas->selectRaw('sum(calculated_value) as total, overtime_date, employee_id')->groupBy('overtime_date')->groupBy('employee_id');
        $result['datas'] = $datas->get()->groupBy('employee_id')->map(function($item){                      
           return $item->keyBy(function($i){ return $i->getRawOriginal('overtime_date'); });
        });

        if($result['datas']){
            $result['employees'] = Employee::select(['id', 'code', 'full_name'])->whereIn('id', $result['datas']->keys())->get()->keyBy('id');
        }
        return $result;
    }
}
