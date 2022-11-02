<?php

namespace App\Repositories\Hr;

use App\Models\Hr\Payroll;
use App\Models\Hr\PayrollDetail;
use App\Repositories\BaseRepository;

/**
 * Class PayrollDetailRepository
 * @package App\Repositories\Hr
 * @version October 4, 2022, 11:17 am WIB
*/

class PayrollDetailRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'payroll_id',
        'component_id',
        'benefit_value',
        'benefit_key'
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
        return PayrollDetail::class;
    }

    public function update($input, $id)
    {
        $this->model->getConnection()->beginTransaction();
        try{
            $query = $this->model->newQuery();
            $model = $query->findOrFail($id);            
            $model->fill($input);
            $model->save();
            $payroll = Payroll::find($model->payroll_id);
            $summary = PayrollDetail::selectRaw('sum(sign_value * benefit_value) as total')->where(['payroll_id' => $model->payroll_id])->first();
            $payroll->take_home_pay = $summary->getRawOriginal('total');
            $payroll->save(); 
            // update nilai take_home_pay payroll 
            $this->model->getConnection()->commit();
            return $model;
        } catch (\Exception $e) {
            $this->model->getConnection()->rollBack();
            return $e;
        }
    }
}
