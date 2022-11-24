<?php

namespace App\Models\Hr;

use App\Models\Base as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kalnoy\Nestedset\NodeTrait;

/**
 * @SWG\Definition(
 *      definition="JobLevel",
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
class JobLevel extends Model
{
    use HasFactory;
        use SoftDeletes;
    use NodeTrait;

    public $table = 'job_levels';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


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
        return $this->hasMany(\App\Models\Hr\CareerHistory::class, 'joblevel_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function employees()
    {
        return $this->hasMany(\App\Models\Hr\Employee::class, 'joblevel_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function jobMutations()
    {
        return $this->hasMany(\App\Models\Hr\JobMutation::class, 'new_joblevel_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function jobMutation1s()
    {
        return $this->hasMany(\App\Models\Hr\JobMutation::class, 'old_joblevel_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function jobPlacements()
    {
        return $this->hasMany(\App\Models\Hr\JobPlacement::class, 'joblevel_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function jobTitles()
    {
        return $this->hasMany(\App\Models\Hr\JobTitle::class, 'job_level_id');
    }

    /**
     * Get the parent that owns the JobLevel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(JobLevel::class, 'parent_id');
    }

    public function generateChartData($id = null){
        return empty($id) ? $this->selectRaw('id, parent_id, code as title, name ,_lft, _rgt')->get()->toTree()->toArray() : $this->selectRaw('id, parent_id, code as title, name,_lft, _rgt')->descendantsAndSelf($id)->toTree()->toArray();
    }
}
