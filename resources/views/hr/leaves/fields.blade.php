<!-- Employee Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('employee_id', __('models/leaves.fields.employee_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9">     
    {!! Form::select('employee_id', $employeeItems, null, array_merge(['class' => 'form-control select2', 'required' => 'required', 'data-filter' => json_encode([]), 'data-url' => route('selectAjax'), 'data-repository' => 'Hr\\EmployeeShiftmentGroupRepository' ], config('local.select2.ajax')) ) !!}
</div>
</div>

<!-- Reason Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('reason_id', __('models/leaves.fields.reason_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('reason_id', $reasonItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Leave Start Field -->
<div class="form-group row mb-3">
    {!! Form::label('leave_start', __('models/leaves.fields.leave_start').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('leave_start', null, ['class' => 'form-control datetime', 'required' => 'required' ,'data-optiondate' => json_encode(config('local.datetime')),'id'=>'leave_start']) !!}
</div>
</div>

<!-- Leave End Field -->
<div class="form-group row mb-3">
    {!! Form::label('leave_end', __('models/leaves.fields.leave_end').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('leave_end', null, ['class' => 'form-control datetime', 'required' => 'required' ,'data-optiondate' => json_encode(config('local.datetime')),'id'=>'leave_end']) !!}
</div>
</div>

<!-- Amount Field 
<div class="form-group row mb-3">
    {!! Form::label('amount', __('models/leaves.fields.amount').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {--!! Form::number('amount', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>
</div>
-->
<!-- Status Field
<div class="form-group row mb-3">
    {!! Form::label('status', __('models/leaves.fields.status').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {--!! Form::text('status', null, ['class' => 'form-control','maxlength' => 2,'maxlength' => 2, 'required' => 'required']) !!}
</div>
</div>
-->
<!-- Step Approval Field 
<div class="form-group row mb-3">
    {!! Form::label('step_approval', __('models/leaves.fields.step_approval').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    <label class="checkbox-inline">
        {--!! Form::hidden('step_approval', 0) !!}
        {--!! Form::checkbox('step_approval', '1', null) !!}
    </label>
</div>
</div>
-->

<!-- Amount Approval Field
<div class="form-group row mb-3">
    {!! Form::label('amount_approval', __('models/leaves.fields.amount_approval').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    <label class="checkbox-inline">
        {--!! Form::hidden('amount_approval', 0) !!}
        {--!! Form::checkbox('amount_approval', '1', null) !!}
    </label>
</div>
</div>
-->

<!-- Description Field -->
<div class="form-group row mb-3">
    {!! Form::label('description', __('models/leaves.fields.description').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 3,'maxlength' => 255,'maxlength' => 255, 'required' => 'required']) !!}
</div>
</div>
