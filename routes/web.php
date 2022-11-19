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
Route::get('password.change', [\App\Http\Controllers\Auth\ChangePasswordController::class, 'showResetForm'])->name('password.change');
Route::post('password.change', [\App\Http\Controllers\Auth\ChangePasswordController::class, 'reset'])->name('password.change');

//Route::group(['middleware' => ['auth','role:administrator']],function (){
Route::group(['middleware' => ['auth']], function () {
    Route::group(['prefix' => 'base'], function () {
        Route::resource('import', Base\ImportController::class, ["as" => 'base', 'middleware' => ['easyauth']]);
        Route::resource('export', Base\ExportController::class, ["as" => 'base', 'middleware' => ['easyauth']]);
        Route::resource('roles', Base\RoleController::class, ["as" => 'base', 'middleware' => ['easyauth']]);
        Route::resource('permissions', Base\PermissionController::class, ["as" => 'base', 'middleware' => ['easyauth']]);
        Route::resource('users', Base\UserController::class, ["as" => 'base', 'middleware' => ['easyauth']]);
        Route::resource('menus', Base\MenusController::class, ["as" => 'base', 'middleware' => ['easyauth']]);
        
        Route::resource('cities', Base\CityController::class, ["as" => 'base', 'middleware' => ['easyauth']]);
        Route::resource('companies', Base\CompanyController::class, ["as" => 'base', 'middleware' => ['easyauth']]);
        Route::resource('departments', Base\DepartmentController::class, ["as" => 'base', 'middleware' => ['easyauth']]);
        Route::resource('businessUnits', Base\BusinessUnitController::class, ["as" => 'base', 'middleware' => ['easyauth']]);
        Route::resource('regions', Base\RegionController::class, ["as" => 'base', 'middleware' => ['easyauth']]);
        Route::resource('settings', Base\SettingController::class, ["as" => 'base', 'middleware' => ['easyauth']]);
    });

    Route::group(['prefix' => 'accounting'], function () {
        Route::resource('taxes', Accounting\TaxController::class, ["as" => 'accounting', 'middleware' => ['easyauth']]);
        Route::resource('taxGroupHistories', Accounting\TaxGroupHistoryController::class, ["as" => 'accounting', 'middleware' => ['easyauth']]);
    });
    
    Route::group(['prefix' => 'hr'], function () {
        Route::resource('absentReasons', Hr\AbsentReasonController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('educationTitles', Hr\EducationTitleController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('educationalInstitutes', Hr\EducationalInstituteController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('contracts', Hr\ContractController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('employees', Hr\EmployeeController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('employees.salaryBenefits', Hr\SalaryBenefitController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('holidays', Hr\HolidayController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('jobLevels', Hr\JobLevelController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('jobMutations', Hr\JobMutationController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('jobPlacements', Hr\JobPlacementController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('jobTitles', Hr\JobTitleController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::get('attendanceLogfingers/detail/{workDate}/{employeeId}', [App\Http\Controllers\Hr\AttendanceLogfingerController::class, 'detailLog'])->name('hr.attendanceLogfingers.detailLog');
        Route::resource('attendanceLogfingers', Hr\AttendanceLogfingerController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);        
        Route::resource('attendanceSummaries', Hr\AttendanceSummaryController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('attendances', Hr\AttendanceController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        
        Route::resource('careerHistories', Hr\CareerHistoryController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('employeeShiftments', Hr\EmployeeShiftmentController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('fingerprintDevices', Hr\FingerprintDeviceController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('leaves', Hr\LeafController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('overtimes', Hr\OvertimeController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('ritaseDrivers', Hr\RitaseDriverController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);

        Route::resource('payrollPeriodGroups', Hr\PayrollPeriodGroupController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('payrollPeriods', Hr\PayrollPeriodController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('payrollMonthlyPeriods', Hr\PayrollMonthlyPeriodController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('payrollBiweeklyPeriods', Hr\PayrollBiweeklyPeriodController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('payrolls', Hr\PayrollController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('payrollDetails', Hr\PayrollDetailController::class, ["as" => 'hr', 'middleware' => ['easyauth']])->only(['index', 'show', 'update', 'edit']);
        Route::get('payrollDownload/{id}', [App\Http\Controllers\Hr\PayrollPeriodDownloadController::class, 'exportExcel'])->name('hr.payrollDownload.download');
        Route::resource('shiftmentGroups', Hr\ShiftmentGroupController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);

        Route::resource('salaryAllowances', Hr\SalaryAllowanceController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('salaryBenefitHistories', Hr\SalaryBenefitHistoryController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        // Route::resource('salaryBenefits', Hr\SalaryBenefitController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('salaryComponents', Hr\SalaryComponentController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('salaryGroupDetails', Hr\SalaryGroupDetailController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('salaryGroups', Hr\SalaryGroupController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('shiftmentGroups', Hr\ShiftmentGroupController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('shiftments', Hr\ShiftmentController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('shiftmentGroups.details', Hr\ShiftmentGroupDetailController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('shiftmentSchedules', Hr\ShiftmentScheduleController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('skillGroups', Hr\SkillGroupController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('skills', Hr\SkillController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        
        Route::resource('workshifts', Hr\WorkshiftController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);        
        Route::get('workshifts.generate', [App\Http\Controllers\Hr\WorkshiftController::class, 'generate'])->name('hr.workshifts.generate');
        Route::resource('requestWorkshifts', Hr\RequestWorkshiftController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('workshiftGroups', Hr\WorkshiftGroupController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::get('workshiftGroups.generate', [App\Http\Controllers\Hr\WorkshiftGroupController::class, 'generate'])->name('hr.workshiftGroups.generate');

        Route::resource('groupingPayrollEntities', Hr\GroupingPayrollEntityController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('groupingPayrollEmployeeReports', Hr\GroupingPayrollEmployeeReportController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
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



