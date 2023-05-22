<?php

namespace App\Models;

use App\Traits\BlameableCustomTrait;
use App\Traits\SearchModelTrait;
use App\Traits\ShowColumnOptionTrait;
use Carbon\Carbon;
use DigitalCloud\Blameable\Traits\Blameable;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Base extends Model
{
    use Cachable;
    use SearchModelTrait;
    use ShowColumnOptionTrait;
    
    use Blameable, BlameableCustomTrait{
        BlameableCustomTrait::bootBlameable insteadof Blameable;
    }

    public const CREATED_BY = 'created_by';
    public const UPDATED_BY = 'updated_by';

    protected static $logFillable = true;

    /**
     * Get the name of the "created by" column.
     *
     * @return null|string
     */
    public function getCreatedByColumn()
    {
        return static::CREATED_BY;
    }

    /**
     * Get the name of the "updated by" column.
     *
     * @return null|string
     */
    public function getUpdatedByColumn()
    {
        return static::UPDATED_BY;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo(\App\Models\Base\User::class, static::CREATED_BY);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updatedBy()
    {
        return $this->belongsTo(\App\Models\Base\User::class, static::UPDATED_BY);
    }

    public function getCreatedAtAttribute($value){        
        return localFormatDateTime((new Carbon($value))->setTimezone(config('app.timezone')));
    }

    public function getUpdatedAtAttribute($value){
        return localFormatDateTime((new Carbon($value))->setTimezone(config('app.timezone')));
    }

    protected function scopeEmployeeDescendants($query, $column = 'employee_id'){
        $employee = \Auth::user()->employee;        
        if($employee){
            $allDescendants = $employee->getAllDescendant();            
            return $query->whereIn($column, $allDescendants);
        }
        return $query;
    }
}
