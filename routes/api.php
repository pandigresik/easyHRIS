<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();    
});
Route::group(['prefix' => 'base'], function () {
    Route::resource('cities', Base\CityAPIController::class);
    Route::resource('companies', Base\CompanyAPIController::class);
    Route::resource('departments', Base\DepartmentAPIController::class);
    Route::resource('regions', Base\RegionAPIController::class);
    Route::resource('settings', Base\SettingAPIController::class);
});


Route::group(['prefix' => 'accounting'], function () {
    Route::resource('taxes', Accounting\TaxAPIController::class);
    Route::resource('tax_group_histories', Accounting\TaxGroupHistoryAPIController::class);
});

Route::group(['prefix' => 'hr'], function () {
    Route::resource('absent_reasons', Hr\AbsentReasonAPIController::class);
    Route::resource('education_titles', Hr\EducationTitleAPIController::class);
    Route::resource('educational_institutes', Hr\EducationalInstituteAPIController::class);
    Route::resource('contracts', Hr\ContractAPIController::class);
    Route::resource('employees', Hr\EmployeeAPIController::class);
    Route::resource('holidays', Hr\HolidayAPIController::class);
    Route::resource('job_levels', Hr\JobLevelAPIController::class);
    Route::resource('job_mutations', Hr\JobMutationAPIController::class);
    Route::resource('job_placements', Hr\JobPlacementAPIController::class);
    Route::resource('job_titles', Hr\JobTitleAPIController::class);
    Route::resource('attendance_logfingers', Hr\AttendanceLogfingerAPIController::class);
    Route::resource('attendance_summaries', Hr\AttendanceSummaryAPIController::class);
    Route::resource('attendances', Hr\AttendanceAPIController::class);
    Route::resource('career_histories', Hr\CareerHistoryAPIController::class);
    Route::resource('employee_shiftments', Hr\EmployeeShiftmentAPIController::class);
    Route::resource('fingerprint_devices', Hr\FingerprintDeviceAPIController::class);
    Route::resource('leaves', Hr\LeafAPIController::class);
    Route::resource('overtimes', Hr\OvertimeAPIController::class);

    Route::resource('payroll_periods', Hr\PayrollPeriodAPIController::class);
    Route::resource('payrolls', Hr\PayrollAPIController::class);
    Route::resource('payroll_details', Hr\PayrollDetailAPIController::class);

    Route::resource('salary_allowances', Hr\SalaryAllowanceAPIController::class);
    Route::resource('salary_benefit_histories', Hr\SalaryBenefitHistoryAPIController::class);
    Route::resource('salary_benefits', Hr\SalaryBenefitAPIController::class);
    Route::resource('salary_components', Hr\SalaryComponentAPIController::class);
    Route::resource('salary_group_details', Hr\SalaryGroupDetailAPIController::class);
    Route::resource('salary_groups', Hr\SalaryGroupAPIController::class);
    Route::resource('shiftment_groups', Hr\ShiftmentGroupAPIController::class);
    Route::resource('shiftments', Hr\ShiftmentAPIController::class);    
    Route::resource('shiftment_group_details', Hr\ShiftmentGroupDetailAPIController::class);
    Route::resource('shiftment_schedules', Hr\ShiftmentScheduleAPIController::class);

    Route::resource('skill_groups', Hr\SkillGroupAPIController::class);
    Route::resource('skills', Hr\SkillAPIController::class);        

    Route::resource('workshifts', Hr\WorkshiftAPIController::class);
    Route::resource('request_workshifts', Hr\RequestWorkshiftAPIController::class);
    Route::resource('workshift_groups', Hr\WorkshiftGroupAPIController::class);
});

Route::group(['prefix' => 'hr'], function () {
    Route::resource('payroll_period_groups', App\Http\Controllers\API\Hr\Hr\PayrollPeriodGroupAPIController::class);
});


Route::group(['prefix' => 'hr'], function () {
    Route::resource('ritase_drivers', App\Http\Controllers\API\Hr\Hr\RitaseDriverAPIController::class);
});
