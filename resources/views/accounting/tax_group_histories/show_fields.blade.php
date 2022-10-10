<!-- Employee Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('employee_id', __('models/taxGroupHistories.fields.employee_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $taxGroupHistory->employee_id }}</p>
    </div>
</div>

<!-- Old Tax Group Field -->
<div class="form-group row mb-3">
    {!! Form::label('old_tax_group', __('models/taxGroupHistories.fields.old_tax_group').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $taxGroupHistory->old_tax_group }}</p>
    </div>
</div>

<!-- New Tax Group Field -->
<div class="form-group row mb-3">
    {!! Form::label('new_tax_group', __('models/taxGroupHistories.fields.new_tax_group').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $taxGroupHistory->new_tax_group }}</p>
    </div>
</div>

<!-- Old Risk Ratio Field -->
<div class="form-group row mb-3">
    {!! Form::label('old_risk_ratio', __('models/taxGroupHistories.fields.old_risk_ratio').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $taxGroupHistory->old_risk_ratio }}</p>
    </div>
</div>

<!-- New Risk Ratio Field -->
<div class="form-group row mb-3">
    {!! Form::label('new_risk_ratio', __('models/taxGroupHistories.fields.new_risk_ratio').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $taxGroupHistory->new_risk_ratio }}</p>
    </div>
</div>

