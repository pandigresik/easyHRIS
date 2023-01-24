<?php

namespace App\Models\Hr;

use App\Models\Base as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Shiftment",
 *      required={"start_hour", "end_hour"},
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
class Shiftment extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'shiftments';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';    

    protected $dates = ['deleted_at'];

    
    public $fillable = [
        'code',
        'name',
        'start_hour',
        'end_hour'        
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'code' => 'string',
        'name' => 'string',
        'next_day' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'code' => 'nullable|string|max:7',
        'name' => 'nullable|string|max:255',
        'start_hour' => 'required',
        'end_hour' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function attendances()
    {
        return $this->hasMany(\App\Models\Hr\Attendance::class, 'shiftment_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function overtimes()
    {
        return $this->hasMany(\App\Models\Hr\Overtime::class, 'shiftment_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function workshifts()
    {
        return $this->hasMany(\App\Models\Hr\Workshift::class, 'shiftment_id');
    }

    /**
     * Get all of the schedules for the Shiftment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function schedules()
    {
        return $this->hasMany(ShiftmentSchedule::class, 'shiftment_id');
    }
}
