<?php

namespace App\Repositories\Hr;

use App\Models\Hr\SalaryBenefit;
use App\Models\Hr\SalaryComponent;
use App\Repositories\BaseRepository;

/**
 * Class SalaryBenefitRepository
 * @package App\Repositories\Hr
 * @version October 4, 2022, 10:38 am WIB
*/

class SalaryBenefitRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'employee_id',
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
        return SalaryBenefit::class;
    }
    // ketika update salary benefit untuk gaji maka otomatis update juga potongan kehadiran
    public function update($input, $id)
    {
        $this->model->getConnection()->beginTransaction();

        try {
            $model = parent::update($input, $id);
            $component = $model->component;
            if(in_array($component->code, ['GP', 'GPH'])){
                // update Potongan Kehadiran
                $componentPthd = SalaryComponent::whereCode('PTHD')->first();
                $pthd = SalaryBenefit::where(['employee_id' => $model->employee_id, 'component_id' => $componentPthd->id])->first();
                $pthd->benefit_value = $model->getRawOriginal('benefit_value');
                $pthd->save();
            }
            $this->model->getConnection()->commit();
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $this->model->getConnection()->rollBack();

            return $e;
        }

        return $model;
    }
}
