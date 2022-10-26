<!-- Component Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('component_id', __('models/salaryBenefits.fields.component_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('component_id', $componentItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Benefit Value Field -->
<div class="form-group row mb-3">
    {!! Form::label('benefit_value', __('models/salaryBenefits.fields.benefit_value').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('benefit_value', null, ['class' => 'form-control inputmask', 'data-unmask' =>1, 'data-optionmask' => json_encode(config('local.number.decimal')), 'required' => 'required']) !!}
</div>
</div>
