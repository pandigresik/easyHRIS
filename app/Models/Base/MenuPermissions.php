<?php

namespace App\Models\Base;

use App\Models\Base as Model;

/**
 * @SWG\Definition(
 *      definition="MenuPermissions",
 *      required={"permission_id"},
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
class MenuPermissions extends Model
{
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    public $table = 'menu_permissions';

    public $fillable = [
        'permission_id',
        'status',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = [
        'permission_id' => 'required',
        'status' => 'nullable|string|max:1',
    ];

    protected $dates = [];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'menu_id' => 'integer',
        'permission_id' => 'integer',
        'status' => 'string',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function menu()
    {
        return $this->belongsTo(\App\Models\Menu::class, 'menu_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function permission()
    {
        return $this->belongsTo(\App\Models\Base\Permission::class, 'permission_id');
    }
}
