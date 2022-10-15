<?php

namespace App\Models\Base;

use App\Models\Base as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Company",
 *      required={"birth_day"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="region_id",
 *          description="region_id",
 *          type="integer",
 *          format="int32"
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
class Company extends Model
{
    use HasFactory;
        use SoftDeletes;

    public $table = 'companies';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'parent_id',
        'address',
        'code',
        'name',
        'birth_day',
        'email',
        'tax_number'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'parent_id' => 'integer',
        'address' => 'string',
        'code' => 'string',
        'name' => 'string',
        'birth_day' => 'date',
        'email' => 'string',
        'tax_number' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'parent_id' => 'nullable',
        'address' => 'nullable|string|max:255',
        'code' => 'nullable|string|max:7',
        'name' => 'nullable|string|max:255',
        'birth_day' => 'required',
        'email' => 'nullable|string|max:255',
        'tax_number' => 'nullable|string|max:255'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function careerHistories()
    {
        return $this->hasMany(\App\Models\Base\CareerHistory::class, 'company_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function companyDepartments()
    {
        return $this->hasMany(\App\Models\Base\CompanyDepartment::class, 'company_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function employees()
    {
        return $this->hasMany(\App\Models\Base\Employee::class, 'company_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function jobMutations()
    {
        return $this->hasMany(\App\Models\Base\JobMutation::class, 'old_company_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function jobMutation1s()
    {
        return $this->hasMany(\App\Models\Base\JobMutation::class, 'new_company_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function jobPlacements()
    {
        return $this->hasMany(\App\Models\Base\JobPlacement::class, 'company_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function payrollPeriods()
    {
        return $this->hasMany(\App\Models\Base\PayrollPeriod::class, 'company_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function shiftmentGroups()
    {
        return $this->hasMany(\App\Models\Base\ShiftmentGroup::class, 'company_id');
    }

    public function getBirthDayAttribute($value){
        return localFormatDate($value);
    }

    /**
     * Get the parent that owns the Company
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'parent_id');
    }
}
