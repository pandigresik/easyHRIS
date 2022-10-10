<?php

namespace App\Models\Base;

use App\Traits\SearchModelTrait;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

/**
 * @SWG\Definition(
 *      definition="User",
 *      required={"name", "email", "password"},
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
 *          property="email",
 *          description="email",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="email_verified_at",
 *          description="email_verified_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="password",
 *          description="password",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="remember_token",
 *          description="remember_token",
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
class User extends Authenticatable
{
    use SoftDeletes;
    use HasRoles;
    use HasPermissions;
    use Cachable;
    use SearchModelTrait;
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
    public $table = 'users';

    public $fillable = [
        'id',
        'name',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|max:255',
        'email_verified_at' => 'nullable',
        'password' => 'required|string|max:255',
        'remember_token' => 'nullable|string|max:100',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
    ];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'email' => 'string',
        'email_verified_at' => 'datetime',
        'password' => 'string',
        'remember_token' => 'string',
    ];

    // Cache permissions and roles
    public function getPermissionsAttribute()
    {
        $permissions = Cache::rememberForever('permissions_cache', function () {
            return Permission::select('permissions.*', 'model_has_permissions.*')
                ->join('model_has_permissions', 'permissions.id', '=', 'model_has_permissions.permission_id')
                ->get()
            ;
        });

        return $permissions->where('model_id', $this->id);
    }

    public function getRolesAttribute()
    {
        $roles = Cache::rememberForever('roles_cache', function () {
            return Role::select('roles.*', 'model_has_roles.*')
                ->join('model_has_roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->get()
            ;
        });

        return $roles->where('model_id', $this->id);
    }

    public function getUnitAttribute()
    {
        $result = collect();
        $this->roles->each(function ($item) use ($result) {
            $item->units()->each(function ($unit) use ($result) {
                $result->add($unit);
            });
        });

        return $result;
    }
}
