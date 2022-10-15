<?php

namespace App\Models\Hr;

use App\Models\Base as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Contract",
 *      required={"start_date", "signed_date", "used"},
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
class Contract extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $showColumnOption = 'letter_number';
    public $table = 'contracts';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'type',
        'letter_number',
        'subject',
        'description',
        'start_date',
        'end_date',
        'signed_date',
        'tags',
        'used'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'type' => 'string',
        'letter_number' => 'string',
        'subject' => 'string',
        'description' => 'string',
        'start_date' => 'date',
        'end_date' => 'date',
        'signed_date' => 'date',
        'tags' => 'string',
        'used' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'type' => 'nullable|string|max:1',
        'letter_number' => 'nullable|string|max:27',
        'subject' => 'nullable|string|max:255',
        'description' => 'nullable|string|max:255',
        'start_date' => 'required',
        'end_date' => 'nullable',
        'signed_date' => 'required',
        'tags' => 'nullable|string',
        'used' => 'required|boolean'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function careerHistories()
    {
        return $this->hasMany(\App\Models\Hr\CareerHistory::class, 'contract_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function employees()
    {
        return $this->hasMany(\App\Models\Hr\Employee::class, 'contract_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function jobMutations()
    {
        return $this->hasMany(\App\Models\Hr\JobMutation::class, 'contract_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function jobPlacements()
    {
        return $this->hasMany(\App\Models\Hr\JobPlacement::class, 'contract_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function salaryBenefitHistories()
    {
        return $this->hasMany(\App\Models\Hr\SalaryBenefitHistory::class, 'contract_id');
    }
}
