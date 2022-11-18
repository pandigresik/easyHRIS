<!-- Employee Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('employee_id', __('models/groupingPayrollEmployeeReports.fields.employee_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $groupingPayrollEmployeeReport->employee_id }}</p>
    </div>
</div>

<!-- Grouping Payroll Entity Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('grouping_payroll_entity_id', __('models/groupingPayrollEmployeeReports.fields.grouping_payroll_entity_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $groupingPayrollEmployeeReport->grouping_payroll_entity_id }}</p>
    </div>
</div>

