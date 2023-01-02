<!-- Model Field -->
<div class="form-group row mb-3">
    {!! Form::label('model', __('models/approvals.fields.model').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $approval->model }}</p>
    </div>
</div>

<!-- Reference Field -->
<div class="form-group row mb-3">
    {!! Form::label('reference', __('models/approvals.fields.reference').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $approval->reference }}</p>
    </div>
</div>

<!-- Status Field -->
<div class="form-group row mb-3">
    {!! Form::label('status', __('models/approvals.fields.status').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $approval->status }}</p>
    </div>
</div>

<!-- Comment Field -->
<div class="form-group row mb-3">
    {!! Form::label('comment', __('models/approvals.fields.comment').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $approval->comment }}</p>
    </div>
</div>

<!-- Sequence Field -->
<div class="form-group row mb-3">
    {!! Form::label('sequence', __('models/approvals.fields.sequence').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $approval->sequence }}</p>
    </div>
</div>

<!-- User Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('employee_id', __('models/approvals.fields.employee_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $approval->employee_id }}</p>
    </div>
</div>

