<?php

namespace App\Models\Hr;

use App\Models\Base as Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="AttendanceLogfinger",
 *      required={"fingertime"},
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
class AttendanceLogfinger extends Model
{
    use HasFactory;
        use SoftDeletes;

    public $table = 'attendance_logfingers';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const CREATED_BY = NULL;
    const UPDATED_BY = NULL;
    
    protected $showColumnOption = 'display_name';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'employee_id',
        'type_absen',
        'fingertime',
        'fingerprint_device_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'employee_id' => 'integer',
        'type_absen' => 'string',
        'fingertime' => 'datetime',
        'fingerprint_device_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'employee_id' => 'required',
        'type_absen' => 'nullable|string|max:1',
        'fingertime' => 'required',
        'fingerprint_device_id' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function employee()
    {
        return $this->belongsTo(\App\Models\Hr\Employee::class, 'employee_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function fingerprintDevice()
    {
        return $this->belongsTo(\App\Models\Hr\FingerprintDevice::class, 'fingerprint_device_id');
    }

    public function getFingertimeAttribute($value){
        return localFormatDateTime($value);
    }

    public function getFingerDateAttribute($value){
        return Carbon::parse($this->attributes['fingertime'])->format('Y-m-d');
    }
}
