<?php

namespace App\Models\Base;

use App\Traits\SearchModelTrait;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Models\Role as Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
/**
 * @SWG\Definition(
 *      definition="Role",
 *      required={"name", "guard_name"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int64"
 *      ),
 *      @SWG\Property(
 *          property="name",
 *          description="name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="guard_name",
 *          description="guard_name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="created_at",
 *          description="created_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="updated_at",
 *          description="updated_at",
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */
class Role extends Model
{
    use Cachable;
    use SearchModelTrait;
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    public $fillable = [
        'name',
        'guard_name',
    ];
    //protected $guarded = ['id'];
    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:255',
        'guard_name' => 'required|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'guard_name' => 'string',
    ];

    /**
     * Get all of the units for the Role.
     */
    // public function units(): HasManyThrough
    // {
    //     return $this->hasManyThrough(Units::class, RoleUnits::class, 'role_id', 'id', 'id');
    // }

    /**
     * The units that belong to the Role.
     */
    public function units(): BelongsToMany
    {
        return $this->belongsToMany(Units::class, 'role_units', 'role_id', 'unit_id');
    }    
}
