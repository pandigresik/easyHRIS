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

<!-- Leave Start Field -->
<div class="form-group row mb-3">
    {!! Form::label('leave_start', __('models/leaves.fields.leave_start').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $leaf->leave_start }}</p>
    </div>
</div>

<!-- Leave End Field -->
<div class="form-group row mb-3">
    {!! Form::label('leave_end', __('models/leaves.fields.leave_end').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $leaf->leave_end }}</p>
    </div>
</div>

<!-- Amount Field -->
<div class="form-group row mb-3">
    {!! Form::label('amount', __('models/leaves.fields.amount').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $leaf->amount }}</p>
    </div>
</div>

<!-- Status Field -->
<div class="form-group row mb-3">
    {!! Form::label('status', __('models/leaves.fields.status').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $leaf->status }}</p>
    </div>
</div>

<!-- Step Approval Field -->
<div class="form-group row mb-3">
    {!! Form::label('step_approval', __('models/leaves.fields.step_approval').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $leaf->step_approval }}</p>
    </div>
</div>

<!-- Amount Approval Field -->
<div class="form-group row mb-3">
    {!! Form::label('amount_approval', __('models/leaves.fields.amount_approval').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $leaf->amount_approval }}</p>
    </div>
</div>

<!-- Description Field -->
<div class="form-group row mb-3">
    {!! Form::label('description', __('models/leaves.fields.description').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $leaf->description }}</p>
    </div>
</div>

