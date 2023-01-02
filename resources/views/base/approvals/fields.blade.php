<!-- Model Field -->
<div class="form-group row mb-3">
    {!! Form::label('model', __('models/approvals.fields.model').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('model', null, ['class' => 'form-control','maxlength' => 80,'maxlength' => 80, 'required' => 'required']) !!}
</div>
</div>

<!-- Reference Field -->
<div class="form-group row mb-3">
    {!! Form::label('reference', __('models/approvals.fields.reference').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::number('reference', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>
</div>

<!-- Status Field -->
<div class="form-group row mb-3">
    {!! Form::label('status', __('models/approvals.fields.status').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('status', null, ['class' => 'form-control','maxlength' => 2,'maxlength' => 2, 'required' => 'required']) !!}
</div>
</div>

<!-- Comment Field -->
<div class="form-group row mb-3">
    {!! Form::label('comment', __('models/approvals.fields.comment').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('comment', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255, 'required' => 'required']) !!}
</div>
</div>

<!-- Sequence Field -->
<div class="form-group row mb-3">
    {!! Form::label('sequence', __('models/approvals.fields.sequence').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    <label class="checkbox-inline">
        {!! Form::hidden('sequence', 0) !!}
        {!! Form::checkbox('sequence', '1', null) !!}
    </label>
</div>
</div>


<!-- User Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('employee_id', __('models/approvals.fields.employee_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('employee_id', $userItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>
