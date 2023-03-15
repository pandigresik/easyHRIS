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
    Route::get('password.change', [\App\Http\Controllers\Auth\ChangePasswordController::class, 'showResetForm'])->name('password.change');
    Route::post('password.change', [\App\Http\Controllers\Auth\ChangePasswordController::class, 'reset'])->name('password.change');
    Route::get('password/resetAdmin/{user}', [\App\Http\Controllers\Auth\ChangePasswordController::class, 'resetByAdmin'])->name('password.resetByAdmin')->middleware(['can:users-passwordResetAdmin']);
    
    Route::group(['prefix' => 'base'], function () {
        Route::resource('import', Base\ImportController::class, ["as" => 'base']);
        Route::resource('export', Base\ExportController::class, ["as" => 'base']);
        Route::resource('roles', Base\RoleController::class, ["as" => 'base', 'middleware' => ['easyauth']]);
        Route::resource('permissions', Base\PermissionController::class, ["as" => 'base', 'middleware' => ['easyauth']]);
        Route::resource('users', Base\UserController::class, ["as" => 'base', 'middleware' => ['easyauth']]);
        Route::resource('menus', Base\MenusController::class, ["as" => 'base', 'middleware' => ['easyauth']]);
        
        Route::resource('cities', Base\CityController::class, ["as" => 'base', 'middleware' => ['easyauth']]);
        Route::resource('companies', Base\CompanyController::class, ["as" => 'base', 'middleware' => ['easyauth']]);
        Route::resource('departments', Base\DepartmentController::class, ["as" => 'base', 'middleware' => ['easyauth']]);
        Route::get('departments/display/chart/{id?}', [\App\Http\Controllers\Base\DepartmentController::class, 'displayChart'])->name('base.departments.chart');
        Route::resource('businessUnits', Base\BusinessUnitController::class, ["as" => 'base', 'middleware' => ['easyauth']]);
        Route::resource('regions', Base\RegionController::class, ["as" => 'base', 'middleware' => ['easyauth']]);
        Route::resource('settings', Base\SettingController::class, ["as" => 'base', 'middleware' => ['easyauth']]);

        Route::resource('approvals', Base\ApprovalController::class, ["as" => 'base']);
    });

    Route::group(['middleware' => ['can:user-administrator'],'prefix' => 'utility'], function () {
        Route::resource('jobs', Utility\JobController::class, ["as" => 'utility'])->only(['index']);
        Route::resource('failedJobs', Utility\FailedJobController::class, ["as" => 'utility']);
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
        Route::resource('employeeSupervisors', Hr\EmployeeSupervisorController::class, ["as" => 'hr', 'middleware' => ['easyauth']])->only(['index', 'create', 'store']);
        Route::post('employeeSupervisors/list', [\App\Http\Controllers\Hr\EmployeeSupervisorController::class, 'list'])->name('hr.employeeSupervisors.list');
        Route::resource('holidays', Hr\HolidayController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('jobLevels', Hr\JobLevelController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::get('jobLevels/display/chart/{id?}', [\App\Http\Controllers\Hr\JobLevelController::class, 'displayChart'])->name('hr.jobLevels.chart');
        Route::resource('jobMutations', Hr\JobMutationController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('jobPlacements', Hr\JobPlacementController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('jobTitles', Hr\JobTitleController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::get('attendanceLogfingers/detail/{workDate}/{employeeId}', [App\Http\Controllers\Hr\AttendanceLogfingerController::class, 'detailLog'])->name('hr.attendanceLogfingers.detailLog');
        Route::resource('attendanceLogfingers', Hr\AttendanceLogfingerController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);        
        Route::get('downloadLogFingers/download', [App\Http\Controllers\Hr\DownloadLogfingerController::class, 'index']);
        Route::post('downloadLogFingers/download/{fingerprintDeviceId}', [App\Http\Controllers\Hr\DownloadLogfingerController::class, 'download']);
        Route::resource('attendanceSummaries', Hr\AttendanceSummaryController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('attendances', Hr\AttendanceController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::post('attendances/updateDescription/{id}', [App\Http\Controllers\Hr\AttendanceController::class, 'updateDescription'])->name('attendances.updateDescription');

        Route::resource('careerHistories', Hr\CareerHistoryController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('employeeShiftments', Hr\EmployeeShiftmentController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('fingerprintDevices', Hr\FingerprintDeviceController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('leaves', Hr\LeafController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('leaveApproves', Hr\LeaveApproveController::class, ["as" => 'hr'])->only(['index', 'update']);
        Route::resource('overtimes', Hr\OvertimeController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('overtimeApproves', Hr\OvertimeApproveController::class, ["as" => 'hr'])->only(['index', 'update']);
        Route::resource('overtimeReports', Hr\OvertimeReportController::class, ["as" => 'hr'])->only('index');
        Route::resource('ritaseDrivers', Hr\RitaseDriverController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);

        Route::resource('payrollPeriodGroups', Hr\PayrollPeriodGroupController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('payrollPeriods', Hr\PayrollPeriodController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('payrollMonthlyPeriods', Hr\PayrollMonthlyPeriodController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('payrollBiweeklyPeriods', Hr\PayrollBiweeklyPeriodController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::get('payrolls/payslip/{id}', [App\Http\Controllers\Hr\PayrollController::class, 'payslip'])->name('hr.payrolls.payslip');
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
        Route::resource('shiftmentGroups.details', Hr\ShiftmentGroupDetailController::class, ["as" => 'hr']);
        Route::resource('shiftmentSchedules', Hr\ShiftmentScheduleController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('skillGroups', Hr\SkillGroupController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('skills', Hr\SkillController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        
        Route::resource('workshifts', Hr\WorkshiftController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);        
        Route::get('workshifts.generate', [App\Http\Controllers\Hr\WorkshiftController::class, 'generate'])->name('hr.workshifts.generate');
        Route::get('workshifts.manual', [App\Http\Controllers\Hr\WorkshiftController::class, 'manual'])->name('hr.workshifts.manual');
        Route::resource('requestWorkshifts', Hr\RequestWorkshiftController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('requestWorkshiftApproves', Hr\RequestWorkshiftApproveController::class, ["as" => 'hr'])->only(['index', 'update']);
        Route::resource('workshiftGroups', Hr\WorkshiftGroupController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::get('workshiftGroups.generate', [App\Http\Controllers\Hr\WorkshiftGroupController::class, 'generate'])->name('hr.workshiftGroups.generate');

        Route::resource('groupingPayrollEntities', Hr\GroupingPayrollEntityController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);
        Route::resource('groupingPayrollEmployeeReports', Hr\GroupingPayrollEmployeeReportController::class, ["as" => 'hr', 'middleware' => ['easyauth']]);

        Route::resource('attendanceReports', Hr\AttendanceReportController::class, ["as" => 'hr'])->only('index');

    });

    Route::get('/selectAjax', [App\Http\Controllers\SelectAjaxController::class, 'index'])->name('selectAjax');
    Route::get('/storage', 'StorageController');
//    Route::get('/events', [App\Http\Controllers\EventsController::class, 'index'])->name('events.index');
});

Route::group(['prefix' => 'artisan'], function () {
    Route::get('clear_cache', function(){
        Artisan::call('cache:clear');
    });
});

Route::group(['prefix' => 'iclock'], function () {
    Route::post('webhook', [\App\Http\Controllers\WebhookIclockController::class, 'index']);
});
