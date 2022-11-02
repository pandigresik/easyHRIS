<?php

namespace App\Models\Hr;

use App\Models\Base as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="JobMutation",
 *      required={""},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="type",
 *          description="type",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="code",
 *          description="code",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="name",
 *          description="name",
 *          type="string"
 *      )
 * )
 */
class JobMutation extends Model
{
    use HasFactory;
        use SoftDeletes;

    public $table = 'job_mutations';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'employee_id',
        'old_company_id',
        'old_department_id',
        'old_joblevel_id',
        'old_jobtitle_id',
        'old_supervisor_id',
        'new_company_id',
        'new_department_id',
        'new_joblevel_id',
        'new_jobtitle_id',
        'new_supervisor_id',
        'contract_id',
        'type'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'employee_id' => 'integer',
        'old_company_id' => 'integer',
        'old_department_id' => 'integer',
        'old_joblevel_id' => 'integer',
        'old_jobtitle_id' => 'integer',
        'old_supervisor_id' => 'integer',
        'new_company_id' => 'integer',
        'new_department_id' => 'integer',
        'new_joblevel_id' => 'integer',
        'new_jobtitle_id' => 'integer',
        'new_supervisor_id' => 'integer',
        'contract_id' => 'integer',
        'type' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'employee_id' => 'nullable',
        'old_company_id' => 'nullable',
        'old_department_id' => 'nullable',
        'old_joblevel_id' => 'nullable',
        'old_jobtitle_id' => 'nullable',
        'old_supervisor_id' => 'nullable',
        'new_company_id' => 'nullable',
        'new_department_id' => 'nullable',
        'new_joblevel_id' => 'nullable',
        'new_jobtitle_id' => 'nullable',
        'new_supervisor_id' => 'nullable',
        'contract_id' => 'nullable',
        'type' => 'nullable|string|max:1'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function newJoblevel()
    {
        return $this->belongsTo(\App\Models\Hr\JobLevel::class, 'new_joblevel_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function contract()
    {
        return $this->belongsTo(\App\Models\Hr\Contract::class, 'contract_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function oldCompany()
    {
        return $this->belongsTo(\App\Models\Base\Company::class, 'old_company_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function oldJoblevel()
    {
        return $this->belongsTo(\App\Models\Hr\JobLevel::class, 'old_joblevel_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function newSupervisor()
    {
        return $this->belongsTo(\App\Models\Hr\Employee::class, 'new_supervisor_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function newCompany()
    {
        return $this->belongsTo(\App\Models\Base\Company::class, 'new_company_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function oldSupervisor()
    {
        return $this->belongsTo(\App\Models\Hr\Employee::class, 'old_supervisor_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function oldJobtitle()
    {
        return $this->belongsTo(\App\Models\Hr\JobTitle::class, 'old_jobtitle_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function newJobtitle()
    {
        return $this->belongsTo(\App\Models\Hr\JobTitle::class, 'new_jobtitle_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function employee()
    {
        return $this->belongsTo(\App\Models\Hr\Employee::class, 'employee_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function newDepartment()
    {
        return $this->belongsTo(\App\Models\Hr\Department::class, 'new_department_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function oldDepartment()
    {
        return $this->belongsTo(\App\Models\Hr\Department::class, 'old_department_id');
    }
}
