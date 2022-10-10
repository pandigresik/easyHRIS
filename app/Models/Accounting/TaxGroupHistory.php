<?php

namespace App\Models\Accounting;

use App\Models\Base as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="TaxGroupHistory",
 *      required={""},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="employee_id",
 *          description="employee_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="old_tax_group",
 *          description="old_tax_group",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="new_tax_group",
 *          description="new_tax_group",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="old_risk_ratio",
 *          description="old_risk_ratio",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="new_risk_ratio",
 *          description="new_risk_ratio",
 *          type="string"
 *      )
 * )
 */
class TaxGroupHistory extends Model
{
    use HasFactory;
        use SoftDeletes;

    public $table = 'tax_group_history';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'employee_id',
        'old_tax_group',
        'new_tax_group',
        'old_risk_ratio',
        'new_risk_ratio'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'employee_id' => 'integer',
        'old_tax_group' => 'string',
        'new_tax_group' => 'string',
        'old_risk_ratio' => 'string',
        'new_risk_ratio' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'employee_id' => 'nullable',
        'old_tax_group' => 'nullable|string|max:3',
        'new_tax_group' => 'nullable|string|max:3',
        'old_risk_ratio' => 'nullable|string|max:3',
        'new_risk_ratio' => 'nullable|string|max:3'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function employee()
    {
        return $this->belongsTo(\App\Models\Accounting\Employee::class, 'employee_id');
    }
}
