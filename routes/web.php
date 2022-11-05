<?php

use Illuminate\Support\Facades\Route; 
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/tes', [App\Http\Controllers\HomeController::class, 'tes']);

//Route::group(['middleware' => ['auth','role:administrator']],function (){
Route::group(['middleware' => ['auth']], function () {
    Route::group(['prefix' => 'base'], function () {
        Route::resource('import', Base\ImportController::class, ['as' => 'base']);
        Route::resource('export', Base\ExportController::class, ['as' => 'base']);
        Route::resource('roles', Base\RoleController::class, ['as' => 'base']);
        Route::resource('permissions', Base\PermissionController::class, ['as' => 'base']);
        Route::resource('users', Base\UserController::class, ['as' => 'base']);
        Route::resource('menus', Base\MenusController::class, ['as' => 'base']);
        
        Route::resource('cities', Base\CityController::class, ["as" => 'base']);
        Route::resource('companies', Base\CompanyController::class, ["as" => 'base']);
        Route::resource('departments', Base\DepartmentController::class, ["as" => 'base']);
        Route::resource('regions', Base\RegionController::class, ["as" => 'base']);
        Route::resource('settings', Base\SettingController::class, ["as" => 'base']);
    });

    Route::group(['prefix' => 'accounting'], function () {
        Route::resource('taxes', Accounting\TaxController::class, ["as" => 'accounting']);
        Route::resource('taxGroupHistories', Accounting\TaxGroupHistoryController::class, ["as" => 'accounting']);
    });
    
    Route::group(['prefix' => 'hr'], function () {
        Route::resource('absentReasons', Hr\AbsentReasonController::class, ["as" => 'hr']);
        Route::resource('educationTitles', Hr\EducationTitleController::class, ["as" => 'hr']);
        Route::resource('educationalInstitutes', Hr\EducationalInstituteController::class, ["as" => 'hr']);
        Route::resource('contracts', Hr\ContractController::class, ["as" => 'hr']);
        Route::resource('employees', Hr\EmployeeController::class, ["as" => 'hr']);
        Route::resource('employees.salaryBenefits', Hr\SalaryBenefitController::class, ["as" => 'hr']);
        Route::resource('holidays', Hr\HolidayController::class, ["as" => 'hr']);
        Route::resource('jobLevels', Hr\JobLevelController::class, ["as" => 'hr']);
        Route::resource('jobMutations', Hr\JobMutationController::class, ["as" => 'hr']);
        Route::resource('jobPlacements', Hr\JobPlacementController::class, ["as" => 'hr']);
        Route::resource('jobTitles', Hr\JobTitleController::class, ["as" => 'hr']);
        Route::resource('attendanceLogfingers', Hr\AttendanceLogfingerController::class, ["as" => 'hr']);
        Route::resource('attendanceSummaries', Hr\AttendanceSummaryController::class, ["as" => 'hr']);
        Route::resource('attendances', Hr\AttendanceController::class, ["as" => 'hr']);
        
        Route::resource('careerHistories', Hr\CareerHistoryController::class, ["as" => 'hr']);
        Route::resource('employeeShiftments', Hr\EmployeeShiftmentController::class, ["as" => 'hr']);
        Route::resource('fingerprintDevices', Hr\FingerprintDeviceController::class, ["as" => 'hr']);
        Route::resource('leaves', Hr\LeafController::class, ["as" => 'hr']);
        Route::resource('overtimes', Hr\OvertimeController::class, ["as" => 'hr']);

        Route::resource('payrollPeriodGroups', Hr\PayrollPeriodGroupController::class, ["as" => 'hr']);
        Route::resource('payrollPeriods', Hr\PayrollPeriodController::class, ["as" => 'hr']);
        Route::resource('payrollMonthlyPeriods', Hr\PayrollMonthlyPeriodController::class, ["as" => 'hr']);
        Route::resource('payrollBiweeklyPeriods', Hr\PayrollBiweeklyPeriodController::class, ["as" => 'hr']);
        Route::resource('payrolls', Hr\PayrollController::class, ["as" => 'hr']);
        Route::resource('payrollDetails', Hr\PayrollDetailController::class, ["as" => 'hr'])->only(['index', 'show', 'update', 'edit']);
        Route::resource('shiftmentGroups', Hr\ShiftmentGroupController::class, ["as" => 'hr']);

        Route::resource('salaryAllowances', Hr\SalaryAllowanceController::class, ["as" => 'hr']);
        Route::resource('salaryBenefitHistories', Hr\SalaryBenefitHistoryController::class, ["as" => 'hr']);
        // Route::resource('salaryBenefits', Hr\SalaryBenefitController::class, ["as" => 'hr']);
        Route::resource('salaryComponents', Hr\SalaryComponentController::class, ["as" => 'hr']);
        Route::resource('salaryGroupDetails', Hr\SalaryGroupDetailController::class, ["as" => 'hr']);
        Route::resource('salaryGroups', Hr\SalaryGroupController::class, ["as" => 'hr']);
        Route::resource('shiftmentGroups', Hr\ShiftmentGroupController::class, ["as" => 'hr']);
        Route::resource('shiftments', Hr\ShiftmentController::class, ["as" => 'hr']);
        Route::resource('shiftmentGroups.details', Hr\ShiftmentGroupDetailController::class, ["as" => 'hr']);
        Route::resource('shiftmentSchedules', Hr\ShiftmentScheduleController::class, ["as" => 'hr']);
        Route::resource('skillGroups', Hr\SkillGroupController::class, ["as" => 'hr']);
        Route::resource('skills', Hr\SkillController::class, ["as" => 'hr']);
        
        Route::resource('workshifts', Hr\WorkshiftController::class, ["as" => 'hr']);        
        Route::get('workshifts.generate', [App\Http\Controllers\Hr\WorkshiftController::class, 'generate'])->name('hr.workshifts.generate');
        Route::resource('requestWorkshifts', Hr\RequestWorkshiftController::class, ["as" => 'hr']);
        Route::resource('workshiftGroups', Hr\WorkshiftGroupController::class, ["as" => 'hr']);
        Route::get('workshiftGroups.generate', [App\Http\Controllers\Hr\WorkshiftGroupController::class, 'generate'])->name('hr.workshiftGroups.generate');
    });

    Route::get('/selectAjax', [App\Http\Controllers\SelectAjaxController::class, 'index'])->name('selectAjax');
//    Route::get('/events', [App\Http\Controllers\EventsController::class, 'index'])->name('events.index');
});

// builder generator
// Route::get('generator_builder', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@builder')->name('io_generator_builder');
// Route::get('field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@fieldTemplate')->name('io_field_template');
// Route::get('relation_field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@relationFieldTemplate')->name('io_relation_field_template');
// Route::post('generator_builder/generate', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generate')->name('io_generator_builder_generate');
// Route::post('generator_builder/rollback', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@rollback')->name('io_generator_builder_rollback'); 
// Route::post(
//     'generator_builder/generate-from-file',
//     '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generateFromFile'
// )->name('io_generator_builder_generate_from_file');

Route::group(['prefix' => 'artisan'], function () {
    Route::get('clear_cache', function(){
        Artisan::call('cache:clear');
    });
});
