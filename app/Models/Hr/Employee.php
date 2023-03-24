<?php

namespace App\Models\Hr;

use App\Models\Base as Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Employee",
 *      required={"join_date", "date_of_birth", "have_overtime_benefit"},
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
class Employee extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    public $table = 'employees';
    private $hasMealAllowance = 0;
    private $hasPartialMealAllowance = 0;
    private $minDateGetMealAllowance;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const GRADE = ['NON-STAFF', 'STAFF'];

    protected $dates = ['deleted_at'];
    protected $showColumnOption = 'full_name';

    public $fillable = [
        'contract_id',
        'company_id',
        'department_id',
        'business_unit_id',
        'joblevel_id',
        'jobtitle_id',
        'supervisor_id',
        'region_of_birth_id',
        'city_of_birth_id',
        'address',
        'join_date',
        'employee_status',
        'code',
        'full_name',
        'gender',
        'date_of_birth',
        'identity_number',
        'identity_type',
        'account_bank',
        'marital_status',
        'email',
        'leave_balance',
        'tax_group',
        'resign_date',
        'have_overtime_benefit',
        'risk_ratio',
        'profile_image',
        'profile_size',
        'salary_group_id',
        'shiftment_group_id',        
        'payroll_period_group_id',
        'grade'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'contract_id' => 'integer',
        'company_id' => 'integer',
        'department_id' => 'integer',
        'joblevel_id' => 'integer',
        'jobtitle_id' => 'integer',
        'supervisor_id' => 'integer',
        'region_of_birth_id' => 'integer',
        'city_of_birth_id' => 'integer',
        'address' => 'string',
        'join_date' => 'date:Y-m-d',
        'employee_status' => 'string',
        'code' => 'string',
        'full_name' => 'string',
        'gender' => 'string',
        'date_of_birth' => 'date',
        'identity_number' => 'string',
        'identity_type' => 'string',
        'account_bank' => 'string',
        'marital_status' => 'string',
        'email' => 'string',
        'leave_balance' => 'integer',
        'tax_group' => 'string',
        'resign_date' => 'date',
        'have_overtime_benefit' => 'integer',
        'risk_ratio' => 'string',
        'profile_image' => 'string',
        'profile_size' => 'integer',
        'salary_group_id' => 'integer',
        'shiftment_group_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'contract_id' => 'nullable',
        'company_id' => 'nullable',
        'department_id' => 'nullable',
        'joblevel_id' => 'nullable',
        'jobtitle_id' => 'nullable',
        'supervisor_id' => 'nullable',
        'region_of_birth_id' => 'nullable',
        'city_of_birth_id' => 'nullable',
        'address' => 'nullable|string|max:255',
        'join_date' => 'required',
        'employee_status' => 'nullable|string|max:10',
        'code' => 'nullable|string|max:17',
        'full_name' => 'nullable|string|max:255',
        'gender' => 'nullable|string|max:1',
        'date_of_birth' => 'required',
        'identity_number' => 'nullable|string|max:27',
        'identity_type' => 'nullable|string|max:10',
        'marital_status' => 'nullable|string|max:2',
        'email' => 'nullable|string|max:255',
        'leave_balance' => 'nullable|integer',
        'tax_group' => 'nullable|string|max:3',
        'resign_date' => 'nullable',
        'have_overtime_benefit' => 'required|boolean',
        'risk_ratio' => 'nullable|string|max:3',
        'profile_image' => 'nullable|string|max:255',
        'profile_size' => 'nullable|integer',
        'salary_group_id' => 'nullable',
        'shiftment_group_id' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function contract()
    {
        return $this->belongsTo(\App\Models\Hr\Contract::class, 'contract_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function cityOfBirth()
    {
        return $this->belongsTo(\App\Models\Base\City::class, 'city_of_birth_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function company()
    {
        return $this->belongsTo(\App\Models\Base\Company::class, 'company_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function department()
    {
        return $this->belongsTo(\App\Models\Base\Department::class, 'department_id');
    }

    public function businessUnit(){
        return $this->belongsTo(\App\Models\Base\BusinessUnit::class, 'business_unit_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function regionOfBirth()
    {
        return $this->belongsTo(\App\Models\Base\Region::class, 'region_of_birth_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function joblevel()
    {
        return $this->belongsTo(\App\Models\Hr\JobLevel::class, 'joblevel_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function jobtitle()
    {
        return $this->belongsTo(\App\Models\Hr\JobTitle::class, 'jobtitle_id');
    }

    public function supervisorEmployee()
    {
        return $this->belongsTo(\App\Models\Hr\Employee::class, 'supervisor_id', 'id');
    }    

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function attendanceLogfingers()
    {
        return $this->hasMany(\App\Models\Hr\AttendanceLogfinger::class, 'employee_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function attendanceSummaries()
    {
        return $this->hasMany(\App\Models\Hr\AttendanceSummary::class, 'employee_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function attendances()
    {
        return $this->hasMany(\App\Models\Hr\Attendance::class, 'employee_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function careerHistories()
    {
        return $this->hasMany(\App\Models\Hr\CareerHistory::class, 'supervisor_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function careerHistory1s()
    {
        return $this->hasMany(\App\Models\Hr\CareerHistory::class, 'employee_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function employeeShiftments()
    {
        return $this->hasMany(\App\Models\Hr\EmployeeShiftment::class, 'employee_id');
    }

    public function shiftmentGroup()
    {
        return $this->belongsTo(\App\Models\Hr\ShiftmentGroup::class, 'shiftment_group_id');
    }

    public function salaryGroup()
    {
        return $this->belongsTo(\App\Models\Hr\SalaryGroup::class, 'salary_group_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function jobMutations()
    {
        return $this->hasMany(\App\Models\Hr\JobMutation::class, 'new_supervisor_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function jobMutation2s()
    {
        return $this->hasMany(\App\Models\Hr\JobMutation::class, 'old_supervisor_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function jobMutation3s()
    {
        return $this->hasMany(\App\Models\Hr\JobMutation::class, 'employee_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function jobPlacements()
    {
        return $this->hasMany(\App\Models\Hr\JobPlacement::class, 'supervisor_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function jobPlacement4s()
    {
        return $this->hasMany(\App\Models\Hr\JobPlacement::class, 'employee_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function leaves()
    {
        return $this->hasMany(\App\Models\Hr\Leaf::class, 'employee_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function overtimes()
    {
        return $this->hasMany(\App\Models\Hr\Overtime::class, 'approved_by_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function overtime5s()
    {
        return $this->hasMany(\App\Models\Hr\Overtime::class, 'employee_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function payrolls()
    {
        return $this->hasMany(\App\Models\Hr\Payroll::class, 'employee_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function salaryAllowances()
    {
        return $this->hasMany(\App\Models\Hr\SalaryAllowance::class, 'employee_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function salaryBenefitHistories()
    {
        return $this->hasMany(\App\Models\Hr\SalaryBenefitHistory::class, 'employee_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function salaryBenefits()
    {
        return $this->hasMany(\App\Models\Hr\SalaryBenefit::class, 'employee_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function taxGroupHistories()
    {
        return $this->hasMany(\App\Models\Hr\TaxGroupHistory::class, 'employee_id');
    }
    
    public function groupPayrollEmployeeReport()
    {
        return $this->hasOne(\App\Models\Hr\GroupingPayrollEmployeeReport::class, 'employee_id');
    }

    public function payrollPeriodGroup()
    {
        return $this->belongsTo(\App\Models\Hr\PayrollPeriodGroup::class, 'payroll_period_group_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function taxes()
    {
        return $this->hasMany(\App\Models\Hr\Tax::class, 'employee_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function workshifts()
    {
        return $this->hasMany(\App\Models\Hr\Workshift::class, 'employee_id');
    }

    public function children()
    {
        return $this->hasMany(\App\Models\Hr\Employee::class, 'supervisor_id', 'id')->with(['jobLevel']);
    }    

    public function payrollEntity(){
        return $this->hasOneThrough(\App\Models\Hr\GroupingPayrollEntity::class, \App\Models\Hr\GroupingPayrollEmployeeReport::class, 'employee_id', 'id', 'id', 'grouping_payroll_entity_id');
    }

    public function scopeSupervisor($query){        
        // pakai cara ini, menggunakan subquery error 
        $jobLevelLeader = config('local.job_level_leader');        
        $joblevelId = JobLevel::select('id')->whereIn('code', $jobLevelLeader)->pluck('id');        
        return $query->whereIn('joblevel_id',$joblevelId);
    }

    public function scopeActive($query, $date = NULL){
        return $query->where(function($q) use ($date){
            if(empty($date)){
                return $q->whereNull('resign_date');
            }
            return $q->whereNull('resign_date')->orWhere('resign_date','>=', $date);
        });
    }

    public function scopeDriver($query){
        return $query->where('jobtitle_id',function($q){
            return $q->select(['id'])->from('job_titles')->where('name','like','%driver%');
        });
    }

    public function scopeKernet($query){
        return $query->where('jobtitle_id',function($q){
            return $q->select(['id'])->from('job_titles')->where('name','like','%kernet');
        });
    }

    public function getJoinDateAttribute($value){
        return localFormatDate($value);
    }

    public function getDateOfBirthAttribute($value){
        return localFormatDate($value);
    }

    public function getResignDateAttribute($value){
        return localFormatDate($value);
    }

    public function getCodeNameAttribute($value){
        return $this->attributes['full_name'].' ('.$this->attributes['code'].')';
    }

    // jika sudah lebih dari waktu tertentu maka hari libur tetap dibayar
    public function isHolidayPay($minJoinDate){
        return $this->attributes['join_date'] <= $minJoinDate;
    }

    public function isParentNode(){
        $jobLevelLeader = config('local.job_level_leader');
        $jobLevelEmployee = $this->jobLevel;
        
        return in_array($jobLevelEmployee->code ?? NULL , $jobLevelLeader);
    }
    
    public function getAllDescendant(){        
        $result = [$this->id];        
        if($this->isParentNode()){            
            $children = $this->children;
            while(!$children->isEmpty()){
                 $loopChildren = collect([]);
                 foreach($children as $child){                    
                     $result[] = $child->id;
                     
                     if($child->isParentNode()){
                        $loopChildren = $loopChildren->merge($child->children);                        
                     }
                 }
                 $children = $loopChildren;
            }            
         }         
        return $result;
    }

    public function getAllSupervisor(){        
        $result = [];        
            $maxLoop = 15; // untuk mencegah infinite loop karena salah setting
            $loop = 1;
            $supervisor = $this->supervisorEmployee;
            if($supervisor){
                while($supervisor && $loop < $maxLoop){                    
                    $result[] = $supervisor->id;
                    $supervisor = $supervisor->supervisorEmployee;
                    $loop++;
               }
            }
        return $result;
    }

    /**
     * Get the value of hasMealAllowance
     */ 
    public function checkMealAllowance($minJoinDate, $maxJoinDate, $minMonthGetMealAllowance)
    {
        $this->setMinDateGetMealAllowance(Carbon::parse($this->attributes['join_date'])->addMonths($minMonthGetMealAllowance)->format('Y-m-d'));
        if($this->attributes['join_date'] <= $minJoinDate){
            $this->hasMealAllowance = 1;
        }else{
            if($this->attributes['join_date'] <= $maxJoinDate){
                $this->hasPartialMealAllowance = 1;
            }
        }        
    }    
    
    public function getHasPartialMealAllowance()
    {
        return $this->hasPartialMealAllowance;
    }

    /**
     * Get the value of minDateGetMealAllowance
     */ 
    public function getMinDateGetMealAllowance()
    {
        return $this->minDateGetMealAllowance;
    }

    /**
     * Set the value of minDateGetMealAllowance
     *
     * @return  self
     */ 
    public function setMinDateGetMealAllowance($minDateGetMealAllowance)
    {
        $this->minDateGetMealAllowance = $minDateGetMealAllowance;

        return $this;
    }

    /**
     * Get the value of hasMealAllowance
     */ 
    public function getHasMealAllowance()
    {
        return $this->hasMealAllowance;
    }

    /**
     * Set the value of hasMealAllowance
     *
     * @return  self
     */ 
    public function setHasMealAllowance($hasMealAllowance)
    {
        $this->hasMealAllowance = $hasMealAllowance;

        return $this;
    }
}
