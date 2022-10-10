<?php

namespace App\Models\Base;

use App\Traits\SearchModelTrait;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Spatie\Permission\Models\Permission as Model;

/**
 * @SWG\Definition(
 *      definition="Permission",
 *      required={"name", "guard_name"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="string"
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
class Permission extends Model
{
    use Cachable;
    use SearchModelTrait;
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    public $fillable = [
        'name',
        'guard_name',
    ];

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
     * Indicates if the IDs are UUIDs.
     *
     * @var bool
     */
    protected $keyIsUuid = false;
    protected $keyType = 'int';
    protected $showColumnOption = 'name';

    protected $dates = ['deleted_at'];

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
     * Get the value of showColumnOption.
     */
    public function getShowColumnOption()
    {
        return $this->showColumnOption ?? $this->getKeyName();
    }
}
