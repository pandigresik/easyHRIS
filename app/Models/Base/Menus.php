<?php

namespace App\Models\Base;

use App\Models\Base as Model;

/**
 * @SWG\Definition(
 *      definition="Menus",
 *      required={"name", "status"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="name",
 *          description="name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="description",
 *          description="description",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="status",
 *          description="status",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="icon",
 *          description="icon",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="route",
 *          description="route",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="parent_id",
 *          description="parent_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="seq_number",
 *          description="seq_number",
 *          type="boolean"
 *      )
 * )
 */
class Menus extends Model
{
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
    public const CREATED_BY = null;
    public const UPDATED_BY = null;

    public $table = 'menus';

    public $fillable = [
        'name',
        'description',
        'status',
        'icon',
        'route',
        'parent_id',
        'seq_number',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:100|unique:menus,name',
        'description' => 'nullable|string|max:100',
        'status' => 'required|string|max:1',
        'icon' => 'nullable|string|max:50',
        'route' => 'nullable|string|max:100',
        'parent_id' => 'nullable|integer',
        'seq_number' => 'nullable|integer',
    ];
    protected $showColumnOption = 'name';
    protected $dates = [];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'description' => 'string',
        'status' => 'string',
        'icon' => 'string',
        'route' => 'string',
        'parent_id' => 'integer',
        'seq_number' => 'integer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(\App\Models\Base\Permission::class, 'menu_permissions', 'menu_id');
    }

    public function menuPermission()
    {
        return $this->hasMany(\App\Models\Base\MenuPermissions::class);
    }

    public function parent()
    {
        return $this->belongsTo(\App\Models\Base\Menus::class, 'parent_id');
    }
}
