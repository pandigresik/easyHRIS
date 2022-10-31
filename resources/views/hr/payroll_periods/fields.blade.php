<!-- Company Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('company_id', __('models/payrollPeriods.fields.company_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('company_id', $companyItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Name Field -->
<div class="form-group row mb-3">
    {!! Form::label('name', __('models/payrollPeriods.fields.name').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('name', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255, 'required' => 'required']) !!}
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

<!-- Start Period Field -->
<div class="form-group row mb-3">
    {!! Form::label('start_period', __('models/payrollPeriods.fields.start_period').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('start_period', null, ['class' => 'form-control datetime', 'required' => 'required' ,'data-optiondate' => json_encode( ['locale' => ['format' => config('local.date_format_javascript') ]]),'id'=>'start_period']) !!}
</div>
</div>

<!-- End Period Field -->
<div class="form-group row mb-3">
    {!! Form::label('end_period', __('models/payrollPeriods.fields.end_period').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('end_period', null, ['class' => 'form-control datetime', 'required' => 'required' ,'data-optiondate' => json_encode( ['locale' => ['format' => config('local.date_format_javascript') ]]),'id'=>'end_period']) !!}
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

