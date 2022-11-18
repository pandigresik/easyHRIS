<!-- Employee Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('employee_id', __('models/groupingPayrollEmployeeReports.fields.employee_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
@if($employeeItems)
{!! Form::select('employee_id', $employeeItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
@else
{!! Form::select('employee_id[]', $employeeItems, null, array_merge(['class' => 'form-control select2','id' =>
        'employee_id', 'data-filter' => json_encode([]), 'data-url' =>
        route('selectAjax'), 'data-repository' => 'Hr\\EmployeePayrollGroupReportRepository', 'multiple' => 'multiple' ],
        config('local.select2.ajax')) ) !!}
@endif

</div>
</div>

<!-- Grouping Payroll Entity Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('grouping_payroll_entity_id', __('models/groupingPayrollEmployeeReports.fields.grouping_payroll_entity_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('grouping_payroll_entity_id', $groupingPayrollEntityItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>
