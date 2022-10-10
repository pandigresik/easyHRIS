<!-- Employee Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('employee_id', __('models/leaves.fields.employee_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $leaf->employee_id }}</p>
    </div>
</div>

<!-- Reason Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('reason_id', __('models/leaves.fields.reason_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $leaf->reason_id }}</p>
    </div>
</div>

<!-- Leave Date Field -->
<div class="form-group row mb-3">
    {!! Form::label('leave_date', __('models/leaves.fields.leave_date').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $leaf->leave_date }}</p>
    </div>
</div>

<!-- Amount Field -->
<div class="form-group row mb-3">
    {!! Form::label('amount', __('models/leaves.fields.amount').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $leaf->amount }}</p>
    </div>
</div>

<!-- Description Field -->
<div class="form-group row mb-3">
    {!! Form::label('description', __('models/leaves.fields.description').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $leaf->description }}</p>
    </div>
</div>

