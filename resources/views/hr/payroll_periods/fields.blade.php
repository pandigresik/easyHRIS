<!-- Company Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('company_id', __('models/payrollPeriods.fields.company_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('company_id', $companyItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Year Field -->
<div class="form-group row mb-3">
    {!! Form::label('year', __('models/payrollPeriods.fields.year').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::number('year', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>
</div>

<!-- Month Field -->
<div class="form-group row mb-3">
    {!! Form::label('month', __('models/payrollPeriods.fields.month').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::number('month', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>
</div>

<!-- Closed Field -->
<div class="form-group row mb-3">
    {!! Form::label('closed', __('models/payrollPeriods.fields.closed').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    <label class="checkbox-inline">
        {!! Form::hidden('closed', 0) !!}
        {!! Form::checkbox('closed', '1', null) !!}
    </label>
</div>
</div>

