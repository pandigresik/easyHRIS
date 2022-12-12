<!-- Contract Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('contract_id', __('models/employees.fields.contract_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('contract_id', $contractItems, null, ['class' => 'form-control select2']) !!}
</div>
</div>

<!-- Company Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('company_id', __('models/employees.fields.company_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('company_id', $companyItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Department Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('department_id', __('models/employees.fields.department_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('department_id', $departmentItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Business Unit Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('business_unit_id', __('models/employees.fields.business_unit_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('business_unit_id', $businessUnitItems, null, ['class' => 'form-control select2']) !!}
</div>
</div>

<!-- Joblevel Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('joblevel_id', __('models/employees.fields.joblevel_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('joblevel_id', $joblevelItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Jobtitle Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('jobtitle_id', __('models/employees.fields.jobtitle_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('jobtitle_id', $jobtitleItems, null, ['class' => 'form-control select2']) !!}
</div>
</div>

<!-- Supervisor Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('supervisor_id', __('models/employees.fields.supervisor_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('supervisor_id', $supervisorItems, null, ['class' => 'form-control select2']) !!}
</div>
</div>

<!-- Region Of Birth Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('region_of_birth_id', __('models/employees.fields.region_of_birth_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('region_of_birth_id', $regionOfBirthItems, null, ['class' => 'form-control select2']) !!}
</div>
</div>

<!-- City Of Birth Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('city_of_birth_id', __('models/employees.fields.city_of_birth_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('city_of_birth_id', $cityOfBirthItems, null, ['class' => 'form-control select2']) !!}
</div>
</div>

<!-- Address Field -->
<div class="form-group row mb-3">
    {!! Form::label('address', __('models/employees.fields.address').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('address', null, ['class' => 'form-control','maxlength' => 255]) !!}
</div>
</div>

<!-- Join Date Field -->
<div class="form-group row mb-3">
    {!! Form::label('join_date', __('models/employees.fields.join_date').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('join_date', null, ['class' => 'form-control datetime', 'required' => 'required' ,'data-optiondate' => json_encode( ['locale' => ['format' => config('local.date_format_javascript') ]]),'id'=>'join_date']) !!}
</div>
</div>

<!-- Employee Status Field -->
<div class="form-group row mb-3">
    {!! Form::label('employee_status', __('models/employees.fields.employee_status').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('employee_status', null, ['class' => 'form-control','maxlength' => 10, 'required' => 'required']) !!}
</div>
</div>

<!-- Code Field -->
<div class="form-group row mb-3">
    {!! Form::label('code', __('models/employees.fields.code').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('code', null, ['class' => 'form-control','maxlength' => 17,'maxlength' => 17, 'required' => 'required']) !!}
</div>
</div>

<!-- Full Name Field -->
<div class="form-group row mb-3">
    {!! Form::label('full_name', __('models/employees.fields.full_name').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('full_name', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255, 'required' => 'required']) !!}
</div>
</div>

<!-- Gender Field -->
<div class="form-group row mb-3">
    {!! Form::label('gender', __('models/employees.fields.gender').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('gender', null, ['class' => 'form-control','maxlength' => 1,'maxlength' => 1, 'required' => 'required']) !!}
</div>
</div>

<!-- Date Of Birth Field -->
<div class="form-group row mb-3">
    {!! Form::label('date_of_birth', __('models/employees.fields.date_of_birth').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('date_of_birth', null, ['class' => 'form-control datetime' ,'data-optiondate' => json_encode( ['locale' => ['format' => config('local.date_format_javascript') ]]),'id'=>'date_of_birth']) !!}
</div>
</div>

<!-- Identity Type Field -->
<div class="form-group row mb-3">
    {!! Form::label('account_bank', __('models/employees.fields.account_bank').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('account_bank', null, ['class' => 'form-control','maxlength' => 15]) !!}
</div>
</div>

<!-- Identity Number Field -->
<div class="form-group row mb-3">
    {!! Form::label('identity_number', __('models/employees.fields.identity_number').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('identity_number', null, ['class' => 'form-control','maxlength' => 27]) !!}
</div>
</div>

<!-- Identity Type Field -->
<div class="form-group row mb-3">
    {!! Form::label('identity_type', __('models/employees.fields.identity_type').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('identity_type', null, ['class' => 'form-control','maxlength' => 10]) !!}
</div>
</div>

<!-- Marital Status Field -->
<div class="form-group row mb-3">
    {!! Form::label('marital_status', __('models/employees.fields.marital_status').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('marital_status', null, ['class' => 'form-control','maxlength' => 2]) !!}
</div>
</div>

<!-- Email Field -->
<div class="form-group row mb-3">
    {!! Form::label('email', __('models/employees.fields.email').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::email('email', null, ['class' => 'form-control','maxlength' => 255]) !!}
</div>
</div>

<!-- Leave Balance Field -->
<div class="form-group row mb-3">
    {!! Form::label('leave_balance', __('models/employees.fields.leave_balance').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::number('leave_balance', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>
</div>

<!-- Tax Group Field -->
<div class="form-group row mb-3">
    {!! Form::label('tax_group', __('models/employees.fields.tax_group').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('tax_group', null, ['class' => 'form-control','maxlength' => 3]) !!}
</div>
</div>

<!-- Resign Date Field -->
<div class="form-group row mb-3">
    {!! Form::label('resign_date', __('models/employees.fields.resign_date').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('resign_date', null, ['class' => 'form-control datetime', 'data-optiondate' => json_encode( config('local.datesingle_empty')) ,'id'=>'resign_date']) !!}
</div>
</div>

<!-- Have Overtime Benefit Field -->
<div class="form-group row mb-3">
    {!! Form::label('have_overtime_benefit', __('models/employees.fields.have_overtime_benefit').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    <label class="checkbox-inline">
        {!! Form::hidden('have_overtime_benefit', 0) !!}
        {!! Form::checkbox('have_overtime_benefit', '1', null) !!}
    </label>
</div>
</div>


<!-- Risk Ratio Field
<div class="form-group row mb-3">
    {!! Form::label('risk_ratio', __('models/employees.fields.risk_ratio').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {--!! Form::text('risk_ratio', null, ['class' => 'form-control','maxlength' => 3,'maxlength' => 3, 'required' => 'required']) !!}
</div>
</div>
-->
<!-- Profile Image Field
<div class="form-group row mb-3">
    {!! Form::label('profile_image', __('models/employees.fields.profile_image').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {--!! Form::text('profile_image', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255, 'required' => 'required']) !!}
</div>
</div>
-->
<!-- Profile Size Field 
<div class="form-group row mb-3">
    {!! Form::label('profile_size', __('models/employees.fields.profile_size').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {--!! Form::number('profile_size', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>
</div>
-->
<!-- Salary Group Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('salary_group_id', __('models/employees.fields.salary_group_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('salary_group_id', $salaryGroupItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Shiftment Group Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('shiftment_group_id', __('models/employees.fields.shiftment_group_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('shiftment_group_id', $shiftmentGroupItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Shiftment Group Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('payroll_period_group_id', __('models/employees.fields.payroll_period_group_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('payroll_period_group_id', $payrollPeriodGroupItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>
