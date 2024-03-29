<?php

namespace App\Models\Hr;

use App\Models\Base as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Workshift",
 *      required={"work_date"},
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
class Workshift extends Model
{
    use HasFactory;
        use SoftDeletes;

    public $table = 'workshifts';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    public $fillable = [
        'employee_id',
        'shiftment_id',
        'description',
        'work_date',
        'start_hour',
        'end_hour',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'employee_id' => 'integer',
        'shiftment_id' => 'integer',
        'description' => 'string',
        'work_date' => 'date:Y-m-d',
        'start_hour' => 'datetime',
        'end_hour' => 'datetime',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'employee_id' => 'nullable',
        'shiftment_id' => 'nullable',
        'description' => 'nullable|string|max:255',
        // 'work_date' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function shiftment()
    {
        return $this->belongsTo(\App\Models\Hr\Shiftment::class, 'shiftment_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function employee()
    {
        return $this->belongsTo(\App\Models\Hr\Employee::class, 'employee_id');
    }

    public function getWorkDateAttribute($value){
        return localFormatDate($value);
    }

    public function getStartHourAttribute($value){
        return localFormatDateTime($value);
    }

    public function getEndHourAttribute($value){
        return localFormatDateTime($value);
    }

    public function isOffShift(){
        return $this->attributes['start_hour'] == $this->attributes['end_hour'];
    }

    public function isEndOverDay(){        
        return explode(' ',$this->attributes['end_hour'])[0] != $this->attributes['work_date'];
    }

    public function isStartOverDay(){
        return explode(' ',$this->attributes['start_hour'])[0] != $this->attributes['work_date'];
    }
}
