
<!-- Benefit Value Field -->
<div class="form-group row mb-3">
    {!! Form::label('benefit_value', __('models/payrollDetails.fields.benefit_value').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('benefit_value', null, ['class' => 'form-control inputmask', 'data-unmask' => 1, 'data-optionmask' => json_encode(config('local.number.integer')), 'required' => 'required']) !!}
</div>
</div>

<!-- Benefit Key Field -->
<div class="form-group row mb-3">
    {!! Form::label('description', __('models/payrollDetails.fields.description').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::textarea('description', null, ['class' => 'form-control','rows' => 4,'maxlength' => 255, 'required' => 'required']) !!}
</div>
</div>
