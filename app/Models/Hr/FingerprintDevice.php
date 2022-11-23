<?php

namespace App\Models\Hr;

use App\Models\Base as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="FingerprintDevice",
 *      required={"serial_number", "ip", "display_name"},
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
class FingerprintDevice extends Model
{
    use HasFactory;
    // use SoftDeletes;

    public $table = 'fingerprint_devices';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const CREATED_BY = NULL;
    const UPDATED_BY = NULL;

    protected $dates = ['deleted_at'];
    protected $showColumnOption = 'display_name';


    public $fillable = [
        'serial_number',
        'ip',
        'port',
        'display_name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'serial_number' => 'string',
        'ip' => 'string',
        'port' => 'integer',
        'display_name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'serial_number' => 'required|string|max:50',
        'ip' => 'required|string|max:30',
        'port' => 'required|integer',
        'display_name' => 'required|string|max:30'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function attendanceLogfingers()
    {
        return $this->hasMany(\App\Models\Hr\AttendanceLogfinger::class, 'fingerprint_device_id');
    }
}
