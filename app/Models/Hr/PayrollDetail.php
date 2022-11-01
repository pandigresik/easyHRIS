<?php

namespace App\Models\Hr;

use App\Models\Base as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="PayrollDetail",
 *      required={""},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="company_id",
 *          description="company_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="year",
 *          description="year",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="month",
 *          description="month",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="closed",
 *          description="closed",
 *          type="boolean"
 *      )
 * )
 */
class PayrollDetail extends Model
{
    use HasFactory;
        use SoftDeletes;

    public $table = 'payroll_details';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'payroll_id',
        'component_id',
        'benefit_value',
        'sign_value',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'payroll_id' => 'integer',
        'component_id' => 'integer',
        'benefit_value' => 'string'        
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'payroll_id' => 'nullable',
        'component_id' => 'nullable',
        'benefit_value' => 'nullable|string'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function payroll()
    {
        return $this->belongsTo(\App\Models\Hr\Payroll::class, 'payroll_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function component()
    {
        return $this->belongsTo(\App\Models\Hr\SalaryComponent::class, 'component_id');
    }
}
