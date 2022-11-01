<!-- Company Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('company_id', __('models/payrollPeriods.fields.company_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('company_id', $companyItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Start Period Field -->
<div class="form-group row mb-3">
    {!! Form::label('range_period', __('models/payrollPeriods.fields.range_period').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('range_period', null, ['class' => 'form-control datetime', 'required' => 'required' ,'data-optiondate' => json_encode( array_merge(['minDate' => $minDate, 'endDate' => $endDate ],config('local.daterange')) ),'id'=>'range_period']) !!}
</div>
</div>
