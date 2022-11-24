<?php

namespace App\Models\Base;

use App\Models\Base as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;

/**
 * @SWG\Definition(
 *      definition="Department",
 *      required={""},
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
class Department extends Model
{
    use HasFactory;
    use SoftDeletes;
    use NodeTrait;
    public $table = 'departments';

    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'parent_id',
        'code',
        'name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'parent_id' => 'integer',
        'code' => 'string',
        'name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'parent_id' => 'nullable',
        'code' => 'nullable|string|max:7',
        'name' => 'nullable|string|max:255'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function careerHistories()
    {
        return $this->hasMany(\App\Models\Base\CareerHistory::class, 'department_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function companyDepartments()
    {
        return $this->hasMany(\App\Models\Base\CompanyDepartment::class, 'department_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function employees()
    {
        return $this->hasMany(\App\Models\Base\Employee::class, 'department_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function jobMutations()
    {
        return $this->hasMany(\App\Models\Base\JobMutation::class, 'new_department_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function jobMutation1s()
    {
        return $this->hasMany(\App\Models\Base\JobMutation::class, 'old_department_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function jobPlacements()
    {
        return $this->hasMany(\App\Models\Base\JobPlacement::class, 'department_id');
    }

    /**
     * Get the parent associated with the Department
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'parent_id');
    }

    public function generateChartData($id = null){
        return empty($id) ? $this->selectRaw('id, parent_id, code as title, name ,_lft, _rgt')->get()->toTree()->toArray() : $this->selectRaw('id, parent_id, code as title, name,_lft, _rgt')->descendantsAndSelf($id)->toTree()->toArray();
    }
}
